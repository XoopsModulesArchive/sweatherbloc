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

include "../../mainfile.php";
include_once XOOPS_ROOT_PATH . "/modules/sweatherbloc/class/class.sweatherbloc.php";

include_once XOOPS_ROOT_PATH.'/header.php';


$xoopsOption['template_main'] = 'swb_index.html';

	$Conf=1;
	if (isset($_GET['bid']))
		$Conf=$_GET['bid'];

	if($Conf<=0)
		$Conf = 1;
		
	if($Conf>4)
		$Conf = 1;	

	$weather = new sweatherbloc ($Conf);

	if ($weather->getForecastFullInfo($wCurrent,$wForecast))
	{
		$wCurrent['error'] = false;
		$wCurrent['city_name'] = $weather->getCityName();
	}
	else
	{
	    $wCurrent['error'] = true;
		$wCurrent['city_name'] = _MD_SWB_ERROR . $weather->getCityName();
	}

	$xoopsTpl->assign('wCurrent', $wCurrent);
	$xoopsTpl->assign('wForecast', $wForecast);


include_once XOOPS_ROOT_PATH.'/footer.php';
