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

  	$getsch = $API->comm("/system/scheduler/print");
	$TotalReg = count($getsch);
	
	$countsch = $API->comm("/system/scheduler/print", array(
	  "count-only" => "",));

}
?>
<div class="row">
<div class="col-12">
<div class="card">
<div class="card-header">
	<h3><i class=" fa fa-clock-o"></i> System Scheduler 
<?php
  if($countsch < 2 ){echo "$countsch item";
  }elseif($countsch > 1){
  echo "$countsch items";};echo"</th>";
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
    <th>Name</th>
    <th>Start Date</th>
    <th>Start Time</th>
    <th>Interval</th>
    <th>Next Run</th>
    <th>Comment</th>
  </tr>
  </thead>
  <tbody> 
<?php
	for ($i=0; $i<$TotalReg; $i++){
	$sch = $getsch[$i];
	$id = $sch['.id'];
	$name = $sch['name'];
	$startd = $sch['start-date'];
	$startt = $sch['start-time'];
	$interval = formatInterval($sch['interval']);
	$nextrun = $sch['next-run'];
	$comment = $sch['comment'];
	$disabled = $sch['disabled'];
	
	echo "<tr>";
	?>
  	<td style='text-align:center;'><i class='fa fa-minus-square text-danger pointer' onclick="if(confirm('Are you sure to delete scheduler (<?php echo $name;?>)?')){window.location='./app.php?remove-scheduler=<?php echo $id;?>&session=<?php echo $session;?>'}else{}" title='Remove <?php echo $name;?>'></i>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
  	<?php
	
	if($disabled == "true"){ $tcolor = "#616161"; echo "<a title='Enable Scheduler ".$name . "'  href='./app.php?enable-scheduler=".$id . "&session=".$session."'><i class='fa fa-lock '></i></a></td>";}else{ $tcolor = "#f3f4f5";echo "<a title='Disable Scheduler ".$name . "'  href='./app.php?disable-scheduler=".$id . "&session=".$session."'><i class='fa fa-unlock '></i></a></td>";}
	echo "<td style='color:".$tcolor."; '>"  . $name. "</td>";
	echo "<td style='color:".$tcolor."; '>"  . $startd. "</td>";
	echo "<td style='color:".$tcolor."; '>"  . $startt. "</td>";
	echo "<td style='color:".$tcolor."; '>"  . $interval . "</td>";
	echo "<td style='color:".$tcolor."; '>" . $nextrun."</a></td>";
	echo "<td style='color:".$tcolor."; '>" . $comment."</a></td>";
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