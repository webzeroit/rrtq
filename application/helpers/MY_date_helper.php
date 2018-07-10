<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Converts a MySQL date format (yyyy-mm-dd) in Italian format (dd/mm/yyyy)
 * @param type $data
 * @return string Returns the converted date
 */
function convertsDataInItalianFormat($data) {
    if ($data === NULL) return "";
    $aaaa = substr ($data, 0, 4 );
    $mm = substr ($data, 5, 2 );
    $gg = substr ($data, 8, 2 );
    $cdata = $gg . "/" . $mm . "/" . $aaaa;
    return $cdata;
}

/**
 * Converts a Italian date format (dd/mm/yyyy) in MySQL date format (yyyy-mm-dd) 
 * @param type $data
 * @return string Returns the converted date
 */
function convertsDataInMySQLFormat($data) {
    if ($data === NULL) return "";
    $gg = substr ($data, 0, 2 );
    $mm = substr ($data, 3, 2 );
    $aaaa = substr ($data, 6, 4 );
    $cdata =  $aaaa . '-' .  $mm . '-' . $gg;
    return $cdata;
}

function convertsDataOraInItalianFormat($data) {
    if ($data === NULL) return "";
    $aaaa = substr ($data, 0, 4 );
    $mm = substr ($data, 5, 2 );
    $gg = substr ($data, 8, 2 );
    $ora = substr ($data, 11, 5 );
    $cdata = $gg . "/" . $mm . "/" . $aaaa . " " . $ora;
    return $cdata;
}