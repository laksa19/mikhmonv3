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

// routeros api
include_once('../lib/routeros_api.class.php');

$API = new RouterosAPI();
$API->debug = false;
$API->connect( $iphost, $userhost, decrypt($passwdhost));

// get system resource MikroTik
$getresource = $API->comm("/system/resource/print");
$resource = $getresource[0];
// get routeboard info
$getrouterboard = $API->comm("/system/routerboard/print");
$routerboard = $getrouterboard[0];

}

                echo "Board Name ". $resource['board-name']."<br/>
        		Model : ".$routerboard['model']."<br/>
        		Router OS : ".$resource['version'];
?>