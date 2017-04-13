<?php

function isNullEmpty($value){
    $result = false;
    if($value == null || $value == ""){
        $result = true;
    }
    return $result;
}

function returnNullField ($key,$value){
    if($value == null){
        global $nullValueArray;
        array_push($nullValueArray,$key);
    }
    return $value;
}

?>