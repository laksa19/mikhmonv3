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
if (!isset($_SESSION["mikhmon"])) {
	header("Location:../admin.php?id=login");
} else {
// load session MikroTik
	$session = $_GET['session'];

// load config
include('../include/config.php');
include('../include/readcfg.php');



$url = $_SERVER['REQUEST_URI'];
$telplate = $_GET['template'];
if ($telplate == "default" || $telplate == "rdefault") {
	$telplatet = "template";
	$popup = "javascript:window.open('./voucher/vpreview.php?usermode=up&qr=no&session=" . $session . "','_blank','width=310,height=310')";
	$popupQR = "javascript:window.open('./voucher/vpreview.php?usermode=up&qr=yes&session=" . $session . "','_blank','width=310,height=310')";
} elseif ($telplate == "thermal" || $telplate == "rthermal") {
	$telplatet = "template-thermal";
	$popup = "javascript:window.open('./voucher/vpreview.php?usermode=up&user=m&qr=no&session=" . $session . "','_blank','width=310,height=310')";
	$popupQR = "javascript:window.open('./voucher/vpreview.php?usermode=up&user=m&qr=yes&session=" . $session . "','_blank','width=310,height=310')";
} elseif ($telplate == "small" || $telplate == "rsmall") {
	$telplatet = "template-small";
	$popup = "javascript:window.open('./voucher/vpreview.php?usermode=up&small=yes&qr=no&session=" . $session . "','_blank','width=310,height=310')";
	$popupQR = "javascript:window.open('./voucher/vpreview.php?usermode=up&small=yes&qr=yes&session=" . $session . "','_blank','width=310,height=310')";
}
if (isset($_POST['save'])) {
	$template = './voucher/' . $telplatet . '.php';
	$handle = fopen($template, 'w') or die('Cannot open file:  ' . $template);

	$data = ($_POST['editor']);

	fwrite($handle, $data);
		
		//header("Location:$url");
}

}
?>
<!-- Create a simple CodeMirror instance -->
<link rel="stylesheet" href="./css/editor.min.css">
<script src="./js/editor.min.js"></script>	

<style>
.CodeMirror {
  border: 1px solid #2f353a;
  height: 505px;
}
textarea{
  font-size:12px;
  border: 1px solid #2f353a;
}
</style>


		<div class="row">
	    	<div class="col-9">
	    		<div class="card">
					<div class="card-header">
						<h3><i class="fa fa-edit"></i> <?= $_template_editor ?></h3>
					</div>
			<div class="card-body">
				<form autocomplete="off" method="post" action="">
					<table class="table">
						<tr>
							<td>
							<div class="row">
								<div class="col-4 col-box-12">
								<button type="submit" title="Save template" class="btn bg-primary" name="save"><i class="fa fa-save"></i> <?= $_save ?></button>
								<a class="btn bg-green" href="<?= $popup?>" title="View voucher with Logo"><i class="fa fa-image"></i> </a>
								<a class="btn bg-green" href="<?= $popupQR?>" title="View voucher with  QR"><i class="fa fa-qrcode"></i> </a>
								</div>
								<div class="col-8 pd-t-5 pd-b-5 col-box-12">
								<div class="input-group">
            					<div class="input-group-3">
            						<div class="group-item group-item-l pd-2p5 text-center">Template</div>
            					</div>
								<div class="input-group-3">
									<select style="padding:4.2px;"  class="group-item group-item-m" onchange="window.location.href=this.value+'&session=<?= $session; ?>';">
	    								<option><?= ucfirst($telplate); ?></option>
	    								<option value="./admin.php?id=editor&template=default">Default</option>
	    								<option value="./admin.php?id=editor&template=thermal">Thermal</option>
	    								<option value="./admin.php?id=editor&template=small">Small</option>
	    							</select>
	    						</div>
								
								<div class="input-group-3">
            						<div class="group-item group-item-m pd-2p5 text-center">Reset</div>
            					</div>
	    						<div class="input-group-3">
	    							<select style="padding:4.2px;"  class="group-item group-item-r" onchange="window.location.href=this.value+'&session=<?= $session; ?>';">
	    								<option><?= ucfirst($telplate); ?></option>
	    								<option value="./admin.php?id=editor&template=rdefault">Default</option>
	    								<option value="./admin.php?id=editor&template=rthermal">Thermal</option>
	    								<option value="./admin.php?id=editor&template=rsmall">Small</option>
	    							</select>
	    						</div>
								</div>
								</div>
							</div>
	    					</td>
						</tr>
						</table>
	        	<textarea class="bg-dark" id="editorMikhmon" name="editor" style="width:100%" height="700">
						<?php if ($telplate == "default") {
						echo file_get_contents('./voucher/template.php');
					} elseif ($telplate == "thermal") {
						echo file_get_contents('./voucher/template-thermal.php');
					} elseif ($telplate == "small") {
						echo file_get_contents('./voucher/template-small.php');
					} elseif ($telplate == "rdefault") {
						echo file_get_contents('./voucher/default.php');
					} elseif ($telplate == "rthermal") {
						echo file_get_contents('./voucher/default-thermal.php');
					} elseif ($telplate == "rsmall") {
						echo file_get_contents('./voucher/default-small.php');
					} ?>
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
				<textarea id="var" class="bg-dark" readonly rows=39 style="width:100%" disabled>
	        		<?= file_get_contents('./voucher/variable.php'); ?>
	    		</textarea>
			</div>
			</div>
		</div>
</div>

<script>
var _0x5b73=["\x75\x6E\x64\x65\x66\x69\x6E\x65\x64","\x4D\x69\x6B\x68\x6D\x6F\x6E\x53\x65\x73\x73\x69\x6F\x6E","\x69\x6E\x6E\x65\x72\x48\x54\x4D\x4C","\x67\x65\x74\x45\x6C\x65\x6D\x65\x6E\x74\x42\x79\x49\x64","\x73\x65\x74\x49\x74\x65\x6D","\x50\x6C\x65\x61\x73\x65\x20\x75\x73\x65\x20\x47\x6F\x6F\x67\x6C\x65\x20\x43\x68\x72\x6F\x6D\x65","\x67\x65\x74\x49\x74\x65\x6D","\x6E\x75\x6C\x6C","","\x4D\x69\x6B\x68\x6D\x6F\x6E\x20\x62\x61\x6A\x61\x6B\x61\x6E\x21\x20\x3A\x29","\x65\x64\x69\x74\x6F\x72\x4D\x69\x6B\x68\x6D\x6F\x6E","\x61\x70\x70\x6C\x69\x63\x61\x74\x69\x6F\x6E\x2F\x78\x2D\x68\x74\x74\x70\x64\x2D\x70\x68\x70","\x74\x6F\x4D\x61\x74\x63\x68\x69\x6E\x67\x54\x61\x67","\x66\x72\x6F\x6D\x54\x65\x78\x74\x41\x72\x65\x61","\x74\x68\x65\x6D\x65","\x6D\x61\x74\x65\x72\x69\x61\x6C","\x73\x65\x74\x4F\x70\x74\x69\x6F\x6E"];if( typeof (Storage)!== _0x5b73[0]){sessionStorage[_0x5b73[4]](_0x5b73[1],document[_0x5b73[3]](_0x5b73[1])[_0x5b73[2]])}else {alert(_0x5b73[5])};var session=sessionStorage[_0x5b73[6]](_0x5b73[1]);if(session=== _0x5b73[7]|| session=== _0x5b73[8]){alert(_0x5b73[9])};var editor=CodeMirror[_0x5b73[13]](document[_0x5b73[3]](_0x5b73[10]),{lineNumbers:true,matchBrackets:true,mode:_0x5b73[11],indentUnit:4,indentWithTabs:true,lineWrapping:true,viewportMargin:Infinity,matchTags:{bothTags:true},extraKeys:{"\x43\x74\x72\x6C\x2D\x4A":_0x5b73[12]}});editor[_0x5b73[16]](_0x5b73[14],_0x5b73[15])
</script>


