<?php
// include du formloader
include XOOPS_ROOT_PATH."/class/xoopsformloader.php";

// création du formulaire (avec thème)
$swbAdminForm = new XoopsThemeForm(_AM_SWB_ADMIN_FORM, "swbAdminForm", "index.php");

$swbAdminForm->insertBreak(_AM_SWB_ADMIN_FORM_TITLE1 . " : " . _AM_SWB_ADMIN_REAL_NAME . $weatherConfig1->city_code ." (".$weatherConfig1->getRealCityNameFromCode().")<br/>");


// création text box 
$swbAdminForm->addElement(new XoopsFormText(_AM_SWB_ADMIN_FORM_CITY_CODE, "CityCode1", 8, 8, $weatherConfig1->city_code), true);

$swbAdminForm->addElement(new XoopsFormText(_AM_SWB_ADMIN_FORM_CITY_NAME, "CityName1", 30, 30, $weatherConfig1->city_name), true);

$swbAdminLinkRadio1 = new XoopsFormRadioYN(_AM_SWB_ADMIN_FORM_RADIO_LINK, "Details1", $weatherConfig1->allow_details);
$swbAdminForm->addElement($swbAdminLinkRadio1, true);

$swbAdminTempUnitRadio1 = new XoopsFormRadio(_AM_SWB_ADMIN_FORM_RADIO_TEMP, "TempUnit1", $weatherConfig1->temperature_unit);
$options = array('C' =>_AM_SWB_ADMIN_FORM_C, 'F' => _AM_SWB_ADMIN_FORM_F);
$swbAdminTempUnitRadio1->addOptionArray($options);
$swbAdminForm->addElement($swbAdminTempUnitRadio1, true);

$swbAdminForm->insertBreak(_AM_SWB_ADMIN_FORM_TITLE2 . " : " . _AM_SWB_ADMIN_REAL_NAME . $weatherConfig2->city_code ." (".$weatherConfig2->getRealCityNameFromCode().")<br/>");


$swbAdminForm->addElement(new XoopsFormText(_AM_SWB_ADMIN_FORM_CITY_CODE, "CityCode2", 8, 8, $weatherConfig2->city_code), true);

$swbAdminForm->addElement(new XoopsFormText(_AM_SWB_ADMIN_FORM_CITY_NAME, "CityName2", 30, 30, $weatherConfig2->city_name), true);

$swbAdminLinkRadio2 = new XoopsFormRadioYN(_AM_SWB_ADMIN_FORM_RADIO_LINK, "Details2", $weatherConfig2->allow_details);
$swbAdminForm->addElement($swbAdminLinkRadio2, true);

$swbAdminTempUnitRadio2 = new XoopsFormRadio(_AM_SWB_ADMIN_FORM_RADIO_TEMP, "TempUnit2", $weatherConfig2->temperature_unit);
$options = array('C' =>_AM_SWB_ADMIN_FORM_C, 'F' => _AM_SWB_ADMIN_FORM_F);
$swbAdminTempUnitRadio2->addOptionArray($options);
$swbAdminForm->addElement($swbAdminTempUnitRadio2, true);

$swbAdminForm->insertBreak(_AM_SWB_ADMIN_FORM_TITLE3 . " : " . _AM_SWB_ADMIN_REAL_NAME . $weatherConfig3->city_code ." (".$weatherConfig3->getRealCityNameFromCode().")<br/>");


$swbAdminForm->addElement(new XoopsFormText(_AM_SWB_ADMIN_FORM_CITY_CODE, "CityCode3", 8, 8, $weatherConfig3->city_code), true);

$swbAdminForm->addElement(new XoopsFormText(_AM_SWB_ADMIN_FORM_CITY_NAME, "CityName3", 30, 30, $weatherConfig3->city_name), true);

$swbAdminLinkRadio3 = new XoopsFormRadioYN(_AM_SWB_ADMIN_FORM_RADIO_LINK, "Details3", $weatherConfig3->allow_details);
$swbAdminForm->addElement($swbAdminLinkRadio3, true);

$swbAdminTempUnitRadio3 = new XoopsFormRadio(_AM_SWB_ADMIN_FORM_RADIO_TEMP, "TempUnit3", $weatherConfig3->temperature_unit);
$options = array('C' =>_AM_SWB_ADMIN_FORM_C, 'F' => _AM_SWB_ADMIN_FORM_F);
$swbAdminTempUnitRadio3->addOptionArray($options);
$swbAdminForm->addElement($swbAdminTempUnitRadio3, true);

$swbAdminForm->insertBreak(_AM_SWB_ADMIN_FORM_TITLE4 . " : " . _AM_SWB_ADMIN_REAL_NAME . $weatherConfig4->city_code ." (".$weatherConfig4->getRealCityNameFromCode().")<br/>");


$swbAdminForm->addElement(new XoopsFormText(_AM_SWB_ADMIN_FORM_CITY_CODE, "CityCode4", 8, 8, $weatherConfig4->city_code), true);

$swbAdminForm->addElement(new XoopsFormText(_AM_SWB_ADMIN_FORM_CITY_NAME, "CityName4", 30, 30, $weatherConfig4->city_name), true);

$swbAdminLinkRadio4 = new XoopsFormRadioYN(_AM_SWB_ADMIN_FORM_RADIO_LINK, "Details4", $weatherConfig4->allow_details);
$swbAdminForm->addElement($swbAdminLinkRadio4, true);

$swbAdminTempUnitRadio4 = new XoopsFormRadio(_AM_SWB_ADMIN_FORM_RADIO_TEMP, "TempUnit4", $weatherConfig4->temperature_unit);
$options = array('C' =>_AM_SWB_ADMIN_FORM_C, 'F' => _AM_SWB_ADMIN_FORM_F);
$swbAdminTempUnitRadio4->addOptionArray($options);
$swbAdminForm->addElement($swbAdminTempUnitRadio4, true);




$button_tray = new XoopsFormElementTray('' ,'');
$submit_btn = new XoopsFormButton('','post', _AM_SWB_ADMIN_BUTTON, 'submit');
$button_tray->addElement($submit_btn);

$swbAdminForm->addElement($button_tray);


$swbAdminForm->display();
?>
