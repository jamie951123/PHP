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


ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE); 

$content = file_get_contents('php://input');
$content_json = json_decode($content, true);
$partyId = $content_json[0][partyId];

if($partyId == null){
    echo 'No PartyId';
    exit;
}

$sql_getProductPool = mysql_query("SELECT * FROM  `receivingOrder` where `partyId` = '$partyId' order by `orderId`"); 
$count_getProductPool = mysql_num_rows($sql_getProductPool);
$getProductPoolArray = array();

if($count_getProductPool >0){
    while($row_getProductPool = mysql_fetch_assoc($sql_getProductPool)) {
      $getProductPoolArray[] =  $row_getProductPool;
    }
    echo json_encode($getProductPoolArray);
}
mysql_close();
?>