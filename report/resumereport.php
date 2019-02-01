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
// load session MikroTik
$session = $_GET['session'];


// load config
  include('../include/config.php');
  include('../include/readcfg.php');

// routeros api
  include_once('../lib/routeros_api.class.php');
  include_once('../lib/formatbytesbites.php');
  $API = new RouterosAPI();
  $API->debug = false;
  $API->connect($iphost, $userhost, decrypt($passwdhost));
// get selling report

$idbl = $_GET['idbl'];
$thisM = substr($idbl,0,3);
$thisY = substr($idbl,-4);

$ms = array(1 => "jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep", "oct", "nov", "dec");
$mn = array_search($thisM, $ms);
$getM = cal_days_in_month(CAL_GREGORIAN,$mn,$thisY);

if ($mn == date("n")){
  $totD =  (date('d') +1);
}else{
  $totD = ($getM + 1);
}


$getSRBl = $API->comm("/system/script/print", array(
  "?owner" => "$idbl",
));
$TotalRBl = count($getSRBl);

for ($i = 0; $i < $TotalRBl; $i++) {

  $tBl += explode("-|-", $getSRBl[$i]['name'])[3];
}


if ($currency == in_array($currency, $cekindo['indo'])) {
  $totalreport = "Total " . $TotalRBl . "vcr : " . $currency . " " . number_format($tBl, 0, ",", ".");

} else {
  $totalreport = "Total " . $TotalRBl . "vcr : " . $currency . " " . number_format($tBl, 2);
}



    function resumeHr($idhr)
    {
      $session = $_GET['session'];
  // load config
      include('./include/config.php');
      include('./include/readcfg.php');
  // routeros api
      include_once('./lib/routeros_api.class.php');
      $API = new RouterosAPI();
      $API->debug = false;
      if($API->connect($iphost, $userhost, decrypt($passwdhost))){
      $getSRHr = $API->comm("/system/script/print", array(
        "?source" => "$idhr",
      ));
    
      $TotalRHr = count($getSRHr);
      for ($i = 0; $i < $TotalRHr; $i++) {
        $tHr += explode("-|-", $getSRHr[$i]['name'])[3];
      }
      return $tHr;
      }else{
        $nl = '\n';
        if ($currency == in_array($currency, $cekindo['indo'])) {
            echo "<script>alert('Mikhmon not connected!".$nl."Silakan periksa kembali IP, User, Password dan port API harus enable.".$nl."Jika menggunakan koneksi VPN, pastikan VPN tersebut terkoneksi.')</script>";
          }else{
            echo "<script>alert('Mikhmon not connected!".$nl."Please check the IP, User, Password and port API must be enabled.')</script>";
          }
          if($c == "settings"){
            echo "<script>window.location='./admin.php?id=settings&session=" . $session . "'</script>";
          }else{
            echo "<script>window.location='./admin.php?id=sessions'</script>";
          }
        }
    }
}
?>

          <div class="card">
            <div class="card-header"><h3><i class="fa fa-area-chart"></i> Resume Report </h3></div>
          
              <div class="card-body">
                <div class="row">

                  <script src="./js/highcharts/highcharts.js"></script>
                  <script src="./js/highcharts/themes/hc.<?= $theme; ?>.js"></script>


<div class="col-12" id="container"></div>

<script type="text/javascript">
Highcharts.chart('container', {
    chart: {
    height: 500,
    type: 'area',
    },
    title: {
        text: 'Selling Report <?= ucfirst($thisM)." ".$thisY;?>'
    },

    subtitle: {
        text: '<?= $totalreport;?>'
    },

    xAxis: {
        tickInterval: 1
    },

    yAxis: {
        title: {
            text: 'Total Sales'
        }
    },

    legend: {
        layout: 'horizontal',
        align: 'center',
        verticalAlign: 'bottom'
    },

    
    plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            },
            pointStart: 1
        }
    },

    series: [{
        name: 'Report',
        data: [
<?php

for ($i = 1; $i < $totD; $i++) {
        if (strlen($i) == "1") {
          $thisD = "0" . $i;
        } else {
          $thisD = $i;
        }
        $idhr = strtolower($thisM . '/' . $thisD . '/' . $thisY);
        if(resumeHr($idhr) == ""){$r = 0;}else{$r = resumeHr($idhr);}
        echo "['<b>".ucfirst($thisM)." ".$thisD."</b>',".$r."],";
}

?>

        ]
    }],
    tooltip: {
        pointFormat: 'Total sales: <b>{point.y}</b>',
    },
    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});


</script>
                </div>
              </div>  