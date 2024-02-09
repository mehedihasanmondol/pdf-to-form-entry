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

//This function return Full office Location

function get_value_between_keywords($data, $keyFrom, $keyTo) {
    $pattern = "/$keyFrom\s*([^.]*)/";
    preg_match($pattern, $data, $matches);

    if (isset($matches[1])) {
        return trim($matches[1]);
    } else {
        return "";
    }
}

function make_valid_date($inputDate){
    // Parse the input date
    $timestamp = strtotime($inputDate);

    // Format the date as DD/MM/YYYY
    return date("d/m/Y", $timestamp);
}

function filter_in_array($array,$key,$value){
    return array_filter($array,function ($item) use ($key,$value){
        return strtolower($item[$key]) == strtolower($value);
    });
}

function extract_data($file_path){
    $pdf_data = $pdf_data = get_pdf_data($file_path);

    $string = get_string_after($pdf_data,"REGISTRATION DATE");
    $data = array();

    $data['officeAddress2'] = get_value_between_keywords($pdf_data, "Register office :", ".");


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
    $data['doi'] = make_valid_date($data['doi']);


    $office_address_2_extract = explode(",",$data['officeAddress2']);
    $union = $office_address_2_extract[0] ?? '';
    $upazila = $office_address_2_extract[1] ?? '';
    $district = $office_address_2_extract[2] ?? '';
    $district_bangla = '';
    $upazila_bangla = '';
    $union_bangla = '';

    require_once 'Bangladesh_Location-data/unions/unions.php';
    require_once 'Bangladesh_Location-data/districts/districts.php';
    require_once 'Bangladesh_Location-data/upazilas/upazilas.php';
    require_once 'dob_word.php';


    $get_district_bangla = array_values(filter_in_array($districts,"name",trim($district)));
    if ($get_district_bangla){
        $district_bangla = $get_district_bangla[0]['bn_name'];
    }

    $get_upazila_bangla = array_values(filter_in_array($upazilas,"name",trim($upazila)));
    if ($get_upazila_bangla){
        $upazila_bangla = $get_upazila_bangla[0]['bn_name'];
    }
    
    $get_union_bangla = array_values(filter_in_array($unions,"name",trim($union)));
    if ($get_union_bangla){
        $union_bangla = $get_union_bangla[0]['bn_name'];
    }


    $data['district_en'] = $district;
    $data['district_bn'] = $district_bangla;
    
    $data['union_en'] = $union;
    $data['union_bn'] = $union_bangla;
    
    $data['upazila_en'] = $upazila;
    $data['upazila_bn'] = $upazila_bangla;
    $data['dob'] = convert_text_date($data['date']);

    

    return $data;


}



?>
