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

if(!isset($_SESSION["mikhmon"])){
  header("Location:../admin.php?id=login");
}else{
  
  $getprofile = $API->comm("/ip/hotspot/user/profile/print");
  $srvlist = $API->comm("/ip/hotspot/print");
  
  if(substr($hotspotuser,0,1) == "*"){
	  $hotspotuser = $hotspotuser;
  }elseif(substr($hotspotuser,0,1) != ""){
	  $getuser = $API->comm("/ip/hotspot/user/print", array(
    "?name"=> "$hotspotuser",
    ));
    $hotspotuser =	$getuser[0]['.id'];
    //if($hotspotuser == ""){echo "<b>Hotspot User not found</b>";}
  }
  
  $getuser = $API->comm("/ip/hotspot/user/print", array(
    "?.id"=> "$hotspotuser",
    ));
	$userdetails =	$getuser[0];
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

  if(substr(formatBytes2($udatalimit,2),-2) == "MB"){
    $udatalimit = $udatalimit/1048576;
    $MG = "MB";
  }elseif(substr(formatBytes2($udatalimit,2),-2) == "GB"){
    $udatalimit = $udatalimit/1073741824;
    $MG = "GB";
  }elseif($udatalimit == ""){
    $udatalimit = "";
    $MG = "MB";
  }

	if($uname == $upass){$usermode = "vc";}else{$usermode = "up";}
  
  if($uname == ""){ echo "<b>User not found redirect to user list...</b>"; echo "<script>window.location='./app.php?hotspot=users&profile=all&session=".$session."'</script>";}
  
  $getprofilebyuser = $API->comm("/ip/hotspot/user/profile/print", array(
    "?name" => "$uprofile"));
  $profiledetalis = $getprofilebyuser[0];
  $ponlogin = $profiledetalis['on-login'];
  $getvalid = explode(",",$ponlogin)[3];
  $getprice = explode(",",$ponlogin)[2];
  
  
  $getsch = $API->comm("/system/scheduler/print", array(
    "?name"=> "$uname",
    ));
  $schdetails = $getsch[0]  ;
	$start = $schdetails['start-date'] ." ". $schdetails['start-time'];
	$end = $schdetails['next-run'];
	//$valy = $schdetails['interval'];
// share WhatsApp  
if($getvalid != ""){
  $wavalid = "Validity : *".$getvalid."* %0A";
}else{
  $wavalid = "";
}
if ($utimelimit != "") {
  $watlimit = "TimeLimit : *".$utimelimit."* %0A";
}else{
  $watlimit = "";
}
if ($udatalimit != "") {
  $wadlimit = "DataLimit : *".$udatalimit."".$MG."* %0A";
}else{
  $wadlimit = "";
}
if($getprice == 0){echo "";}else{
  if($currency == "Rp" || $currency == "rp" || $currency == "IDR" || $currency == "idr"){
    $waprice = "Price : *".$currency." ".number_format($getprice,0,",",".")."* %0A";
  }else{
    $waprice = "Price : *".$currency." ".number_format($getprice)."* %0A";
  }
}

$shareWAUP = "
%0A---------%0A
*".$hotspotname."*
%0A%0A
Username : *" .$uname."* %0A
Password : *".$upass."* %0A
".$wavalid."
".$watlimit."
".$wadlimit."
".$waprice." %0A
Login : *http://".$dnsname."* %0A
--------- 
"; 
$shareWAVC = "
%0A---------%0A
*".$hotspotname."*
%0A%0A
Voucher : *" .$uname."* %0A
".$wavalid."
".$watlimit."
".$wadlimit."
".$waprice." %0A
Login : *http://".$dnsname."* %0A
---------
"; 
if($uname == $upass){$shareWA = $shareWAVC;}else{$shareWA = $shareWAUP;}
	
  if(isset($_POST['name'])){
    $server = ($_POST['server']);
    $name = ($_POST['name']);
    $password = ($_POST['pass']);
    $profile = ($_POST['profile']);
    $disabled = ($_POST['disabled']);
    $timelimit = ($_POST['timelimit']);
    $datalimit = ($_POST['datalimit']);
    $comment = ($_POST['comment']);
    $mbgb = ($_POST['mbgb']);
    if($timelimit == ""){$timelimit = "0";}else{$timelimit = $timelimit;}
    if($datalimit == ""){$datalimit = "0";}else{$datalimit = $datalimit*$mbgb;}
    $API->comm("/ip/hotspot/user/set", array(
	    ".id"=> "$uid",
	    "server" => "$server",
	    "name" => "$name",
	    "password" => "$password",
	    "profile" => "$profile",
	    "disabled" => "$disabled",
	    "limit-uptime" => "$timelimit",
			"limit-bytes-total" => "$datalimit",
      "comment" => "$comment",
	    ));
    echo "<script>window.location='./app.php?hotspot-user=".$uid."&session=".$session."'</script>";
  }
}
?>
<script>
  function PassUser(){
    var x = document.getElementById('passUser');
    if (x.type === 'password') {
    x.type = 'text';
    } else {
    x.type = 'password';
    }}
</script>
<div class="row">
<div class="col-12">
<div class="card">
<div class="card-header">
    <h3><i class="fa fa-edit"></i> Edit User</h3>
</div>
<div class="card-body">
<form autocomplete="new-password" method="post" action="">
  <div>
    <?php if($_SESSION['ubp'] != ""){
    echo "    <a class='btn bg-warning' href='./app.php?hotspot=users&profile=".$_SESSION['ubp']."&session=".$session."'><i class='fa fa-close'></i> Close</a>";
}elseif($_SESSION['ubc'] != ""){
    echo "    <a class='btn bg-warning' href='./app.php?hotspot=users&comment=".$_SESSION['ubc']."&session=".$session."'><i class='fa fa-close'></i> Close</a>";
}elseif($_SESSION['hua'] != ""){
    $_SESSION['ubn'] = "";
    echo "    <a class='btn bg-warning' href='./app.php?hotspot=active&session=".$session."'><i class='fa fa-close'></i> Close</a>";
    $_SESSION['hua'] = "";
}elseif($_SESSION['ubn'] != ""){
    echo "    <a class='btn bg-warning' href='./app.php?hotspot=users&profile=all&session=".$session."'><i class='fa fa-close'></i> Close</a>";
    $_SESSION['ubn'] = "";
}else{
    echo "    <a class='btn bg-warning' href='./app.php?hotspot=users&profile=all&session=".$session."'><i class='fa fa-close'></i> Close</a>";
}
?>
    <button type="submit" name="save" class="btn bg-primary" > <i class="fa fa-save"></i> Save</button>
    <div class="btn bg-danger"  onclick="if(confirm('Are you sure to delete username (<?php echo $uname;?>)?')){window.location='./app.php?remove-hotspot-user=<?php echo $uid;?>&session=<?php echo $session;?>'}else{}" title='Remove <?php echo $uname;?>'><i class='fa fa-minus-square'></i> Remove</div>
    <a class="btn bg-secondary"  title="Print" href="javascript:window.open('./voucher/print.php?user=<?php echo $usermode."-".$uname;?>&qr=no&session=<?php echo $session;?>','_blank','width=310,height=450').print();"> <i class="fa fa-print"></i> Print</a>
    <a class="btn bg-info"  title="Print QR" href="javascript:window.open('./voucher/print.php?user=<?php echo $usermode."-".$uname;?>&qr=yes&session=<?php echo $session;?>','_blank','width=310,height=450').print();"> <i class="fa fa-qrcode"></i> QR</a>
    <?php if($utimelimit == "1s"){echo '<a class="btn bg-info"  href="./app.php?reset-hotspot-user='.$uid.'&session='.$session.'"> <i class="fa fa-retweet"></i> Reset</a>';}?>
    <a id="shareWA" class="btn bg-success" title="Share WhatsApp" href="whatsapp://send?text=<?php echo $shareWA;?>"> <i class="fa fa-whatsapp"></i> Share</a>
  </div>
<table class="table">
  <tr>
    <td class="align-middle">Enabled</td>
    <td>
			<select class="form-control" name="disabled" required="1">
				<option value="<?php echo $ueduser;?>"><?php if($ueduser == "true"){echo "No";}else{echo "Yes";}?></option>
				<option value="no">Yes</option>
				<option value="yes">No</option>
			</select>
    </td>
  </tr>
  <tr>
    <td class="align-middle">Server</td>
    <td>
			<select class="form-control" name="server" required="1">
				<option><?php if($userver == ""){echo "all";}else{echo $userver;}?></option>
				<option>all</option>
				<?php $TotalReg = count($srvlist);
				for ($i=0; $i<$TotalReg; $i++){
				  echo "<option>" . $srvlist[$i]['name'] . "</option>";
				  }
				?>
			</select>
		</td>
	</tr>
  <tr>
    <td class="align-middle">Name</td><td><input class="form-control" type="text" autocomplete="off" name="name" value="<?php echo $uname;?>"></td>
  </tr>
  <tr>
    <td class="align-middle">Password</td><td>
	<div class="input-group">
    <div class="input-group-11 col-box-10">
      <input class="group-item group-item-l" id="passUser" type="password" name="pass" autocomplete="new-password" value="<?php echo  $upass;?>">
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
    <td class="align-middle">Profile</td><td>
			<select class="form-control" name="profile" required="1">
				<option><?php echo $uprofile;?></option>
				<?php $TotalReg = count($getprofile);
				for ($i=0; $i<$TotalReg; $i++){
				  echo "<option>" . $getprofile[$i]['name'] . "</option>";
				  }
				?>
			</select>
		</td>
	</tr>
  <tr>
    <td class="align-middle">Mac Address</td><td><input class="form-control" type="text" value="<?php echo $umac;?>"></td>
  </tr>
  <tr>
    <td class="align-middle">Uptime</td><td><input class="form-control" type="text" value="<?php if($uuptime == 0){}else{echo $uuptime;}?>" disabled></td>
  </tr>
  <tr>
    <td class="align-middle">Bytes  In / Out</td><td><input class="form-control" type="text" value="<?php if($ubytesout == 0){}else{echo formatBytes($ubytesin,2);}?> / <?php if($ubytesout == 0){}else{echo formatBytes($ubytesout,2);}?>" disabled></td>
  </tr>
  <tr>
    <td class="align-middle">Time Limit</td><td><input class="form-control" type="text" size="4" autocomplete="off" name="timelimit" value="<?php if($utimelimit == "1s"){echo "";}else{ echo $utimelimit;}?>"></td>
  </tr>
  <tr>
    <td class="align-middle">Data Limit</td><td>
      <div class="input-group">
        <div class="input-group-10 col-box-9">
        <input class="group-item group-item-l" type="number" min="0" max="9999" name="datalimit" value="<?php echo $udatalimit;?>">
      </div>
          <div class="input-group-2 col-box-3">
              <select style="padding: 4.2px;" class="group-item group-item-r" name="mbgb" required="1">
				        <option value="<?php if($MG == "MB"){echo "1048576";}elseif($MG == "GB"){echo "1073741824";}?>"><?php echo $MG;?></option>
				        <option value=1048576>MB</option>
				        <option value=1073741824>GB</option>
			        </select>
          </div>
      </div>
    </td>
  </tr>
  <tr>
    <td class="align-middle">Comment</td><td><input class="form-control" type="text" id="comment" autocomplete="off" name="comment" title="No special characters" value="<?php echo $ucomment;?>"></td>
  </tr>
  <tr>
    <td class="align-middle">Price</td><td><input class="form-control" type="text" value="<?php if($getprice == 0){}else{if($currency == "Rp" || $currency == "rp" || $currency == "IDR" || $currency == "idr"){echo $currency." ".number_format($getprice,0,",",".");}else{ echo $currency." ".number_format($getprice); }}?>" disabled></td>
  </tr>
  <?php if($getvalid != ""){?>
  <tr>
    <td class="align-middle">Validity</td><td><input class="form-control" type="text" value="<?php echo $getvalid;?>" disabled></td>
  </tr>
  <tr>
    <td class="align-middle">Start</td><td><input class="form-control" type="text" value="<?php echo $start;?>" disabled></td>
  </tr>
  <tr>
    <td class="align-middle"><?php if($utimelimit == "1s"){echo "Expired";}else{echo "End";}?></td><td><input class="form-control" type="text" value="<?php echo $end;?>" disabled></td>
  </tr>
  <?php }else{}?>
  <tr>
    <td colspan="2">
      <?php if($currency == "Rp" || $currency == "rp" || $currency == "IDR" || $currency == "idr"){?>
      <p style="padding:0px 5px;">
        Format Time Limit.<br>
        [wdhm] Contoh : 30d = 30hari, 12h = 12jam, 4w3d = 31hari.
      </p>
      <?php }else{?>
      <p style="padding:0px 5px;">
        Format Time Limit.<br>
        [wdhm] Example : 30d = 30days, 12h = 12hours, 4w3d = 31days.
      </p>
      <?php }?>
    </td>
  </tr>
</table>
</form>
</div>
</div>
</div>
</div>