<?php
include("/Applications/XAMPP/xamppfiles/htdocs/RMS/Common/commonServe.php");
include("/Applications/XAMPP/xamppfiles/htdocs/RMS/Common/objectUtil.php");

$connect=mysql_connect($host, $username, $password) 
                    or die ("Sorry, unable to connect database server");

$dbselect=mysql_select_db($dbname,$connect)
    or die ("Sorry, unable to connect database");

ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE); 

$content = file_get_contents('php://input');
$content_json = json_decode($content, true);
$partyId = $content_json[0][partyId];
$createDate = $content_json[0][createDate];
//$partyId = "JAMES.TL";
//$createDate = "2017-04-09 03:22:58";
if($partyId == null){
    echo 'No PartyId';
    exit;
}
if($createDate == null){
    echo 'No CreateDate';
    exit;
}
//$sql_getReceivingOrderId = mysql_query("SELECT `orderId` FROM  `receivingOrder` where `partyId` = '$partyId' and `createDate` = `$createDate` "); 

$sql_getReceivingOrderId = mysql_query("SELECT * FROM  `receivingOrder` where `partyId` = '$partyId' and `createDate` = '$createDate'"); 

$count_getReceivingOrderId = mysql_num_rows($sql_getReceivingOrderId);
$getReceivingOrderIdArray = array();
if($count_getReceivingOrderId >0){
    while($row_getReceivingOrderId = mysql_fetch_assoc($sql_getReceivingOrderId)) {
      $getReceivingOrderIdArray[] =  $row_getReceivingOrderId;
    }
    echo json_encode($getReceivingOrderIdArray);
}else{
    echo 'No Receod';
}

?>