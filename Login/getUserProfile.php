
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

// Run the query
$sql_UserProfile = mysql_query("SELECT * FROM `userProfile`");
$userProfileArray = array();
if($sql_UserProfile){
    while($rowUserProfile = mysql_fetch_assoc($sql_UserProfile)){
        $informatio_resin_id  = $rowUserProfile["userProfileId"];
        $userProfileArray[]= $rowUserProfile;
    }
          echo json_encode($userProfileArray);
}
//echo json_encode($information);
mysql_close();
?>