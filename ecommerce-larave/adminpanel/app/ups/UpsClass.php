<?php

class XML_Array{
var $_data = Array();
var $_name = Array();
var $_rep  = Array();
var $_parser = 0;
var $_ignore = Array(),$_replace = Array(),$_showAttribs;
var $_level = 0;

function __construct(&$data,$ignore = Array(),$replace = Array(),$showattribs = false,$toupper = false)
{
$this->_showAttribs = $showattribs;
$this->_parser  = xml_parser_create();

 xml_set_object($this->_parser,$this);
 if ($toupper)
 {
 foreach ($ignore  as $key => $value) $this->_ignore[strtoupper($key)]  = strtoupper($value);
 foreach ($replace as $key => $value) $this->_replace[strtoupper($key)] = strtoupper($value);
 xml_parser_set_option($this->_parser,XML_OPTION_CASE_FOLDING,true);
 }
 else
 {
 $this->_ignore  = &$ignore;
 $this->_replace = &$replace;
 xml_parser_set_option($this->_parser,XML_OPTION_CASE_FOLDING,false);
 }
 xml_set_element_handler($this->_parser, "_startElement", "_endElement");
 xml_set_character_data_handler($this->_parser, "_cdata");

 $this->_data = array();
 $this->_level = 0;
 if(!xml_parse($this->_parser, $data, true))
 {
 //new Error("XML Parse Error: ".xml_error_string(xml_get_error_code($this->_parser)).
 //"\n on line: ".xml_get_current_line_number($this->_parser),true);
 return false;
 }
 xml_parser_free($this->_parser);
 }
 function & ReturnArray() {
 return $this->_data[0];
 }
 function & ReturnReplaced() {
 return $this->_data['_Replaced_'];
 }
 function & ReturnAttributes() {
 return $this->_data['_Attributes_'];
 }
 function _startElement($parser, $name, $attrs)
 {
 if (!isset($this->_rep[$name])) $this->_rep[$name] = 0;
 if (!in_array($name,$this->_ignore))
 {
 $this->_addElement($name,$this->_data[$this->_level],$attrs,true);
 $this->_name[$this->_level] = $name;
 $this->_level++;
 }
 }
 function _endElement($parser,$name)
 {
 if (!in_array($name,$this->_ignore) && isset($this->_name[$this->_level - 1]))
 {
 if (isset($this->_data[$this->_level]))
 {
 $this->_addElement($this->_name[$this->_level - 1],$this->_data[$this->_level - 1],
 $this->_data[$this->_level],false);
 }
 unset($this->_data[$this->_level]);
 $this->_level--;
 $this->_rep[$name]++;
 }
 }
 function _cdata($parser, $data)
 {
 if ($this->_name[$this->_level - 1]) {
 $this->_addElement($this->_name[$this->_level - 1],$this->_data[$this->_level - 1],
 str_replace(array("&gt;", "&lt;","&quot;", "&amp;"), array(">","<",'"',"&"),$data),false);
 }
 }
 function _addElement(&$name,&$start,$add = array(),$isattribs = false)
 {
 if ((sizeof($add) == 0 && is_array($add)) || !$add) {
 if (!isset($start[$name])) $start[$name] = '';
 $add = '';
 //if (is_array($add)) return;
 //return;
 }
 if (strtoupper($this->_replace[$name]) == '_ARRAY_') {
 if (!$start[$name]) $this->_rep[$name] = 0;
 $update = &$start[$name][$this->_rep[$name]];
 }
 elseif ($this->_replace[$name]) {
 if ($add[$this->_replace[$name]]) {
 $this->_data['_Replaced_'][$add[$this->_replace[$name]]] = $name;
 $name = $add[$this->_replace[$name]];
 }
 $update = &$start[$name];
 }
 else {
 $update = &$start[$name];
 }

 if     ($isattribs && !$this->_showAttribs) return;
 elseif ($isattribs) $this->_data['_Attributes_'][$this->_level][$name][] = $add;
 elseif (is_array($add) && is_array($update)) $update += $add;
 elseif (is_array($update)) return;
 elseif (is_array($add)) $update = $add;
 elseif ($add)   $update .= $add;
 }
}

class UPS extends XML_Array{
 //the varibales come here

 var $license_number;
 var $user_name;
 var $user_password;
 var $pickup_type;
 var $shipper_postal_code;
 var $shipper_country_code;
 var $shipto_postal_code;
 var $shipto_country_code;
 var $shipfrom_postal_code;
 var $shipfrom_country_code;
 var $service_code;
 var $packaging_type;
 var $package_dimension_uom;
 var $package_length;
 var $package_width;
 var $package_height;
 var $package_weight_uom;
 var $package_weight;
 var $xml_string;
 var $result;
 var $residentialindicator;
 var $instances;
 function __construct()
 {

 }

 function GetRate()
 {
 $this->PrepareXmlString();
 $this->DoCurlOpts();
 $res=$this->GetResult();
 $xmlobj = new XML_Array($res,array(),array(),true,false);
 $myarray = $xmlobj->ReturnArray();       
 $final_result = $this->ProcessArray($myarray);

 return $final_result;
 }//end GetRate

 function ProcessArray($myarray)
 {
 //print_r($myarray);

 if($myarray['RatingServiceSelectionResponse']['Response']['ResponseStatusCode'] == 1)
 {

 $temp_result = $myarray['RatingServiceSelectionResponse']['RatedShipment']['TotalCharges']['MonetaryValue'];
 //return the surcharge here

 return $temp_result;

 }
 else{
 $error_msg = "";
 //$error_msg .= "Error Status Description:".
 //$myarray['RatingServiceSelectionResponse']['Response']['ResponseStatusDescription']."<br>";
 $error_msg .= "Error Description :".
 $myarray['RatingServiceSelectionResponse']['Response']['Error']['ErrorDescription']."<br>";
 return $error_msg;

 }
 }
 function PrepareXmlString()
 {
 $this->xml_string     = "";
 $this->xml_string   = "<?xml version=\"1.0\" ?>";
 $this->xml_string  .= "<AccessRequest xml:lang=\"en-US\">";
 $this->xml_string  .=          "<AccessLicenseNumber>".$this->GetLicenseNumer()."</AccessLicenseNumber>";
 $this->xml_string  .=                  "<UserId>".$this->GetUserName()."</UserId>";
 $this->xml_string  .=                  "<Password>".$this->GetUserPassword()."</Password>";
 $this->xml_string  .= "</AccessRequest>";
 $this->xml_string  .= "<?xml version=\"1.0\" ?>";
 $this->xml_string  .= "<RatingServiceSelectionRequest xml:lang=\"en-US\">";
 $this->xml_string  .=        "<Request>";
 $this->xml_string  .=            "<TransactionReference>";
 $this->xml_string  .=                "<CustomerContext>Bare Bones Rate Request</CustomerContext>";
 $this->xml_string  .=                    "<XpciVersion>1.0</XpciVersion>";
 $this->xml_string  .=            "</TransactionReference>";
 $this->xml_string  .=            "<RequestAction>Rate</RequestAction>";
 $this->xml_string  .=            "<RequestOption>Rate</RequestOption>";
 $this->xml_string  .=        "</Request>";
 $this->xml_string  .=        "<PickupType>";
 $this->xml_string  .=            "<Code>".$this->GetPickUpType()."</Code>";
 $this->xml_string  .=        "</PickupType>";
 $this->xml_string  .=        "<Shipment>";
 $this->xml_string  .=            "<Shipper>";
 $this->xml_string  .=                "<Address>";
 $this->xml_string  .=                    "<PostalCode>".$this->GetShipperPostalCode()."</PostalCode>";
 $this->xml_string  .=                    "<CountryCode>".$this->GetShipperCountryCode()."</CountryCode>";
 $this->xml_string  .=                "</Address>";
 $this->xml_string  .=            "</Shipper>";
 $this->xml_string  .=            "<ShipTo>";
 $this->xml_string  .=            "<Address>";
 $this->xml_string  .=                "<PostalCode>".$this->GetShipToPostalCode()."</PostalCode>";
 $this->xml_string  .=                "<CountryCode>".$this->GetShipToCountryCode()."</CountryCode>";
 if($this->GetResidentialIndicator() == "Y")
 {
 $this->xml_string  .=                "<ResidentialAddressIndicator/>";
 }
 $this->xml_string  .=            "</Address>";
 $this->xml_string  .=            "</ShipTo>";
 $this->xml_string  .=            "<ShipFrom>";
 $this->xml_string  .=            "<Address>";
 $this->xml_string  .=                "<PostalCode>".$this->GetShipFromPostalCode()."</PostalCode>";
 $this->xml_string  .=                "<CountryCode>".$this->GetShipFromCountryCode()."</CountryCode>";
 $this->xml_string  .=            "</Address>";
 $this->xml_string  .=            "</ShipFrom>";
 $this->xml_string  .=            "<Service>";
 $this->xml_string  .=                "<Code>".$this->GetServiceCode()."</Code>";
 $this->xml_string  .=            "</Service>";

 for($i = 0 ; $i < $this->instance; $i++)
 {
 $this->xml_string  .=            "<Package>";
 $this->xml_string  .=                "<PackagingType>";
 $this->xml_string  .=                    "<Code>".$this->GetPackagingType()."</Code>";
 $this->xml_string  .=                "</PackagingType>";
 $this->xml_string  .=                "<Dimensions>";
 $this->xml_string  .=                    "<UnitOfMeasurement>";
 $this->xml_string  .=                        "<Code>".$this->GetPackageDimensionUOM()."</Code>";
 $this->xml_string  .=                    "</UnitOfMeasurement>";
 $this->xml_string  .=                    "<Length>".$this->GetPackageLength()."</Length>";
 $this->xml_string  .=                    "<Width>".$this->GetPackageWidth()."</Width>";
 $this->xml_string  .=                    "<Height>".$this->GetPackageHeight()."</Height>";
 $this->xml_string  .=                "</Dimensions>";
 $this->xml_string  .=                "<PackageWeight>";
 $this->xml_string  .=                    "<UnitOfMeasurement>";
 $this->xml_string  .=                        "<Code>".$this->GetPackageWeightUOM()."</Code>";
 $this->xml_string  .=                    "</UnitOfMeasurement>";
 $this->xml_string  .=                    "<Weight>".$this->GetPackageWeight()."</Weight>";
 $this->xml_string  .=                "</PackageWeight>";
 $this->xml_string  .=            "</Package>";

 }

 $this->xml_string  .=        "</Shipment>";
 $this->xml_string  .= "</RatingServiceSelectionRequest>";
 //echo $this->xml_string . "<BR><BR>";

 }//end of function PrepareXmlString

 function DoCurlOpts()
 {
 $ch = curl_init(); /// initialize a curl session
 //        echo $this->xml_string;
 //        exit();       ?
 /// the url to post to without the ?query+string
 curl_setopt ($ch, CURLOPT_URL,"https://www.ups.com/ups.app/xml/Rate");
 curl_setopt ($ch, CURLOPT_HEADER, 0); 
 curl_setopt($ch, CURLOPT_POST, 1); // tell curl to do a POST, not a GET
 curl_setopt($ch, CURLOPT_VERBOSE, 1); // tell curl to do a verbose
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // tell curl to do a verbose
 /// the query string goes here as set in the variable above
 curl_setopt($ch, CURLOPT_POSTFIELDS, "$this->xml_string");
 /// allows it to set the response in a variable - $xyz
 curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
 /// allows it to set the response in a variable - $xyz
 curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml;'));
 /// execute the curl session and store the response in the variable $xyz
 $myresult = curl_exec ($ch);
 curl_close ($ch); /// close the curl session
 //$arr = GetXMLTree($myresult);       ?
 $this->SetResult($myresult);

 }//end of function DoCurlOpts

 /******************************************/
 function GetLicenseNumer()
 {
 return  $this->license_number;
 }

 function SetLicenseNumer($value)
 {
 $this->license_number = urlencode($value);
 }
 /******************************************/

 function GetUserName()
 {
 return  $this->user_name;
 }

 function SetUserName($value)
 {
 $this->user_name = urlencode($value);
 }

 /******************************************/
 function GetUserPassword()
 {
 return $this->user_password;
 }

 function SetUserPassword($value)
 {
 $this->user_password = urlencode($value);
 }
 /******************************************/

 function GetPickUpType()
 {
 return $this->pickup_type;
 }

 function SetPickUpType($value)
 {
 $this->pickup_type = urlencode($value);
 }

 /******************************************/
 function GetShipperPostalCode()
 {
 return $this->shipper_postal_code;
 }

 function SetShipperPostalCode($value)
 {
 $this->shipper_postal_code = urlencode($value);
 }
 /******************************************/

 function GetShipperCountryCode()
 {
 return $this->shipper_country_code;
 }

 function SetShipperCountryCode($value)
 {

 $this->shipper_country_code = urlencode($value);
 }

 /******************************************/
 function GetShipToPostalCode()
 {
 return $this->shipto_postal_code;
 }

 function SetShipToPostalCode($value)
 {
 $this->shipto_postal_code = urlencode($value);
 }

 /******************************************/
 function GetShipToCountryCode()
 {
 return  $this->shipto_country_code;
 }

 function SetShipToCountryCode($value)
 {
 $this->shipto_country_code = urlencode($value);
 }
 /******************************************/
 function GetShipFromPostalCode()
 {
 return  $this->shipfrom_postal_code;
 }

 function SetShipFromPostalCode($value)
 {
 $this->shipfrom_postal_code = urlencode($value);
 }
 /******************************************/

 function GetShipFromCountryCode()
 {
 return  $this->shipfrom_country_code;
 }

 function SetShipFromCountryCode($value)
 {
 $this->shipfrom_country_code = urlencode($value);
 }

 /******************************************/
 function GetServiceCode()
 {
 return $this->service_code;
 }
 function SetServiceCode($value)
 {
 $value = strtoupper($value);
 if($value == "1DA")
 {
 $this->service_code = "01";
 }
 else if ($value == "2DA")
 {
 $this->service_code = "02";
 }
 else if ($value == "GND")
 {
 $this->service_code = "03";
 }
 else if ($value == "3DS")
 {
 $this->service_code = "12";
 }
 else if ($value == "1DP")
 {
 $this->service_code = "13";
 }
 else if ($value == "1DM")
 {
 $this->service_code = "14";
 }
 else if ($value == "2DM")
 {
 $this->service_code = "59";
 }
 else if($value == "UPSWWE")
 {
 $this->service_code = "07";
 }
 else if ($value == "UPSWWX")
 {
 $this->service_code = "08";
 }
 else if ($value ==     "UPSSTD")
 {
 $this->service_code = "11";
 }
 else if ($value ==    "UPSWWEXPP")
 {
 $this->service_code = "54";
 }

 }

 /******************************************/
 function GetPackagingType()
 {
 return $this->packaging_type;
 }
 function SetPackagingType($value)
 {
 $this->packaging_type = urlencode($value);
 }
 /******************************************/
 function GetPackageDimensionUOM()
 {
 return $this->package_dimension_uom;
 }
 function SetPackageDimensionUOM($value)
 {
 $this->package_dimension_uom = urlencode($value);
 }
 /******************************************/
 function GetPackageLength()
 {
 return $this->package_length;
 }
 function SetPackageLength($value)
 {
 $this->package_length = urlencode($value);
 }
 /******************************************/
 function GetPackageWidth()
 {
 return  $this->package_width;
 }

 function SetPackageWidth($value)
 {
 $this->package_width = urlencode($value);
 }
 /******************************************/

 function GetPackageHeight()
 {
 return  $this->package_height;
 }

 function SetPackageHeight($value)
 {
 $this->package_height = urlencode($value);
 }
 /******************************************/

 function GetPackageWeightUOM()
 {
 return  $this->package_weight_uom;
 }

 function SetPackageWeightUOM($value)
 {
 $this->package_weight_uom = urlencode($value);
 }

 /******************************************/
 function GetPackageWeight()
 {
 return $this->package_weight;
 }

 function SetPackageWeight($value)
 {

 if(ceil($value) > 150)
 {
 $ceil_weight = ceil($value);
 $this->instance = ceil($ceil_weight/150);           
 $this->package_weight = $value/ $this->instance;
 }
 else{

 $this->instance = 1;
 $this->package_weight = urlencode($value);
 }
 }

 /******************************************/
 function GetResult()
 {
 return $this->result;
 }

 function SetResult($value)
 {
 $this->result = $value;
 }
 /******************************************/
 function GetResidentialIndicator()
 {
 return $this->residentialindicator;
 }
 function SetResidentialIndicator($value)
 {
 $this->residentialindicator = $value;
 }

 function XmlToArray()
 {
 $xml_data = $this->GetResult();

 $parser = xml_parser_create();

 xml_parse_into_struct($parser, $xml_data, $assoc_arr, $idx_arr);
 xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
 xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
 $root_tag = $assoc_arr[0]['tag'];
 $base_tag = strtolower($assoc_arr[1]['tag']);
 $i = 0;
 foreach($assoc_arr as $key => $element)
 {
 if($element['tag'] != $root_tag)
 {

 if(!preg_match('/^\s+$/', $element['value']))
 {
 $tag = strtolower($element['tag']);
 $items[$i][$tag] = $element['value'];
 if($tag == $base_tag)
 {
 $i++;
 }
 }
 elseif(isset($element['attributes']))
 {
 $items[$i]['id'] = $element['attributes']['ID'];
 }
 }
 }

 return $items;
 }//end of function

}//end of class UPS
?>
