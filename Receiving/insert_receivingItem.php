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

$key_receivingID     = 'receivingID';
$key_productId       = 'productId';
$key_status          = 'status';
$key_createDate      = 'createDate';
$key_receivingDate   = 'receivingDate';
$key_grossWeight     = 'grossWeight';
$key_grossWeightUnit = 'grossWeightUnit';
$key_remark          = 'remark';
$key_partyId         = 'partyId';
$key_orderId         = 'orderId';
$key_itemQty         = 'itemQty';
$key_itemQtyUnit     = 'itemQtyUnit';

ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE); 

$content = file_get_contents('php://input');
$content_json = json_decode($content,true);
$content_json_count  = count($content_json);

$isinsertsuccessful = true;
$obj = new stdClass();
$obj -> selection = "ReceivingIncreaseItem";
$errorIndex = array();
//$obj -> missingField = $nullValueArray;

for($i=0; $i<$content_json_count;$i++){
    $productId          = $content_json[$i][productId];
    $status             = $content_json[$i][status];
    $createDate         = $content_json[$i][createDate];
    $receivingDate      = $content_json[$i][receivingDate];
    $grossWeight        = $content_json[$i][grossWeight];
    $grossWeightUnit    = $content_json[$i][grossWeightUnit];
    $itemQty            = $content_json[$i][itemQty];
    $itemQtyUnit        = $content_json[$i][itemQtyUnit];
    $remark             = $content_json[$i][remark];
    $partyId            = $content_json[$i][partyId];
    $orderId            = $content_json[$i][orderId];
    
    $sql_insert_receivingItem = mysql_query("
    INSERT INTO `receiving` (
    `$key_receivingID`,
    `$key_productId`, 
    `$key_status`, 
    `$key_createDate`, 
    `$key_receivingDate`, 
    `$key_grossWeight`, 
    `$key_grossWeightUnit`,
    `$key_remark`, 
    `$key_partyId`, 
    `$key_orderId`,
    `$key_itemQty`,
    `$key_itemQtyUnit`
    ) 
    VALUES (
    '', 
    '$productId', 
    'PROGRESS', 
    '$createDate',
    '$receivingDate',
    '$grossWeight', 
    '$grossWeightUnit',
    '$remark',
    '$partyId',
    '$orderId',
    '$itemQty',
    '$itemQtyUnit'
    );");
    
    if(!$sql_insert_receivingItem){
        $isinsertsuccessful = false;
        array_push($errorIndex,$i+1);
    }
}
    if($isinsertsuccessful){
        $obj ->insertMessage = $insertsuccessful;
    }else{
        $obj ->insertMessage = $queryfail;
        $obj ->errorIndex    = $errorIndex;
    }

    echo json_encode($obj);

mysql_close();
?>