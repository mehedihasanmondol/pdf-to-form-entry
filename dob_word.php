<?php
// Define arrays for the words representing numbers
$ones = ["", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine"];
$tens = ["", "Ten", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"];
$teens = ["", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen"];

// Function to convert a two-digit number to words
function two_digit_to_words($number) {
    global $ones, $tens, $teens;
    
    if ($number < 1 || $number > 99) {
        return "Invalid input: Number should be between 1 and 99";
    }
    
    if ($number >= 11 && $number <= 19) {
        return $teens[$number - 10];
    } else {
        $tens_digit = intval($number / 10);
        $ones_digit = $number % 10;
        
        $result = $tens[$tens_digit];
        if ($ones_digit > 0) {
            $result .= " " . $ones[$ones_digit];
        }
        
        return $result;
    }
}

// Function to convert a four-digit year to words as two parts
function year_to_two_parts($year) {
    if ($year < 1000 || $year > 9999) {
        return "Invalid input: Year should be between 1000 and 9999";
    }
    
    $yearWords = [
        2000 => "Two Thousand",
        2001 => "Two Thousand One",
        2002 => "Two Thousand Two",
        2003 => "Two Thousand Three",
        2004 => "Two Thousand Four",
        2005 => "Two Thousand Five",
        2006 => "Two Thousand Six",
        2007 => "Two Thousand Seven",
        2008 => "Two Thousand Eight",
        2009 => "Two Thousand Nine"
    ];

    if (isset($yearWords[$year])) {
        return $yearWords[$year];
    }

    $first_two_digits = intval($year / 100);
    $last_two_digits = $year % 100;

    $first_part = two_digit_to_words($first_two_digits);
    $second_part = two_digit_to_words($last_two_digits);

    return $first_part . " " . $second_part;
}

function numberToWords($number) {
    $words = [
    1 => 'First',
    2 => 'Second',
    3 => 'Third',
    4 => 'Fourth',
    5 => 'Fifth',
    6 => 'Sixth',
    7 => 'Seventh',
    8 => 'Eighth',
    9 => 'Ninth',
    10 => 'Tenth',
    11 => 'Eleventh',
    12 => 'Twelfth',
    13 => 'Thirteenth',
    14 => 'Fourteenth',
    15 => 'Fifteenth',
    16 => 'Sixteenth',
    17 => 'Seventeenth',
    18 => 'Eighteenth',
    19 => 'Nineteenth',
    20 => 'Twentieth',
    21 => 'Twenty First',
    22 => 'Twenty Second',
    23 => 'Twenty Third',
    24 => 'Twenty Fourth',
    25 => 'Twenty Fifth',
    26 => 'Twenty Sixth',
    27 => 'Twenty Seventh',
    28 => 'Twenty Eighth',
    29 => 'Twenty Ninth',
    30 => 'Thirtieth',
    31 => 'Thirty First',
];

    if (isset($words[$number])) {
        return $words[$number];
    } elseif ($number < 100) {
        $tens = $words[($number / 10) * 10];
        $units = $number % 10;
        return $tens . ($units ? ' ' . $words[$units] : '');
    } else {
        return 'Invalid';
    }
}

function dateToWords($date) {
    list($day, $month, $year) = explode('/', $date);
    
    if ($day < 1 || $day > 31 || $month < 1 || $month > 12) {
        return 'Invalid Date';
    }
    
    $dayWord = numberToWords((int)$day);
    $monthWord = date('F', strtotime("{$year}/{$month}/01"));
    
    return "{$dayWord} of {$monthWord}";
}

function convert_text_date($inputDate){
    //Call This Function
    ////Change the desired date (DD/MM/YYYY) here

// Extract the year from the input date
    list(, , $year) = explode('/', $inputDate);

    $resultDate = dateToWords($inputDate);
    $resultYear = year_to_two_parts($year);

    return $resultDate . " " . $resultYear;
}

?>
