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
	$prefix = $_GET['prefix'];

	$gettimezone = $API->comm("/system/clock/print");
	$timezone = $gettimezone[0]['time-zone-name'];
	date_default_timezone_set($timezone);

	if (isset($remdata)) {
		if (strlen($idhr) > "0") {
			if ($API->connect($iphost, $userhost, decrypt($passwdhost))) {
				$API->write('/system/script/print', false);
				$API->write('?source=' . $idhr . '', false);
				$API->write('=.proplist=.id');
				$ARREMD = $API->read();
				for ($i = 0; $i < count($ARREMD); $i++) {
					$API->write('/system/script/remove', false);
					$API->write('=.id=' . $ARREMD[$i]['.id']);
					$READ = $API->read();

				}
			}
		} elseif (strlen($idbl) > "0") {
			if ($API->connect($iphost, $userhost, decrypt($passwdhost))) {
				$API->write('/system/script/print', false);
				$API->write('?owner=' . $idbl . '', false);
				$API->write('=.proplist=.id');
				$ARREMD = $API->read();
				for ($i = 0; $i < count($ARREMD); $i++) {
					$API->write('/system/script/remove', false);
					$API->write('=.id=' . $ARREMD[$i]['.id']);
					$READ = $API->read();

				}
			}

		}
		echo "<script>window.location='./?report=selling&session=" . $session . "'</script>";
	}

	if ($prefix != "") {
		$fprefix = "-prefix-[" . $prefix . "]";
	} else {
		$fprefix = "";
	}
	if (strlen($idhr) > "0") {
		if ($API->connect($iphost, $userhost, decrypt($passwdhost))) {
			$getData = $API->comm("/system/script/print", array(
				"?source" => "$idhr",
			));
			$TotalReg = count($getData);
			for ($i = 0; $i < $TotalReg; $i++) {

				$totalSR += explode("-|-", $getData[$i]['name'])[3];

			}
		}
		$filedownload = $idhr;
		$shf = "hidden";
		$shd = "inline-block";
	} elseif (strlen($idbl) > "0") {
		if ($API->connect($iphost, $userhost, decrypt($passwdhost))) {
			$getData = $API->comm("/system/script/print", array(
				"?owner" => "$idbl",
			));
			$TotalReg = count($getData);
			for ($i = 0; $i < $TotalReg; $i++) {

				$totalSR += explode("-|-", $getData[$i]['name'])[3];

			}
		}
		$filedownload = $idbl;
		$shf = "hidden";
		$shd = "inline-block";
	} elseif ($idhr == "" || $idbl == "") {
		if ($API->connect($iphost, $userhost, decrypt($passwdhost))) {
			$getData = $API->comm("/system/script/print", array(
				"?comment" => "mikhmon",
			));
			$TotalReg = count($getData);
			for ($i = 0; $i < $TotalReg; $i++) {

				$totalSR += explode("-|-", $getData[$i]['name'])[3];

			}
		}
		$filedownload = "all";
		$shf = "text";
		$shd = "none";
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
<script>
$(document).ready(function(){
  $("#openResume").click(function(){
    notify("Calculating data");
    window.location = "./?report=resume-report&idbl=<?= $idbl;?>&session=<?= $session;?>"
  });
});
</script>
<div class="row">		
<div class="col-12">
<div class="card">
<div class="card-header">
	<h3><i class=" fa fa-money"></i> Selling Report <?= $idhr . $idbl; if ($prefix != "") {echo " prefix [" . $prefix . "]";} ?> <small id="loader" style="display: none;" ><i><i class='fa fa-circle-o-notch fa-spin'></i> Processing... </i></small></h3>
</div>
<div class="card-body">
<div class="row">
	<div>
		<div style="padding-bottom: 5px; padding-top: 5px;">   
		  <input id="filterTable" type="text" class="form-control" style="float:left; margin-top: 6px; max-width: 150px;" placeholder="Search..">&nbsp;
		  <button class="btn bg-primary" onclick="exportTableToCSV('report-mikhmon-<?= $filedownload . $fprefix; ?>.csv')" title="Download selling report"><i class="fa fa-download"></i> CSV</button>
		  <button class="btn bg-primary" onclick="location.href='./?report=selling&session=<?= $session; ?>';" title="Reload all data"><i class="fa fa-search"></i> ALL</button>
		  <button name="help" class="btn bg-primary" onclick="location.href='#help';" title="Help"><i class="fa fa-question"></i> Help</button>
		  <button name="resume" id="openResume" class="btn bg-primary"title="Resume Report"><i class="fa fa-area-chart"></i> Resume</button>
		  <button style="display: <?= $shd; ?>;" name="remdata" class="btn bg-danger" onclick="location.href='#remdata';" title="Delete Data <?= $filedownload; ?>"><i class="fa fa-trash"></i> Delete data <?= $filedownload; ?></button>
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
				<div style="padding:3.5px;"  class="group-item group-item-r text-center pointer" onclick="filterR(); loader();"><i class="fa fa-search"></i> Filter</div>
			</div>
			<script type="text/javascript">
				
				function filterR(){
					var D = document.getElementById('D').value;
					var M = document.getElementById('M').value;
					var Y = document.getElementById('Y').value;
					var X = document.getElementById('filterTable').value;

					if(D !== ""){
						window.location='./?report=selling&idhr='+M+'/'+D+'/'+Y+'&prefix='+X+'&session=<?= $session; ?>';
					}else if(D === ""){
						window.location='./?report=selling&idbl='+M+Y+'&prefix='+X+'&session=<?= $session; ?>';
					}
				}
			</script>
		</div>
		  <div class="overflow box-bordered" style="max-height: 75vh">
			<table id="dataTable" class="table table-bordered table-hover text-nowrap">
				<thead class="thead-light">
				<tr>
				  <th colspan=4 >Selling report <?= $filedownload . $fprefix; ?><b style="font-size:0;">,</b></th>
				  <th style="text-align:right;">Total</th>
				  <th style="text-align:right;" id="total"><?= $totalSR; ?></th>
				</tr>
				<tr>
					<th >Date</th>
					<th >Time</th>
					<th >Username</th>
					<th >Profile</th>
					<th >Comment</th>
					<th style="text-align:right;">Price <?= $currency; ?></th>
				</tr>
				</thead>
				<tbody>
				<?php
			if ($prefix != "") {
				for ($i = 0; $i < $TotalReg; $i++) {
					$getname = explode("-|-", $getData[$i]['name']);
					if (substr($getname[2], 0, strlen($prefix)) == $prefix) {
						echo "<tr>";
						echo "<td>";
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
						$profile = $getname[7];
						echo $profile;
						echo "</td>";
						echo "<td>";
						$comment = $getname[8];
						echo $comment;
						echo "</td>";
						echo "<td style='text-align:right;'>";
						$price = $getname[3];
						echo $price;
						echo "</td>";
						echo "</tr>";
					}
				}
			} else {
				for ($i = 0; $i < $TotalReg; $i++) {
					$getname = explode("-|-", $getData[$i]['name']);
					echo "<tr>";
					echo "<td>";
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
					$profile = $getname[7];
					echo $profile;
					echo "</td>";
					echo "<td>";
					$comment = $getname[8];
					echo $comment;
					echo "</td>";
					echo "<td style='text-align:right;'>";
					$price = $getname[3];
					echo $price;
					echo "</td>";
					echo "</tr>";
				}

			}

			?>
			</tbody>
			</table>
		</div>
</div>
</div>
</div>

<!-- Modal -->
<div class="modal-window" id="remdata" aria-hidden="true">
  <div>
  	<header><h1>Confirm</h1></header>
  	<a style="font-weight:bold;" href="#" title="Close" class="modal-close">X</a>
	<p>
        <?php if ($currency == in_array($currency, $cekindo['indo'])) { ?>
		      <ul>
		        <li>Menghapus Selling Report akan menghapus User Log juga.</li>
		        <li>Disarankan untuk mengunduh  <a class="text-blue" href="./?hotspot=userlog&session=<?= $session; ?>">User Log</a> terlebih dahulu.</li>
		      </ul>
		    <?php 
				} else { ?>
		      <ul>
		        <li>Deleting the Selling Report will delete the User Log as well. </li>
		        <li>It is recommended to download <a class="text-blue" href="./?hotspot=userlog&session=<?= $session; ?>">User Log</a> first. </li>
		      </ul>
		    <?php 
				} ?>
		</p>
	<form autocomplete="off" method="post" action="">
	<center>
	<button type="submit" name="remdata" title="Yes" class="btn bg-primary">Yes</button>&nbsp;
	<a class="btn bg-secondary" href="#" title="Close" class="modal-close">No</a>
	</center>
	</form>
  </div>
</div>
<div class="modal-window" id="help" aria-hidden="true">
  <div>
  	<header><h1>Help</h1></header>
  	<a style="font-weight:bold;" href="#" title="Close" class="modal-close">X</a>
	<p> 
		    <?php if ($currency == in_array($currency, $cekindo['indo'])) { ?>
		      <ul>
		        <li>Klik CSV untuk mengunduh.</li>
		        <li>Untuk filter per bulan, pilih Day dan bulannya, kemudian klik Filter.<br>
		        	<img width="70%" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAATUAAAAsCAYAAAAEsS/jAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAOlSURBVHhe7d09TtxAGMbxnCYSKOJDCggtqZIqHCRVpFwDiYJj0MARIq2i5QQUW6RH0CJST/x6bM/YM7Z38cfi1//iJ2F7PCvGfp+ZYQs+nH+7MACgBaEGQBVCDYAqhBoAVQg1AKoQagBUaQy1xdfv0fMA8F7VhtrBycLsH382Hz8dYgf2jxh74C2ioXZ4ujB7SVEdn33BjuQPKHYNmJtt6iEINdlyygrt+Ow8aIzxEGqA0ynUBMW0e4Qa4BBqChBqgEOoKUCoAQ6hpgChBjiEmgKEGuAQagoQaoBDqClAqAHOiKF2bZZP/8zLa+jhNtYem+oUardr8/J0by5j14AJGj3UggC7ujePBFsnhBrg7D7UhBTW69rc5MdZ0LnV3LNZXtlrN+vkeH3n3W/7fVxde+em7ffyj/e7W3Iu1lb0GmoNY2+vrc1y9eyue/deyvlSQN6Zh6SNe+bhat09N2nr9f3016yD51rtD3MwZD0MF2rpy5oVT7ByywohL5ZoAHrHCvz4+St4iHIu1lb0FmptY58HXjGp2JDJg6c51LK+vAkpbV+Epm0bXPf7Y1U5S0PWw4Ch1nSt+nKXZ+v0WmnlpoM/OzXNSqK3UIsojX0aat7KLeGvnIMQqjyrQKm/SNvK58lnaVqRY3ND1cPIoZbN3DmvWPyXW36uLZoJ82enpllJ9B9qNWPfU6il9xT9N4Ra6b2Qn8ufjfkYqh7G2X56BVW7rSkKUdrq2nr6ZEZqm5VEf6HWMvYdQ60Is2h/5ba5tE/pX9qW+sbcDFEP43xREFk5xIslKYZV0lbh1jMnM1LbrCS2eYhFSOTn/PFuG/tOoZY9M3+ltUGo2Tb2CwS2nvM2RD0ME2rpS+ud9wOuOPZm90w+60dDcma2eYjV8fVDqXXsW0LNtnfX05ArnlE1tOxx8/ZT2Pem9C0s0GD0UEuLpCR8WYttipCCqhRLqlqAM7ZVqCWC8W265o99W6hV7n9c3ZUnsjwkU9KPDTK7AqsLtdgKEKg3Yqj1TArE30bN2LahNjUSamw9sanJhpqsCGKz+hzpDjVZ4YereaDO9EIt+xscqzRHbahl21VWadjG9EINAbWhBrwBoaYAoQY4hJoChBrgEGoKEGqA0ynU3D8zjt+AcRBqgNMp1MTBycLsHfFf2neJUAOczqEmDk8X6Yot7wzj2k8mldh5AM1qQ03IVjR2HgDeq8ZQA4CpIdQAqEKoAVCFUAOgCqEGQBVCDYAiF+Y/bd3pxgv3MhEAAAAASUVORK5CYII=">
		        </li>
		        <li>Untuk filter berdasarkan prefix, isikan prefix di kolom search, kemudian klik filter.</li>
		        <li>Disarankan untuk menghapus laporan penjualan setelah mengunduh laporan CSV.</li>
		      </ul>
		    <?php 
				} else { ?>
		      <ul>
		        <li>Click CSV to download.</li>
		        <li>For filters per month, select Day and month, then click Filter.<br>
		        	<img width="70%" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAATUAAAAsCAYAAAAEsS/jAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAOlSURBVHhe7d09TtxAGMbxnCYSKOJDCggtqZIqHCRVpFwDiYJj0MARIq2i5QQUW6RH0CJST/x6bM/YM7Z38cfi1//iJ2F7PCvGfp+ZYQs+nH+7MACgBaEGQBVCDYAqhBoAVQg1AKoQagBUaQy1xdfv0fMA8F7VhtrBycLsH382Hz8dYgf2jxh74C2ioXZ4ujB7SVEdn33BjuQPKHYNmJtt6iEINdlyygrt+Ow8aIzxEGqA0ynUBMW0e4Qa4BBqChBqgEOoKUCoAQ6hpgChBjiEmgKEGuAQagoQaoBDqClAqAHOiKF2bZZP/8zLa+jhNtYem+oUardr8/J0by5j14AJGj3UggC7ujePBFsnhBrg7D7UhBTW69rc5MdZ0LnV3LNZXtlrN+vkeH3n3W/7fVxde+em7ffyj/e7W3Iu1lb0GmoNY2+vrc1y9eyue/deyvlSQN6Zh6SNe+bhat09N2nr9f3016yD51rtD3MwZD0MF2rpy5oVT7ByywohL5ZoAHrHCvz4+St4iHIu1lb0FmptY58HXjGp2JDJg6c51LK+vAkpbV+Epm0bXPf7Y1U5S0PWw4Ch1nSt+nKXZ+v0WmnlpoM/OzXNSqK3UIsojX0aat7KLeGvnIMQqjyrQKm/SNvK58lnaVqRY3ND1cPIoZbN3DmvWPyXW36uLZoJ82enpllJ9B9qNWPfU6il9xT9N4Ra6b2Qn8ufjfkYqh7G2X56BVW7rSkKUdrq2nr6ZEZqm5VEf6HWMvYdQ60Is2h/5ba5tE/pX9qW+sbcDFEP43xREFk5xIslKYZV0lbh1jMnM1LbrCS2eYhFSOTn/PFuG/tOoZY9M3+ltUGo2Tb2CwS2nvM2RD0ME2rpS+ud9wOuOPZm90w+60dDcma2eYjV8fVDqXXsW0LNtnfX05ArnlE1tOxx8/ZT2Pem9C0s0GD0UEuLpCR8WYttipCCqhRLqlqAM7ZVqCWC8W265o99W6hV7n9c3ZUnsjwkU9KPDTK7AqsLtdgKEKg3Yqj1TArE30bN2LahNjUSamw9sanJhpqsCGKz+hzpDjVZ4YereaDO9EIt+xscqzRHbahl21VWadjG9EINAbWhBrwBoaYAoQY4hJoChBrgEGoKEGqA0ynU3D8zjt+AcRBqgNMp1MTBycLsHfFf2neJUAOczqEmDk8X6Yot7wzj2k8mldh5AM1qQ03IVjR2HgDeq8ZQA4CpIdQAqEKoAVCFUAOgCqEGQBVCDYAiF+Y/bd3pxgv3MhEAAAAASUVORK5CYII=">
		        </li>
		        <li>For filters based on prefix, fill prefix in the search input, then click filter.</li>
		        <li>It is recommended to delete the sales report after download  the CSV report.</li>
		      </ul>
		    <?php 
				} ?>
	</p>
  </div>
</div>
</div>
