<?php

use Donquixote\Stable\SortArrays;
use Donquixote\Stable\Util\BenchUtil;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$items_unsorted = [];
for ($i = 0; $i < 100; ++$i) {
  $item = [
    'x' => uniqid('', false),
    'y' => uniqid('', false),
  ];
  $weight = mt_rand(-30, 30);
  if ($weight % 3 === 0) {
    $item['weight'] = $weight / 3;
  }
  else {
    $item['weight'] = 0;
  }
  $items_unsorted[uniqid('', false)] = $item;
}

$x = [];
$x[] = SortArrays::sortByWeightKey_itemsByWeight($items_unsorted, 'weight', SORT_NUMERIC);
$x[] = SortArrays::sortByWeightKey_itemsByWeight_isArray($items_unsorted, 'weight', SORT_NUMERIC);
$x[] = SortArrays::sortByWeightKey_itemsByWeight_arrayKeyExists($items_unsorted, 'weight', SORT_NUMERIC);
$x[] = SortArrays::sortByWeightKey_itemsByWeight_knownKey($items_unsorted, 'weight', SORT_NUMERIC);
assert($x[0] === $x[1]);
assert($x[0] === $x[2]);

$dtss = [];
$t0 = microtime(true);

for ($j = 0; $j < 100; ++$j) {

  for ($i = 0; $i < 100; ++$i) {
    $items_sorted = SortArrays::sortByWeightKey_itemsByWeight_knownKey($items_unsorted, 'weight', SORT_NUMERIC);
  }

  $t0 = ($dtss['itemsByWeight_knownKey'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < 100; ++$i) {
    $items_sorted = SortArrays::sortByWeightKey_itemsByWeight($items_unsorted, 'weight', SORT_NUMERIC);
  }

  $t0 = ($dtss['itemsByWeight'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < 100; ++$i) {
    $items_sorted = SortArrays::sortByWeightKey_itemsByWeight_isArray($items_unsorted, 'weight', SORT_NUMERIC);
  }

  $t0 = ($dtss['itemsByWeight_isArray'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < 100; ++$i) {
    $items_sorted = SortArrays::sortByWeightKey_itemsByWeight_arrayKeyExists($items_unsorted, 'weight', SORT_NUMERIC);
  }

  $t0 = ($dtss['itemsByWeight_arrayKeyExists'][] = microtime(true) - $t0) + $t0;
}

BenchUtil::printPercentilesTable($dtss, 10000);
