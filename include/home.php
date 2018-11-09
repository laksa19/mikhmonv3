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
// load session MikroTik
$session = $_GET['session'];

}
?>
    
<div id="reloadHome">

    <div class="row">
      <div class="col-4">
        <div class="box bmh-75 box-bordered">
          <div class="box-group">
            <div class="box-group-icon"><i class="fa fa-calendar"></i></div>
              <div class="box-group-area">
                <span >System Date & Time<br>
                  <div id="reloadDT">
                    <?php include('./include/dt.php');?>
                  </div>
                </span>
              </div>
            </div>
          </div>
        </div>
      <div class="col-4">
        <div class="box bmh-75 box-bordered">
          <div class="box-group">
          <div class="box-group-icon"><i class="fa fa-info-circle"></i></div>
              <div class="box-group-area">
                <span >
                <div id="reloadInfo">
                    <?php include('./include/info.php');?>
                  </div>
                </span>
              </div>
            </div>
          </div>
        </div>
    <div class="col-4">
      <div class="box bmh-75 box-bordered">
        <div class="box-group">
          <div class="box-group-icon"><i class="fa fa-server"></i></div>
              <div class="box-group-area">
                <span >
                    <div id="reloadSysload">
                    <?php include('./include/sysload.php');?>
                  </div>
                </span>
                </div>
              </div>
            </div>
          </div> 
      </div>

        <div class="row">
          <div class="col-8">
            <div class="card">
              <div class="card-header"><h3><i class="fa fa-wifi"></i> Hotspot</h3></div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-3 col-box-6">
                      <div class="box bg-primary bmh-75">
                        <a href="./app.php?hotspot=active&session=<?php echo $session;?>">
                          <?php include('./include/hactive.php');?>
                          <div>
                            <i class="fa fa-laptop"></i> Hotspot Active
                          </div>
                        </a>
                      </div>
                    </div>
                    <div class="col-3 col-box-6">
                    <div class="box bg-success bmh-75">
                      <a href="./app.php?hotspot=users&profile=all&session=<?php echo $session;?>">
                        <?php include('./include/tusers.php');?>
                      <div>
                            <i class="fa fa-users"></i> Hotspot Users
                          </div>
                      </a>
                    </div>
                  </div>
                  <div class="col-3 col-box-6">
                    <div class="box bg-warning bmh-75">
                      <a href="./app.php?hotspot-user=add&session=<?php echo $session;?>">
                        <div>
                          <h1><i class="fa fa-user-plus"></i>
                              <span style="font-size: 15px;">Add</span>
                          </h1>
                        </div>
                        <div>
                            <i class="fa fa-user-plus"></i> Hotspot User
                        </div>
                      </a>
                    </div>
                  </div>
                  <div class="col-3 col-box-6">
                    <div class="box bg-danger bmh-75">
                      <a href="./app.php?hotspot-user=generate&session=<?php echo $session;?>">
                        <div>
                          <h1><i class="fa fa-user-plus"></i>
                              <span style="font-size: 15px;">Generate</span>
                          </h1>
                        </div>
                        <div>
                            <i class="fa fa-user-plus"></i> Hotspot User
                        </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
            <div class="card">
              <div class="card-header"><h3><i class="fa fa-area-chart"></i> Traffic </h3></div>
                <div class="card-body">
                  <div id="reloadTraffic"> 
                    <?php include('./include/traffic.php');?>
                  </div>
                </div> 
              </div>
            </div>  
            <div class="col-4">
            <div id="reloadHLog">
            <div class="card">
              <div class="card-header">
                <h3><i class="fa fa-align-justify"></i> Hotspot Log</h3></div>
                  <div class="card-body">
                    <div style="padding: 5px; height: 400px;" class="mr-t-10 overflow">
                      <table class="table table-sm table-bordered table-hover" style="font-size: 12px;">
                        <thead>
                          <tr>
                            <th>Time</th>
                            <th>User (IP)</th>
                            <th>Messages</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php  
                              for ($x = 0; $x <= 15; $x++) {
                                echo "<tr><td>Loading...</td><td>Loading...</td><td>Loading...</td></tr>";
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
</div>