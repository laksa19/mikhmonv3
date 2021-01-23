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

	$idhr = $_GET['idhr'];
	$idbl = $_GET['idbl'];
	$remdata = ($_POST['remdata']);


	if (strlen($idhr) > "0") {
		if ($API->connect($iphost, $userhost, decrypt($passwdhost))) {
			$API->write('/system/script/print', false);
			$API->write('?=source=' . $idhr . '');
			$ARRAY = $API->read();
			$API->disconnect();
		}
		$filedownload = $idhr;
		$shf = "hidden";
		$shd = "text";
	} elseif (strlen($idbl) > "0") {
		if ($API->connect($iphost, $userhost, decrypt($passwdhost))) {
			$API->write('/system/script/print', false);
			$API->write('?=owner=' . $idbl . '');
			$ARRAY = $API->read();
			$API->disconnect();
		}
		$filedownload = $idbl;
		$shf = "hidden";
		$shd = "text";
	} elseif ($idhr == "" || $idbl == "") {
		if ($API->connect($iphost, $userhost, decrypt($passwdhost))) {
			$API->write('/system/script/print', false);
			$API->write('?=comment=mikhmon');
			$ARRAY = $API->read();
			$API->disconnect();
		}
		$filedownload = "all";
		$shf = "text";
		$shd = "hidden";
	}
}
?>
		<script>
			function downloadCSV(csv, filename) {
			  var csvFile;
			  var downloadLink;
			  // CSV file
			  csvFile = new Blob([csv], {type: "text/csv"});
			  // Download link
			  downloadLink = document.createElement("a");
			  // File name
			  downloadLink.download = filename;
			  // Create a link to the file
			  downloadLink.href = window.URL.createObjectURL(csvFile);
			  // Hide download link
			  downloadLink.style.display = "none";
			  // Add the link to DOM
			  document.body.appendChild(downloadLink);
			  // Click download link
			  downloadLink.click();
			  }
			  
			  function exportTableToCSV(filename) {
			    var csv = [];
			    var rows = document.querySelectorAll("#dataTable tr");
			    
			   for (var i = 0; i < rows.length; i++) {
			      var row = [], cols = rows[i].querySelectorAll("td, th");
			   for (var j = 0; j < cols.length; j++)
            row.push(cols[j].innerText);
        csv.push(row.join(","));
        }
        // Download CSV file
        downloadCSV(csv.join("\n"), filename);
        }

		</script>
<div class="row">
<div class="col-12">
<div class="card">
<div class="card-header">
	<h3><i class=" fa fa-align-justify"></i> User Log <?= $idhr . $idbl; ?></h3>
</div>
<div class="card-body">
	<div>
		<div style="padding-bottom: 5px; padding-top: 5px; display: table-row;">	   
		  <input id="filterTable" type="text" class="form-control" style="float:left; margin-top: 6px; max-width: 150px;" placeholder="Search..">&nbsp;
		  <button class="btn bg-primary " onclick="exportTableToCSV('user-log-mikhmon-<?= $filedownload; ?>.csv')" title="Download user log"><i class="fa fa-download"></i> CSV</button>
		  <button class="btn bg-primary " onclick="location.href='./?report=userlog&session=<?= $session; ?>';" title="Reload all data"><i class="fa fa-search"></i> <?= $_all ?></button>
		</div>
		<div class="input-group mr-b-10">  
			<div class="input-group-1 col-box-2">
			<select style="padding:5px;" class="group-item group-item-l" title="Day" id="D">
        			<?php
										$day = explode("/", $idhr)[1];
										if ($day != "") {
											echo "<option value='" . $day . "'>" . $day . "</option>";
										}
										echo "<option value=''>Day</option>";

										for ($x = 1; $x <= 31; $x++) {
											if (strlen($x) == 1) {
												$x = "0" . $x;
											} else {
												$x = $x;
											}
											echo "<option value='" . $x . "'>" . $x . "</option>";
										}
										?> 
    		</select>
			</div>
			<div class="input-group-2 col-box-4">
			<select style="padding:5px;" class="group-item group-item-md" title="Month" id="M">
        			<?php 
										$idbls = array(1 => "jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep", "oct", "nov", "dec");
										$idblf = array(1 => "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
										$month = explode("/", $idhr)[0];
										$month1 = substr($idbl, 0, 3);

										if ($month != "") {
											$fm = array_search($month, $idbls);
											echo "<option value='" . $month . "'>" . $idblf[$fm] . "</option>";
										} elseif ($month1 != "") {
											$fm = array_search($month1, $idbls);
											echo "<option value=" . $month1 . ">" . $idblf[$fm] . "</option>";
										} else {
											echo "<option value=" . $idbls[date("n")] . ">" . $idblf[date("n")] . "</option>";
										}
										for ($x = 1; $x <= 12; $x++) {
											echo "<option value='" . $idbls[$x] . "''>" . $idblf[$x] . "</option>";
										}
										?> 
    		</select>
			</div>
			<div class="input-group-2 col-box-3">
			<select style="padding:5px;" class="group-item group-item-md" title="Year" id="Y">
        			<?php 
										$year = explode("/", $idhr)[2];
										$year1 = substr($idbl, 3, 4);

										if ($year != "") {
											echo "<option>" . $year . "</option>";
										} elseif ($year1 != "") {
											echo "<option>" . $year1 . "</option>";
										} else {
											echo "<option>" . date("Y") . "</option>";
										}
										for ($Y = 2018; $Y <= date("Y"); $Y++) {
											if ($Y == date("Y")) {
											} else {
												echo "<option value='" . $Y . "''>" . $Y . "</option>";
											}
										}
										?> 
    		</select>
			</div>
            <div class="input-group-2 col-box-3">	
				<div style="padding:3.5px;"  class="group-item group-item-r text-center pointer" onclick="filterR();"><i class="fa fa-search"></i> Filter</div>
			</div>
			<script type="text/javascript">
				
				function filterR(){
					var D = document.getElementById('D').value;
					var M = document.getElementById('M').value;
					var Y = document.getElementById('Y').value;

					if(D !== ""){
						window.location='./?report=userlog&idhr='+M+'/'+D+'/'+Y+'&session=<?= $session; ?>';
					}else if(D === ""){
						window.location='./?report=userlog&idbl='+M+Y+'&session=<?= $session; ?>';
					}
				}
			</script>
		</div>
		</div>  
		  <div class="overflow box-bordered" style="max-height: 75vh;">
			<table id="dataTable" class="table table-bordered table-hover text-nowrap">
				<thead>
				<tr>
				  <th colspan=6 >User Log <?= $filedownload; ?></th>
				</tr>
				<tr>
					<th ><?= $_date ?></th>
					<th ><?= $_time ?></th>
					<th ><?= $_user_name ?></th>
					<th >address</th>
					<th >Mac Address</th>
					<th ><?= $_validity ?></th>
				</tr>
				</thead>
				<tbody>
				<?php
			$TotalReg = count($ARRAY);

			for ($i = 0; $i < $TotalReg; $i++) {
				$regtable = $ARRAY[$i];
				echo "<tr>";
				echo "<td>";
				$getname = explode("-|-", $regtable['name']);
				$tgl = $getname[0];
				echo $tgl;
				echo "</td>";
				echo "<td>";
				$ltime = $getname[1];
				echo $ltime;
				echo "</td>";
				echo "<td>";
				$username = $getname[2];
				echo $username;
				echo "</td>";
				echo "<td>";
				$addr = $getname[4];
				echo $addr;
				echo "</td>";
				echo "<td>";
				$mac = $getname[5];
				echo $mac;
				echo "</td>";
				echo "<td>";
				$val = $getname[6];
				echo $val;
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
