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

$idhr = $_GET['idhr'];
$idbl = $_GET['idbl'];
$remdata = ($_POST['remdata']);


if(strlen($idhr) > "0"){
  if ($API->connect( $iphost, $userhost, decrypt($passwdhost))) {
	$API->write('/system/script/print', false);
	$API->write('?=source='.$idhr.'');
	$ARRAY = $API->read();
	$API->disconnect();
  }
	$filedownload = $idhr;
	$shf = "hidden";
	$shd = "text";
}elseif(strlen($idbl) > "0"){
  if ($API->connect( $iphost, $userhost, decrypt($passwdhost))) {
	$API->write('/system/script/print', false);
	$API->write('?=owner='.$idbl.'');
	$ARRAY = $API->read();
	$API->disconnect();
  }
	$filedownload = $idbl;
	$shf = "hidden";
	$shd = "text";
}elseif($idhr == "" || $idbl == ""){
  if ($API->connect( $iphost, $userhost, decrypt($passwdhost))) {
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
	<h3><i class=" fa fa-align-justify"></i> User Log</h3>
</div>
<div class="card-body">
	<div style="">
		<div style="padding-bottom: 5px; padding-top: 5px; display: table-row;">	   
		  <input id="filterTable" type="text" class="form-control" style="float:left; margin-top: 6px; max-width: 150px;" placeholder="Search..">&nbsp;
		  <button class="btn bg-primary " onclick="exportTableToCSV('user-log-mikhmon-<?php echo $filedownload;?>.csv')" title="Download user log"><i class="fa fa-download"></i> CSV</button>
		  <button class="btn bg-primary " onclick="location.href='./app.php?hotspot=userlog&session=<?php echo $session;?>';" title="Reload all data"><i class="fa fa-search"></i> ALL</button>
		</div>
		</div>  
		  <div class="overflow box-bordered" style="max-height: 75vh;">
			<table id="dataTable" class="table table-bordered table-hover text-nowrap">
				<thead>
				<tr>
				  <th colspan=6 >User Log <?php echo $filedownload;?></th>
				</tr>
				<tr>
					<th >Date</th>
					<th >Time</th>
					<th >Username</th>
					<th >address</th>
					<th >Mac Address</th>
					<th >Validity</th>
				</tr>
				</thead>
				<tbody>
				<?php
					$TotalReg = count($ARRAY);

						for ($i=0; $i<$TotalReg; $i++){
						  $regtable = $ARRAY[$i];
						  echo "<tr>";
							echo "<td>";
							$getname = explode("-|-",$regtable['name']);
							$getowner = $regtable['owner'];
							$tgl = $getname[0];
							$getdy = explode("/",$tgl);
							$m = $getdy[0];
							$dy = $getdy[1]."/".$getdy[2];
							echo "<a style='color:#f3f4f5;' href='./app.php?hotspot=userlog&idbl=".$getowner ."&session=".$session."' title='Filter user log month : ".$getowner."'>$m/</a><a style='color:#f3f4f5;' href='./app.php?hotspot=userlog&idhr=".$tgl ."&session=".$session."' title='Filter userlog day : ".$tgl."'>$dy</a>";
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