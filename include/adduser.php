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
if(!isset($_SESSION["mikhmon"])){
  header("Location:../admin.php?id=login");
}else{

  $getprofile = $API->comm("/ip/hotspot/user/profile/print");
  $srvlist = $API->comm("/ip/hotspot/print");
  
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
    $API->comm("/ip/hotspot/user/add", array(
	    "server" => "$server",
	    "name" => "$name",
	    "password" => "$password",
	    "profile" => "$profile",
	    "disabled" => "no",
	    "limit-uptime" => "$timelimit",
			"limit-bytes-total" => "$datalimit",
      "comment" => "$comment",
	    ));
    $getuser = $API->comm("/ip/hotspot/user/print", array(
    "?name"=> "$name",
    ));
    $uid =	$getuser[0]['.id'];
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
<div class="col-8">
<div class="card box-bordered">
  <div class="card-header">
    <h3><i class="fa fa-user-plus"></i> Add User </h3> <i id="loader" style="display: none;" ><i class='fa fa-circle-o-notch fa-spin'></i> Processing... </i>
  </div>
  <div class="card-body">
<form autocomplete="off" method="post" action="">  
  <div>
  <?php if($_SESSION['ubp'] != ""){
    echo "    <a class='btn bg-warning' href='./app.php?hotspot=users&profile=".$_SESSION['ubp']."&session=".$session."'> <i class='fa fa-close'></i> Close</a>";
}else{
    echo "    <a class='btn bg-warning' href='./app.php?hotspot=users&profile=all&session=".$session."'> <i class='fa fa-close'></i> Close</a>";
}
?>
    <button type="submit" onclick="loader()" class="btn bg-primary" name="save"><i class="fa fa-save"></i> Save</button>
  </div>

<table class="table">
  <tr>
    <td class="align-middle" >Server</td>
    <td>
			<select class="form-control" name="server" required="1">
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
    <td class="align-middle">Name</td><td><input class="form-control" type="text" autocomplete="off" name="name" value="" required="1" autofocus></td>
  </tr>
  <tr>
    <td class="align-middle">Password</td><td>
        <div class="input-group">
          <div class="input-group-11 col-box-10">
            <input class="group-item group-item-l" id="passUser" type="password" name="pass" autocomplete="new-password" value="" required="1">
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
			<select class="form-control" onchange="GetVP();"  id="uprof" name="profile" required="1">
				<?php $TotalReg = count($getprofile);
				for ($i=0; $i<$TotalReg; $i++){
				  echo "<option>" . $getprofile[$i]['name'] . "</option>";
				  }
				?>
			</select>
		</td>
	</tr>
	<tr>
    <td class="align-middle">Time Limit</td><td><input class="form-control" type="text"  autocomplete="off" name="timelimit" value=""></td>
  </tr>
  <tr>
    <td class="align-middle">Data Limit</td><td>
      <div class="input-group">
        <div class="input-group-10 col-box-9">
          <input class="group-item group-item-l" type="number" min="0" max="9999" name="datalimit" value="<?php echo $udatalimit;?>">
        </div>
          <div class="input-group-2 col-box-3">
              <select style="padding:4.2px;" class="group-item group-item-r" name="mbgb" required="1">
				        <option value=1048576>MB</option>
                <option value=1073741824>GB</option>
			        </select>
          </div>
      </div>
    </td>
  </tr>
  <tr>
    <td class="align-middle">Comment</td><td><input class="form-control" type="text" title="No special characters" id="comment" autocomplete="off" name="comment" value=""></td>
  </tr>
  <tr >
    <td  colspan="4" class="align-middle"  id="GetValidPrice"></td>
  </tr>
</table>
</form>
</div>
</div>
</div>
<div class="col-4">
  <div class="card">
    <div class="card-header">
      <h3><i class="fa fa-book"></i> ReadMe</h3>
    </div>
    <div class="card-body">
<table>
   <tr>
    <td colspan="2">
      <?php if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){?>
      <p style="padding:0px 5px;">
        Format Time Limit.<br>
        [wdhm] Contoh : 30d = 30hari, 12h = 12jam, 4w3d = 31hari.
      </p>
       <p style="padding:0px 5px;">
        Add User dengan Time Limit.<br>
        Sebaiknya Time Limit < Validity.
      </p>
      <?php }else{?>
      <p style="padding:0px 5px;">
        Add User with Time Limit.<br>
        Preferably  Time Limit < Validity.
      </p>
      <?php }?>
    </td>
  </tr>
</table>
</div>
</div>
</div>
<script>
  function loader(){
    document.getElementById('loader').style='display:block;';
  }
// get valid $ price
function GetVP(){
  var prof = document.getElementById('uprof').value;
  var url = "./process/getvalidprice.php?name=";
  var session = "&session=<?php echo $session;?>"
  var getvalidprice = url+prof+session
  $("#GetValidPrice").load(getvalidprice);
}  
</script>
</div>