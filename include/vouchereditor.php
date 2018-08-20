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
?>
<?php
error_reporting(0);
if(!isset($_SESSION["mikhmon"])){
  header("Location:../admin.php?id=login");
}else{
// load session MikroTik
$session = $_GET['session'];
}
// load config
include('../include/config.php');
$iphost=explode('!',$data[$session][1])[1]; 
$userhost=explode('@|@',$data[$session][2])[1];
$passwdhost=explode('#|#',$data[$session][3])[1]; 
$hotspotname=explode('%',$data[$session][4])[1]; 
$dnsname=explode('^',$data[$session][5])[1]; 
$curency=explode('&',$data[$session][6])[1];



$url = $_SERVER['REQUEST_URI'];
$telplate = $_GET['template'];
if($telplate == "default" || $telplate == "rdefault"){
  $telplatet = "template";
}elseif($telplate == "thermal" || $telplate == "rthermal"){
  $telplatet = "template-thermal";
}elseif($telplate == "small" || $telplate == "rsmall"){
  $telplatet = "template-small";
}
  if(isset($_POST['save'])){
    $template = './voucher/'.$telplatet.'.php';
		$handle = fopen($template, 'w') or die('Cannot open file:  '.$template);
		
		$data = ($_POST['editor']);
    
		fwrite($handle, $data);
		
		//header("Location:$url");
}
?>
<style>
textarea{
  font-size:12px;
  border: 1px solid #2f353a;
}
</style>
			<div class="row">
	      	<div class="col-9">
	      		<div class="card">
					<div class="card-header">
						<h3><i class="fa fa-edit"></i> Template Editor</h3>
					</div>
				<div class="card-body">
	  				<form autocomplete="off" method="post" action="">
	  		<table class="table">
	  			<tr>
	  				<td>
	          			<button type="submit" title="Save template" class="btn bg-primary" name="save"><i class="fa fa-save"></i> Save</button>
	      			</td>
	      	<td>
	      	<div class="input-group">
            	<div class="input-group-6">
            		<div class="group-item group-item-l pd-2p5 text-center">Template</div>
            	</div>
	      		<div class="input-group-6">
	          		<select style="padding:4.2px;"  class="group-item group-item-r" onchange="window.location.href=this.value+'&session=<?php echo $session;?>';">
	          			<option><?php echo $telplate;?></option>
	          			<option value="./admin.php?id=editor&template=default">Default</option>
	          			<option value="./admin.php?id=editor&template=thermal">Thermal</option>
	          			<option value="./admin.php?id=editor&template=small">Small</option>
	          		</select>
	      		</div>
	  		</div>
	    </td>
	    <td>
	      	<div class="input-group">
            	<div class="input-group-6">
            		<div class="group-item group-item-l pd-2p5 text-center">Reset</div>
            	</div>
	      		<div class="input-group-6">
	          		<select style="padding:4.2px;"  class="group-item group-item-r" onchange="window.location.href=this.value+'&session=<?php echo $session;?>';">
	          			<option><?php echo $telplate;?></option>
	          			<option value="./admin.php?id=editor&template=rdefault">Default</option>
	          			<option value="./admin.php?id=editor&template=rthermal">Thermal</option>
	          			<option value="./admin.php?id=editor&template=rsmall">Small</option>
	          		</select>
	          	</div>
	          </div>
	      </td>
	      </tr>
	  </table>
	          <textarea id="editor" class="bg-dark" name="editor" style="width:100%" rows=40>
	            <?php if($telplate == "default"){?>
	            <?=file_get_contents ('./voucher/template.php');?>
	            <?php }elseif($telplate == "thermal"){?>
	              <?=file_get_contents ('./voucher/template-thermal.php');?>
	            <?php }elseif($telplate == "small"){?>
	              <?=file_get_contents ('./voucher/template-small.php');?>
	           <?php }elseif($telplate == "rdefault"){?>
	            <?=file_get_contents ('./voucher/default.php');?>
	            <?php }elseif($telplate == "rthermal"){?>
	              <?=file_get_contents ('./voucher/default-thermal.php');?>
	            <?php }elseif($telplate == "rsmall"){?>
	              <?=file_get_contents ('./voucher/default-small.php');?>
	            <?php }?>
	          </textarea>
	  </form>
	</div>
</div>
</div>
<div class="col-3">
	<div class="card">
		<div class="card-header">
			<h3>Variable</h3>
		</div>
	<div class="card-body">
		<textarea class="bg-dark" readonly rows=43 style="width:100%" disabled>
	        <?=file_get_contents ('./voucher/variable.php');?>
	    </textarea>
	</div>
	</div>
</div>
</div>

