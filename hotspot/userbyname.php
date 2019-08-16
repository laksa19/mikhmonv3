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

if (!isset($_SESSION["mikhmon"])) {
  header("Location:../admin.php?id=login");
} else {

  date_default_timezone_set($_SESSION['timezone']);

  $getprofile = $API->comm("/ip/hotspot/user/profile/print");
  $srvlist = $API->comm("/ip/hotspot/print");

  if (substr($hotspotuser, 0, 1) == "*") {
    $hotspotuser = $hotspotuser;
  } elseif (substr($hotspotuser, 0, 1) != "") {
    $getuser = $API->comm("/ip/hotspot/user/print", array(
      "?name" => "$hotspotuser",
    ));
    $hotspotuser = $getuser[0]['.id'];
    //if($hotspotuser == ""){echo "<b>Hotspot User not found</b>";}
  }

  $getuser = $API->comm("/ip/hotspot/user/print", array(
    "?.id" => "$hotspotuser",
  ));
  $userdetails = $getuser[0];
  $uid = $userdetails['.id'];
  $userver = $userdetails['server'];
  $uname = $userdetails['name'];
  $upass = $userdetails['password'];
  $umac = $userdetails['mac-address'];
  $uprofile = $userdetails['profile'];
  $uuptime = formatDTM($userdetails['uptime']);
  $ueduser = $userdetails['disabled'];
  $utimelimit = $userdetails['limit-uptime'];
  $udatalimit = $userdetails['limit-bytes-total'];
  $ubytesout = $userdetails['bytes-out'];
  $ubytesin = $userdetails['bytes-in'];
  $ucomment = $userdetails['comment'];
  

  if (substr(formatBytes2($udatalimit, 2), -2) == "MB") {
    $udatalimit = $udatalimit / 1048576;
    $MG = "MB";
  } elseif (substr(formatBytes2($udatalimit, 2), -2) == "GB") {
    $udatalimit = $udatalimit / 1073741824;
    $MG = "GB";
  } elseif ($udatalimit == "") {
    $udatalimit = "";
    $MG = "MB";
  }

  if ($uname == $upass) {
    $usermode = "vc";
  } else {
    $usermode = "up";
  }

  if ($uname == "") {
    echo "<b>User not found redirect to user list...</b>";
    echo "<script>window.location='./?hotspot=users&profile=all&session=" . $session . "'</script>";
  }

  if((substr($ucomment,3,1) == "/" && substr($ucomment,6,1) == "/")){
    $commt = 'disabled';
    $comment2t = 'text';
    $_tcomment = $_expired;
    $_tcomment2 = $_comment;
    $ucomment2 = substr($ucomment,21, (strlen($ucomment)-21));
    $ucomment =  substr($ucomment,0,20);
  }else{
    $comment2t = 'hidden';
    $_tcomment = $_comment;
    $_tcomment2 = "";
    $display = 'style="display:none"';
  }
  
  $getprofilebyuser = $API->comm("/ip/hotspot/user/profile/print", array(
    "?name" => "$uprofile"
  ));
  $profiledetalis = $getprofilebyuser[0];
  $ponlogin = $profiledetalis['on-login'];
  $getvalid = explode(",", $ponlogin)[3];
  $getprice = explode(",", $ponlogin)[2];
  $getsprice = explode(",", $ponlogin)[4];


  $getsch = $API->comm("/system/scheduler/print", array(
    "?name" => "$uname",
  ));
  $schdetails = $getsch[0];
  $start = $schdetails['start-date'] . " " . $schdetails['start-time'];
  $end = $schdetails['next-run'];
	//$valy = $schdetails['interval'];
// share WhatsApp
  if ($getvalid != "") {
    $wavalid = $_validity." : *" . $getvalid . "* %0A";
  } else {
    $wavalid = "";
  }
  if ($utimelimit != "") {
    $watlimit = $_time_limit." : *" . $utimelimit . "* %0A";
  } else {
    $watlimit = "";
    $bMB = "";
  }
  if ($udatalimit != "") {
    $wadlimit = $_data_limit." : *" . $udatalimit . "" . $MG . "* %0A";
    $bMG = $MG;
  } else {
    $wadlimit = "";
  }
  
  if($getsprice == "" && $getprice != ""){
    if ($currency == in_array($currency, $cekindo['indo'])) {
      $waprice = $_price." : *" . $currency . " " . number_format($getprice, 0, ",", ".") . "* %0A";
    } else {
      $waprice = $_price . " : *" . $currency . " " . number_format($getprice) . "* %0A";
    }
    $btprice = $getprice;
  }else if($getsprice != ""){
    if ($currency == in_array($currency, $cekindo['indo'])) {
      $waprice = $_price." : *" . $currency . " " . number_format($getsprice, 0, ",", ".") . "* %0A";
    } else {
      $waprice = $_price . " : *" . $currency . " " . number_format($getsprice) . "* %0A";
    }
    $btprice = $getsprice;
  }else if ($getsprice == "") {
    $waprice = "";
    $btprice = "";
  }

  $shareWAUP = "
%0A---------%0A
*" . $hotspotname . "*
%0A%0A
Username : *" . $uname . "* %0A
Password : *" . $upass . "* %0A
" . $wavalid . "
" . $watlimit . "
" . $wadlimit . "
" . $waprice . " %0A
Login : *http://" . $dnsname . "* %0A
---------
";
  $shareWAVC = "
%0A---------%0A
*" . $hotspotname . "*
%0A%0A
Voucher : *" . $uname . "* %0A
" . $wavalid . "
" . $watlimit . "
" . $wadlimit . "
" . $waprice . " %0A
Login : *http://" . $dnsname . "* %0A
---------
";
  if ($uname == $upass) {
    $shareWA = $shareWAVC;
  } else {
    $shareWA = $shareWAUP;
  }

// quick bt
include('./include/quickbt.php');

// Print BT
  $chl = urlencode("http://$dnsname/login?username=$uname&password=$upass");
	$qrcode = 'https://chart.googleapis.com/chart?cht=qr&chs=100x100&chld=L|0&chl=' . $chl . '&choe=utf-8';
  //$qrcode = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data='.$chl;
 


if ($currency == in_array($currency, $cekindo['indo'])) {
  $pricebt = $currency . " " . number_format($btprice, 0, ",", ".");
  if (substr($getvalid, -1) == "d") {
    $validity = substr($getvalid, 0, -1) . "Hari";
  } else if (substr($getvalid, -1) == "h") {
    $validity = substr($getvalid, 0, -1) . "Jam";
  } else if (substr($getvalid, -1) == "m") {
    $validity = substr($getvalid, 0, -1) . "Menit";
  }
  if (substr($utimelimit, -1) == "d" & strlen($utimelimit) > 3) {
    $timelimit = ((substr($utimelimit, 0, -1) * 7) + substr($utimelimit, 2, 1)) . "Hari";
  } else if (substr($utimelimit, -1) == "d") {
    $timelimit = substr($utimelimit, 0, -1) . "Hari";
  } else if (substr($utimelimit, -1) == "h") {
    $timelimit = substr($utimelimit, 0, -1) . "Jam";
  } else if (substr($utimelimit, -1) == "w") {
    $timelimit = (substr($utimelimit, 0, -1) * 7) . "Hari";
  }
  } else {
    $pricebt = $currency . " " . number_format($btprice);
    $timelimit = $utimelimit;
    $validity = $getvalid;
  }


  if (isset($_POST['name'])) {
    $server = ($_POST['server']);
    $name = ($_POST['name']);
    $password = ($_POST['pass']);
    $profile = ($_POST['profile']);
    $disabled = ($_POST['disabled']);
    $timelimit = ($_POST['timelimit']);
    $datalimit = ($_POST['datalimit']);
    $comment = ($_POST['comment']);
    $comment2 = ($_POST['comment2']);
    $hcomment = ($_POST['h_comment']);
    $mbgb = ($_POST['mbgb']);
    if ($timelimit == "") {
      $timelimit = "0";
    } else {
      $timelimit = $timelimit;
    }
    if ($datalimit == "") {
      $datalimit = "0";
    } else {
      $datalimit = $datalimit * $mbgb;
    }
    if ($name == $password) {
      $usermode = "vc-";
    }else{
      $usermode = "up-";
    }
    
    if((substr($hcomment,3,1) == "/" && substr($hcomment,6,1) == "/")){
      $comment = $hcomment." ".$comment2;
    }elseif((substr($comment,3,1) == "/" && substr($comment,6,1) == "/")){
      $comment = $comment." ".$comment2;
    }elseif(substr($comment,0,3) == "vc-" || substr($comment,0,3) == "up-"){
      $comment = $comment;
    }else{
      $comment = $usermode.$comment;
    }

    $API->comm("/ip/hotspot/user/set", array(
      ".id" => "$uid",
      "server" => "$server",
      "name" => "$name",
      "password" => "$password",
      "profile" => "$profile",
      "disabled" => "$disabled",
      "limit-uptime" => "$timelimit",
      "limit-bytes-total" => "$datalimit",
      "comment" => "$comment",
    ));
    echo "<script>window.location='./?hotspot-user=" . $uid . "&session=" . $session . "'</script>";
  }
}
include('./voucher/printbt.php');
?>

<script>
  function PassUser(){
    var x = document.getElementById('passUser');
    if (x.type === 'password') {
    x.type = 'text';
    } else {
    x.type = 'password';
    }}
    var _0x7baa=["\x63\x6C\x69\x63\x6B","\x2E\x70\x72\x69\x6E\x74\x42\x54","\x72\x65\x61\x64\x79"];$(document)[_0x7baa[2]](function(){$(_0x7baa[1])[_0x7baa[0]](function(){printBT()})})
</script>
<div class="row">
<div class="col-12"></div>
<div class="card">
<div class="card-header">
    <h3><i class="fa fa-edit"></i> <?php  echo $_edit_user.' '.$uname.' '; if ($utimelimit == "1s") {  echo $_expired;}?></h3>
</div>
<div class="card-body">
<form autocomplete="new-password" method="post" action="">
  <div>
    <?php if ($_SESSION['ubp'] != "") {
      echo "    <a class='btn bg-warning' href='./?hotspot=users&profile=" . $_SESSION['ubp'] . "&session=" . $session . "'><i class='fa fa-close'></i> ".$_close."</a>";
    } elseif ($_SESSION['ubc'] != "") {
      echo "    <a class='btn bg-warning' href='./?hotspot=users&comment=" . $_SESSION['ubc'] . "&session=" . $session . "'><i class='fa fa-close'></i> ".$_close."</a>";
    } elseif ($_SESSION['hua'] != "") {
      $_SESSION['ubn'] = "";
      echo "    <a class='btn bg-warning' href='./?hotspot=active&session=" . $session . "'><i class='fa fa-close'></i> ".$_close."</a>";
      $_SESSION['hua'] = "";
    } elseif ($_SESSION['ubn'] != "") {
      echo "    <a class='btn bg-warning' href='./?hotspot=users&profile=all&session=" . $session . "'><i class='fa fa-close'></i> ".$_close."</a>";
      $_SESSION['ubn'] = "";
    } else {
      echo "    <a class='btn bg-warning' href='./?hotspot=users&profile=all&session=" . $session . "'><i class='fa fa-close'></i> ".$_close."</a>";
    }
    ?>
    <button type="submit" name="save" class="btn bg-primary" > <i class="fa fa-save"></i> <?= $_save ?></button>
    <div class="btn bg-danger"  onclick="if(confirm('Are you sure to delete username (<?= $uname; ?>)?')){loadpage('./?remove-hotspot-user=<?= $uid; ?>&session=<?= $session; ?>')}else{}" title='Remove <?= $uname; ?>'><i class='fa fa-minus-square'></i> <?= $_remove ?></div>
    <a class="btn bg-secondary"  title="Print" href="javascript:window.open('./voucher/print.php?user=<?= $usermode . "-" . $uname; ?>&qr=no&session=<?= $session; ?>','_blank','width=310,height=450').print();"> <i class="fa fa-print"></i> <?= $_print ?></a>
    <a class="btn bg-info"  title="Print QR" href="javascript:window.open('./voucher/print.php?user=<?= $usermode . "-" . $uname; ?>&qr=yes&session=<?= $session; ?>','_blank','width=310,height=450').print();"> <i class="fa fa-qrcode"></i> <?= $_print_qr ?></a>
    <?php if ($utimelimit == "1s") {
      echo '<a class="btn bg-info"  href="./?reset-hotspot-user=' . $uid . '&session=' . $session . '"> <i class="fa fa-retweet"></i> Reset</a>';
    } ?>
    <a id="shareWA" class="btn bg-green" title="Share WhatsApp" href="whatsapp://send?text=<?= $shareWA; ?>"> <i class="fa fa-whatsapp"></i> <?= $_share ?></a>
    <!--<div id="shareWA" class="btn bg-blue printBT" title="Print Bluetooth"><i class="fa fa-bluetooth"></i> <?= $_print ?> BT</div>-->
    <div id="shareWA" class="btn bg-blue" onclick="sendToQuickPrinterChrome()" title="Print Bluetooth"><i class="fa fa-bluetooth"></i> <?= $_print ?> BT</div><br>
  </div>
<table class="table">
  <tr>
    <td class="align-middle">Enabled</td>
    <td>
			<select class="form-control" name="disabled" required="1">
				<option value="<?= $ueduser; ?>"><?php if ($ueduser == "true") {
          echo "No";
        } else {
          echo "Yes";
        } ?></option>
				<option value="no">Yes</option>
				<option value="yes">No</option>
			</select>
    </td>
  </tr>
  <tr>
    <td class="align-middle">Server</td>
    <td>
			<select class="form-control" name="server" required="1">
				<option><?php if ($userver == "") {
  echo "all";
} else {
  echo $userver;
} ?></option>
				<option>all</option>
				<?php $TotalReg = count($srvlist);
    for ($i = 0; $i < $TotalReg; $i++) {
      echo "<option>" . $srvlist[$i]['name'] . "</option>";
    }
    ?>
			</select>
		</td>
	</tr>
  <tr>
    <td class="align-middle"><?= $_name ?></td><td><input id="name" class="form-control" type="text" autocomplete="off" name="name" value="<?= $uname; ?>"></td>
  </tr>
  <tr>
    <td class="align-middle"><?= $_password ?></td><td>
	<div class="input-group">
    <div class="input-group-11 col-box-10">
      <input class="group-item group-item-l" id="passUser" type="password" name="pass" autocomplete="new-password" value="<?= $upass; ?>">
    </div>
          <div class="input-group-1 col-box-2">
<div class="group-item group-item-r pd-2p5 text-center">
  <input title="Show/Hide Password" type="checkbox" onclick="PassUser()">
</div>
          </div>
  </div>
		</td>
  </tr>
  <tr>
    <td class="align-middle"><?= $_profile ?></td><td>
			<select class="form-control" name="profile" required="1">
				<option><?= $uprofile; ?></option>
				<?php $TotalReg = count($getprofile);
    for ($i = 0; $i < $TotalReg; $i++) {
      echo "<option>" . $getprofile[$i]['name'] . "</option>";
    }
    ?>
			</select>
		</td>
	</tr>
  <tr>
    <td class="align-middle">Mac Address</td><td><input class="form-control" type="text" value="<?= $umac; ?>"></td>
  </tr>
  <tr>
    <td class="align-middle">Uptime</td><td><input class="form-control" type="text" value="<?php if ($uuptime == 0) {
      } else {
        echo $uuptime;
      } ?>" disabled></td>
  </tr>
  <tr>
    <td class="align-middle">Bytes  In / Out</td><td><input class="form-control" type="text" value="<?php if ($ubytesout == 0) {
    } else {
      echo formatBytes($ubytesin, 2);
    } ?> / <?php if ($ubytesout == 0) {
    } else {
          echo formatBytes($ubytesout, 2);
    } ?>" disabled></td>
  </tr>
  <tr>
    <td class="align-middle"><?= $_time_limit ?></td><td><input id="timelimit" class="form-control" type="text" size="4" autocomplete="off" name="timelimit" value="<?php if ($utimelimit == "1s") {echo "";} else {echo $utimelimit;} ?>"></td>
  </tr>
  <tr>
    <td class="align-middle"><?= $_data_limit ?></td><td>
      <div class="input-group">
        <div class="input-group-10 col-box-9">
        <input class="group-item group-item-l" type="number" min="0" max="9999" id="datalimit" name="datalimit" value="<?= $udatalimit; ?>">
      </div>
          <div class="input-group-2 col-box-3">
              <select style="padding: 4.2px;" class="group-item group-item-r" id="mbgb" name="mbgb" required="1">
				        <option value="<?php if ($MG == "MB") {echo "1048576";  } elseif ($MG == "GB") {echo "1073741824";  } ?>"><?= $MG; ?></option>
				        <option value="1048576">MB</option>
				        <option value="1073741824">GB</option>
			        </select>
          </div>
      </div>
    </td>
  </tr>
  <tr>
    <td class="align-middle"><?= $_tcomment ?></td><td><input class="form-control" type="text" id="comment" autocomplete="off" name="comment" title="No special characters" value="<?= $ucomment; ?>" <?= $commt ?>><input type="hidden" name="h_comment" value="<?= $ucomment ?>"></td>
  </tr>
  <tr>
  <tr <?=$display?>>
    <td class="align-middle"><?= $_tcomment2 ?></td><td><input class="form-control" type="<?= $comment2t ;?>" id="comment2" autocomplete="off" name="comment2" title="No special characters" value="<?= $ucomment2; ?>"></td>
  </tr>
  <tr>
    <td class="align-middle"><?= $_price ?></td><td><input class="form-control" id="price" type="text" value="<?php if ($getprice == 0) {
      } else {
        if ($currency == in_array($currency, $cekindo['indo'])) {
          echo $currency . " " . number_format($getprice, 0, ",", ".");
        } else {
          echo $currency . " " . number_format($getprice);
        }
      } ?>" disabled></td>
  </tr>
  <tr>
    <td class="align-middle"><?= $_selling_price ?></td><td><input class="form-control" id="price" type="text" value="<?php if ($getprice == 0) {
      } else {
        if ($currency == in_array($currency, $cekindo['indo'])) {
          echo $currency . " " . number_format($getsprice, 0, ",", ".");
        } else {
          echo $currency . " " . number_format($getsprice);
        }
      } ?>" disabled></td>
  </tr>
  <?php if ($getvalid != "") { ?>
  <tr>
    <td class="align-middle"><?= $_validity ?></td><td><input class="form-control" type="text" id="validity" value="<?= $getvalid; ?>" disabled></td>
  </tr>
  <?php
} else {
} ?>
  <tr>
    <td colspan="2">
      <p style="padding:0px 5px;">
        <?= $_format_time_limit ?>
      </p>
    </td>
  </tr>
</table>
</form>
</div>
</div>
</div>
</div>