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
// array color
  $color = array('1' => 'bg-blue', 'bg-indigo', 'bg-purple', 'bg-pink', 'bg-red', 'bg-yellow', 'bg-green', 'bg-teal', 'bg-cyan', 'bg-grey', 'bg-light-blue');

  ?>
<div class="row">
<div class="col-12">
<div class="card">
<div class="card-header">
	<h3><i class=" fa fa-users"></i> <?= $_vouchers ?> &nbsp;&nbsp; | &nbsp;&nbsp;<i onclick="location.reload();" class="fa fa-refresh pointer" title="Reload data"></i></h3>
</div>
<div class="card-body">
<div class="overflow" style="max-height: 80vh">	
<div class="row">	
      <div class="col-4">
        <div class="box bmh-75 box-bordered <?= $color[rand(1, 11)]; ?>">
          <div class="box-group">
            <div class="box-group-icon">
              <a title='Open User by profile <?= $pname; ?>'  href='./?hotspot=users&profile=all&session=<?= $session; ?>'>
              <i class="fa fa-ticket"></i></a>
            </div>
              <div class="box-group-area">
                <h3 >Profile : all<br>
                <?php $countuser = $API->comm("/ip/hotspot/user/print", array("count-only" => ""));
                if ($countuser < 2) {
                  echo $countuser . " Item";
                } elseif ($countuser > 1) {
                  echo $countuser . " Items";
                }
                ?></h3>

              <a title="Open User by profile all" href="./?hotspot=users&profile=all&session=<?= $session; ?>"><i class="fa fa-external-link"></i> <?= $_open ?></a>&nbsp;
              <a title="Generate User by profile <?= $pname; ?>" href="./?hotspot-user=generate&session=<?= $session; ?>"><i class="fa fa-users"></i> <?= $_generate ?></a>&nbsp;
              </div>
            </div>
            
          </div>
        </div>
<?php
// get user profile
$getprofile = $API->comm("/ip/hotspot/user/profile/print");
$TotalReg = count($getprofile);
for ($i = 0; $i < $TotalReg; $i++) {
  $profiledetalis = $getprofile[$i];
  $pname = $profiledetalis['name'];
  ?>
	     <div class="col-4">
        <div class="box bmh-75 box-bordered <?= $color[rand(1, 11)]; ?>">
          <div class="box-group">
            <div class="box-group-icon">
              <a title='Open User by profile <?= $pname; ?>'  href='./?hotspot=users&profile=<?= $pname; ?>&session=<?= $session; ?>'>
            	<i class="fa fa-ticket"></i></a>
            </div>
              <div class="box-group-area">
                <h3 >Profile : <?= $pname; ?><br>
                <?php	$countuser = $API->comm("/ip/hotspot/user/print", array("count-only" => "", "?profile" => "$pname", ));
                if ($countuser < 2) {
                  echo $countuser . " Item";
                } elseif ($countuser > 1) {
                  echo $countuser . " Items";
                }
                ?></h3>

              <a title="Open User by profile <?= $pname; ?>" href="./?hotspot=users&profile=<?= $pname; ?>&session=<?= $session; ?>"><i class="fa fa-external-link"></i> <?= $_open ?></a>&nbsp;
              <a title="Generate User by profile <?= $pname; ?>" href="./?hotspot-user=generate&genprof=<?= $pname; ?>&session=<?= $session; ?>"><i class="fa fa-users"></i> <?= $_generate ?></a>&nbsp;
              </div>
            </div>
            
          </div>
        </div>
        <?php 
      }
    } ?>
      </div>
    </div>
</div>
</div>
</div>
</div>