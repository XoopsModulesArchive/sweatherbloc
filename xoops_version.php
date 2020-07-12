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

// Main Info

$modversion['name'] = _MI_SWB_NAME;
$modversion['version'] = "2.0";
$modversion['description'] = _MI_SWB_DESC;
$modversion['credits'] = "T. Andre";
$modversion['author'] = "T. Andre";
$modversion['help'] = "";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "images/SWB_logo.png";
$modversion['dirname'] = "sweatherbloc";

//SQL

$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][0] = "sweatherbloc_config";
$modversion['tables'][1] = "sweatherbloc_datacache";

//Admin

$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

//Menu

$modversion['hasMain'] = 1;

// Templates

$modversion['templates'][1]['file']='swb_index.html';
$modversion['templates'][1]['description']= _MI_SWB_TEMPLATE_DESC;

// Blocks
$modversion['blocks'][1]['file'] = "sweather_bloc.php";
$modversion['blocks'][1]['name'] = _MI_SWB_BNAME1;
$modversion['blocks'][1]['description'] = _MI_SWB_BDESC;
$modversion['blocks'][1]['show_func'] = "b_swb_show";
$modversion['blocks'][1]['options'] = "1";
$modversion['blocks'][1]['edit_func'] = "";
$modversion['blocks'][1]['template'] = 'swb_block.html';

$modversion['blocks'][2]['file'] = "sweather_bloc.php";
$modversion['blocks'][2]['name'] = _MI_SWB_BNAME2;
$modversion['blocks'][2]['description'] = _MI_SWB_BDESC;
$modversion['blocks'][2]['show_func'] = "b_swb_show";
$modversion['blocks'][2]['options'] = "2";
$modversion['blocks'][2]['edit_func'] = "";
$modversion['blocks'][2]['template'] = 'swb_block.html';

$modversion['blocks'][3]['file'] = "sweather_bloc.php";
$modversion['blocks'][3]['name'] = _MI_SWB_BNAME3;
$modversion['blocks'][3]['description'] = _MI_SWB_BDESC;
$modversion['blocks'][3]['show_func'] = "b_swb_show";
$modversion['blocks'][3]['options'] = "3";
$modversion['blocks'][3]['edit_func'] = "";
$modversion['blocks'][3]['template'] = 'swb_block.html';

$modversion['blocks'][4]['file'] = "sweather_bloc.php";
$modversion['blocks'][4]['name'] = _MI_SWB_BNAME4;
$modversion['blocks'][4]['description'] = _MI_SWB_BDESC;
$modversion['blocks'][4]['show_func'] = "b_swb_show";
$modversion['blocks'][4]['options'] = "4";
$modversion['blocks'][4]['edit_func'] = "";
$modversion['blocks'][4]['template'] = 'swb_block.html';

// Search
$modversion['hasSearch'] = 0;

// Smarty
$modversion['use_smarty'] = 1;

// Notification
?>
