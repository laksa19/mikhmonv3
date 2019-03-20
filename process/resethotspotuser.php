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

$API->comm("/ip/hotspot/user/set", array(
	".id" => "$resethotspotuser", "limit-uptime" => "0", "comment" => ""
));
$API->comm("/ip/hotspot/user/reset-counters", array(
	".id" => "$resethotspotuser",
));

$getuname = $API->comm("/ip/hotspot/user/print", array(
	"?.id" => "$resethotspotuser",
));
$uname = $getuname[0]['name'];

$getsname = $API->comm("/system/scheduler/print", array(
	"?name" => "$uname",
));
$removesch = $getsname[0]['.id'];

$API->comm("/system/scheduler/remove", array(
	".id" => "$removesch",
));

echo "<script>window.location='./?hotspot-user=" . $resethotspotuser . "&session=" . $session . "'</script>";

?>