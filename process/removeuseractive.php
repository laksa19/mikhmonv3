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

// get user active
$getuser = $API->comm("/ip/hotspot/active/print", array(
    "?.id" => "$removeuseractive",
));
$user = $getuser[0]['user'];
// get cookie id
$getcookie = $API->comm("/ip/hotspot/cookie/print", array(
    "?user" => "$user",
));
$ck = $getcookie[0]['.id'];
// remove cookie
$API->comm("/ip/hotspot/cookie/remove", array(
    ".id" => "$ck",
));
// remove user active
$API->comm("/ip/hotspot/active/remove", array(
    ".id" => "$removeuseractive",
));
// redirect to user active
echo "<script>window.location='./?hotspot=active&session=" . $session . "'</script>";
?>