<?php
/*
 *  Copyright (C) 2019 Laksamadi Guko.
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
// load session MikroTik
  $session = $_GET['session'];

// load config
  include('../include/config.php');
  $iphost = explode('!', $data[$session][1])[1];
  $userhost = explode('@|@', $data[$session][2])[1];
  $passwdhost = explode('#|#', $data[$session][3])[1];
  $curency = explode('&', $data[$session][6])[1];

// lang
include('../include/lang.php');
include('../lang/'.$langid.'.php');

  include_once('../lib/routeros_api.class.php');

  $API = new RouterosAPI();
  $API->debug = false;
  $API->connect($iphost, $userhost, decrypt($passwdhost));

  $uprofname = $_GET['name'];
  if ($uprofname != "") {
    $getprofile = $API->comm("/ip/hotspot/user/profile/print", array("?name" => "$uprofname"));
    $ponlogin = $getprofile[0]['on-login'];
    $getvalid = $_validity. " : " . explode(",", $ponlogin)[3];
    $getprice = explode(",", $ponlogin)[2];
    $getsprice = explode(",", $ponlogin)[4];
    $getlock = "| ".$_lock_user." : " . explode(",", $ponlogin)[6];
    if ($getprice == 0) {
    } else {
      if ($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr") {
        $price = "| ".$_price." : " . $curency . " " . number_format($getprice, 0, ",", ".");
      } else {
        $price = "| ".$_price." : " . $curency . " " . number_format($getprice);
      }
    }
    if ($getsprice == 0) {
    } else {
      if ($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr") {
        $sprice = "| ".$_selling_price." : " . $curency . " " . number_format($getsprice, 0, ",", ".");
      } else {
        $sprice = "| ".$_selling_price." : " . $curency . " " . number_format($getsprice);
      }
    }
    echo '<b id="getdata">' . $getvalid . ' ' . $price . ' ' . $sprice . ' ' . $getlock . '</b>';
    echo '<span id="validity">' . explode(",", $ponlogin)[3] . '</span> ';
  }
}
?>
