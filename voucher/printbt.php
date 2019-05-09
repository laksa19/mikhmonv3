<?php date_default_timezone_set($_SESSION['timezone']); ?>
<script>
function sendToQuickPrinterChrome(){
 
    var commandsToPrint = 

                        "<center><big><bold><?= $hotspotname ?>\n" +
                        //"<line0>\n" +
                        "<center><?= date("Y-m-d h:i:sa") ?>\n" +
                        "<line0>\n" +
                        <?php if($uname == $upass){
                        echo '"'.$_voucher_code.' :;; '. $uname.'\n" +';
                        }else{
                          echo '"'.$_user_name.' :;; '. $uname.'\n" +
                        "'.$_password.' :;; '. $upass.'\n" +';
                        }?>
                        <?php if($getvalid != ""){
                          echo '"'.$_validity.' :;; '.$validity.'\n" +';
                        }?>
                        <?php if($utimelimit != ""){
                          echo '"'.$_time_limit.' :;; '.$timelimit.'\n" +';
                        }?>
                        <?php if($udatalimit != ""){
                          echo '"'.$_data_limit.' :;; '.$udatalimit.$MG.'\n" +';
                        }?>
                        <?php if ($getprice != 0) {
                          echo '"'.$_price.' :;; '.$pricebt.'\n" +';
                        }?>
                        "<line0>\n" +
                        "<center>Login : http://<?= $dnsname ?>\n" +
                        //"<line0>\n" +
                        <?php if($qrbt == "enable"){
                          echo '"<center><image>" + "'.$qrcode.'" +"\n"';
                        }else{echo '"\n"';}?>
                        + "<cut>"
                ;
    var textEncoded = encodeURI(commandsToPrint);
    window.location.href="intent://"+textEncoded+"#Intent;scheme=quickprinter;package=pe.diegoveloper.printerserverapp;end;";
}
</script>