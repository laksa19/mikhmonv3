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

if(isset($remdata)){
  if(strlen($idhr) > "0"){
	if ($API->connect( $iphost, $userhost, decrypt($passwdhost))) {
	  $API->write('/system/script/print', false);
	  $API->write('?source='.$idhr.'', false);
	  $API->write('=.proplist=.id');
	  $ARREMD = $API->read();
	  for ($i=0;$i<count($ARREMD);$i++) {
	  $API->write('/system/script/remove', false);
	  $API->write('=.id=' . $ARREMD[$i]['.id']);
	  $READ = $API->read();
	    
	}
	}
  }elseif(strlen($idbl) > "0"){
  if ($API->connect( $iphost, $userhost, decrypt($passwdhost))) {
	  $API->write('/system/script/print', false);
	  $API->write('?owner='.$idbl.'', false);
	  $API->write('=.proplist=.id');
	  $ARREMD = $API->read();
	  for ($i=0;$i<count($ARREMD);$i++) {
	  $API->write('/system/script/remove', false);
	  $API->write('=.id=' . $ARREMD[$i]['.id']);
	  $READ = $API->read();
	    
	}
	}
  
}
  echo "<script>window.location='./app.php?hotspot=selling&session=".$session."'</script>";
}
  



if(strlen($idhr) > "0"){
  if ($API->connect( $iphost, $userhost, decrypt($passwdhost))) {
	$API->write('/system/script/print', false);
	$API->write('?=source='.$idhr.'');
	$ARRAY = $API->read();
	$API->disconnect();
  }
	$filedownload = $idhr;
	$shf = "hidden";
	$shd = "inline-block";
}elseif(strlen($idbl) > "0"){
  if ($API->connect( $iphost, $userhost, decrypt($passwdhost))) {
	$API->write('/system/script/print', false);
	$API->write('?=owner='.$idbl.'');
	$ARRAY = $API->read();
	$API->disconnect();
  }
	$filedownload = $idbl;
	$shf = "hidden";
	$shd = "inline-block";
}elseif($idhr == "" || $idbl == ""){
  if ($API->connect( $iphost, $userhost, decrypt($passwdhost))) {
	$API->write('/system/script/print', false);
	$API->write('?=comment=mikhmon');
	$ARRAY = $API->read();
	$API->disconnect();
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
        
        window.onload=function() {
          var sum = 0;
          var dataTable = document.getElementById("dataTable");
          
          // use querySelector to find all second table cells
          var cells = document.querySelectorAll("td + td + td + td");
          for (var i = 0; i < cells.length; i++)
          sum+=parseFloat(cells[i].firstChild.data);
          
          var th = document.getElementById('total');
          th.innerHTML = th.innerHTML + (sum) ;
        }
		</script>
<div class="row">		
<div class="col-12">
<div class="card">
<div class="card-header">
	<h3><i class=" fa fa-money"></i> Selling Report</h3>
</div>
<div class="card-body">
<div class="row">
	</div>
		<div style="padding-bottom: 5px; padding-top: 5px;">   
		  <input id="filterTable" type="text" class="form-control" style="float:left; margin-top: 6px; max-width: 150px;" placeholder="Search..">&nbsp;
		  <button class="btn bg-primary" onclick="exportTableToCSV('report-mikhmon-<?php echo $filedownload;?>.csv')" title="Download selling report"><i class="fa fa-download"></i> CSV</button>
		  <button class="btn bg-primary" onclick="location.href='./app.php?hotspot=selling&session=<?php echo $session;?>';" title="Reload all data"><i class="fa fa-search"></i> ALL</button>
		  <button name="help" class="btn bg-primary" onclick="location.href='#help';" title="Help"><i class="fa fa-question"></i> Help</button>
		  <button style="display: <?php echo $shd;?>;" name="remdata" class="btn bg-danger" onclick="location.href='#remdata';" title="Delete Data <?php echo $filedownload;?>"><i class="fa fa-remove"></i> Delete data <?php echo $filedownload;?></button>
		</div>
		  <div class="overflow box-bordered" style="max-height: 75vh">
			<table id="dataTable" class="table table-bordered table-hover text-nowrap">
				<thead class="thead-light">
				<tr>
				  <th colspan=2 >Selling report <?php echo $filedownload;?><b style="font-size:0;">,</b></th>
				  <th style="text-align:right;">Total</th>
				  <th style="text-align:right;" id="total"></th>
				</tr>
				<tr>
					<th >Date</th>
					<th >Time</th>
					<th >Username</th>
					<th style="text-align:right;">Price <?php echo $curency;?></th>
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
							echo "<a style='color:#f3f4f5;' href='./app.php?hotspot=selling&idbl=".$getowner ."&session=".$session."' title='Filter selling report month : ".$getowner."'>$m/</a><a style='color:#f3f4f5;' href='./app.php?hotspot=selling&idhr=".$tgl ."&session=".$session."' title='Filter selling report day : ".$tgl."'>$dy</a>";
							echo "</td>";
							echo "<td>";
							$ltime = $getname[1];
							echo $ltime;
							echo "</td>";
							echo "<td>";
							$username = $getname[2];
							echo $username;
							echo "</td>";
							echo "<td style='text-align:right;'>";
							$price = $getname[3];
							echo $price;
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

<!-- Modal -->
<div class="modal-window" id="remdata" aria-hidden="true">
  <div>
  	<header><h1>Confirm</h1></header>
  	<a style="font-weight:bold;" href="#" title="Close" class="modal-close">X</a>
	<p>
        <?php if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){?>
		      <ul>
		        <li>Menghapus Selling Report akan menghapus User Log juga.</li>
		        <li>Disarankan untuk mengunduh  <a class="text-blue" href="./app.php?hotspot=userlog&session=<?php echo $session;?>">User Log</a> terlebih dahulu.</li>
		      </ul>
		    <?php }else{?>
		      <ul>
		        <li>Deleting the Selling Report will delete the User Log as well. </li>
		        <li>It is recommended to download <a class="text-blue" href="./app.php?hotspot=userlog&session=<?php echo $session;?>">User Log</a> first. </li>
		      </ul>
		    <?php }?>
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
		    <?php if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){?>
		      <ul>
		        <li>Filter berdasarkan hari klik pada [19/2018].</li>
		        <li>Filter berdasarkan bulan klik pada [jan/].</li>
		        <li>Klik CSV untuk mengunduh.</li>
		        <li>Disarankan untuk menghapus laporan penjualan setelah mengunduh laporan CSV.</li>
		        <li>Untuk menghapus laporan klik pada hari atau bulan terlebih dahulu.</li>
		      </ul>
		    <?php }else{?>
		      <ul>
		        <li>Filter by day click on [19/2018].</li>
		        <li>Filter by month day click on [jan/].</li>
		        <li>Click CSV to download.</li>
		        <li>It is recommended to delete the sales report after download  the CSV report.</li>
		      </ul>
		    <?php }?>
	</p>
  </div>
</div>
</div>