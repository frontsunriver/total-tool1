<?php
//include('includes/inc.head.php');
include("UpsClass.php");

/*$cServiceCodes = array('UGN' => "GND", 'U2D' => "2DA", 'U2A' => "2DM", 'U3S' => "3DS", 
'UNS' => "1DP", 'UND' => "1DA", 'UNA' => "1DM", 'UWE' => "UPSWWE", 'UWP' => "UPSWWEXPP",
'UWX' => "UPSWWX", 'UCX' => "UPSSTD", 'UCE' => "UPSSTD", 'UCP' => "UPSSTD", 'UCS' => "UPSSTD");*/

$upsobj = new UPS();

$upsobj->SetLicenseNumer($_REQUEST['access_key']);    # UPS License Number
$upsobj->SetUserName($_REQUEST['user_name']);              # UPS Username
$upsobj->SetUserPassword($_REQUEST['password']);          # UPS Password

$upsobj->SetPickUpType($_REQUEST['pickUpType']);                  # Drop Off Location

$upsobj->SetShipToPostalCode($_REQUEST['shipToPostalCode']);         # Origin Postal Code
$upsobj->SetShipToCountryCode($_REQUEST['shipToCountryCode']);           # Origin Country

$upsobj->SetShipFromPostalCode($_REQUEST['shipFromPostalCode']);       # Destination Postal Code
$upsobj->SetShipFromCountryCode($_REQUEST['shipFromCountryCode']);         # Destination Country

$upsobj ->SetResidentialIndicator("RES");      				# Residence Shipping and for commercial shipping "COM"

$upsobj->SetServiceCode($_REQUEST['cServiceCodes']); 		# Sipping rate for UPS Ground 
$upsobj->SetPackagingType($_REQUEST['packagingType']);
$upsobj->SetPackageDimensionUOM("IN");        				 # Dimension in Inches

$upsobj->SetPackageLength(6);                				 # Package Length
$upsobj->SetPackageWidth(6);                  				 # Package Width
$upsobj->SetPackageHeight(6);              							# Package Height

$upsobj->SetPackageWeightUOM("LBS");           							# Weight in Pounds
$upsobj->SetPackageWeight($_REQUEST['packageWeight']);                  # Package Weight

$rate = $upsobj->GetRate();

echo $rate

?>