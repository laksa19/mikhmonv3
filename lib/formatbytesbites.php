<?php
// function  format bytes
function formatBytes($size, $decimals = 0){
$unit = array(
'0' => 'Byte',
'1' => 'KiB',
'2' => 'MiB',
'3' => 'GiB',
'4' => 'TiB',
'5' => 'PiB',
'6' => 'EiB',
'7' => 'ZiB',
'8' => 'YiB'
);

for($i = 0; $size >= 1024 && $i <= count($unit); $i++){
$size = $size/1024;
}

return round($size, $decimals).' '.$unit[$i];
}

// function  format bytes2
function formatBytes2($size, $decimals = 0){
$unit = array(
'0' => 'Byte',
'1' => 'KB',
'2' => 'MB',
'3' => 'GB',
'4' => 'TB',
'5' => 'PB',
'6' => 'EB',
'7' => 'ZB',
'8' => 'YB'
);

for($i = 0; $size >= 1000 && $i <= count($unit); $i++){
$size = $size/1000;
}

return round($size, $decimals).''.$unit[$i];
}


// function  format bites
function formatBites($size, $decimals = 0){
$unit = array(
'0' => 'bps',
'1' => 'kbps',
'2' => 'Mbps',
'3' => 'Gbps',
'4' => 'Tbps',
'5' => 'Pbps',
'6' => 'Ebps',
'7' => 'Zbps',
'8' => 'Ybps'
);

for($i = 0; $size >= 1000 && $i <= count($unit); $i++){
$size = $size/1000;
}

return round($size, $decimals).' '.$unit[$i];
}
?>