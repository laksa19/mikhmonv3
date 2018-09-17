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
session_start();
?>
<?php
error_reporting(0);
if(!isset($_SESSION["mikhmon"])){
  header("Location:../admin.php?id=login");
}else{

// load session MikroTik
$session = $_GET['session'];

// load config
include('../include/config.php');
$iphost=explode('!',$data[$session][1])[1]; 
$userhost=explode('@|@',$data[$session][2])[1];
$passwdhost=explode('#|#',$data[$session][3])[1]; 
$hotspotname=explode('%',$data[$session][4])[1]; 
$dnsname=explode('^',$data[$session][5])[1]; 
$curency=explode('&',$data[$session][6])[1];


include('../lib/formatbytesbites.php');

$id = $_GET['id'];
$qr = $_GET['qr'];
$small = $_GET['small'];
$userp = $_GET['user'];

require('../lib/routeros_api.class.php');
$API = new RouterosAPI();
$API->debug = false;
$API->connect( $iphost, $userhost, decrypt($passwdhost));

if($userp != ""){
  $usermode = explode('-',$userp)[0];
  $user = explode('-',$userp)[1];
  $getuser = $API->comm("/ip/hotspot/user/print", array("?name"=> "$user"));
  $TotalReg = count($getuser);
}elseif($id != ""){
  $usermode = explode('-',$id)[0];
  $getuser = $API->comm('/ip/hotspot/user/print', array("?comment" => "$id", "?uptime"=> "0s"));
  $TotalReg = count($getuser);
}
  $getuprofile = $getuser[0]['profile'];
    

$getprofile = $API->comm("/ip/hotspot/user/profile/print", array("?name" => "$getuprofile"));
  $getsharedu = $getprofile[0]['shared-users'];
  $ponlogin = $getprofile[0]['on-login'];
  $validity = explode(",",$ponlogin)[3];
  $getprice = explode(",",$ponlogin)[2];
  if($getprice == 0){
    $price = "";
  }else{
    if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
       $price = $curency." ".number_format($getprice,0,",",".");
     }else{
    $price = $curency." ".number_format($getprice);
  }
  }

$logo = "../img/logo-".$session.".png";
if (file_exists($logo)) {
    $logo = "../img/logo-".$session.".png";
} else {
    $logo = "../img/logo.png";
}

}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Voucher-<?php echo $hotspotname."-".$getuprofile."-".$id;  ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="pragma" content="no-cache" />
		<link rel="icon" href="../img/favicon.png" />
		<style>
body {
  color: #000000;
  background-color: #FFFFFF;
  font-size: 14px;
  font-family:  'Helvetica', arial, sans-serif;
  margin: 0px;
  -webkit-print-color-adjust: exact;
}
table.voucher {
  display: inline-block;
  border: 2px solid black;
  margin: 2px;
}
@page
{
  size: auto;
  margin-left: 7mm;
  margin-right: 3mm;
  margin-top: 9mm;
  margin-bottom: 3mm;
}
@media print
{
  table { page-break-after:auto }
  tr    { page-break-inside:avoid; page-break-after:auto }
  td    { page-break-inside:avoid; page-break-after:auto }
  thead { display:table-header-group }
  tfoot { display:table-footer-group }
}
#num {
  float:right;
  display:inline-block;
}
.qrc {
  width:30px;
  height:30px;
  margin-top:1px;
}
		</style>
	</head>
	<body onload="window.print()">

<?php for ($i=0; $i<$TotalReg; $i++){;
   $regtable = $getuser[$i];
   $username = $regtable['name'];
   $password = $regtable['password'];
   $timelimit = $regtable['limit-uptime'];
   $getdatalimit = $regtable['limit-bytes-total'];
   if($getdatalimit == 0){$datalimit = "";}else{$datalimit = formatBytes($getdatalimit,2);}
   // CHart Size
	$chs = "80x80";
	// CHart Link
	$chl = urlencode("http://$dnsname/login?username=$username&password=$password");
	$qrcode = 'https://chart.googleapis.com/chart?cht=qr&chs=' . $chs . '&chld=L|0&chl=' . $chl . '&choe=utf-8';
	
	$num = $i+1;
?>
<?php
if($userp != ""){
  include('./template-thermal.php');
}else{
  if($small == "yes"){
    include('./template-small.php');
  }else{
    include('./template.php');
  }
}
?>
<?php } ?>

	
</body>
</html>
