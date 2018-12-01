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
	".id" => "$disablehotspotuser",
	"disabled" => "yes",
));
if ($_SESSION['ubp'] != "") {
	echo "<script>window.location='./?hotspot=users&profile=" . $_SESSION['ubp'] . "&session=" . $session . "'</script>";
} elseif ($_SESSION['ubc'] != "") {
	echo "<script>window.location='./?hotspot=users&comment=" . $_SESSION['ubc'] . "&session=" . $session . "'</script>";
} else {
	echo "<script>window.location='./?hotspot=users&profile=all&session=" . $session . "'</script>";
}


?>