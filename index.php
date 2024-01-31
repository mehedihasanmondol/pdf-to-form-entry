<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<?php

echo "<pre>";
require_once 'packages/vendor/autoload.php';

function get_string_after($text,$key){
    return substr($text,strpos($text,$key));
}
function get_pdf_data($file){
    // Parse PDF file and build necessary objects.
    $parser = new \Smalot\PdfParser\Parser();
    $pdf = $parser->parseFile($file);
    $text = $pdf->getText();
    $actual_text = get_string_after($text,"REGISTRATION DATE");
    return $actual_text;

}

$string = get_pdf_data("2.pdf");


function get_value_by_pattern($data,$key){
    $pattern = "/$key\s+(.*?)\t/"; // Matches "ISSUANCE DATE" followed by any characters until the first tab

    preg_match($pattern, $data, $matches);

    if (isset($matches[1])) {
        return $matches[1]; // This will print "13 DECEMBER 2023"
    } else {
        return "";
    }
}

function get_value_by_pattern_2($data,$key){
    preg_match("/$key\s*(.*)/", $data, $matches);

    if (isset($matches[1])) {
        return $matches[1]; // This will print "13 DECEMBER 2023"
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

    return substr($data,$start,$limit);
}
get_value_by_position('mahadi hasan noyon','mahadi','noyon');

print_r($string);

$data = array(
        "registration_date" => get_value_by_pattern($string,"ISSUANCE DATE")
);
$data['registration_office'] = get_value_by_pattern($string,$data['registration_date']);
$data['issuance_date'] = get_value_by_pattern_2($string,$data['registration_office']);

$data['date_of_birth'] = get_value_by_pattern($string,"SEX");
$data['birth_registration_number'] = get_value_by_pattern($string,$data['date_of_birth']);
$data['sex'] = get_value_by_pattern_2($string,$data['birth_registration_number']);

$bangla_string = str_replace("\n", " ", get_string_after($string,"নিবন্ধিত"))." end";

$data['registered_person_name_bangla'] = get_value_by_position($bangla_string,"নিবন্ধিত ব্যক্তির নাম","REGISTERED PERSON NAME");
$data['registered_person_name_english'] = get_value_by_position($bangla_string,"REGISTERED PERSON NAME","জন্মস্থান");
$data['birth_place_bangla'] = get_value_by_position($bangla_string,"জন্মস্থান","PLACE OF BIRTH");
$data['birth_place_english'] = get_value_by_position($bangla_string,"PLACE OF BIRTH","মাতার নাম");

$data['mother_name_bangla'] = get_value_by_position($bangla_string,"মাতার নাম","MOTHER'S NAME");
$data['mother_name_english'] = get_value_by_position($bangla_string,"MOTHER'S NAME","মাতার জাতীয়তা");
$data['mother_nationality_bangla'] = get_value_by_position($bangla_string,"মাতার জাতীয়তা","MOTHER'S NATIONALITY");
$data['mother_nationality_english'] = get_value_by_position($bangla_string,"MOTHER'S NATIONALITY","পিতার নাম");

$data['father_name_bangla'] = get_value_by_position($bangla_string,"পিতার নাম","FATHER'S NAME");
$data['father_name_english'] = get_value_by_position($bangla_string,"FATHER'S NAME","পিতার জাতীয়তা");
$data['father_nationality_bangla'] = get_value_by_position($bangla_string,"পিতার জাতীয়তা","FATHER'S NATIONALITY");
$data['father_nationality_english'] = get_value_by_position($bangla_string,"FATHER'S NATIONALITY","end");


print_r($data);


echo "</pre>";
?>
</body>
</html>
<pre>
