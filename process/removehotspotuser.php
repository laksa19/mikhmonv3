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
if ($removehotspotusers != "") {
	$uids = explode("~", $removehotspotusers);

	$nuids = count($uids);

	for ($i = 0; $i < $nuids; $i++) {

		$getuname = $API->comm("/ip/hotspot/user/print", array(
			"?.id" => "$uids[$i]",
		));

		$name = $getuname[0]['name'];

		$getscr = $API->comm("/system/script/print", array(
			"?name" => "$name",
		));

		$scr = $getscr[0]['.id'];

		$getsch = $API->comm("/system/scheduler/print", array(
			"?name" => "$name",
		));

		$sch = $getsch[0]['.id'];

		$API->comm("/system/script/remove", array(
			".id" => "$scr",
		));

		$API->comm("/system/scheduler/remove", array(
			".id" => "$sch",
		));

		$API->comm("/ip/hotspot/user/remove", array(
			".id" => "$uids[$i]",
		));

	}

	if ($_SESSION['ubp'] != "") {
		echo "<script>window.location='./?hotspot=users&profile=" . $_SESSION['ubp'] . "&session=" . $session . "'</script>";
	} elseif ($_SESSION['ubc'] != "") {
		echo "<script>window.location='./?hotspot=users&comment=" . $_SESSION['ubc'] . "&session=" . $session . "'</script>";
	} else {
		echo "<script>window.location='./?hotspot=users&profile=all&session=" . $session . "'</script>";
	}


} else {
	$getuname = $API->comm("/ip/hotspot/user/print", array(
		"?.id" => "$removehotspotuser",
	));

	$name = $getuname[0]['name'];

	$getscr = $API->comm("/system/script/print", array(
		"?name" => "$name",
	));

	$scr = $getscr[0]['.id'];

	$getsch = $API->comm("/system/scheduler/print", array(
		"?name" => "$name",
	));

	$sch = $getsch[0]['.id'];

	$API->comm("/system/script/remove", array(
		".id" => "$scr",
	));

	$API->comm("/system/scheduler/remove", array(
		".id" => "$sch",
	));

	$API->comm("/ip/hotspot/user/remove", array(
		".id" => "$removehotspotuser",
	));


	if ($_SESSION['ubp'] != "") {
		echo "<script>window.location='./?hotspot=users&profile=" . $_SESSION['ubp'] . "&session=" . $session . "'</script>";
	} elseif ($_SESSION['ubc'] != "") {
		echo "<script>window.location='./?hotspot=users&comment=" . $_SESSION['ubc'] . "&session=" . $session . "'</script>";
	} else {
		echo "<script>window.location='./?hotspot=users&profile=all&session=" . $session . "'</script>";
	}
}
?>