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


  $btnmenuactive = "font-weight: bold;background-color: #f9f9f9; color: #000000";
if($hotspot == "dashboard"){
  $shome = "active";
  $mpage = "Dashboard";
}elseif($hotspot == "users" || $userbyprofile != "" || $hotspot == "export-users" ){
  $susersl = "active";
  $susers = "active";
  $mpage = "Users";
  $umenu = "menu-open";
}elseif($hotspot == "user-profiles"){
  $suserprofiles = "active";
  $suserprof = "active";
  $mpage = "User Profiles";
  $upmenu = "menu-open";
}elseif($hotspot == "active"){
  $sactive = "active";
  $mpage = "Hotspot Active";
}elseif($hotspot == "hosts" || $hotspot == "hostp" || $hotspot == "hosta"){
  $shosts = "active";
  $mpage = "Hosts";
}elseif($hotspot == "dhcp-leases"){
  $slease = "active";
  $mpage = "DHCP Leases";  
}elseif($hotspot == "ipbinding" || $hotspot == "binding"){
  $sipbind = "active";
  $mpage = "IP Bindings";
}elseif($hotspot == "log"){
  $log = "active";
  $slog = "active";
  $mpage = "Hotspot Log";
  $lmenu = "menu-open";
}elseif($hotspot == "userlog"){
  $log = "active";
  $sulog = "active";
  $mpage = "User Log";
  $lmenu = "menu-open";
}elseif($hotspot == "selling"){
  $sselling = "active";
  $mpage = "Report";
}elseif($userprofile == "add"){
  $suserprof = "active";
  $sadduserprof = "active";
  $mpage = "User Profiles";
  $upmenu = "menu-open";
}elseif($userprofilebyname != ""){
  $suserprof = "active";
  $mpage = "User Profiles";
}elseif($hotspotuser == "add"){
  $sadduser = "active";
  $mpage = "Users";
  $susers = "active";
  $umenu = "menu-open";
}elseif($hotspotuser == "generate"){
  $sgenuser = "active";
  $mpage = "Users";
  $susers = "active";
  $umenu = "menu-open";
}elseif($hotspot == "users-by-profile"){
  $susersbp = "active";
  $mpage = "Users";
  $susers = "active";
  $umenu = "menu-open";   
}elseif($userbyname != ""){
  $mpage = "Users";
  $susers = "active";
}elseif($hotspot == "about"){
  $mpage = "About";
  $sabout= "active";
}elseif($id == "sessions"){
  $ssesslist = "active";
  $mpage = "Router List";
}elseif($id == "settings" && $session == "new"){
  $snsettings = "active";
  $mpage = "Add Router";
}elseif($id == "settings"){
  $ssettings = "active";
  $mpage = "Session Settings";
}elseif($id == "about"){
  $sabout = "active";
  $mpage = "Router List";
}elseif($id == "uplogo"){
  $suplogo = "active";
  $mpage = "Upload Logo";
}elseif($id == "editor"){
  $seditor = "active";
  $mpage = "Template Voucher";
}
}
?>


<?php if($id != ""){?>

<div id="navbar" class="navbar">
  <div class="navbar-left">
    <a id="brand" class="text-center" href="javascript:void(0)"><span>MIKHMON</span></a>

<a id="openNav" class="navbar-hover" href="javascript:void(0)">&#9776;</a>
<a id="closeNav" class="navbar-hover" href="javascript:void(0)">&#9776;</a>
<a id="cpage" class="navbar-left" href="javascript:void(0)"><?php echo $mpage;?></a>
</div>
 <div class="navbar-right">
  <a href="./admin.php?id=logout" ><i class="fa fa-sign-out mr-1"></i> Logout</a>
  <a href="javascript:void(0)" ><?php echo $hotspotname;?></a>
</div>
</div>

<div id="sidenav" class="sidenav">
<?php if($session == "" || $session == "new"){}else{?>  
  <div class="menu text-center align-middle card-header"><h3><?php echo $session;?></h3></div>
  <a href="./app.php?hotspot=dashboard&session=<?php echo $session;?>" class="menu <?php echo $shome;?>" title="Dashboard"><i class='fa fa-tachometer'></i> Dashboard</a>
  <a  href="./admin.php?id=settings&session=<?php echo $session;?>" class="menu <?php echo $ssettings;?>" title="Mikhmon Settings"><i class='fa fa-gear'></i> Settings</a>
  <a href="./admin.php?id=uplogo&session=<?php echo $session;?>" class="menu <?php echo $suplogo;?>"><i class="fa fa-upload "></i> Upload Logo</a>
  <a href="./admin.php?id=editor&template=default&session=<?php echo $session;?>" class="menu <?php echo $seditor;?>"><i class="fa fa-edit"></i> Template Editor</a>
  <div class="menu" style="border-bottom: 1px solid #23282c;"></div>
<?php } ?>  
  <a href="./admin.php?id=sessions" class="menu <?php echo $ssesslist;?>"><i class="fa fa-server"></i> Router List</a>
  <a href="./admin.php?id=settings&router=new" class="menu <?php echo $snsettings?>"><i class="fa fa-plus"></i> Add Router</a>
  <a href="./admin.php?id=about" class="menu <?php echo $sabout;?>"><i class="fa fa-info-circle"></i> About</a>
</div>

<?php }else{?>

<div id="navbar" class="navbar">
  <div class="navbar-left">
    <a id="brand" class="text-center" href="./app.php?hotspot=dashboard&session=<?php echo $session;?>"><span>MIKHMON</span></a>

<a id="openNav" class="navbar-hover" href="javascript:void(0)">&#9776;</a>
<a id="closeNav" class="navbar-hover" href="javascript:void(0)">&#9776;</a>
<a id="cpage" class="navbar-left" href="javascript:void(0)"><?php echo $mpage;?></a>
</div>
 <div class="navbar-right">
  <a href="./app.php?hotspot=logout&session=<?php echo $session;?>" ><i class="fa fa-sign-out mr-1"></i> Logout</a>

  <select style="float: right; border: none; background-color: #3a4149; font-size: 14px;" class="text-light text-right mr-t-10 pd-5" onchange="location = this.value;">
  <option><?php echo $hotspotname;?></option>
      <?php
          foreach(file('./include/config.php') as $line) {
            $value = explode("'",$line)[1];
            if ($value == "" || $value == "mikhmon") {
            }else{
            echo '<option value="app.php?hotspot=dashboard&session='.$value.'">'.$value.'</option>';
            }
          }
      ?>
    
  </select>
</div>
</div>

<div id="sidenav" class="sidenav">
  <div class="menu text-center align-middle card-header"><h3><?php echo $identity;?></h3></div>
  <a href="./app.php?hotspot=dashboard&session=<?php echo $session;?>" class="menu <?php echo $shome;?>"><i class="fa fa-dashboard"></i> Dashboard</a>
  <div class="dropdown-btn <?php echo $susers;?>"><i class="fa fa-users"></i> Users
    <i class="fa fa-caret-down"></i>
  </div>
  <div class="dropdown-container <?php echo $umenu;?>">
    <a href="./app.php?hotspot=users&profile=all&session=<?php echo $session;?>" class="<?php echo $susersl;?>">
                  <i class="fa fa-list "></i>
                  <span>User List</span>
                </a>
    <a href="./app.php?hotspot-user=add&session=<?php echo $session;?>" class="<?php echo $sadduser;?>">
                  <i class="fa fa-user-plus "></i>
                  <span>Add User</span>
                </a>
    <a href="./app.php?hotspot-user=generate&session=<?php echo $session;?>" class="<?php echo $sgenuser;?>">
                  <i class="fa fa-user-plus"></i>
                  <span>Generate</span>
                </a>
    <a href="./app.php?hotspot=users-by-profile&session=<?php echo $session;?>" class="<?php echo $susersbp;?>">
                  <i class="fa fa-users"></i>
                  <span>Users by Profile</span>
                </a>            
  </div>
  <div class="dropdown-btn <?php echo $suserprof;?>"><i class=" fa fa-pie-chart"></i>  User Profile
    <i class="fa fa-caret-down"></i>
  </div>
  <div class="dropdown-container <?php echo $upmenu;?>">
    <a href="./app.php?hotspot=user-profiles&session=<?php echo $session;?>" class=" <?php echo $suserprofiles;?>">
                  <i class="fa fa-list "></i>
                  User Profile List
                </a>
    <a href="./app.php?user-profile=add&session=<?php echo $session;?>" class=" <?php echo $sadduserprof;?>">
                  <i class="fa fa-plus-square "></i>
                  Add User Profile
                </a>
  </div>
  <a href="./app.php?hotspot=active&session=<?php echo $session;?>" class="menu <?php echo $sactive;?>"><i class=" fa fa-wifi"></i> Hotspot Active</a>
  <a href="./app.php?hotspot=dhcp-leases&session=<?php echo $session;?>" class="menu <?php echo $slease;?>"><i class=" fa fa-sitemap"></i> DHCP Leases</a>
  <div class="dropdown-btn <?php echo $log;?>"><i class=" fa fa-align-justify"></i> Log
    <i class="fa fa-caret-down"></i>
  </div>
  <div class="dropdown-container <?php echo $lmenu;?>">
    <a href="./app.php?hotspot=log&session=<?php echo $session;?>" class="<?php echo $slog;?>">
                  <i class="fa fa-wifi "></i>
                  Hotspot Log
                </a>
    <a href="./app.php?hotspot=userlog&session=<?php echo $session;?>" class=" <?php echo $sulog;?>">
                  <i class="fa fa-users "></i>
                  User Log
                </a>
  </div>
  <a href="./app.php?hotspot=selling&session=<?php echo $session;?>" class="menu <?php echo $sselling;?>"><i class="nav-icon fa fa-money"></i> Report</a>
  <div class="dropdown-btn "><i class=" fa fa-gear"></i> Settings 
    <i class="fa fa-caret-down"></i> &nbsp;
  </div>
  <div class="dropdown-container">
    <a href="./admin.php?id=settings&session=<?php echo $session;?>" class="">
                  <i class="fa fa-gear "></i>
                  Session Settings
                </a>
    <a href="./admin.php?id=editor&template=default&session=<?php echo $session;?>" class="">
                  <i class="fa fa-edit "></i>
                  Template Editor
                </a>
    <a href="./admin.php?id=uplogo&session=<?php echo $session;?>" class="">
                  <i class="fa fa-upload "></i>
                  Upload Logo
                </a>
    <a href="./admin.php?id=reboot&session=<?php echo $session;?>" class="">
                  <i class="fa fa-power-off "></i>
                  Reboot
                </a>            
  </div>
  <a href="./app.php?hotspot=about&session=<?php echo $session;?>" class="menu <?php echo $sabout;?>"><i class="fa fa-info-circle"></i> About</a>
</div>
<?php }?>
<div id="main">  
<div class="main-container">


