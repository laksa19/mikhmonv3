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

if(isset($_POST["submit"])) {
$logo_dir = "./img/";
$logo_file = $logo_dir . basename($_FILES["UploadLogo"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($logo_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image

    $check = getimagesize($_FILES["UploadLogo"]["tmp_name"]);
    if($check !== false) {
      if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
          $galat = '<div class="box bg-danger"></i> Alert!<br> File name is : ' . basename($_FILES["UploadLogo"]["name"]). '. </div>';
      }else{
          $galat = '<div class="box bg-danger"></i> Alert!<br> File name is : ' . basename($_FILES["UploadLogo"]["name"]). '. </div>';
      }
        $uploadOk = 1;
    } else {
      if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
          $galat = '<div class="box bg-danger"></i> Alert!<br>  File bukan gambar. </div>';
      }else{
          $galat = '<div class="box bg-danger"></i> Alert!<br>  File is not an image. </div>';
      }
        $uploadOk = 0;
    }


// Check file size
if ($_FILES["UploadLogo"]["size"] > 2000000) {
  if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
          $galat = '<div class="box bg-danger"></i> Alert!<br>  Ukuran file terlalu besar. </div>';
      }else{
          $galat = '<div class="box bg-danger"></i> Alert!<br> File is too large. </div>';
      }
    $uploadOk = 0;
}
// Allow certain file formats
if( basename($_FILES["UploadLogo"]["name"] != "logo-".$session.".png")) {
  if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
          $galat = '<div class="box bg-danger"></i> Alert!<br>  Hanya bisa upload logo-'.$session.'.png. </div>';
      }else{
          $galat = '<div class="box bg-danger"></i> Alert!<br>  Only logo-'.$session.'.png are allowed. </div>';
      }
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
          $galat = '<div class="box bg-danger"></i> Alert!<br>  File tidak diupload. </div>';
      }else{
          $galat = '<div class="box bg-danger"></i> Alert!<br>  File was not uploaded. </div>';
      }
    
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["UploadLogo"]["tmp_name"], $logo_file)) {
      if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
           $galat = '<div class="box bg-success"></i> Alert!<br>  Success!</h5> File '. basename( $_FILES["UploadLogo"]["name"]). ' telah diupload. </div>';
      }else{
           $galat = '<div class="box bg-success"></i> Alert!<br>  Success!</h5> The File '. basename( $_FILES["UploadLogo"]["name"]). ' has been uploaded. </div>';
      }
       
    } else {
      if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
          $galat = '<div class="box bg-danger"></i> Alert!<br>  Terjadi masalah ketika upload file. </div>';
      }else{
           $galat = '<div class="box bg-danger"></i> Alert!<br>  There was an error uploading your file </div>';
      }
        
    }
}
//echo "<script>window.location='./admin.php?id=uplogo&session=".$session."'</script>";
}
}
?>
<div class="row">
<div class="col-12">
  <div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-upload"></i> Upload Logo Voucher</h3>
    </div>
    <div class="card-body">
      <div>
    <?php echo $galat;?>
      <form action="" method="post" enctype="multipart/form-data">

          <div class="pd-10">Format file : logo-<?php echo $session;?>.png </div>
          <div class="input-group">
            <div class="input-group-4 col-box-8">
                <input style="cursor: pointer; " type="file" class="group-item group-item-l" name="UploadLogo" >
            </div>
            <div class="input-group-2 col-box-4">
                <input style="cursor: pointer; font-size: 14px; padding:8px;" class="group-item group-item-r" type="submit" value="Upload" title="Upload logo" name="submit">
            </div>

      </form>
    </div>
      <div class="mr-t-10">
      <table class="table table-bordered table-hover">
        <thead>
        <tr>
          <th>List Logo</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
      $dir = "./img";
      // Open a directory, and read its contents
      if (is_dir($dir)){
        if ($dh = opendir($dir)){
          while (($file = readdir($dh)) !== false){
            if($file != "." && $file != ".."){
              if(
                substr($file,0,5) != "logo-" ||
                substr($file, -5) == ".html" ||
                substr($file, -4) == ".php" ||
                substr($file, -4) == ".jpg" ||
                substr($file, -4) == ".bak"
                ){
            }else{?>
              
              <tr><td><?php echo $file;?></td><td><a href="javascript:void(0)" onclick="if(confirm('Sure to delete <?php echo $file;?> ?')){window.location='./admin.php?id=remove&logo=<?php echo $file;?>'}else{}"><i class="fa fa-remove"></i> Delete</a></td></tr>
              
          <?php }}
        }
          closedir($dh);
        }
      }
      ?>
      </tbody>
    </table>
  </div>
  
  </div>
</div>
</div>
</div>