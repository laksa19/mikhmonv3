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

// load config
include('./config.php');
$iphost=explode('!',$data[$session][1])[1]; 
$userhost=explode('@|@',$data[$session][2])[1];
$passwdhost=explode('#|#',$data[$session][3])[1]; 
$iface=explode('(',$data[$session][8])[1];  
$maxtx=explode(')',$data[$session][9])[1]; 
$maxrx=explode('=',$data[$session][10])[1];


// routeros api
include_once('../lib/routeros_api.class.php');
include_once('../lib/formatbytesbites.php');
$API = new RouterosAPI();
$API->debug = false;
$API->connect( $iphost, $userhost, decrypt($passwdhost));



// get traffic ether
  $getinterface = $API->comm("/interface/print");
  $interface = $getinterface[$iface-1]['name'];
  $getinterfacetraffic = $API->comm("/interface/monitor-traffic", array(
    "interface" => "$interface",
    "once" => "",
    ));
  $ftx = formatBites($getinterfacetraffic[0]['tx-bits-per-second'],1);
  $frx = formatBites($getinterfacetraffic[0]['rx-bits-per-second'],1);

  $tx = $getinterfacetraffic[0]['tx-bits-per-second'];
  $rx = $getinterfacetraffic[0]['rx-bits-per-second'];
  if($maxtx == "" || $maxtx == "0"){$mxtx = formatBites(100000000,0); $maxtx = "100000000";}else{$mxtx = formatBites($maxtx,0); $maxtx = $maxtx;}
  if($maxrx == "" || $maxrx == "0"){$mxrx = formatBites(100000000,0); $maxrx = "100000000";}else{$mxrx = formatBites($maxrx,0); $maxrx = $maxrx;}
  $trff = "trff".$session;
  if(empty($_SESSION[$trff])){
    $_SESSION[$trff] = "0~0,0~0,0~0,0~0,0~0,0~0,0~0,0~0,0~0,0~0,0~0,0~0,0~0,0~0,0~0,0~0,0~0,0~0,0~0,".$tx."~".$rx;
  }

  $vtrff = explode(",",$_SESSION[$trff]);
  $ctrff = count($vtrff);

  $_SESSION[$trff] = $vtrff[1].",".$vtrff[2].",".$vtrff[3].",".$vtrff[4].",".$vtrff[5].",".$vtrff[6].",".$vtrff[7].",".$vtrff[8].",".$vtrff[9].",".$vtrff[10].",".$vtrff[11].",".$vtrff[12].",".$vtrff[13].",".$vtrff[14].",".$vtrff[15].",".$vtrff[16].",".$vtrff[17].",".$vtrff[18].",".$vtrff[19].",".$tx."~".$rx; 
  
}
?>           
            
                  <div class="row">
                    <div class="col-12">
                      <div class="box box-bordered">
                        <div><h3><?php echo $interface;?></h3></div>
                          <div class="progress">
                            <div class="progress-bar-blue" style="width: <?php echo $getinterfacetraffic[0]['tx-bits-per-second']/$maxtx*100;?>%"></div>
                          </div>
                            <span class="progress-description">
                              Tx : <?php echo $ftx." / ".$mxtx;?>
                            </span>
                          <div class="progress">
                            <div class="progress-bar-red" style="width: <?php echo $getinterfacetraffic[0]['rx-bits-per-second']/$maxrx*100;?>%"></div>
                            </div>
                            <span class="progress-description">
                              Rx : <?php echo $frx." / ".$mxrx;?>
                            </span>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="box box-bordered">
                          <table class="table table-bordered" style="table-layout: fixed; width: 100%; height: 100px;">
                            <tr>
                            <?php 
                            for($i=0;$i<=$ctrff-1;$i++){

                            $txf = explode("~",explode(",", $_SESSION[$trff])[$i])[0];
                            $rxf = explode("~",explode(",", $_SESSION[$trff])[$i])[1];

                            echo "<td style='vertical-align:bottom; padding:0px;'><div class='w-12 bg-blue' style='writing-mode:tb-rl;height:".($txf/$maxrx*100)."px;'></div></td><td style='vertical-align:bottom; padding:0px;'><div class='w-12 bg-red' style='writing-mode:tb-rl;height:".($rxf/$maxrx*100)."px;'></div></td>";
                            }

                            ?>
                            </tr>
                          </table>
                        </div>
                      </div>
                    </div>
                    