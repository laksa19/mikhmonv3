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

if (!isset($_SESSION["mikhmon"])) {
  header("Location:../admin.php?id=login");
} else {

  if ($prof == "all") {
    $getuser = $API->comm("/ip/hotspot/user/print");
    $TotalReg = count($getuser);

    $counttuser = $API->comm("/ip/hotspot/user/print", array(
      "count-only" => ""
    ));
    
  } elseif ($prof != "all") {
    $getuser = $API->comm("/ip/hotspot/user/print", array(
      "?profile" => "$prof",
    ));
    $TotalReg = count($getuser);

    $counttuser = $API->comm("/ip/hotspot/user/print", array(
      "count-only" => "",
      "?profile" => "$prof",
    ));

  }
  if ($comm != "") {
    $getuser = $API->comm("/ip/hotspot/user/print", array(
      "?comment" => "$comm",
    //"?uptime" => "00:00:00"
    ));
    $TotalReg = count($getuser);

    $counttuser = $API->comm("/ip/hotspot/user/print", array(
      "count-only" => "",
      "?comment" => "$comm",
    ));
    if ($counttuser == 0) {
      echo "<script>window.location='./?hotspot=users&profile=all&session=" . $session . "</script>";
    }
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
        if ($counttuser == 0) {
          echo "<script>window.location='./?hotspot=users&profile=all&session=" . $session . "</script>";
        } ?>
         &nbsp; | &nbsp; <a href="./?hotspot-user=add&session=<?= $session; ?>" title="Add User"><i class="fa fa-user-plus"></i> Add</a>
        &nbsp; | &nbsp; <a href="./?hotspot-user=generate&session=<?= $session; ?>" title="Generate User"><i class="fa fa-users"></i> Generate</a>        
         &nbsp; | &nbsp; <a href="<?= str_replace("=users", "=export-users", $url); ?>&export=script" title="Download User List as Mikrotik Script"><i class="fa fa-download"></i> Script</a>&nbsp; | &nbsp; <a href="<?= str_replace("=users", "=export-users", $url); ?>&export=csv" title="Download User List as CSV"><i class="fa fa-download"></i> CSV</a>
        </span>  &nbsp; 
        <small id="loader" style="display: none;" ><i><i class='fa fa-circle-o-notch fa-spin'></i> Processing... </i></small>
    </h3>
</div>
<div class="card-body">	
  <div class="row">
   <div class="col-6 pd-t-5 pd-b-5"> 
  <div class="input-group">
    <div class="input-group-4 col-box-4">
      <input id="filterTable" type="text" style="padding:5.8px;" class="group-item group-item-l" placeholder="Search..">
    </div>
    <div class="input-group-4 col-box-4">
      <select style="padding:5px;" class="group-item group-item-m" onchange="location = this.value; loader()" title="Filter by Profile">
        <option>Profile <?= $prof; ?></option>
        <option value="./?hotspot=users&profile=all&session=<?= $session; ?>">Show All</option>
      <?php
      for ($i = 0; $i < $TotalReg2; $i++) {
        $profile = $getprofile[$i];
        echo "<option value='./?hotspot=users&profile=" . $profile['name'] . "&session=" . $session . "'>" . $profile['name'] . "</option>";
      }
      ?>
    </select>
  </div>
  <div class="input-group-4 col-box-4">
    <select style="padding:5px;" class="group-item group-item-r" id="comment" name="comment">
    <?php 
    if($comm != ""){}else{echo "<option value=''>Comment</option>";}
    for ($i = 0; $i < $TotalReg; $i++) {
      $ucomment = $getuser[$i]['comment'];
      if (substr($ucomment, 0, 2) == "vc" || substr($ucomment, 0, 2) == "up") {  
      if($ucomment <> $getuser[$i+1]['comment']){echo "<option value='".$ucomment."' >".$ucomment."</option>";}
    }}
    
    ?>
    </select>
  </div>
  </div>
  </div>
 
  <div class="col-6">
    <?php if ($comm != "") { ?>
            <button class="btn bg-red" onclick="if(confirm('Are you sure to delete username by comment (<?= $comm; ?>)?')){window.location='./?remove-hotspot-user-by-comment=<?= $comm; ?>&session=<?= $session; ?>';loader();}else{}" title="Remove user by comment <?= $comm; ?>">  <i class="fa fa-trash"></i> By Comment</button>
    <?php ;
  } ?>
  <script>
    function printV(a,b){
    var comm = document.getElementById('comment').value;
    var url = "./voucher/print.php?id="+comm+"&"+a+"="+b+"&session=<?= $session; ?>";
    if (comm === "" ){
      <?php if ($currency == in_array($currency, $cekindo['indo'])) { ?>
      alert('Silakan pilih salah satu Comment terlebih dulu!');
      <?php } else { ?>
      alert('Please choose one of the Comments first!');
      <?php } ?>
    }else{
      var win = window.open(url, '_blank');
      win.focus();
    }}
  </script>
  <button class="btn bg-blue" title='Print' onclick="printV('qr','no');"><i class="fa fa-print"></i> Default</button>
  <button class="btn bg-blue" title='Print QR' onclick="printV('qr','yes');"><i class="fa fa-print"></i> QR</button>
  <button class="btn bg-blue" title='Print Small'onclick="printV('small','yes');"><i class="fa fa-print"></i> Small</button>
  </div>  
</div>
<div class="overflow mr-t-10 box-bordered" style="max-height: 75vh">   
<table id="dataTable" class="table table-bordered table-hover text-nowrap">
  <thead>
  <tr>
    <th style="min-width:50px;" class="align-middle text-center" ><?= $counttuser; ?></th>
    <th style="min-width:50px;" >Server</th>
    <th colspan="3">Name</th>
    <th>Profile</th>
    <th class="text-right align-middle">Uptime</th>
    <th class="text-right align-middle">Bytes In</th>
    <th class="text-right align-middle">Bytes Out</th>
    <th>Comment</th>
    </tr>
  </thead>
  <tbody>
<?php
for ($i = 0; $i < $TotalReg; $i++) {
  $userdetails = $getuser[$i];
  $uid = $userdetails['.id'];
  $userver = $userdetails['server'];
  $uname = $userdetails['name'];
  $upass = $userdetails['password'];
  $uprofile = $userdetails['profile'];
  $uuptime = formatDTM($userdetails['uptime']);
  $ubytesi = formatBytes($userdetails['bytes-in'], 2);
  $ubyteso = formatBytes($userdetails['bytes-out'], 2);

  $ucomment = $userdetails['comment'];
  $udisabled = $userdetails['disabled'];
  $utimelimit = $userdetails['limit-uptime'];
  if ($utimelimit == '1s') {
    $utimelimit = ' expired';
  } else {
    $utimelimit = ' ' . $utimelimit;
  }
  $udatalimit = $userdetails['limit-bytes-total'];
  if ($udatalimit == '') {
    $udatalimit = '';
  } else {
    $udatalimit = ' ' . formatBytes($udatalimit, 2);
  }

  echo "<tr>";
  ?>
  <td style='text-align:center;'>  <i class='fa fa-minus-square text-danger pointer' onclick="if(confirm('Are you sure to delete username (<?= $uname; ?>)?')){window.location='./?remove-hotspot-user=<?= $uid; ?>&session=<?= $session; ?>'}else{}" title='Remove <?= $uname; ?>'></i>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
  <?php
  if ($udisabled == "true") {
    $tcolor = "#616161";
    echo "<a title='Enable User " . $uname . "'  href='./?enable-hotspot-user=" . $uid . "&session=" . $session . "'><i class='fa fa-lock '></i></a></td>";
  } else {
    $tcolor = "#f3f4f5";
    echo "<a title='Disable User " . $uname . "'  href='./?disable-hotspot-user=" . $uid . "&session=" . $session . "'><i class='fa fa-unlock '></i></a></td>";
  }
  echo "<td style='color:" . $tcolor . ";'>" . $userver ."</td>";
  if ($uname == $upass) {
    $usermode = "vc";
  } else {
    $usermode = "up";
  }
  $popup = "javascript:window.open('./voucher/print.php?user=" . $usermode . "-" . $uname . "&qr=no&session=" . $session . "','_blank','width=310,height=450').print();";
  $popupQR = "javascript:window.open('./voucher/print.php?user=" . $usermode . "-" . $uname . "&qr=yes&session=" . $session . "','_blank','width=310,height=450').print();";
  echo "<td style='color:" . $tcolor . ";'><a title='Open User " . $uname . "' style='color:" . $tcolor . ";' href=./?hotspot-user=" . $uid . "&session=" . $session . "><i class='fa fa-edit'></i> " . $uname . " </a>";
  echo '</td><td class"text-center"><a style="color:' . $tcolor . ';"  title="Print ' . $uname . '" href="' . $popup . '"><i class="fa fa-print"></i></a></td>';
  echo '</td><td class"text-center"><a style="color:' . $tcolor . ';"  title="Print ' . $uname . '" href="' . $popupQR . '"><i class="fa fa-qrcode"></i></a></td>';
  echo "<td style='color:" . $tcolor . "; '>" . $uprofile . "</td>";
  echo "<td style='color:" . $tcolor . "; text-align:right'>" . $uuptime . "</td>";
  echo "<td style='color:" . $tcolor . "; text-align:right'>" . $ubytesi . "</td>";
  echo "<td style='color:" . $tcolor . "; text-align:right'>" . $ubyteso . "</td>";
  echo "<td style='color:" . $tcolor . ";'>";
  if ($uname == "default-trial") {
  } else {
    echo "<a style='color:" . $tcolor . ";' href=./?hotspot=users&comment=" . $ucomment . "&session=" . $session . " title='Filter by " . $ucomment . "'>" . $ucomment . "</a>";
  }
  echo $utimelimit . ' ' . $udatalimit . "</td>";
  

}
?>
  </tr>
  </tbody>
</table>
</div>
</div>
</div>
</div>
</div>

	
	
