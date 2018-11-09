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
echo $_GET['hlog'];

// load config
include('./config.php');
$iphost=explode('!',$data[$session][1])[1]; 
$userhost=explode('@|@',$data[$session][2])[1];
$passwdhost=explode('#|#',$data[$session][3])[1]; 

// routeros api
include_once('../lib/routeros_api.class.php');
include_once('../lib/formatbytesbites.php');
$API = new RouterosAPI();
$API->debug = false;
$API->connect( $iphost, $userhost, decrypt($passwdhost));

}

?>
            <div class="card">
              <div class="card-header">
                <h3><a href="./app.php?hotspot=log&session=<?php echo $session;?>" title="Open Hotspot Log" ><i class="fa fa-align-justify"></i> Hotspot Log</a></h3></div>
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

// move hotspot log to disk

  $getlogging = $API->comm("/system/logging/print", array(
    "?prefix" => "->",));
  $logging = $getlogging[0];
  if($logging['prefix'] == "->"){}else{
  $API->comm("/system/logging/add", array("action" => "disk","prefix" => "->","topics" => "hotspot,info,debug",));
  }
  
// get hotspot log
  $getlog = $API->comm("/log/print", array(
    "?topics" => "hotspot,info,debug",));
  $log = array_reverse($getlog);
  $TotalReg = count($getlog);
  if($TotalReg > 100){$n = 100;}elseif($TotalReg > 200){$n = 200;}elseif($TotalReg > 300){$n = 300;}elseif($TotalReg > 400){$n = 400;}elseif($TotalReg > 500){$n = 500;}else{$n = $TotalReg;}
  for ($i=0; $i<$n; $i++){
  $mess = explode(":", $log[$i]['message']);
  $time = $log[$i]['time']; 
  echo "<tr>";
  if(substr($log[$i]['message'], 0,2) == "->"){  
  echo "<td>" . $time . "</td>";
  //echo substr($mess[1], 0,2);
  echo "<td>"; if(count($mess) > 6){echo $mess[1].":".$mess[2].":".$mess[3].":".$mess[4].":".$mess[5].":".$mess[6];}else{echo $mess[1];} echo "</td>";
  echo "<td>"; if(count($mess) > 6){echo str_replace("trying to", "", $mess[7]. " " .$mess[8]. " " .$mess[9]. " " .$mess[10]);}else{echo str_replace("trying to", "", $mess[2]. " " .$mess[3]. " " .$mess[4]. " " .$mess[5]);} echo "</td>";
  }else{}
  echo "</tr>";
  }
?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>



