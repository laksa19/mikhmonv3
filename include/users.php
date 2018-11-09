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
ini_set('max_execution_time', 300);

if(!isset($_SESSION["mikhmon"])){
  header("Location:../admin.php?id=login");
}else{

if($prof == "all"){
  $getuser = $API->comm("/ip/hotspot/user/print");
	$TotalReg = count($getuser);
	
  $counttuser = $API->comm("/ip/hotspot/user/print", array(
	 "count-only" => ""));
}elseif($prof != "all"){
  $getuser = $API->comm("/ip/hotspot/user/print", array(
    "?profile" => "$prof",
    ));
  $TotalReg = count($getuser);
  
  $counttuser = $API->comm("/ip/hotspot/user/print", array(
   "count-only" => "",
   "?profile" => "$prof",
   ));
  
}
if($comm != ""){
  $getuser = $API->comm("/ip/hotspot/user/print", array(
    "?comment" => "$comm",
    //"?uptime" => "00:00:00"
  ));
  $TotalReg = count($getuser);
  
  $counttuser = $API->comm("/ip/hotspot/user/print", array(
   "count-only" => "",
   "?comment" => "$comm",
   ));
  if($counttuser == 0){echo "<script>window.location='./app.php?hotspot=users&profile=all&session=".$session."</script>";}
}
	$getprofile = $API->comm("/ip/hotspot/user/profile/print");
	$TotalReg2 = count($getprofile);
}
?>
<div class="row">
<div class="col-12">
<div class="card">
<div class="card-header">
    <h3><i class="fa fa-users"></i> Users
      <span style="font-size: 14px">
        <?php
          if($counttuser == 0 ){echo "<script>window.location='./app.php?hotspot=users&profile=all&session=".$session."</script>";}?>
         &nbsp; | &nbsp; <a href="./app.php?hotspot-user=add&session=<?php echo $session;?>" title="Add User"><i class="fa fa-user-plus"></i> Add</a>
        &nbsp; | &nbsp; <a href="./app.php?hotspot-user=generate&session=<?php echo $session;?>" title="Generate User"><i class="fa fa-users"></i> Generate</a>    
          <?php if($comm != ""){?>
            &nbsp; | &nbsp;<a class="text-info" onclick="loader()" href="./app.php?hotspot=users&profile=all&session=<?php echo $session;?>"><i class="fa fa-search"></i> Show All</a> &nbsp; | &nbsp; <a class="text-danger" onclick="if(confirm('Are you sure to delete username by comment (<?php echo $comm;?>)?')){window.location='./app.php?remove-hotspot-user-by-comment=<?php echo $comm;?>&session=<?php echo $session;?>';loader();}else{}" title="Remove user by comment <?php echo $comm;?>" href="#">  <i class="fa fa-minus-square"></i> Remove</a>
          <?php ;}
				?>
        
         &nbsp; | &nbsp; <a href="./app.php?hotspot=export-users&profile=<?php echo $prof;?>&session=<?php echo $session;?>" title="Download User List"><i class="fa fa-download"></i> Export</a>
        </span> 
    </h3>
    <i id="loader" style="display: none;" ><i class='fa fa-circle-o-notch fa-spin'></i> Processing... </i>
</div>
<div class="card-body">	
  <div class="row">
  <div class="input-group">
    <div class="input-group-3 col-box-6">
      <input id="filterTable" type="text" style="padding:5.8px;" class="group-item group-item-l" placeholder="Search..">
    </div>
    <div class="input-group-3 col-box-6">
      <select style="padding:5px;" class="group-item group-item-r" onchange="location = this.value; loader()" title="Filter by Profile">
        <option>Profile <?php echo $prof;?></option>
        <option value="./app.php?hotspot=users&profile=all&session=<?php echo $session;?>">Show All</option>
      <?php
      for ($i=0; $i<$TotalReg2; $i++){
        $profile = $getprofile[$i];
      echo "<option value='./app.php?hotspot=users&profile=".$profile['name'] . "&session=".$session."'>". $profile['name']."</option>";
      }
      ?>
    </select>
  </div>
  </div>
</div>
<div class="overflow mr-t-10 box-bordered" style="max-height: 75vh">     
<table id="dataTable" class="table table-bordered table-hover text-nowrap">
  <thead>
  <tr>
    <th style="min-width:50px;" class="align-middle text-center" ><?php
          echo "$counttuser";
          ;?></th>
    <th style="min-width:50px;" >
      Server
    </th>
    <th colspan="2">
      Name
    </th>
    <th>
      Profile
    </th>
    <th class="text-right align-middle">
      Uptime
    </th>
    <th class="text-right align-middle">
      Bytes In
    </th>
    <th class="text-right align-middle">
      Bytes Out
    </th>
    <th>
      Comment
    </th>
    <th class="text-center align-middle" colspan="3">Print</th>
    </tr>
  </thead>
  <tbody>
<?php
for ($i=0; $i<$TotalReg; $i++){
	$userdetails =	$getuser[$i];
	$uid = $userdetails['.id'];
	$userver = $userdetails['server'];
	$uname = $userdetails['name'];
	$upass = $userdetails['password'];
	$uprofile = $userdetails['profile'];
	$uuptime = formatDTM($userdetails['uptime']);
  $ubytesi = formatBytes($userdetails['bytes-in'],2);
  $ubyteso = formatBytes($userdetails['bytes-out'],2);
  if($ubyteso == 0){$ubyteso = "";}else{$ubyteso = $ubyteso;}
  if($ubytesi == 0){$ubytesi = "";}else{$ubytesi = $ubytesi;}
	$ucomment = $userdetails['comment'];
  $udisabled = $userdetails['disabled'];
  $utimelimit = $userdetails['limit-uptime'];
  if($utimelimit == '1s'){$utimelimit = ' expired';}else{$utimelimit = ' '.$utimelimit;}
  $udatalimit = $userdetails['limit-bytes-total'];
  if($udatalimit == ''){$udatalimit = '';}else{$udatalimit = ' '.formatBytes($udatalimit,2);}

	echo "<tr>";
	?>
  <td style='text-align:center;'><i class='fa fa-minus-square text-danger pointer' onclick="if(confirm('Are you sure to delete username (<?php echo $uname;?>)?')){window.location='./app.php?remove-hotspot-user=<?php echo $uid;?>&session=<?php echo $session;?>'}else{}" title='Remove <?php echo $uname;?>'></i>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
  <?php
	if($udisabled == "true"){ $tcolor = "#616161"; echo "<a title='Enable User ".$uname . "'  href='./app.php?enable-hotspot-user=".$uid . "&session=".$session."'><i class='fa fa-lock '></i></a></td>";}else{ $tcolor = "#f3f4f5";echo "<a title='Disable User ".$uname . "'  href='./app.php?disable-hotspot-user=".$uid . "&session=".$session."'><i class='fa fa-unlock '></i></a></td>";}
	echo "<td style='color:".$tcolor.";'>" . $userver;echo "</td>";
  if($uname == $upass){$usermode = "vc";}else{$usermode = "up";} 
  $popup = "javascript:window.open('./voucher/print.php?user=".$usermode."-".$uname."&qr=no&session=".$session."','_blank','width=310,height=450').print();";
	echo "<td style='color:".$tcolor.";'><a title='Open User ".$uname . "' style='color:".$tcolor.";' href=./app.php?hotspot-user=".$uid . "&session=".$session."><i class='fa fa-edit'></i> ". $uname." </a>";echo '</td><td class"text-center"><a style="color:'.$tcolor.';"  title="Print '.$uname.'" href="'.$popup.'"><i class="fa fa-print text-right"></i></a></td>';
	echo "<td style='color:".$tcolor."; '>" . $uprofile;echo "</td>";
	echo "<td style='color:".$tcolor."; text-align:right'>" . $uuptime;echo "</td>";
  echo "<td style='color:".$tcolor."; text-align:right'>" . $ubytesi;echo "</td>";
  echo "<td style='color:".$tcolor."; text-align:right'>" . $ubyteso;echo "</td>";
	echo "<td style='color:".$tcolor.";'>"; if($uname == "default-trial"){}else{echo "<a style='color:".$tcolor.";' href=./app.php?hotspot=users&comment=".$ucomment."&session=".$session." title='Filter by ".$ucomment."'>".$ucomment."</a>";}; echo $utimelimit.' '.$udatalimit."</td>";
	echo "<td style='color:".$tcolor.";'>";

	if(substr($ucomment,0,2) == "vc" || substr($ucomment,0,2) == "up"){echo "<a style='color:".$tcolor.";' title='Print' href='./voucher/print.php?id=" . $ucomment . "&qr=no&session=".$session."' target='_blank'>Default</a>";echo "</td>";
	}
  echo "<td style='color:".$tcolor.";'>";
  if(substr($ucomment,0,2) == "vc" || substr($ucomment,0,2) == "up"){echo "<a style='color:".$tcolor.";' title='Print QR' href='./voucher/print.php?id=" . $ucomment . "&qr=yes&session=".$session."' target='_blank'> QR</a>";echo "</td>";
  }
  echo "<td style='color:".$tcolor.";'>";
  if(substr($ucomment,0,2) == "vc" || substr($ucomment,0,2) == "up"){echo "<a style='color:".$tcolor.";' title='Print Small' href='./voucher/print.php?id=" . $ucomment . "&small=yes&session=".$session."' target='_blank'> Small</a>";echo "</td>";
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
<script>
  function loader(){
    document.getElementById('loader').style='display:block;';
  }
</script>
</div>

	
	
