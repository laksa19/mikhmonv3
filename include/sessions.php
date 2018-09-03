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

// hide all error
error_reporting(0);
if(!isset($_SESSION["mikhmon"])){
  header("Location:../admin.php?id=login");
}else{

// array color
$color = array ('1'=>'bg-blue','bg-indigo','bg-purple','bg-pink','bg-red','bg-yellow','bg-green','bg-teal','bg-cyan','bg-grey','bg-light-blue');

if(isset($_POST['save'])){

	$suseradm = ($_POST['useradm']);
  $spassadm = encrypt($_POST['passadm']);

		$cari = array ('1' =>"mikhmon<|<$useradm","mikhmon>|>$passadm");
    $ganti = array ('1' =>"mikhmon<|<$suseradm","mikhmon>|>$spassadm");
   
    for ($i=1; $i<3; $i++){ 
    $file = file("./include/config.php");
    $content = file_get_contents("./include/config.php");
    $newcontent = str_replace((string)$cari[$i], (string)$ganti[$i], "$content");
    file_put_contents("./include/config.php", "$newcontent");
    } 
  
		echo "<script>window.location='./admin.php?id=sessions'</script>";
		}
}
?>
<script>
  function PassMk(){
    var x = document.getElementById('passmk');
    if (x.type === 'password') {
    x.type = 'text';
    } else {
    x.type = 'password';
    }}
    function PassAdm(){
    var x = document.getElementById('passadm');
    if (x.type === 'password') {
    x.type = 'text';
    } else {
    x.type = 'password';
  }}
</script>
 
<div class="row">
	<div class="col-12">
  	<div class="card">
  		<div class="card-header">
  			<h3 class="card-title"><i class="fa fa-server"></i> Router List &nbsp; | &nbsp;&nbsp;<i onclick="location.reload();" class="fa fa-refresh pointer " title="Reload data"></i></h3>
  		</div>
      <div class="card-body overflow">
        <div class="row">
          <div class="col-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><i class="fa fa-server"></i> Router</h3>
              </div>
            <div class="card-body">
            <div class="row"> 
              <?php
              foreach(file('./include/config.php') as $line) {
                $value = explode("'",$line)[1];
                  if ($value == "" || $value == "mikhmon") {
                  }else{?>
                     <div class="col-12">
                        <div class="box bmh-75 box-bordered <?php echo $color[rand(1,11)];?>">
                                <div class="box-group">
                                  
                                  <div class="box-group-icon">
                                    <a title='Open User by profile <?php echo $pname;?>'  href='./app.php?hotspot=dashboard&session=<?php echo $value;?>'>
                                    <i class="fa fa-server"></i>
                                      </a>
                                  </div>
                                
                                  <div class="box-group-area">
                                    <span >
                                      Hotspot Name : <?php echo explode('%',$data[$value][4])[1];?><br>
                                      Session Name : <?php echo $value;?><br>
                                      <a href="./app.php?hotspot=dashboard&session=<?php echo $value;?>"><i class="fa fa-external-link"></i> Open</a>&nbsp;
                                      <a href="./admin.php?id=settings&session=<?php echo $value;?>"><i class="fa fa-edit"></i> Edit</a>&nbsp;
                                      <a href="javascript:void(0)" onclick="if(confirm('Sure to delete data <?php echo $value; echo " (".explode('%',$data[$value][4])[1].")";?>?')){window.location='./admin.php?id=remove&session=<?php echo $value;?>'}else{}"><i class="fa fa-remove"></i> Delete</a>
                                    </span>
 
                                  </div>
                                </div>
                              
                            </div>
                          </div>
               <?php }
              }
              ?>
              </div>
            </div>
          </div>
        </div>
			    <div class="col-6">
          <form autocomplete="off" method="post" action="">  
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><i class="fa fa-user-circle"></i> Admin</h3>
              </div>
            <div class="card-body">  
      <table class="table table-sm">
        <tr>
          <td class="align-middle">Username  </td><td><input class="form-control" id="useradm" type="text" size="10" name="useradm" title="User Admin" value="<?php echo $useradm; ?>" required="1"/></td>
        </tr>
        <tr>
          <td class="align-middle">Password  </td>
          <td>
          <div class="input-group">
          <div class="input-group-11 col-box-10"> 
                <input class="group-item group-item-l" id="passadm" type="password" size="10" name="passadm" title="Password Admin" value="<?php echo decrypt($passadm); ?>" required="1"/>
              </div>
                <div class="input-group-1 col-box-2">
                  <div class="group-item group-item-r pd-2p5 text-center align-middle">
                      <input title="Show/Hide Password" type="checkbox" onclick="PassAdm()">
                  </div>
                </div>
            </div>
          </td>
        </tr>
        <tr>
          <td></td><td class="text-right">
              <div class="input-group-4">
                  <input class="group-item group-item-l" type="submit" style="cursor: pointer;" name="save" value="Save"/>
                </div>
                <div class="input-group-2"> 
                  <div style="cursor: pointer;" class="group-item group-item-r pd-2p5 text-center" onclick="location.reload();" title="Reload Data"><i class="fa fa-refresh"></i></div>
                </div>
                </div>  
          </td>
        </tr>
        <tr>
          <td class="align-middle" colspan=2>
            <strong>Please change username and password.</strong>
          </td>
        </tr>
      </table>
    </div>
    </div>
    </form>
  </div>
</div>
</div>
</div>
</div>
</div> 
  






