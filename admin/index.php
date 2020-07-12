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

//include_once 'admin_header.php';
include_once '../../../include/cp_header.php';

include_once XOOPS_ROOT_PATH . "/modules/sweatherbloc/class/class.sweatherbloc.php";

$op = 'form';

if ( isset( $_POST ) )
{
    foreach ( $_POST as $k => $v )
    {
        ${$k} = $v;
    }
}

if ( isset($post))
{
	$op = 'post';
}


$weatherConfig1 = new sweatherbloc(1);
$weatherConfig2 = new sweatherbloc(2);
$weatherConfig3 = new sweatherbloc(3);
$weatherConfig4 = new sweatherbloc(4);

switch ($op)
{
	case "post":
		
		$weatherConfig1->city_code=$CityCode1;
		$weatherConfig1->city_name=$CityName1;
		$weatherConfig1->allow_details=$Details1;
		$weatherConfig1->temperature_unit=$TempUnit1;
		if(!$weatherConfig1->storeConfig())
			{
				redirect_header("index.php", 10,_AM_SWB_ERROR_MODIFY . "   ". $weatherConfig1->sql);
				exit();
			}

		
		$weatherConfig2->city_code=$CityCode2;
		$weatherConfig2->city_name=$CityName2;
		$weatherConfig2->allow_details=$Details2;
		$weatherConfig2->temperature_unit=$TempUnit2;
		if(!$weatherConfig2->storeConfig())
			{
				redirect_header("index.php", 10,_AM_SWB_ERROR_MODIFY . "   ". $weatherConfig2->sql);
				exit();
			}

		
		$weatherConfig3->city_code=$CityCode3;
		$weatherConfig3->city_name=$CityName3;
		$weatherConfig3->allow_details=$Details3;
		$weatherConfig3->temperature_unit=$TempUnit3;
		if(!$weatherConfig3->storeConfig())
			{
				redirect_header("index.php", 10,_AM_SWB_ERROR_MODIFY . "   ". $weatherConfig3->sql);
				exit();
			}

		
		$weatherConfig4->city_code=$CityCode4;
		$weatherConfig4->city_name=$CityName4;
		$weatherConfig4->allow_details=$Details4;
		$weatherConfig4->temperature_unit=$TempUnit4;
		if(!$weatherConfig4->storeConfig())
			{
				redirect_header("index.php", 10,_AM_SWB_ERROR_MODIFY . "   ". $weatherConfig4->sql);
				exit();
			}
		redirect_header("./index.php", 1, _AM_SWB_DBUPDATED);

	break;
	case 'form':
	default:
		//include XOOPS_ROOT_PATH."/header.php";
		xoops_cp_header();
		include "../include/admin_form.inc.php"; // inclusion du formulaire
		//include XOOPS_ROOT_PATH."/footer.php";
		break;
}

xoops_cp_footer();

?>
