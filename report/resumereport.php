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

$idbl = $_GET['idbl'];
$thisM = substr($idbl,0,3);
$thisY = substr($idbl,-4);

$ms = array(1 => "jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep", "oct", "nov", "dec");
$mn = array_search($thisM, $ms);

// https://secure.php.net/manual/en/function.cal-days-in-month.php#38666
function days_in_month($month, $year) 
{ 
// calculate number of days in a month 
return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31); 
} 


if ($mn == date("n")){
  $totD =  (date('d') +1);
}else{
  $totD = (days_in_month($mn, $thisY)+ 1);
}

function resume_per_day($date){
$evalue =  explode($date,$_SESSION['dataresume']);
$x = count($evalue);
			for ($i = 0; $i < $x; $i++) {
				$result += $evalue[$i];
			}
			return ($x-1).'/'.$result;
}

$totalvrc =  explode("/",$_SESSION['totalresume'])[0];
$totalincome = explode("/",$_SESSION['totalresume'])[1];


if ($currency == in_array($currency, $cekindo['indo'])) {
  $totalreport = "Total " . $totalvrc . "vcr : " . $currency . " " . number_format($totalincome, 0, ",", ".");

} else {
  $totalreport = "Total " . $totalvrc . "vcr : " . $currency . " " . number_format($totalincome, 2);
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
        if(explode("/",resume_per_day($idhr))[1] == ""){$r = 0;}else{$r = explode("/",resume_per_day($idhr))[1];}
        echo "['<b>".$thisD." " .ucfirst($thisM)." ".explode("/",resume_per_day($idhr))[0]."vcr</b>',".$r."],";
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