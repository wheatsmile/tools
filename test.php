<?php
$lines = file('./query.csv');
$i = 0;
$lv1 = [];
$lv2 = [];
$lv3 = [];
$postalMap = [];
foreach($lines as $line) {
    $i++;
    if($i == 1) {
        continue;
    }
    $line = trim($line);
    list($id, $level, $levelName, $name, $nameEn, $parentId, $postal, $foo, $bar) = explode(',', $line);
    if($id=='' || $level == '' || $parentId === '' || $postal=='') {
        continue;
    }
    if($level == 1) {
        $lv1[$id] = $nameEn;
        $postalMap[$postal] = $id;
    } elseif ($level == 2) {
        $lv2[$id] = $parentId;
        $postalMap[$postal] = $parentId;
    } elseif ($level == 3) {
        $lv3[$postal] = $parentId;
    }   
}

foreach($lv3 as $postal => $lv2Id) {
    $postalMap[$postal] = $lv2[$lv2Id];
}


foreach($postalMap as $postal => $id) {
    $postalMap[$postal] = $lv1[$id];
}

$lines = file('./result.csv');
$j = 0;
$reuslt = [];
foreach($lines as $line) {
    $j++;
    if($j == 1) continue;
    $line = trim($line);
    list($postal, $number) = explode(",", $line);
    $result[$postalMap[$postal]] += $number; 
}
var_dump($result);die();
