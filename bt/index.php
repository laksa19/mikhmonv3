<?php
/*
 *  Copyright (C) 2018 Laksamadi Guko.
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
// hide all error
error_reporting(0);
// data temp
include('./temp.php');
// btkey
include('../include/btkey.php');
$btkey = explode("-", $tempu)[8];

$url = $_SERVER['REQUEST_URI'];
$dir = explode("bt", $url)[0];
$sess = $_GET['session'];
$getqr = $_GET['qr'];
$getlogo = $_GET['logo'];
$getlang = $_GET['en'];
$key = $_GET['key'];

// check protocol
if (isset($_GET['https'])) {
    $protocol = "https://";
} else {
    $protocol = "http://";
}
$host = $_SERVER[HTTP_HOST];

$cekindo['indo'] = array(
    'RP', 'Rp', 'rp', 'IDR', 'idr', 'RP.', 'Rp.', 'rp.', 'IDR.', 'idr.',
);

if ($key != $btkey) {
echo '<html><style>body{background-color :#000; color:#fff;}</style><body><center><h1>404!</h1></center></body></html>';
} else {
// lang
  include('../include/lang.php');
  if(isset($getlang)){$langid = "en";}
  include('../lang/'.$langid.'.php');
// include  temp data
    include('./temp.php');
    $u_username = explode("-", $tempu)[0];
    $u_password = explode("-", $tempu)[1];
    $u_data_limit = explode("-", $tempu)[2];
    $u_time_limit = explode("-", $tempu)[3];
    $u_validity = explode("-", $tempu)[4];
    $u_price = explode("-", $tempu)[5];
    $session = explode("-", $tempu)[6];
    $timezone = explode("-", $tempu)[7];
// logo url
    $logourl = $protocol . $host . $dir . 'img/logo-' . $session . '.png';
// default timerzone
    date_default_timezone_set($timezone);
// check user monde
    if ($u_username == $u_password) {
        $u_title = "Voucher";
    } else {
        $u_title = "Username";
    }
    
// load config
    include('../include/config.php');
    $hotspotname = explode('%', $data[$session][4])[1];
    $dnsname = explode('^', $data[$session][5])[1];
    $currency = explode('&', $data[$session][6])[1];
// make qr
    $qr = "http://$dnsname/login?username=$u_username&password=$u_password";
// datet time
    $date = date("Y-m-d h:i:sa");

    function harga($harga){
        if ($currency == in_array($currency, $cekindo['indo'])) {
            return number_format($harga, 0, ",", ".");
          } else {
            return number_format($harga);
          }
    }

// object function    
    function objtext($bold, $align, $format, $content){
        $obj->type = 0;//text
        $obj->content = $content;//any string	
        $obj->bold = $bold;//0 if no, 1 if yes
        $obj->align = $align;//0 if left, 1 if center, 2 if right
        $obj->format = $format;//0 if normal, 1 if double Height, 2 if double Height + Width, 3 if double Width
        return $obj;
    }
    function objimg($align, $path){
        $obj->type = 1;//image
        $obj->path = $path;//complete filepath on your web server; make sure that it is not big size
        $obj->align = $align;//0 if left, 1 if center, 2 if right; set left align for big size images
        return $obj;
    }
    function objqr($size, $align, $value){
        $obj->type = 3;//QR code
        $obj->value = $value;//valid QR code value
        $obj->size = $size;//valid QR code size in mm
        $obj->align = $align;//0 if left, 1 if center, 2 if right
        return $obj;
    }

// make json    
    $a = array();
    if (isset($getlogo)) {
        $fhname = 0;
// logo	
        array_push($a, objimg(1, $logourl));
//hotspotname	
        array_push($a, objtext(1, 2, 0, $hotspotname));
    } else {
//hotspotname	
        array_push($a, objtext(1, 1, 2, $hotspotname));
    }
// sparator
    array_push($a, objtext(0, 0, 0, "--------------------------------"));
// date
    array_push($a, objtext(0, 2, 0, $date));
// sparator
    array_push($a, objtext(0, 0, 0, "--------------------------------"));


    if ($u_username == $u_password) {
// username
    array_push($a, objtext(0, 0, 0, $_voucher_code . ' : ' . $u_username));
    } else {
// username        
        array_push($a, objtext(0, 0, 0, $_user_name . ' : ' . $u_username));
// password
        array_push($a, objtext(0, 0, 0, $_password.' : ' . $u_password));
    }
    if ($u_data_limit == "") {
    } else {
// data limit
        array_push($a, objtext(0, 0, 0, $_data_limit.' : ' . $u_data_limit));
    }
    if ($u_time_limit == "") {
    } else {
// time limit
        array_push($a, objtext(0, 0, 0, $_time_limit.' : ' . $u_time_limit));
    }
    if ($u_validity == "") {
    } else {
// validity
        array_push($a, objtext(0, 0, 0, $_validity.' : ' . $u_validity));
    }
    if ($u_price == "" || $u_price == "0") {
    } else {
// price 
$t = '      ';
        array_push($a, objtext(0, 0, 0, $_price.' : ' . $currency . ' ' . harga($u_price)));
    }

    if (isset($getqr)) {
//sending QR entry	
        array_push($a, objqr(40, 1, $qr));
    } else {
    }
// dns name
    array_push($a, objtext(0, 0, 0, 'Login : http://' . $dnsname));
// sparator
    array_push($a, objtext(0, 0, 0, "--------------------------------"));
// sparator
    array_push($a, objtext(0, 0, 0, "-"));
// sparator
    array_push($a, objtext(0, 0, 0, "--------------------------------"));


    echo json_encode($a, JSON_FORCE_OBJECT | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
//Note that same sequence will be used for printing data

}
?>
