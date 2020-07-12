<?php
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

class sweatherbloc
{
	var $swbid;
	var $city_code;
	var $city_name;
	var $allow_details;
	var $temperature_unit;
	var $sql;
	var $current_forecast;
	var $current_forecast_date;
	var $tzone;
	var $config_in_database;
	var $table;
	var $cache_table;

	function sweatherbloc($config=1,$table='sweatherbloc_config')
	{
		$db =& Database::getInstance();
		$this->table = $db->prefix($table);
		$this->cache_table = $db->prefix("sweatherbloc_datacache");
		$this->city_code="FRXX0076";
		$this->city_name="Paris";
		$this->allow_details="0";
		$this->temperature_unit="C";
		if (is_array($config))
			$this->swbid=$config[0];
		else
			$this->swbid=$config;
		$this->getConfig();
		$this->current_forecast_date=0;
//		echo "<br/> $config <br/>";
	}

	function getConfig()
	{
		$db =& Database::getInstance();
//		var_dump ($this->swbid) ;
		$this->sql = "SELECT * FROM ".$this->table." WHERE swbid=".$this->swbid;
//		echo $this->sql;echo "<br/";
		if ($resArray = $db->fetchRow($db->query($this->sql)))
		{
//		    var_dump($resArray);
			list($this->swbid,$this->city_code,$this->city_name,$this->allow_details,$this->temperature_unit)=$resArray;
			$this->config_in_database=true;
		}
	}

	function storeConfig()
	{
		$db =& Database::getInstance();

		if (!isset($this->config_in_database))
		{
			$this->sql = sprintf("INSERT INTO %s (swbid ,citycode , cityname , allowdetails , tempunit) VALUES (%u, \"%s\", \"%s\", \"%s\",\"%s\")",$this->table,$this->swbid, $this->city_code, $this->city_name, $this->allow_details, $this->temperature_unit);
		}
		else
		{
			$this->sql = sprintf("UPDATE %s set swbid=\"%s\" ,citycode=\"%s\" , cityname=\"%s\" , allowdetails=\"%s\" , tempunit=\"%s\" WHERE swbid=\"%s\"",$this->table,$this->swbid, $this->city_code, $this->city_name, $this->allow_details, $this->temperature_unit,$this->swbid);
		}
		if (!$result = $db->query($this->sql))
		{
			
			return false;
		}
		return true;
	}
	
	function getForecastData()
	{

		//$DataUpdated=false;
		$WebError=false;
//		echo "000-";
//		var_dump($WebError);

//		echo " data ";
		$db =& Database::getInstance();
		$this->sql = 'SELECT * FROM '. $this->cache_table . ' WHERE citycode="' . $this->city_code.'"' ;
		//echo $this->sql;
		if ($resArray = $db->fetchRow($db->query($this->sql)))
		{
		//var_dump($resArray);
			list($city_code_dummy,$this->current_forecast_date,$this->current_forecast)=$resArray;
			if ((time()-$this->current_forecast_date)<1801)
			{
//				echo " cache 30 mn ";//echo "<br/>Time : " . gmdate("D M j G:i:s T Y") ;
				//echo "<br/>Stored : " . gmdate("D M j G:i:s T Y",$this->current_forecast_date) . "<br/>";
				return true;

			}
		}

		ini_set('user_agent','MSN Weather');

		$fa = @fopen('http://weather.msn.com/weatherdata.aspx?wealocations=wc:'.$this->city_code, 'rb');
//		echo "111:". $fa; var_dump($WebError);
		if(!$fa)
		{
			$WebError=true;
//			echo "<br/>*open error True"; var_dump($WebError);echo"*<br/>";
		}
		else
		{
			$forecastContent ='';
			while (!feof($fa)) 
  				$forecastContent .= @fread($fa, 8192);
			fclose($fa);
//			echo "le else:";echo strlen($forecastContent);echo"-"; 
			if(strlen($forecastContent) == 0)
			{
				$WebError=true;
//				echo "<br/>*read error True"; var_dump($WebError);echo "*<br/>";
			}
		}
//		echo "222"; var_dump($WebError);
		if($WebError==true)
		{
			if ((time()-$this->current_forecast_date)<21600) // 6hours
			{
//				echo " cache 6h ";//echo "<br/>*ret True" .time()."-". $this->current_forecast_date. "-" . (time()-$this->current_forecast_date) . "*<br/>";
				return true;
				
			}
			else
			{
//				echo "<br/>*ret False" . "*<br/>";
				return false;
				
			}
		}
//		echo "333"; var_dump($WebError);
		

		$p = xml_parser_create();
		xml_parse_into_struct($p, $forecastContent, $vals, $index);
		xml_parser_free($p);

		$timeStamp= $vals[2]['attributes']['DATE'] . " " . $vals[2]['attributes']['OBSERVATIONTIME'];
		$this->current_forecast_date= strtotime($timeStamp);
		$this->tzone=$vals[1]['attributes']['TIMEZONE'];
		$TimeTable = gettimeofday();
		$this->current_forecast_date=$this->current_forecast_date - ($TimeTable['minuteswest']*60)+$TimeTable['dsttime']*3600  - $this->tzone *3600;
/*
		echo '<br/>';
		echo "ts: $timeStamp <br/>";
		echo "cfd: $this->current_forecast_date <br/>";
		echo "tim: $time". time()." <br/>";
		echo 'tt : '; print_r($TimeTable); echo "<br/>";
*/
		$this->sql = 'DELETE FROM '. $this->cache_table . ' WHERE citycode="' . $this->city_code . '"';
		$db->queryF($this->sql);
		//echo $this->sql ."<br/>";
		$this->sql = sprintf("INSERT INTO %s (citycode ,date ,data ) VALUES ('%s',%d, '%s')",$this->cache_table,$this->city_code, $this->current_forecast_date,$forecastContent);
		//echo $this->sql ."<br/>";
		$res = $db->queryF($this->sql);
		//$db->error();

		$this->current_forecast = $forecastContent;
		return true;
	}
	
	function getCityName()
	{
		return $this->city_name;
	}
	
	function getRealCityNameFromCode()
	{
		
		ini_set('user_agent','MSN Weather');

		$fa = @fopen('http://weather.msn.com/weatherdata.aspx?wealocations=wc:'.$this->city_code, 'rb');
		if(!$fa)
		{
			return false;
		}
		else
		{
			$forecastContent ='';
			while (!feof($fa)) 
  				$forecastContent .= @fread($fa, 8192);
			fclose($fa);
			if(strlen($forecastContent) == 0)
			{
				return false;
			}
		}
		
		$p = xml_parser_create();
		xml_parse_into_struct($p, $forecastContent, $vals, $index);
		xml_parser_free($p);
		
		return $vals[1]['attributes']['WEATHERLOCATIONNAME'];
	}
	
	function getForecastBlockInfo(&$block)
	{
		$days2Display = array ( "Sunday" =>_MB_SWB_SUNDAY, "Monday" =>_MB_SWB_MONDAY, "Tuesday"=>_MB_SWB_TUESDAY,"Wednesday"=>_MB_SWB_WENESDAY,"Thursday"=>_MB_SWB_THURSDAY,"Friday"=>_MB_SWB_FRIDAY,"Saturday"=>_MB_SWB_SATURDAY);

		if($this->getForecastData()==false)
			return false;
		
//		echo "<br/>*GFB:"; 
		
		$p = xml_parser_create();
		xml_parse_into_struct($p, $this->current_forecast, $vals, $index);
		xml_parser_free($p);
		
		$i=0;
		foreach ($vals as $pIndex => $pVal)
		{
//			print_r ($pVal);
			if ($pVal['tag'] =='FORECAST')
			{
				$i++;
				$block['image'.$i] = '"' . $vals[1]['attributes']['IMAGERELATIVEURL'] . $vals[$pIndex]['attributes']['SKYCODEDAY'] . ".gif" . '"';
//				$block['image'.$i] = '"' . XOOPS_URL . "/modules/sweatherbloc/images/" . $vals[$pIndex]['attributes']['SKYCODEDAY'] . "_w.gif" . '"';
				$block['maxTemp'.$i] = $this->temperature_unit=="C"?round(($vals[$pIndex]['attributes']['HIGH'] - 32)* 5 / 9) . "&deg;C":$vals[$pIndex]['attributes']['HIGH'] . "&deg;F";
				$block['minTemp'.$i] = $this->temperature_unit=="C"?round(($vals[$pIndex]['attributes']['LOW'] - 32)* 5 / 9) . "&deg;C":$vals[$pIndex]['attributes']['LOW'] . "&deg;F";
				$block['day'.$i] = $days2Display[$vals[$pIndex]['attributes']['DAY']];
			}
		}

    if($this->allow_details)
    {
		$block['details']=true;
		$block['details_url'] = '"' . XOOPS_URL . "/modules/sweatherbloc/index.php?bid=" . $this->swbid. '"';
	}
	else
		$block['details']=false;

    return true;
	}
	
	function getForecastFullInfo(&$wCurrent,&$wForecast)
	{
		
		$days2Display = array ( "Sunday" =>_MD_SWB_SUNDAY, "Monday" =>_MD_SWB_MONDAY, "Tuesday"=>_MD_SWB_TUESDAY,"Wednesday"=>_MD_SWB_WENESDAY,"Thursday"=>_MD_SWB_THURSDAY,"Friday"=>_MD_SWB_FRIDAY,"Saturday"=>_MD_SWB_SATURDAY);

		if($this->getForecastData()==false)
			return false;
		
//		echo "<br/>*GFB:"; 
		
		$p = xml_parser_create();
		xml_parse_into_struct($p, $this->current_forecast, $vals, $index);
		xml_parser_free($p);
		
		$i=0;
		foreach ($vals as $pIndex => $pVal)
		{
//			print_r ($pVal);
			
			if ($pVal['tag'] =='CURRENT')
			{
				$wCurrent['lastUpdate']= $vals[$pIndex]['attributes']['OBSERVATIONTIME'];
				$wCurrent['temp']= $this->temperature_unit=="C"?round(($vals[$pIndex]['attributes']['TEMPERATURE'] - 32)* 5 / 9) . "&deg;C":$vals[$pIndex]['attributes']['TEMPERATURE'] . "&deg;F";
				$wCurrent['icon']=  '"' . $vals[1]['attributes']['IMAGERELATIVEURL'] . $vals[$pIndex]['attributes']['SKYCODE'] . ".gif" . '"';
				$wCurrent['windMph']= $vals[$pIndex]['attributes']['WINDSPEED'] . " mph";
				$wCurrent['windKmh']= round($vals[$pIndex]['attributes']['WINDSPEED']*1.609) . " km/h";
				$wCurrent['humid']= $vals[$pIndex]['attributes']['HUMIDITY'] . "&#37;";
				$wCurrent['feelTemp']= $this->temperature_unit=="C"?round(($vals[$pIndex]['attributes']['FEELSLIKE'] - 32)* 5 / 9) . "&deg;C":$vals[$pIndex]['attributes']['FEELSLIKE'] . "&deg;F";
				
				
			}
			if ($pVal['tag'] =='FORECAST')
			{
				$i++;
				$wForecast['image'.$i] = '"' . $vals[1]['attributes']['IMAGERELATIVEURL'] . $vals[$pIndex]['attributes']['SKYCODEDAY'] . ".gif" . '"';
				$wForecast['maxTemp'.$i] = $this->temperature_unit=="C"?round(($vals[$pIndex]['attributes']['HIGH'] - 32)* 5 / 9) . "&deg;C":$vals[$pIndex]['attributes']['HIGH'] . "&deg;F";
				$wForecast['minTemp'.$i] = $this->temperature_unit=="C"?round(($vals[$pIndex]['attributes']['LOW'] - 32)* 5 / 9) . "&deg;C":$vals[$pIndex]['attributes']['LOW'] . "&deg;F";
				$wForecast['day'.$i] = $days2Display[$vals[$pIndex]['attributes']['DAY']];
				$wForecast['rainProb'.$i] = $vals[$pIndex]['attributes']['PRECIP'] . "&#37;";
			}
		}

	return true;
}
}
?>
