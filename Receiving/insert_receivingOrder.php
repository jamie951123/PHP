<?php
include("/Applications/XAMPP/xamppfiles/htdocs/RMS/Common/commonServe.php");
include("/Applications/XAMPP/xamppfiles/htdocs/RMS/Common/objectUtil.php");

$connect=mysql_connect($host, $username, $password) 
                    or die ("Sorry, unable to connect database server");

$dbselect=mysql_select_db($dbname,$connect)
    or die ("Sorry, unable to connect database");

$insertsuccessful = "InsertSuccessful";
$insertfail = "InsertFail";
$queryfail = "QueryFail";
$nullValueArray = array();


$key_orderId = 'orderId';
$key_partyId = 'partyId';
$key_receivingDate = 'receivingDate';
$key_remark = 'remark';
$key_status = 'status';
$key_createDate = 'createDate';
$key_closeDate = 'closeDate';
$key_actualQty = 'actualQty';
$key_estimateQty = 'estimateQty';

ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE); 

$content = file_get_contents('php://input');
$content_json = json_decode($content,true);

//$orderId        = returnNullField($key_orderId,$content_json[0][orderId]);
//$closeDate      = returnNullField($key_closeDate,$content_json[0][closeDate]);
$remark         = $content_json[0][remark];
$status         = "PROCESS";
$actualQty      = $content_json[0][actualQty];
$estimateQty    = $content_json[0][estimateQty];
//must input
$partyId        = returnNullField($key_partyId,$content_json[0][partyId]);
$receivingDate  = returnNullField($key_receivingDate,$content_json[0][receivingDate]);
$createDate     = returnNullField($key_createDate,$content_json[0][createDate]);

//$partyId = "partyId";
//$receivingDate = "2017-04-05 00:00:00";
//$createDate = "2017-04-05 00:00:00";

$obj = new stdClass();
$obj -> selection = "ReceivingIncreaseOrder";
$obj -> missingField = $nullValueArray;

if(isNullEmpty($partyId) || isNullEmpty($receivingDate) || isNullEmpty($createDate)){
    $obj ->insertMessage = $insertfail;
    $obj ->missingField = $nullValueArray;
    echo json_encode($obj);
    exit;
}

$sql_insert_receivingOrder = mysql_query("INSERT INTO `receivingOrder` 
(
`$key_orderId`, 
`$key_partyId`, 
`$key_receivingDate`, 
`$key_remark`, 
`$key_status`, 
`$key_createDate`,
`$key_closeDate`, 
`$key_actualQty`, 
`$key_estimateQty`
) 
VALUES 
('', 
'$partyId', 
'$receivingDate', 
'$remark',
'$status',
'$createDate',
'',
'$actualQty', 
'$estimateQty'
) ");

if($sql_insert_receivingOrder){
    $obj ->insertMessage = $insertsuccessful;
}else{
     $obj ->insertMessage = $queryfail;
}
echo json_encode($obj);

mysql_close();
?>