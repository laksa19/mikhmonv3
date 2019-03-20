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
ob_start("ob_gzhandler");

$session = $_GET['session'];
require('../lib/routeros_api.class.php');
include('../lib/formatbytesbites.php');
include('../include/config.php');

// theme  
include('../include/theme.php');

$iphost = explode('!', $data[$session][1])[1];
$userhost = explode('@|@', $data[$session][2])[1];
$passwdhost = explode('#|#', $data[$session][3])[1];
$hotspotname = explode('%', $data[$session][4])[1];
$dnsname = explode('^', $data[$session][5])[1];
$currency = explode('&', $data[$session][6])[1];

$cekindo['indo'] = array('RP', 'Rp', 'rp', 'IDR', 'idr', 'RP.', 'Rp.', 'rp.', 'IDR.', 'idr.', );

$API = new RouterosAPI();
$API->debug = false;
if ($currency == in_array($currency, $cekindo['indo'])) {
	$title = array("Status Voucher", "User/Kode Voucher", "Paket", "Lama Terhubung", "Pemakaian Data", "Sisa Data", "Masa Aktif", "Dari", "Sampai", "tidak terdaftar.", "sudah kadaluarsa.", "Tanggal", "Cek Status", " Hari", " Jam", "Aktif", "Expired");
} else {
	$title = array("Voucher Status", "User/Voucher Code", "Profile", "Uptime", "Data Usage", "Data Remaining", "Validity", "Start", "End", "not registered.", "expired.", "Date", "Check Status", " Day", " Hour", "Active", "Expired");
}
if ($currency == in_array($currency, $cekindo['indo'])) {
	$s = "";
} else {
	$s = "s";
}
?>
<!DOCTYPE html>
<html>
<head>
<title><?= $title[0] . " " . $hotspotname; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="pragma" content="no-cache" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"/>
<!-- Font Awesome -->
<link rel="stylesheet" type="text/css" href="../css/font-awesome/css/font-awesome.min.css" />
<!-- Mikhmon UI -->
<link rel="stylesheet" href="../css/mikhmon-ui.<?= $theme; ?>.min.css">
<link rel="icon" href="../img/favicon.png" />
<script>
function goBack() {
    window.history.back();
}
</script>

</head>
<body >
<div class="login-box" style="padding-top: 10px;">
<h3 class="text-center">Status Voucher<br><?= $hotspotname; ?></h3>
<p class="text-center" id="date1"><?= $title[11] . " : " . date("d-m-Y") . "<br>"; ?></p>
<form autocomplete="off"class="form" method="post" action="">
	<div class="input-group">
        <div class="input-group-7">
			<input type="text" class="group-item group-item-l" name="nama" placeholder="<?= $title[1]; ?>" autofocus required="1" />
		</div>
		<div class="input-group-5">
			<button type="submit" style="cursor: pointer; padding: 2.5px;" class="group-item group-item-r"><i class="fa fa-search"></i> <?= " " . $title[12]; ?></button>
		</div>
</div>
</form>
<?php
if (isset($_POST['nama'])) {
	$name = ($_POST['nama']);
	if ($API->connect($iphost, $userhost, decrypt($passwdhost))) {
		$getuser = $API->comm("/ip/hotspot/user/print", array("?name" => "$name"));
		$user = $getuser[0]['name'];
		$profile = $getuser[0]['profile'];
		$exp = $getuser[0]['comment'];
		$uptime = formatDTM($getuser[0]['uptime']);
		$getbytein = $getuser[0]['bytes-in'];
		$getbyteo = $getuser[0]['bytes-out'];
		$getbytetot = ($getbytein + $getbyteo);
		$bytetot = formatBytes($getbytetot, 2);
		$limitup = $getuser[0]['limit-uptime'];
		$limitbyte = $getuser[0]['limit-bytes-total'];
		if ($limitbyte == "") {
			$dataleft = "Unlimited";
		} elseif ($limitbyte < $getbytetot) {
			$dataleft = "0 Byte";
		} else {
			$dataleft = formatBytes($limitbyte - $getbytetot, 2);
		}

		$getprofile = $API->comm("/ip/hotspot/user/profile/print", array("?name" => "$profile", ));
		$ponlogin = $getprofile[0]['on-login'];
		$getvalid = explode(",", $ponlogin)[3];
		$unit = substr($getvalid, -1);
		if ($unit == "d") {
			$getvalid = substr($getvalid, 0, strlen($getvalid) - 1) . " " . $title[13];
		} elseif ($unit == "h") {
			$getvalid = substr($getvalid, 0, strlen($getvalid) - 1) . " " . $title[14];
		}


	}
  
	if ($user == "" || (substr($exp,3,1) != "/" && substr($exp,6,1) != "/")) {
		echo "<h3 class='text-center'>User <i style='color:#008CCA;'>$name</i> $title[9]</h3>";
	} elseif ($limitup == "1s" || $uptime == $limitup || $getbyteo == $limitbyte) {
		echo "<h3 class='text-center'>User <i style='color:#008CCA;'>$name</i> $title[10]</h3>";
	}
	if ($user == "" || (substr($exp,3,1) != "/" && substr($exp,6,1) != "/")) {
	} else {
		?>
<section>
<div class="card">
<div class="card-header">
    <h3>
      <i class="fa fa-user mr-1"></i>
        User Details
    </h3>
  </div>
  <div class="card-body">
  <?php
	echo "<div style='overflow-x:auto;'>";
	echo "<table class='table table-bordered table-hover text-nowrap'>";
	echo "	<tr>";
	echo "		<td >$title[1]</td>";
	echo "		<td > $user</td>";
	echo "	</tr>";
	echo "	<tr>";
	echo "		<td >$title[2]</td>";
	echo "		<td > $profile</td>";
	echo "	</tr>";
	echo "	<tr>";
	echo "		<td >$title[3]</td>";
	echo "		<td > $uptime</td>";
	echo "	</tr>";
	echo "	<tr>";
	echo "		<td >$title[4]</td>";
	echo "		<td > $bytetot</td>";
	echo "	</tr>";
	if ($limitup == "1s" || $uptime == $limitup || $getbyteo == $limitbyte) {
		echo "	<tr>";
		echo "		<td >Status</td>";
		echo "		<td >$title[16]</td>";
		echo "	</tr>";
		echo "</table>";
		echo "</div>";
	} else {
		echo "	<tr>";
		echo "		<td >$title[5]</td>";
		echo "		<td > $dataleft</td>";
		echo "	</tr>";
		echo "	<tr>";
		echo "		<td >$title[6]</td>";
		echo "		<td >$getvalid</td>";
		echo "	</tr>";
				echo "	<tr>";
		echo "		<td >$title[8]</td>";
		echo "		<td >$exp</td>";
		echo "	</tr>";
		echo "	<tr>";
		echo "		<td >Status</td>";
		echo "		<td >$title[15]</td>";
		echo "	</tr>";
		echo "</table>";
		echo "</div>";
	}
}
$API->disconnect();

}

?>
</div>
</div>
</section>
</div>
</div>
</body>
</html>
