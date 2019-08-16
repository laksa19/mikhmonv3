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

ini_set('max_execution_time', 300);

if (!isset($_SESSION["mikhmon"])) {
	header("Location:../admin.php?id=login");
} else {
	$qpid = $_GET['qpid'];
	$rem = $_GET['remove'];
	$charup = array(
		"lower" => "abcd",
		"upper" => " ABCD",
		"upplow" => " aBcD",
		"mix" => " 5ab2c34d",
		"mix1" => " 5AB2C34D",
		"mix2" => "5aB2c34D",
	);

	$charvc = array(
		"lower" => " abcd2345",
		"upper" => " ABCD2345",
		"upplow" => " aBcD2345",
		"num" => " 1234",
	);

if(isset($qpid) && isset($rem)){
	$API->comm("/system/script/remove", array(
		".id" => "$qpid",
));
echo '<script>window.location.reload()</script>';
}	

	// get quick print
$getquickprint = $API->comm("/system/script/print", array("?.id" => "$qpid"));
  $quickprintdetails = $getquickprint[0];
  $qpid = $quickprintdetails['.id'];
  $quickprintsource = explode("#",$quickprintdetails['source']);
  $package = $quickprintsource[1];
  $server = $quickprintsource[2];
  $usermode = $quickprintsource[3];
  $userlength = $quickprintsource[4];
  $prefix = $quickprintsource[5];
  $char = $quickprintsource[6];
  $profile = $quickprintsource[7];
  $timelimit = $quickprintsource[8];
  $datalimit = $quickprintsource[9];
	$comment = $quickprintsource[10];
	if($usermode == "up"){
		$tusermode =  $_user_pass;
		$tchar = $charup[$char];
	}elseif($usermode == "vc"){
		$tusermode =  $_user_user;
		$tchar = $charvc[$char];
	}
	if (substr(formatBytes2($datalimit, 2), -2) == "MB") {
		$udatalimit = $datalimit / 1048576;
		$xdatalimit = 1048576;
    $MG = "MB";
  } elseif (substr(formatBytes2($datalimit, 2), -2) == "GB") {
		$udatalimit = $datalimit / 1073741824;
		$xdatalimit = 1073741824;
    $MG = "GB";
  } else{
		$udatalimit = "";
		$xdatalimit = 1048576;
    $MG = "MB";
  }

	// array color
    $color = array('1' => 'bg-blue', 'bg-indigo', 'bg-purple', 'bg-pink', 'bg-red', 'bg-yellow', 'bg-green', 'bg-teal', 'bg-cyan', 'bg-grey', 'bg-light-blue');

    $srvlist = $API->comm("/ip/hotspot/print");
    $getprofile = $API->comm("/ip/hotspot/user/profile/print");
	

	if (isset($_POST['name'])) {
        $name = ($_POST['name']);
        $sname = "Quick_Print_".(preg_replace('/\s+/', '-', $_POST['name']));
		$server = ($_POST['server']);
		$user = ($_POST['user']);
		$userl = ($_POST['userl']);
		$prefix = ($_POST['prefix']);
		$char = ($_POST['char']);
		$profile = ($_POST['profile']);
		$timelimit = ($_POST['timelimit']);
		$datalimit = ($_POST['datalimit']);
		$adcomment = ($_POST['adcomment']);
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
		if ($adcomment == "") {
			$adcomment = "";
		} else {
			$adcomment = $adcomment;
		}
		$getprofile = $API->comm("/ip/hotspot/user/profile/print", array("?name" => "$profile"));
		$ponlogin = $getprofile[0]['on-login'];
		$getvalid = explode(",", $ponlogin)[3];
		$getprice = explode(",", $ponlogin)[2];
		$getsprice = explode(",", $ponlogin)[4];
		$getlock = explode(",", $ponlogin)[6];

        $source = '#'.$name.'#'.$server.'#'.$user.'#'.$userl.'#'.$prefix.'#'.$char.'#'.$profile.'#'.$timelimit.'#'.$datalimit.'#'.$adcomment.'#'.$getvalid.'#'.$getprice.'_'.$getsprice.'#'.$getlock;

		if (isset($qpid)){
			$API->comm("/system/script/set", array(
				".id" => "$qpid",
				"name" => "$sname",
				"source" => "$source",
				"comment" => "QuickPrintMikhmon",
		));
		}else{
        $API->comm("/system/script/add", array(
            "name" => "$sname",
            "source" => "$source",
            "comment" => "QuickPrintMikhmon",
				));
			}

		echo "<script>window.location='./?hotspot=list-quick-print&session=" . $session . "'</script>";
		
	}



}
?>
<div class="row">
	
<div class="col-4">
<div class="card box-bordered">
	<div class="card-header">
	<h3><i class="fa fa-ticket"></i> <?php if(isset($qpid)){echo $_edit;}else{echo $_add;} echo ' '. $_quick_print ?> <small id="loader" style="display: none;" ><i><i class='fa fa-circle-o-notch fa-spin'></i> <?= $_processing ?> </i></small></h3> 
	</div>
	<div class="card-body">
<form autocomplete="off" method="post" action="">
	<div>
<?php if(isset($qpid)){echo "
		<a class='btn bg-warning' href='./?hotspot=list-quick-print&session=".$session."'> <i class='fa fa-close'></i> ".$_cancel."</a>";
}else{
	echo "<a class='btn bg-warning' href='./?hotspot=quick-print&session=".$session."'> <i class='fa fa-close'></i> ".$_close."</a>";
} ?>

    <button type="submit" name="save" onclick="loader()" class="btn bg-primary" title="Generate User"> <i class="fa fa-save"></i> <?= $_save ?></button>
</div>
<table class="table">
  <tr>
    <td class="align-middle"><?= $_name ?></td><td><div><input class="form-control " type="text" name="name" value="<?= $package ?>" required="1"></div></td>
  </tr>
  <tr>
    <td class="align-middle">Server</td>
    <td>
		<select class="form-control " name="server" required="1">
			<?php if(isset($qid)){echo '<option>'. $server .'</option>';}else{echo '<option>all</option>';} ?>
				<?php $TotalReg = count($srvlist);
			for ($i = 0; $i < $TotalReg; $i++) {
				echo "<option>" . $srvlist[$i]['name'] . "</option>";
			}
			?>
		</select>
	</td>
	</tr>
	<tr>
    <td class="align-middle"><?= $_user_mode ?></td><td>
			<select class="form-control " onchange="defUserl();" id="user" name="user" required="1">
				<?php if(isset($qpid)){echo '<option value="'.$usermode.'">'.$tusermode.'</option>';}?>
				<option value="up"><?= $_user_pass ?></option>
				<option value="vc"><?= $_user_user ?></option>
			</select>
		</td>
	</tr>
  <tr>
    <td class="align-middle"><?= $_user_length ?></td><td>
      <select class="form-control " id="userl" name="userl" required="1">
			<?php if(isset($qpid)){echo '<option>'.$userlength.'</option>';}?>
        <option>4</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
				<option>6</option>
				<option>7</option>
				<option>8</option>
			</select>
    </td>
  </tr>
  <tr>
    <td class="align-middle"><?= $_prefix ?></td><td><input class="form-control " type="text" size="4" maxlength="4" autocomplete="off" name="prefix" value="<?= $prefix ?>"></td>
  </tr>
  <tr>
    <td class="align-middle"><?= $_character ?></td><td>
      <select class="form-control " name="char" required="1">
			<?php if(isset($qpid)){echo '<option value="'.$char.'">'.$_random.' '.$tchar.'</option>';}?>
				<option id="lower" style="display:block;" value="lower"><?= $_random ?> abcd</option>
				<option id="upper" style="display:block;" value="upper"><?= $_random ?> ABCD</option>
				<option id="upplow" style="display:block;" value="upplow"><?= $_random ?> aBcD</option>
				<option id="lower1" style="display:none;" value="lower"><?= $_random ?> abcd2345</option>
				<option id="upper1" style="display:none;" value="upper"><?= $_random ?> ABCD2345</option>
				<option id="upplow1" style="display:none;" value="upplow"><?= $_random ?> aBcD2345</option>
				<option id="mix" style="display:block;" value="mix"><?= $_random ?> 5ab2c34d</option>
				<option id="mix1" style="display:block;" value="mix1"><?= $_random ?> 5AB2C34D</option>
				<option id="mix2" style="display:block;" value="mix2"><?= $_random ?> 5aB2c34D</option>
				<option id="num" style="display:none;" value="num"><?= $_random ?> 1234</option>
			</select>
    </td>
  </tr>
  <tr>
    <td class="align-middle"><?= $_profile ?></td><td>
			<select class="form-control " onchange="GetVP();" id="uprof" name="profile" required="1">
				<?php if (isset($qpid)) {
				echo "<option>" . $profile . "</option>";
			} else {
			}
			$TotalReg = count($getprofile);
			for ($i = 0; $i < $TotalReg; $i++) {
				echo "<option>" . $getprofile[$i]['name'] . "</option>";
			}
			?>
			</select>
		</td>
	</tr>
	<tr>
    <td class="align-middle"><?= $_time_limit ?></td><td><input class="form-control " type="text" size="4" autocomplete="off" name="timelimit" value="<?= $timelimit ?>"></td>
  </tr>
	<tr>
    <td class="align-middle"><?= $_data_limit ?></td><td>
      <div class="input-group">
      	<div class="input-group-8 col-box-9">
        	<input class="group-item group-item-l" type="number" min="0" max="9999" name="datalimit" value="<?= $udatalimit; ?>">
    	</div>
          <div class="input-group-4 col-box-3">
							<select style="padding:4.2px;" class="group-item group-item-r" name="mbgb" required="1">
							<?php if(isset($qpid)){echo '<option value="'.$xdatalimit.'">'.$MG.'</option>';}?>
				        <option value=1048576>MB</option>
				        <option value=1073741824>GB</option>
			        </select>
          </div>
      </div>
    </td>
  </tr>
	<tr>
    <td class="align-middle"><?= $_comment ?></td><td><input class="form-control " type="text" title="No special characters" id="comment" autocomplete="off" name="adcomment" value="<?= $comment ?>"></td>
  </tr>
   <tr >
    <td  colspan="4" class="align-middle w-12"  id="GetValidPrice">
    	<?php if ($genprof != "") {
					echo $ValidPrice;
				} ?>
    </td>
  </tr>
</table>
</form>
</div>
</div>
</div>

<div class="col-8">
	<div class="card">
		<div class="card-header">
			<h3><i class="fa fa-ticket"></i> <?= $_package.' '.  $_quick_print ?></h3>
		</div>
		<div class="card-body">
            <div class="row">
                <div class="overflow box-bordered">
                <table class="table table-bordered table-hover text-nowrap">
                    <tr>
										<th></th>	
                    <th><?= $_package ?></th>
                    <th>Server</th>
                    <th><?= $_user_mode ?></th>
                    <th><?= $_user_length ?></th>
                    <th><?= $_prefix ?></th>
                    <th><?= $_profile ?></th>
                    <th><?= $_time_limit ?></th>
                    <th><?= $_data_limit ?></th>
                    <th><?= $_validity ?></th>
					<th><?= $_price ?></th>
					<th><?= $_selling_price ?></th>
                    <th><?= $_lock_user ?></th>
                    <th><?= $_comment ?></th>
                    </tr>
<?php
// get quick print
$getquickprint = $API->comm("/system/script/print", array("?comment" => "QuickPrintMikhmon"));
$TotalReg = count($getquickprint);
for ($i = 0; $i < $TotalReg; $i++) {
  $quickprintdetails = $getquickprint[$i];
  $qpid = $quickprintdetails['.id'];
  $quickprintsource = explode("#",$quickprintdetails['source']);
  $package = $quickprintsource[1];
  $server = $quickprintsource[2];
  $usermode = $quickprintsource[3];
  $userlength = $quickprintsource[4];
  $prefix = $quickprintsource[5];
  $char = $quickprintsource[6];
  $profile = $quickprintsource[7];
  $timelimit = $quickprintsource[8];
  $datalimit = $quickprintsource[9];
  $comment = $quickprintsource[10];
  $validity = $quickprintsource[11];
  $getprice = explode("_",$quickprintsource[12])[0];
  $getsprice = explode("_",$quickprintsource[12])[1];
  $userlock = $quickprintsource[13];
  if ($currency == in_array($currency, $cekindo['indo'])) {
    $price = $currency . " " . number_format($getprice, 0, ",", ".");
    $sprice = $currency . " " . number_format($getsprice, 0, ",", ".");
} else {
    $price = $currency . " " . number_format($getprice);
    $sprice = $currency . " " . number_format($getsprice);
}
?>
<tr>
<td><i class='fa fa-minus-square text-danger pointer' onclick="if(confirm('Are you sure to delete (<?= $package; ?>)?')){loadpage('./?hotspot=list-quick-print&remove&qpid=<?= $qpid; ?>&session=<?= $session; ?>')}else{}" title='Remove <?= $package; ?>'></i>&nbsp</td>	
<td><a title="Edit <?= $_package.' '. $package; ?>" href="./?hotspot=list-quick-print&qpid=<?= $qpid; ?>&session=<?= $session; ?>"><i class="fa fa-edit"></i> <?= $package; ?></a></td>
<td><?= $server ?></td>
<td><?= $usermode ?></td>
<td><?= $userlength ?></td>
<td><?= $prefix ?></td>
<td><?= $profile ?></td>
<td><?= $timelimit ?></td>
<td><?= formatBytes($datalimit, 2) ?></td>
<td><?= $validity ?></td>
<td><?= $price ?></td>
<td><?= $sprice ?></td>
<td><?= $userlock ?></td>
<td><?= $comment ?></td>
              </tr>
        <?php 
      }
    ?>
    </table>
    </div>
    </div>
</div>
</div>
</div>
<script>
// get valid $ price
function GetVP(){
  var prof = document.getElementById('uprof').value;
  var url = "./process/getvalidprice.php?name=";
  var session = "&session=<?= $session; ?>"
  var getvalidprice = url+prof+session
  $("#GetValidPrice").load(getvalidprice);
}
</script>
</div>
