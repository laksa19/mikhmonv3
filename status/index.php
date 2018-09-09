<?php
error_reporting(0);

$session = $_GET['session'];
require('../lib/routeros_api.class.php');
include('../lib/formatbytesbites.php');
include('../include/config.php');
$iphost=explode('!',$data[$session][1])[1]; 
$userhost=explode('@|@',$data[$session][2])[1];
$passwdhost=explode('#|#',$data[$session][3])[1]; 
$hotspotname=explode('%',$data[$session][4])[1]; 
$dnsname=explode('^',$data[$session][5])[1]; 
$curency=explode('&',$data[$session][6])[1];


$API = new RouterosAPI();
$API->debug = false;
if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
	$title = "Status Voucher";
	$title1 = "User/Kode Voucher";
	$title2 = "Paket";
	$title3 = "Lama Terhubung";
	$title4 = "Pemakaian Data";
	$title5 = "Sisa Data";
	$title6 = "Masa Aktif";
	$title7 = "Dari";
	$title8 = "Sampai";
	$title9 = "tidak terdaftar.";
	$title10 = "sudah kadaluarsa.";
	$title11 = "Tanggal"; 
	$title12 = "Cek Status";
	$title13 = " Hari";
	$title14 = " Jam";
	$title15 = "Aktif";
	$title16 = "Expired";
}else{
	$title = "Voucher Status";
	$title1 = "User/Voucher Code";
	$title2 = "Profile";
	$title3 = "Uptime";
	$title4 = "Data Usage";
	$title5 = "Data Remaining";
	$title6 = "Validity";
	$title7 = "Start";
	$title8 = "End";
	$title9 = "not registered.";
	$title10 = "expired.";
	$title11 = "Date"; 
	$title12 = "Check Status";
	$title13 = " Day";
	$title14 = " Hour";
	$title15 = "Active";
	$title16 = "Expired";
}
if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
	$s = "";
}else{$s = "s";}
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $title." ".$hotspotname;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="pragma" content="no-cache" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"/>
<!-- Font Awesome -->
<link rel="stylesheet" type="text/css" href="../css/font-awesome/css/font-awesome.min.css" />
<!-- Mikhmon UI -->
<link rel="stylesheet" href="../css/mikhmon-ui.css">
<link rel="icon" href="../img/favicon.png" />
<script>
function goBack() {
    window.history.back();
}
</script>

</head>
<body >
<div class="login-box" style="padding-top: 10px;">
<h3 class="text-center">Status Voucher<br><?php echo $hotspotname;?></h3>
<p class="text-center"" id="date1"><?php echo $title11." : " . date("d-m-Y") . "<br>";?></p>
<form autocomplete="off"class="form" method="post" action="">
	<div class="input-group">
        <div class="input-group-7">
			<input type="text" class="group-item group-item-l" name="nama" placeholder="<?php echo $title1;?>" autofocus required="1" />
		</div>
		<div class="input-group-5">
			<button type="submit" style="cursor: pointer; padding: 2.5px;" class="group-item group-item-r"><i class="fa fa-search"></i> <?php echo " ".$title12;?></button>
		</div>
</div>
</form>
<?php
	if(isset($_POST['nama'])){
	$name = ($_POST['nama']);
	if ($API->connect( $iphost, $userhost, decrypt($passwdhost))) {
	$getuser = $API->comm("/ip/hotspot/user/print", array("?name"=> "$name"));
	$user = $getuser[0]['name'];
	$profile = $getuser[0]['profile'];
	$uptime = formatDTM($getuser[0]['uptime']);
	$getbytein = $getuser[0]['bytes-in'];
	$getbyteo = $getuser[0]['bytes-out'];
	$getbytetot = ($getbytein + $getbyteo);
	$bytetot = formatBytes($getbytetot, 2);
	$limitup = $getuser[0]['limit-uptime'];
	$limitbyte = $getuser[0]['limit-bytes-total'];
	if($limitbyte == ""){$dataleft = "Unlimited";}elseif($limitbyte < $getbytetot){$dataleft = "0 Byte";}else{$dataleft = formatBytes($limitbyte-$getbytetot,2);}

	$getprofile = $API->comm("/ip/hotspot/user/profile/print", array("?name"=> "$profile",));
    $ponlogin = $getprofile[0]['on-login'];
    $getvalid = explode(",",$ponlogin)[3];
    $unit = substr($getvalid,-1);
    if($unit == "d"){$getvalid = substr($getvalid,0, strlen($getvalid)-1)." ".$title13;}
    elseif($unit == "h"){$getvalid = substr($getvalid,0, strlen($getvalid)-1)." ".$title14;}

	$API->write('/system/scheduler/print', false);
	$API->write('?=name='.$name.'');
	$ARRAY1 = $API->read();
	$regtable = $ARRAY1[0];
				$exp = $regtable['next-run'];
				$strd = $regtable['start-date'];
				$strt = $regtable['start-time'];
				$flogin = $regtable['comment'];
	}
	if($user == "" || $exp == ""){
		echo "<h3 class='text-center'>User <i style='color:#008CCA;'>$name</i> $title9</h3>";
	}elseif($limitup == "1s" || $uptime == $limitup || $getbyteo == $limitbyte){
		echo "<h3 class='text-center'>User <i style='color:#008CCA;'>$name</i> $title10</h3>";
	}
	if($user == "" || $exp == ""){}else{
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
	echo "		<td >$title1</td>";
	echo "		<td > $user</td>";
	echo "	</tr>";
	echo "	<tr>";
	echo "		<td >$title2</td>";
	echo "		<td > $profile</td>";
	echo "	</tr>";
	echo "	<tr>";
	echo "		<td >$title3</td>";
	echo "		<td > $uptime</td>";
	echo "	</tr>";
	echo "	<tr>";
	echo "		<td >$title4</td>";
	echo "		<td > $bytetot</td>";
	echo "	</tr>";
	if($limitup == "1s"  || $uptime == $limitup || $getbyteo == $limitbyte){
	if($flogin == ""){}else{	
	echo "	<tr>";
	echo "		<td >Start</td>";
	echo "		<td >$flogin</td>";
	echo "	</tr>";	
	}
	echo "	<tr>";
	echo "		<td >Status</td>";
	echo "		<td >$title16</td>";
	echo "	</tr>";
	echo "</table>";
	echo "</div>";	
	}else{
	echo "	<tr>";
	echo "		<td >$title5</td>";
	echo "		<td > $dataleft</td>";
	echo "	</tr>";
	echo "	<tr>";
	echo "		<td >$title6</td>";
	echo "		<td >$getvalid</td>";
	echo "	</tr>";
	echo "	<tr>";
	echo "		<td >$title7</td>";
	echo "		<td >$strd $strt</td>";
	echo "	</tr>";
	echo "	<tr>";
	echo "		<td >$title8</td>";
	echo "		<td >$exp</td>";
	echo "	</tr>";
	echo "	<tr>";
	echo "		<td >Status</td>";
	echo "		<td >$title15</td>";
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
