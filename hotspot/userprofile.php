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
	echo '
<html>
<head><title>403 Forbidden</title></head>
<body bgcolor="white">
<center><h1>403 Forbidden</h1></center>
<hr><center>nginx/1.14.0</center>
</body>
</html>
';
} else {


// get user profile
	$getprofile = $API->comm("/ip/hotspot/user/profile/print");
	$TotalReg = count($getprofile);
// count user profile
	$countprofile = $API->comm("/ip/hotspot/user/profile/print", array(
		"count-only" => "",
	));
}
?>
<div class="row">
<div class="col-12">
<div class="card">
<div class="card-header align-middle">
    <h3><i class=" fa fa-pie-chart"></i> User Profile 
    &nbsp; | &nbsp; <a href="./?user-profile=add&session=<?= $session; ?>" title="Add User"><i class="fa fa-user-plus"></i> Add</a>
	</h3>
</div>
<!-- /.card-header -->
<div class="card-body">
<div class="overflow box-bordered" style="max-height: 75vh"> 			   
<table id="tFilter" class="table table-bordered table-hover text-nowrap">
  <thead>
  <tr> 
		<th style="min-width:50px;" class="text-center" >
		<?php
	if ($countprofile < 2) {
		echo "$countprofile item  ";
	} elseif ($countprofile > 1) {
		echo "$countprofile items   ";
	}
	?></th>
		<th class="align-middle"><?= $_name ?></th>
		<th class="align-middle">Shared<br>Users</th>
		<th class="align-middle">Rate<br>Limit</th>
		<th class="align-middle"><?= $_expired_mode ?></th>
		<th class="align-middle"><?= $_validity ?></th>
		<th class="text-right align-middle" > <?= $_price." ".$currency; ?></th>
		<th class="text-right align-middle" > <?= $_selling_price." ".$currency; ?></th>
		<th class="align-middle"><?= $_lock_user ?></th>
    </tr>
  </thead>
  <tbody>
<?php

for ($i = 0; $i < $TotalReg; $i++) {

	$profiledetalis = $getprofile[$i];
	$pid = $profiledetalis['.id'];
	$pname = $profiledetalis['name'];
	$psharedu = $profiledetalis['shared-users'];
	$pratelimit = $profiledetalis['rate-limit'];
	$ponlogin = $profiledetalis['on-login'];
	$getmonexpired = $API->comm("/system/scheduler/print", array(
    "?name" => "$pname",
  ));
  $monexpired = $getmonexpired[0];
  $monid = $monexpired['.id'];
	$pmon = $monexpired['name'];
	$chkpmon = $monexpired['disabled'];
	if(empty($pmon) || $chkpmon == "true"){$moncolor = "text-orange";}else{$moncolor = "text-green";}
	echo "<tr>";
	?>
  <td style='text-align:center;'><i class='fa fa-minus-square text-danger pointer' onclick="if(confirm('Are you sure to delete profile (<?= $pname; ?>)?')){loadpage('./?remove-user-profile=<?= $pid; ?>&pname=<?= $pname ?>&session=<?= $session; ?>')}else{}" title='Remove <?= $pname; ?>'></i>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
  <?php
	echo "<a title='Open User by profile " . $pname . "'  href='./?hotspot=users&profile=" . $pname . "&session=" . $session . "'><i class='fa fa-users'></i></a></td>";
	echo "<td><a title='Open User Profile " . $pname . "' href='./?user-profile=" . $pid . "&session=" . $session . "'><i class='fa fa-edit'></i> <i class='fa fa-ci fa-circle ".$moncolor."'></i> $pname</a></td>";
//$profiledetalis = $ARRAY[$i];echo "<td>" . $profiledetalis['name'];echo "</td>";
	echo "<td>" . $psharedu;
	echo "</td>";
	echo "<td>" . $pratelimit;
	echo "</td>";

	echo "<td>";
	$getexpmode = explode(",", $ponlogin);
// get expired mode
	$expmode = $getexpmode[1];
	if ($expmode == "rem") {
		echo "Remove";
	} elseif ($expmode == "ntf") {
		echo "Notice";
	} elseif ($expmode == "remc") {
		echo "Remove & Record";
	} elseif ($expmode == "ntfc") {
		echo "Notice & Record";
	} else {

	}
	echo "</td>";
	echo "<td>";
// get validity
	$getvalid = explode(",", $ponlogin);
	echo $getvalid[3];

	echo "</td>";

	echo "<td style='text-align:right;'>";
// get price
	$getprice = explode(",", $ponlogin);
	$price = trim($getprice[2]);
	if ($price == "" || $price == "0") {
		echo "";
	} else {
		if ($currency == in_array($currency, $cekindo['indo'])) {
			echo number_format((float)$price, 0, ",", ".");
		} else {
			echo number_format((float)$price, 2);
		}
	}

	echo "</td>";
	echo "<td style='text-align:right;'>";
// get price
	$getsprice = explode(",", $ponlogin);
	$price = trim($getsprice[4]);
	if ($price == "" || $price == "0") {
		echo "";
	} else {
		if ($currency == in_array($currency, $cekindo['indo'])) {
			echo number_format((float)$price, 0, ",", ".");
		} else {
			echo number_format((float)$price, 2);
		}
	}

	echo "</td>";
	echo "<td>";

	$getgracep = explode(",", $ponlogin);
	echo $getgracep[6];
	echo "</td>";
	echo "</tr>";
}
?>
  </tbody>
</table>
</div>
</div>
</div>
</div>
</div>
