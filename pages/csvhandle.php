<?php

session_start();

require_once "../class/csv.class.php";

$charset = "ISO-8859-1";


$arr_in = json_decode(file_get_contents('php://input'), true);

$ret = array();

$separator = "";


switch (stripslashes($arr_in["separator"])) {
    case "TAB":
        $separator = "\t";
        break;
    case "space":
        $separator = " ";
        break;
    case "comma":
        $separator = ",";
        break;
    case "dot":
        $separator = ".";
        break;
    case "colon":
        $separator = ":";
        break;
    case "semicolon":
        $separator = ";";
        break;
    case "other":
        $separator = stripslashes($arr_in["otherseparator"]);
        break;
    default:
        $separator = stripslashes($arr_in["separator"]);
        break;
}


$csv = new csv("../uploads/" . $arr_in["filename"], //csv file link
        $separator, stripslashes($arr_in["enclosure"]), $charset
);


$_SESSION["filename"] = $arr_in["filename"];
$_SESSION["separator"] = $separator;
$_SESSION["enclosure"] = stripslashes($arr_in["enclosure"]);
$_SESSION["csvdata"] = $retstr = json_encode($csv->getArrCsv());

/*
if (count($csv) == 0) { //csv file is empty
    $_SESSION["total_num_columns_in_csv"] = 0;
} else {
    $_SESSION["total_num_columns_in_csv"] = count($csv[0]);  //row 0 are the title.
}
*/

//$_SESSION["test"] = $csv->getArrCsv();

echo $retstr;
