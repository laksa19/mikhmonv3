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
// hide all error
error_reporting(0);
if (!isset($_SESSION["mikhmon"])) {
  header("Location:../admin.php?id=login");
} else {

  $getallqueue = $API->comm("/queue/simple/print", array(
    "?dynamic" => "false",
  ));

  $getpool = $API->comm("/ip/pool/print");

  if (isset($_POST['name'])) {
    $name = (preg_replace('/\s+/', '-',$_POST['name']));
    $sharedusers = ($_POST['sharedusers']);
    $ratelimit = ($_POST['ratelimit']);
    $expmode = ($_POST['expmode']);
    $validity = ($_POST['validity']);
    $graceperiod = ($_POST['graceperiod']);
    $getprice = ($_POST['price']);
    $getsprice = ($_POST['sprice']);
    $addrpool = ($_POST['ppool']);
    if ($getprice == "") {
      $price = "0";
    } else {
      $price = $getprice;
    }
    if ($getsprice == "") {
      $sprice = "0";
    } else {
      $sprice = $getsprice;
    }
    $getlock = ($_POST['lockunlock']);
    if ($getlock == "Enable") {
      $lock = '; [:local mac $"mac-address"; /ip hotspot user set mac-address=$mac [find where name=$user]]';
    } else {
      $lock = "";
    }

    $randstarttime = "0".rand(1,5).":".rand(10,59).":".rand(10,59);
    $randinterval = "00:02:".rand(10,59);

    $parent = ($_POST['parent']);
    
    $record = '; :local mac $"mac-address"; :local time [/system clock get time ]; :local year [:pick $date 0 4]; :local monthnum [:pick $date 5 7]; :local montharray ("jan","feb","mar","apr","may","jun","jul","aug","sep","oct","nov","dec"); :local month [:pick $montharray ([:tonum $monthnum] - 1)]; /system script add name="$date-|-$time-|-$user-|-'.$price.'-|-$address-|-$mac-|-' . $validity . '-|-'.$name.'-|-$comment" owner="$month$year" source="$date" comment="mikhmon"';
    
    // RouterOS 7 returns scheduler next-run as YYYY-MM-DD HH:MM:SS. Keep that
    // ISO timestamp intact so the monitor can compare it without date conversion.
    $onlogin = ':put (",'.$expmode.',' . $price . ',' . $validity . ','.$sprice.',,' . $getlock . ',"); {:local comment [ /ip hotspot user get [/ip hotspot user find where name="$user"] comment]; :local ucode [:pic $comment 0 2]; :if ($ucode = "vc" or $ucode = "up" or $comment = "") do={ :local date [ /system clock get date ]; /sys sch add name="$user" disable=no start-date=$date interval="' . $validity . '"; :delay 5s; :local exp [ /sys sch get [ /sys sch find where name="$user" ] next-run]; /ip hotspot user set comment="$exp" [find where name="$user"]; :delay 5s; /sys sch remove [find where name="$user"]';
    

    if ($expmode == "rem") {
      $onlogin = $onlogin . $lock . "}}";
      $mode = "remove";
    } elseif ($expmode == "ntf") {
      $onlogin = $onlogin . $lock . "}}";
      $mode = "set limit-uptime=1s";
    } elseif ($expmode == "remc") {
      $onlogin = $onlogin . $record . $lock . "}}";
      $mode = "remove";
    } elseif ($expmode == "ntfc") {
      $onlogin = $onlogin . $record . $lock . "}}";
      $mode = "set limit-uptime=1s";
    } elseif ($expmode == "0" && $price != "") {
      $onlogin = ':put (",,' . $price . ',,,noexp,' . $getlock . ',")' . $lock;
    } else {
      $onlogin = "";
    }

    $bgservice = ':local dateint do={ :local year [:pick $d 0 4]; :local month [:pick $d 5 7]; :local day [:pick $d 8 10]; :return [:tonum ("$year$month$day")]; }; :local timeint do={ :local hours [:pick $t 0 2]; :local minutes [:pick $t 3 5]; :local seconds [:pick $t 6 8]; :return (($hours * 3600) + ($minutes * 60) + $seconds); }; :local date [ /system clock get date ]; :local time [ /system clock get time ]; :local today [$dateint d=$date]; :local curtime [$timeint t=$time]; :foreach i in [ /ip hotspot user find where profile="'.$name.'" ] do={ :local comment [ /ip hotspot user get $i comment]; :local name [ /ip hotspot user get $i name]; :if ([:pick $comment 4] = "-" and [:pick $comment 7] = "-" and [:pick $comment 10] = " ") do={ :local gettime [:pick $comment 11 19]; :local expd [$dateint d=$comment]; :local expt [$timeint t=$gettime]; :if (($expd < $today) or (($expd = $today) and ($expt <= $curtime))) do={ [ /ip hotspot user '.$mode.' $i ]; [ /ip hotspot active remove [find where user=$name] ]; } } }';

    $API->comm("/ip/hotspot/user/profile/add", array(
			  		  /*"add-mac-cookie" => "yes",*/
      "name" => "$name",
      "address-pool" => "$addrpool",
      "rate-limit" => "$ratelimit",
      "shared-users" => "$sharedusers",
      "status-autorefresh" => "1m",
      //"transparent-proxy" => "yes",
      "on-login" => "$onlogin",
      "parent-queue" => "$parent",
    ));

    if($expmode != "0"){
      if (empty($monid)){
        $API->comm("/system/scheduler/add", array(
          "name" => "$name",
          "start-time" => "$randstarttime",
          "interval" => "$randinterval",
          "on-event" => "$bgservice",
          "disabled" => "no",
          "comment" => "Monitor Profile $name",
          ));
      }else{
      $API->comm("/system/scheduler/set", array(
        ".id" => "$monid",
        "name" => "$name",
        "start-time" => "$randstarttime",
        "interval" => "$randinterval",
        "on-event" => "$bgservice",
        "disabled" => "no",
        "comment" => "Monitor Profile $name",
        ));
      }}else{
        $API->comm("/system/scheduler/remove", array(
          ".id" => "$monid"));
      }

    $getprofile = $API->comm("/ip/hotspot/user/profile/print", array(
      "?name" => "$name",
    ));
    $pid = $getprofile[0]['.id'];
    echo "<script>window.location='./?user-profile=" . $pid . "&session=" . $session . "'</script>";
  }
}
?>
<div class="row">
<div class="col-8">
<div class="card box-bordered">
  <div class="card-header">
    <h3><i class="fa fa-plus"></i> <?= $_add.' '.$_user_profile ?> <small id="loader" style="display: none;" ><i><i class='fa fa-circle-o-notch fa-spin'></i> Processing... </i></small></h3>
  </div>
  <div class="card-body">
<form autocomplete="off" method="post" action="">
  <div>
    <a class="btn bg-warning" href="./?hotspot=user-profiles&session=<?= $session; ?>"> <i class="fa fa-close btn-mrg"></i> <?= $_close ?></a>
    <button type="submit" name="save" class="btn bg-primary btn-mrg" ><i class="fa fa-save btn-mrg"></i> <?= $_save ?></button>
  </div>
<table class="table">
  <tr>
    <td class="align-middle"><?= $_name ?></td><td><input class="form-control" type="text" onchange="remSpace();" autocomplete="off" name="name" value="" required="1" autofocus></td>
  </tr>
  <tr>
    <td class="align-middle">Address Pool</td>
    <td>
    <select class="form-control " name="ppool">
      <option>none</option>
        <?php $TotalReg = count($getpool);
        for ($i = 0; $i < $TotalReg; $i++) {

          echo "<option>" . $getpool[$i]['name'] . "</option>";
        }
        ?>
    </select>
    </td>
  </tr>
  <tr>
    <td class="align-middle">Shared Users</td><td><input class="form-control" type="text" size="4" autocomplete="off" name="sharedusers" value="1" required="1"></td>
  </tr>
  <tr>
    <td class="align-middle">Rate limit [up/down]</td><td><input class="form-control" type="text" name="ratelimit" autocomplete="off" value="" placeholder="Example : 512k/1M" ></td>
  </tr>
  <tr>
    <td class="align-middle"><?= $_expired_mode ?></td><td>
      <select class="form-control" onchange="RequiredV();" id="expmode" name="expmode" required="1">
        <option value="">Select...</option>
        <option value="0">None</option>
        <option value="rem">Remove</option>
        <option value="ntf">Notice</option>
        <option value="remc">Remove & Record</option>
        <option value="ntfc">Notice & Record</option>
      </select>
    </td>
  </tr>
  <tr id="validity" style="display:none;">
    <td class="align-middle"><?= $_validity ?></td><td><input class="form-control" type="text" id="validi" size="4" autocomplete="off" name="validity" value="" required="1"></td>
  </tr>
  <tr id="graceperiod" style="display:none;">
    <td class="align-middle"><?= $_grace_period ?></td><td><input class="form-control" type="text" id="gracepi" size="4" autocomplete="off" name="graceperiod" placeholder="5m" value="5m" required="1"></td>
  </tr>
  <tr>
    <td class="align-middle"><?= $_price.' '.$currency; ?></td><td><input class="form-control" type="text" size="10" min="0" name="price" value="" ></td>
  </tr>
  <tr>
    <td class="align-middle"><?= $_selling_price.' '.$currency; ?></td><td><input class="form-control" type="text" size="10" min="0" name="sprice" value="" ></td>
  </tr>
  <tr>
    <td><?= $_lock_user ?></td><td>
      <select class="form-control" id="lockunlock" name="lockunlock" required="1">
        <option value="Disable">Disable</option>
        <option value="Enable">Enable</option>
      </select>
    </td>
  </tr>
  <tr>
    <td class="align-middle">Parent Queue</td>
    <td>
    <select class="form-control " name="parent">
      <option>none</option>
        <?php $TotalReg = count($getallqueue);
        for ($i = 0; $i < $TotalReg; $i++) {

          echo "<option>" . $getallqueue[$i]['name'] . "</option>";
        }
        ?>
    </select>
  </td>
  </tr>
</table>
</form>
</div>
</div>
</div>
<div class="col-4">
  <div class="card">
    <div class="card-header">
      <h3><i class="fa fa-book"></i> <?= $_readme ?></h3>
    </div>
    <div class="card-body">
<table class="table">
    <tr>
    <td colspan="2">
      <p style="padding:0px 5px;">
        <?= $_details_user_profile ?>
      </p>
      <p style="padding:0px 5px;">
        <?= $_format_validity ?>
      </p>
    </td>
  </tr>
</table>
</div>
</div>
</div>
</div>
<script type="text/javascript">
function remSpace() {
  var upName = document.getElementsByName("name")[0];
  var newUpName = upName.value.replace(/\s/g, "-");
  //alert("<?php if ($currency == in_array($currency, $cekindo['indo'])) {
            echo "Nama Profile tidak boleh berisi spasi";
          } else {
            echo "Profile name can't containing white space!";
          } ?>");
  upName.value = newUpName;
  upName.focus();
}
</script>
