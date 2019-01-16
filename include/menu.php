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


  $btnmenuactive = "font-weight: bold;background-color: #f9f9f9; color: #000000";
  if ($hotspot == "dashboard" || substr(end(explode("/", $url)), 0, 8) == "?session") {
    $shome = "active";
    $mpage = "Dashboard";
  } elseif ($hotspot == "users" || $userbyprofile != "" || $hotspot == "export-users" || $removehotspotuserbycomment != "" || $removehotspotuser != "" || $removehotspotusers != "") {
    $susersl = "active";
    $susers = "active";
    $mpage = "Users";
    $umenu = "menu-open";
  } elseif ($hotspotuser == "add") {
    $sadduser = "active";
    $mpage = "Users";
    $susers = "active";
    $umenu = "menu-open";
  } elseif ($hotspotuser == "generate") {
    $sgenuser = "active";
    $mpage = "Users";
    $susers = "active";
    $umenu = "menu-open";
  } elseif ($userbyname != "") {
    $susers = "active";
    $mpage = "Users";
    $umenu = "menu-open";
  } elseif ($hotspot == "user-profiles") {
    $suserprofiles = "active";
    $suserprof = "active";
    $mpage = "User Profiles";
    $upmenu = "menu-open";
  } elseif ($hotspot == "active" || $removeuseractive != "") {
    $sactive = "active";
    $mpage = "Hotspot Active";
    $hamenu = "menu-open";
  } elseif ($hotspot == "hosts" || $hotspot == "hostp" || $hotspot == "hosta" || $removehost != "") {
    $shosts = "active";
    $mpage = "Hosts";
    $hmenu = "menu-open";
  } elseif ($hotspot == "dhcp-leases") {
    $slease = "active";
    $mpage = "DHCP Leases";
  } elseif ($hotspot == "ipbinding" || $hotspot == "binding" || $removeipbinding != "" || $enableipbinding != "" || $disableipbinding != "") {
    $sipbind = "active";
    $mpage = "IP Bindings";
    $ibmenu = "menu-open";
  } elseif ($hotspot == "template-editor") {
    $ssett = "active";
    $teditor = "active";
    $mpage = "Template Editor";
    $settmenu = "menu-open";
  } elseif ($hotspot == "uplogo") {
    $ssett = "active";
    $uplogo = "active";
    $mpage = "Upload Logo";
    $settmenu = "menu-open";
  } elseif ($hotspot == "cookies" || $removecookie != "") {
    $scookies = "active";
    $mpage = "Hotspot Cookies";
    $cmenu = "menu-open";
  } elseif ($hotspot == "log") {
    $log = "active";
    $slog = "active";
    $mpage = "Hotspot Log";
    $lmenu = "menu-open";
  } elseif ($report == "userlog") {
    $log = "active";
    $sulog = "active";
    $mpage = "User Log";
    $lmenu = "menu-open";
  } elseif ($ppp == "secrets" || $ppp == "addsecret" || $enablesecr != "" || $disablesecr != "" || $removesecr != "" || $secretbyname != "") {
    $mppp = "active";
    $ssecrets = "active";
    $mpage = "PPP Secrets";
    $pppmenu = "menu-open";
  } elseif ($ppp == "profiles" || $removepprofile != "") {
    $mppp = "active";
    $spprofile = "active";
    $mpage = "PPP Profiles";
    $pppmenu = "menu-open";
  } elseif ($ppp == "active" || $removepactive != "") {
    $mppp = "active";
    $spactive = "active";
    $mpage = "PPP Active Connections";
    $pppmenu = "menu-open";
  } elseif ($sys == "scheduler" || $enablesch != "" || $disablesch != "" || $removesch != "") {
    $sysmenu = "active";
    $ssch = "active";
    $mpage = "System Scheduler";
    $schmenu = "menu-open";
  } elseif ($report == "selling") {
    $sselling = "active";
    $mpage = "Report";
  } elseif ($userprofile == "add") {
    $suserprof = "active";
    $sadduserprof = "active";
    $mpage = "User Profiles";
    $upmenu = "menu-open";
  } elseif ($userprofilebyname != "") {
    $suserprof = "active";
    $mpage = "User Profiles";
    $upmenu = "menu-open";
  } elseif ($hotspot == "users-by-profile") {
    $susersbp = "active";
    $mpage = "Vouchers";
  } elseif ($userbyname != "") {
    $mpage = "Users";
    $susers = "active";
  } elseif ($hotspot == "about") {
    $mpage = "About";
    $sabout = "active";
  } elseif ($id == "sessions") {
    $ssesslist = "active";
    $mpage = "Router List";
  } elseif ($id == "settings" && $session == "new") {
    $snsettings = "active";
    $mpage = "Add Router";
  } elseif ($id == "settings") {
    $ssettings = "active";
    $mpage = "Session Settings";
  } elseif ($id == "about") {
    $sabout = "active";
    $mpage = "Router List";
  } elseif ($id == "uplogo") {
    $suplogo = "active";
    $mpage = "Upload Logo";
  } elseif ($id == "editor") {
    $seditor = "active";
    $mpage = "Template Voucher";
  }
}
?>


<?php if ($id != "") { ?>

<div id="navbar" class="navbar">
  <div class="navbar-left">
    <a id="brand" class="text-center" href="javascript:void(0)"><span>MIKHMON</span></a>

<a id="openNav" class="navbar-hover" href="javascript:void(0)"><i class="fa fa-bars"></i></a>
<a id="closeNav" class="navbar-hover" href="javascript:void(0)"><i class="fa fa-bars"></i></a>
<a id="cpage" class="navbar-left" href="javascript:void(0)"><?= $mpage; ?></a>
</div>
 <div class="navbar-right">
  <a href="./admin.php?id=logout" ><i class="fa fa-sign-out mr-1"></i> Logout</a>
  <select class="ses text-right mr-t-10 pd-5" onchange="location = this.value;">
    <option> Theme</option>
    <option value="<?= $url; ?>&set-theme=dark">Dark</option>
    <option value="<?= $url; ?>&set-theme=light">Light</option>
  </select>
</div>
</div>

<div id="sidenav" class="sidenav">
<?php if ($session == "" || $session == "new") {
} else { ?>  
  <div class="menu text-center align-middle card-header"><h3 id="MikhmonSession"><?= $session; ?></h3></div>
  <a href="./?session=<?= $session; ?>" class="menu <?= $shome; ?>" title="Dashboard"><i class='fa fa-tachometer'></i> Dashboard</a>
  <a  href="./admin.php?id=settings&session=<?= $session; ?>" class="menu <?= $ssettings; ?>" title="Mikhmon Settings"><i class='fa fa-gear'></i> Session Settings</a>
  <a href="./admin.php?id=uplogo&session=<?= $session; ?>" class="menu <?= $suplogo; ?>"><i class="fa fa-upload "></i> Upload Logo</a>
  <a href="./admin.php?id=editor&template=default&session=<?= $session; ?>" class="menu <?= $seditor; ?>"><i class="fa fa-edit"></i> Template Editor</a>
  <div class="menu spa"></div>
<?php 
} ?>  
  <a href="./admin.php?id=sessions" class="menu <?= $ssesslist; ?>"><i class="fa fa-server"></i> Router List</a>
  <a href="./admin.php?id=settings&router=new" class="menu <?= $snsettings ?>"><i class="fa fa-plus"></i> Add Router</a>
  <a href="./admin.php?id=about" class="menu <?= $sabout; ?>"><i class="fa fa-info-circle"></i> About</a>
</div>

<?php 
} else { ?>

<div id="navbar" class="navbar">
  <div class="navbar-left">
    <a id="brand" class="text-center" href="./?session=<?= $session; ?>"><span>MIKHMON</span></a>

<a id="openNav" class="navbar-hover" href="javascript:void(0)"><i class="fa fa-bars"></i></a>
<a id="closeNav" class="navbar-hover" href="javascript:void(0)"><i class="fa fa-bars"></i></a>
<a id="cpage" class="navbar-left" href="javascript:void(0)"><?= $mpage; ?></a>
</div>
 <div class="navbar-right">
  <a href="./?hotspot=logout&session=<?= $session; ?>" ><i class="fa fa-sign-out mr-1"></i> Logout</a>
  <select class="ses text-right mr-t-10 pd-5" onchange="location = this.value;">
    <option> Theme</option>
    <option value="<?= $url; ?>&set-theme=dark">Dark</option>
    <option value="<?= $url; ?>&set-theme=light">Light</option>
  </select>
  <select class="ses text-right mr-t-10 pd-5" onchange="location = this.value;">
  <option id="MikhmonSession" value="<?= $session; ?>"><?= $hotspotname; ?></option>
      <?php
      foreach (file('./include/config.php') as $line) {
        $value = explode("'", $line)[1];
        if ($value == "" || $value == "mikhmon") {
        } else {
          echo '<option value="./?session=' . $value . '">' . $value . '</option>';
        }
      }
      ?>
    
  </select>
</div>
</div>

<div id="sidenav" class="sidenav">
  <div class="menu text-center align-middle card-header"><h3><?= $identity; ?></h3></div>
  <a href="./?session=<?= $session; ?>" class="menu <?= $shome; ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
  <!--hotspot-->
  <div class="dropdown-btn <?= $susers . $suserprof . $sactive . $shosts . $sipbind . $scookies; ?>"><i class="fa fa-wifi"></i> Hotspot
    <i class="fa fa-caret-down"></i>
  </div>
  <div class="dropdown-container <?= $umenu . $upmenu . $hamenu . $hmenu . $ibmenu . $cmenu; ?>">
   <!--users--> 
  <div class="dropdown-btn <?= $susers; ?>"><i class="fa fa-users"></i> Users
    <i class="fa fa-caret-down"></i>
  </div>
  <div class="dropdown-container <?= $umenu; ?>">
    <a href="./?hotspot=users&profile=all&session=<?= $session; ?>" class="<?= $susersl; ?>"> <i class="fa fa-list "></i> User List </a>
    <a href="./?hotspot-user=add&session=<?= $session; ?>" class="<?= $sadduser; ?>"> <i class="fa fa-user-plus "></i> Add User </a>
    <a href="./?hotspot-user=generate&session=<?= $session; ?>" class="<?= $sgenuser; ?>"> <i class="fa fa-user-plus"></i> Generate </a>        
  </div>
  <!--profile-->
  <div class="dropdown-btn <?= $suserprof; ?>"><i class=" fa fa-pie-chart"></i>  User Profile
    <i class="fa fa-caret-down"></i>
  </div>
  <div class="dropdown-container <?= $upmenu; ?>">
    <a href="./?hotspot=user-profiles&session=<?= $session; ?>" class=" <?= $suserprofiles; ?>"> <i class="fa fa-list "></i> User Profile List </a>
    <a href="./?user-profile=add&session=<?= $session; ?>" class=" <?= $sadduserprof; ?>"> <i class="fa fa-plus-square "></i> Add User Profile </a>
  </div>
  <!--active-->
  <a href="./?hotspot=active&session=<?= $session; ?>" class="menu <?= $sactive; ?>"><i class=" fa fa-wifi"></i> Active</a>
  <!--hosts-->
  <a href="./?hotspot=hosts&session=<?= $session; ?>" class="menu <?= $shosts; ?>"><i class=" fa fa-laptop"></i> Hosts</a>
  <!--ip bindings-->
  <a href="./?hotspot=ipbinding&session=<?= $session; ?>" class="menu <?= $sipbind; ?>"><i class=" fa fa-address-book"></i> IP Bindings</a>
  <!--cookies-->
   <a href="./?hotspot=cookies&session=<?= $session; ?>" class="menu <?= $scookies; ?>"><i class=" fa fa-hourglass"></i> Cookies</a>
  </div>
  <!--vouchers-->
  <a href="./?hotspot=users-by-profile&session=<?= $session; ?>" class="menu <?= $susersbp; ?>"> <i class="fa fa-ticket"></i> Vouchers </a>
  <!--log-->
  <div class="dropdown-btn <?= $log; ?>"><i class=" fa fa-align-justify"></i> Log
    <i class="fa fa-caret-down"></i>
  </div>
  <div class="dropdown-container <?= $lmenu; ?>">
    <a href="./?hotspot=log&session=<?= $session; ?>" class="<?= $slog; ?>"> <i class="fa fa-wifi "></i> Hotspot Log </a>
    <a href="./?report=userlog&idbl=<?= strtolower(date("M")) . date("Y"); ?>&session=<?= $session; ?>" class=" <?= $sulog; ?>"> <i class="fa fa-users "></i> User Log </a>
  </div>
  <!--system-->
  <div class="dropdown-btn <?= $sysmenu; ?>"><i class=" fa fa-gear"></i> System 
    <i class="fa fa-caret-down"></i> &nbsp;
  </div>
  <div class="dropdown-container <?= $schmenu; ?>">
    <a href="./?system=scheduler&session=<?= $session; ?>" class="<?= $ssch; ?>"> <i class="fa fa-clock-o "></i> Scheduler </a>
    <a href="./admin.php?id=reboot&session=<?= $session; ?>" class=""> <i class="fa fa-power-off "></i> Reboot </a>            
  </div>
  <!--dhcp leases-->
  <a href="./?hotspot=dhcp-leases&session=<?= $session; ?>" class="menu <?= $slease; ?>"><i class=" fa fa-sitemap"></i> DHCP Leases</a>
  <!--report-->
  <a href="./?report=selling&idbl=<?= strtolower(date("M")) . date("Y"); ?>&session=<?= $session; ?>" class="menu <?= $sselling; ?>"><i class="nav-icon fa fa-money"></i> Report</a>
  <!--settings-->
  <div class="dropdown-btn <?= $ssett; ?>"><i class=" fa fa-gear"></i> Settings 
    <i class="fa fa-caret-down"></i> &nbsp;
  </div>
  <div class="dropdown-container <?= $settmenu; ?>">
  <a href="./admin.php?id=settings&session=<?= $session; ?>" class="menu "> <i class="fa fa-gear "></i> Session Settings </a>
  <a href="./admin.php?id=sessions" class="menu "> <i class="fa fa-gear "></i> Admin Settings </a>
  <a href="./?hotspot=uplogo&session=<?= $session; ?>" class="menu <?= $uplogo; ?>"> <i class="fa fa-upload "></i> Upload Logo </a>
  <a href="./?hotspot=template-editor&template=default&session=<?= $session; ?>" class="menu <?= $teditor; ?>"> <i class="fa fa-edit "></i> Template Editor </a>          
  </div>
  <!--about-->
  <a href="./?hotspot=about&session=<?= $session; ?>" class="menu <?= $sabout; ?>"><i class="fa fa-info-circle"></i> About</a>

</div>
<?php 
} ?>
<div id="main">  
<div class="main-container">


