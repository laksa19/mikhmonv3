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

	$getlease = $API->comm("/ip/dhcp-server/lease/print");
	$TotalReg = count($getlease);

	$countlease = $API->comm("/ip/dhcp-server/lease/print", array(
		"count-only" => "",
	));

}
?>
<div class="row">
<div class="col-12">
<div class="card">
<div class="card-header">
	<h3><i class=" fa fa-sitemap"></i> DHCP Leases 
<?php
if ($countlease < 2) {
	echo "$countlease item";
} elseif ($countlease > 1) {
	echo "$countlease items";
};
echo "</th>";
?>
&nbsp;&nbsp; | &nbsp;&nbsp;<i onclick="location.reload();" class="fa fa-refresh pointer" title="Reload data"></i>
    </h3>
</div>
<div class="card-body">	   
<div class="w-6">
    <input id="filterTable" type="text" class="form-control" placeholder="Search..">
  </div>
<div class="overflow box-bordered mr-t-10" style="max-height: 75vh">   	   
<table id="dataTable" class="table table-bordered table-hover text-nowrap">
  <thead>
  <tr>
  	<th></th>
    <th class="pointer" title="Click to sort"><i class="fa fa-sort"></i> Address</th>
    <th class="pointer" title="Click to sort"><i class="fa fa-sort"></i> MAC Address</th>
    <th class="pointer" title="Click to sort"><i class="fa fa-sort"></i> Server</th>
    <th class="pointer" title="Click to sort"><i class="fa fa-sort"></i> Active Address</th>
    <th class="pointer" title="Click to sort"><i class="fa fa-sort"></i> Active MAC Address</th>
    <th class="pointer" title="Click to sort"><i class="fa fa-sort"></i> Active Host Name</th>
    <th class="pointer" title="Click to sort"><i class="fa fa-sort"></i> Status</th>
  </tr>
  </thead>
  <tbody> 
<?php
for ($i = 0; $i < $TotalReg; $i++) {
	$lease = $getlease[$i];
	$id = $lease['.id'];


	$addr = $lease['address'];
	$maca = $lease['mac-address'];
	$server = $lease['server'];
	$aaddr = $lease['active-address'];
	$amaca = $lease['active-mac-address'];
	$ahostname = $lease['host-name'];
	$status = $lease['status'];


	echo "<tr>";
	echo "</td>";
	echo "<td style='text-align:center;'>";
	if ($lease['dynamic'] == "true") {
		echo "<b title='D - dynamic'>D</b>";
	} else {
		echo "<b title='S - static'>S</b>";
	}
	echo "</td>";
	echo "<td>" . $addr . "</td>";
	echo "<td>" . $maca . "</td>";
	echo "<td>" . $server . "</td>";
	echo "<td>" . $aaddr . "</a></td>";
	echo "<td>" . $amaca . "</td>";
	echo "<td>" . $ahostname . "</td>";
	echo "<td>" . $status . "</td>";
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
</div>