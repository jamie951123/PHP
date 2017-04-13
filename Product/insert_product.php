<?php
include("/Applications/XAMPP/xamppfiles/htdocs/RMS/Common/commonServe.php");
include("/Applications/XAMPP/xamppfiles/htdocs/RMS/Common/objectUtil.php");

//$host="mysql8.000webhost.com";
//$username="a3371627_james";
//$password="y5139977";
//$dbname =  "a3371627_Goods";

// Connect to server
$connect=mysql_connect($host, $username, $password) 
                    or die ("Sorry, unable to connect database server");

$dbselect=mysql_select_db($dbname,$connect)
    or die ("Sorry, unable to connect database");

$insertsuccessful = "InsertSuccessful";
$insertfail = "InsertFail";
$queryfail = "QueryFail";
$nullValueArray = array();

$key_productId = 'productId';
$key_productCode = 'productCode';
$key_productName = 'productName';
$key_partyId = 'partyId';
$key_status = 'status';
$key_createDate = 'createDate';
$key_closeDate = 'closeDate';
$key_remark = 'remark';
$key_productDescriptionCH = 'productDescriptionCH';
$key_productDescriptionEN = 'productDescriptionEN';

ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE); 

$content = file_get_contents('php://input');
$content_json = json_decode($content,true);
$productCode = returnNullField($key_productCode,$content_json[0][productCode]);
$productName = returnNullField($key_productName,$content_json[0][productName]);
$partyId     = returnNullField($key_partyId,$content_json[0][partyId]);
$status      = "PROCESS";
$createDate  = returnNullField($key_createDate,$content_json[0][createDate]);
$closeDate   = $content_json[0][closeDate];
$remark      = $content_json[0][remark];
$productDescriptionCH = $content_json[0][productDescriptionCH];
$productDescriptionEN = $content_json[0][productDescriptionEN];

$obj = new stdClass();
$obj -> selection = "AllProduct";
$obj -> missingField = $nullValueArray;

if(isNullEmpty($productCode) || isNullEmpty($productName) || 
   isNullEmpty($partyId) || isNullEmpty($createDate)){
    $obj ->insertMessage = $insertfail;
    $obj ->missingField = $nullValueArray;
    echo json_encode($obj);
    exit;
}

$sql_insertProduct = mysql_query("
INSERT INTO `productPool` (
`$key_productId` ,
`$key_productCode` ,
`$key_productName` ,
`$key_partyId` ,
`$key_status` ,
`$key_createDate` ,
`$key_closeDate` ,
`$key_remark` ,
`$key_productDescriptionCH` ,
`$key_productDescriptionEN`
)
VALUES (
NULL , 
'$productCode', 
'$productName', 
'$partyId', 
'$status',  
'$createDate',
'$closeDate' , 
'$remark', 
'$productDescriptionCH', 
'$productDescriptionEN'
);");



if ($sql_insertProduct) {
    $obj ->insertMessage = $insertsuccessful;
} else {
    $obj ->insertMessage = $queryfail;
} 
echo json_encode($obj);

//function returnNullField ($key,$value){
//    if($value == null){
//        global $nullValueArray;
//        array_push($nullValueArray,$key);
//    }
//    return $value;
//}
//
//function isNullEmpty($value){
//    $result = false;
//    if($value == null){
//        $result = true;
//    }
//    return $result;
//}
mysql_close();
?>