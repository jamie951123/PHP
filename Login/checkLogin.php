<?php
include("/Applications/XAMPP/xamppfiles/htdocs/RMS/Common/commonServe.php");
include("/Applications/XAMPP/xamppfiles/htdocs/RMS/Common/objectUtil.php");
//$host = "mysql8.000webhost.com";
//$username = "a3371627_james";
//$password = "y5139977";   // default password for "root" user is empty
//$dbname =  "a3371627_Goods";

//$host = "127.0.0.1";
//$username = "root";
//$password = "";
//$dbname =  "RMS";

// Connect to server
$connect=mysql_connect($host, $username, $password) 
                    or die ("Sorry, unable to connect database server");

$dbselect=mysql_select_db($dbname,$connect)
    or die ("Sorry, unable to connect database");

ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE); 
$content = file_get_contents('php://input');
$content_json = json_decode($content, true);
$getUsername = $content_json[0][username];
$getPassword = $content_json[0][password];
//$getUsername = "11";
//$getPassword = "11";
//// Run the query
$sql_CheckUserName =mysql_query("SELECT * FROM `userProfile` WHERE `username` = '$getUsername' and `password` = '$getPassword'");


$count_CheckUserName=mysql_num_rows($sql_CheckUserName);

$succeful = "LoginSuccessful";
$fail = "LoginFail";


if($count_CheckUserName == 1){
    $row = mysql_fetch_assoc($sql_CheckUserName);
    $obj = new stdClass();
    $obj->loginMessage=$succeful;
    $obj->userProfileId=$row["userProfileId"];
    $obj->username=$row["username"];
    $obj->password=$row["password"];
    $obj->partyId=$row["partyId"];
    $obj->status=$row["status"];
    $obj->createDate=$row["createDate"];
    $obj->closeDate=$row["closeDate"];
}else{
    $obj = new stdClass();
    $obj->loginMessage=$fail;
    $obj->userProfileId=$row["userProfileId"];
    $obj->username=$row["username"];
    $obj->password=$row["password"];
    $obj->partyId=$row["partyId"];
    $obj->status=$row["status"];
    $obj->createDate=$row["createDate"];
    $obj->closeDate=$row["closeDate"];
}
echo json_encode($obj);
mysql_close();
?>