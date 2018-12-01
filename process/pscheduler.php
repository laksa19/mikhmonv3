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

// remove scheduler
if ($removesch != "") {
	$API->comm("/system/scheduler/remove", array(
		".id" => "$removesch",
	));

	echo "<script>window.location='./?system=scheduler&session=" . $session . "'</script>";
}
// enable scheduler
elseif ($enablesch != "") {
	$API->comm("/system/scheduler/set", array(
		".id" => "$enablesch",
		"disabled" => "no",
	));

	echo "<script>window.location='./?system=scheduler&session=" . $session . "'</script>";
}

// disable scheduler
elseif ($disablesch != "") {
	$API->comm("/system/scheduler/set", array(
		".id" => "$disablesch",
		"disabled" => "yes",
	));

	echo "<script>window.location='./?system=scheduler&session=" . $session . "'</script>";
}