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
if (!isset($_SESSION["mikhmon"])) {
    header("Location:../admin.php?id=login");
  } else {
$session = $_GET['session'];
$ping = $_GET['ping'];
if(isset($ping) && !empty($session)){
    include_once('../include/config.php');
    $iphost = explode('!', $data[$session][1])[1];
    $host=explode(":",$iphost)[0];
    $port=explode(":",$iphost)[1];
    if(empty($port)){
        $port = 8728;
    }else{
        $port = $port;
    }
function ping($host,$port){
	$fsock = fsockopen($host,$port,$errno,$errstr,5);
	if (! $fsock ){
		return (
            '<div id="pingX" class="col-12">
			<div class="card">
        	<div class="card-header">
            <h3 class="card-title">Ping Test ['.$host.':'.$port.'] </h3>
        	</div>
        	<div class="card-body">'.
            "Host : ".$host."&nbsp;Port : ".$port."<br>".
			"Error Code : ".$errno."<br>".
            "Error Message : ".$errstr.
            "<br><b class='text-warning'>Ping Timeout </b><br>".
            '<span class="pointer btn bg-grey" onclick="closeX()"><i class="fa fa-close text-red "></i> Close</span>'.
			'</div>
              </div>
            </div>');
	}else{
		return (
            '<div id="pingX" class="col-12">
			<div class="card">
        	<div class="card-header">
            <h3 class="card-title">Ping Test ['.$host.':'.$port.']</h3>
        	</div>
        	<div class="card-body">'.
            "Host : ".$host."&nbsp;Port : ".$port."<br>".
            "<b class='text-green'>Ping OK</b><br>".
            '<span class="pointer btn bg-grey" onclick="closeX()"><i class="fa fa-close text-red "></i> Close</span>'.
			'</div>
            </div>
            </div>');
	}
	fclose($fsock);
}

$ping_test = ping($host,$port);
print_r($ping_test);
}
}