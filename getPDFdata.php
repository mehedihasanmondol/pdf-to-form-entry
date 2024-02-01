<?php
require_once 'packages/vendor/autoload.php';
function get_string_after($text,$key){
    return substr($text,strpos($text,$key));
}
function get_pdf_data($file){
    // Parse PDF file and build necessary objects.
    $parser = new \Smalot\PdfParser\Parser();
    $pdf = $parser->parseFile($file);
    $text = $pdf->getText();

    return $text;

    $actual_text = get_string_after($text,"REGISTRATION DATE");
    return $actual_text;

}

$pdf_data = "";
if (isset($_FILES['multiplefileupload'])){
    if (isset($_FILES['multiplefileupload']['name'])){
        $pdf_data = get_pdf_data($_FILES['multiplefileupload']['tmp_name']);
    }
    else{
        die();
    }
}
else{
    die();
}



$string = get_string_after($pdf_data,"REGISTRATION DATE");


function get_value_by_pattern($data,$key){
    $pattern = "/$key\s+(.*?)\t/"; // Matches "ISSUANCE DATE" followed by any characters until the first tab

    preg_match($pattern, $data, $matches);

    if (isset($matches[1])) {
        return trim($matches[1]); // This will print "13 DECEMBER 2023"
    } else {
        return "";
    }
}

function get_value_by_pattern_2($data,$key){
    preg_match("/$key\s*(.*)/", $data, $matches);

    if (isset($matches[1])) {
        return trim($matches[1]); // This will print "13 DECEMBER 2023"
    } else {
        return "";
    }
}

function get_value_by_pattern_3($data,$key_from,$key_to){
    preg_match("/$key_from\s+(.*)\s+$key_to/", $data, $matches);

    if (isset($matches[1])) {
        return $matches[1]; // This will print "13 DECEMBER 2023"
    } else {
        return "";
    }
}


function get_value_by_position($data,$key_from,$key_to){

    $start = strpos($data,$key_from) + strlen($key_from);
    if (!$key_to){
        $limit = null;
    }
    else{
        $limit = strpos($data,$key_to) - $start;
    }

    return trim(substr($data,$start,$limit));
}

function make_valid_date($inputDate){
    // Parse the input date
    $timestamp = strtotime($inputDate);

    // Format the date as DD/MM/YYYY
    return date("d/m/Y", $timestamp);
}

$data = array();

$data['officeAddress2'] = get_value_by_pattern_2($pdf_data,"Register office :");

$data['dor'] = get_value_by_pattern($string,"ISSUANCE DATE");
$data['officeAddress1'] = get_value_by_pattern($string,$data['dor']);
$data['doi'] = get_value_by_pattern_2($string,$data['officeAddress1']);

$data['date'] = get_value_by_pattern($string,"SEX");
$data['brn'] = get_value_by_pattern($string,$data['date']);
$data['sex'] = get_value_by_pattern_2($string,$data['brn']);


$bangla_string = str_replace("\n", " ", get_string_after($string,"নিবন্ধিত"))." end";

$data['name_bangla'] = get_value_by_position($bangla_string,"নিবন্ধিত ব্যক্তির নাম","REGISTERED PERSON NAME");
$data['name_english'] = get_value_by_position($bangla_string,"REGISTERED PERSON NAME","জন্মস্থান");
$data['pob_bangla'] = get_value_by_position($bangla_string,"জন্মস্থান","PLACE OF BIRTH");
$data['pob_english'] = get_value_by_position($bangla_string,"PLACE OF BIRTH","মাতার নাম");

$data['mother_bangla'] = get_value_by_position($bangla_string,"মাতার নাম","MOTHER'S NAME");
$data['mother_english'] = get_value_by_position($bangla_string,"MOTHER'S NAME","মাতার জাতীয়তা");
$data['mother_n_bangla'] = get_value_by_position($bangla_string,"মাতার জাতীয়তা","MOTHER'S NATIONALITY");
$data['mother_n_english'] = get_value_by_position($bangla_string,"MOTHER'S NATIONALITY","পিতার নাম");

$data['father_bangla'] = get_value_by_position($bangla_string,"পিতার নাম","FATHER'S NAME");
$data['father_english'] = get_value_by_position($bangla_string,"FATHER'S NAME","পিতার জাতীয়তা");
$data['father_n_bangla'] = get_value_by_position($bangla_string,"পিতার জাতীয়তা","FATHER'S NATIONALITY");
$data['father_n_english'] = get_value_by_position($bangla_string,"FATHER'S NATIONALITY","end");

$data['sex'] = ucfirst(strtolower($data['sex']));
$data['date'] = make_valid_date($data['date']);
$data['dor'] = make_valid_date($data['dor']);









//echo "<pre>";
//print_r($data);
echo json_encode($data);

?>
