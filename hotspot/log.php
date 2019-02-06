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

	$getlog = $API->comm("/log/print", array(
		"?topics" => "hotspot,info,debug"
	));
	$log = array_reverse($getlog);
	$TotalReg = count($getlog);
}
?>
<div class="row">
<div class="col-12">
<div class="card">
<div class="card-header">
    <h3><i class=" fa fa-align-justify"></i> <?= $_hotspot_log ?> &nbsp; | &nbsp;&nbsp;<i onclick="location.reload();" class="fa fa-refresh pointer " title="Reload data"></i></h3>
</div>
<div class="card-body">

<div style="max-width: 350px;">
    <input id="filterTable" type="text" class="form-control" placeholder="Search.."> 
</div>
<div style="padding: 5px; max-height: 75vh;" class="mr-t-10 overflow">
<table class="table table-sm table-bordered table-hover" id="dataTable" >
	<thead>
        <tr>
            <th><?= $_time ?></th>
            <th><?= $_users ?> (IP)</th>
            <th><?= $_messages ?></th>
        </tr>
    </thead>
	<tbody>
<?php
for ($i = 0; $i < $TotalReg; $i++) {
	$mess = explode(":", $log[$i]['message']);
	$time = $log[$i]['time'];
	echo "<tr>";
	if (substr($log[$i]['message'], 0, 2) == "->") {
		echo "<td>" . $time . "</td>";
	//echo substr($mess[1], 0,2);
		echo "<td>";
		if (count($mess) > 6) {
			echo $mess[1] . ":" . $mess[2] . ":" . $mess[3] . ":" . $mess[4] . ":" . $mess[5] . ":" . $mess[6];
		} else {
			echo $mess[1];
		}
		echo "</td>";
		echo "<td>";
		if (count($mess) > 6) {
			echo str_replace("trying to", "", $mess[7] . " " . $mess[8] . " " . $mess[9] . " " . $mess[10]);
		} else {
			echo str_replace("trying to", "", $mess[2] . " " . $mess[3] . " " . $mess[4] . " " . $mess[5]);
		}
		echo "</td>";
	} else {
	}
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
