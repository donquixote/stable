<?php

use Donquixote\Stable\SortArrays;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$items_unsorted = [];
for ($i = 0; $i < 1000; ++$i) {
  $item = [
    'x' => uniqid('', false),
    'y' => uniqid('', false),
  ];
  $weight = mt_rand(-30, 30);
  if ($weight % 3 === 0) {
    $item['weight'] = $weight / 3;
  }
  $items_unsorted[uniqid('', false)] = $item;
}

$x0 = SortArrays::sortByWeightKey_itemsByWeight($items_unsorted, 'weight', SORT_NUMERIC);
$x1 = SortArrays::sortByWeightKey_keysByWeight($items_unsorted, 'weight', SORT_NUMERIC);
$x2 = SortArrays::sortByWeightKey_weightWithFraction($items_unsorted, 'weight', SORT_NUMERIC);
assert($x0 === $x1);
assert($x0 === $x2);

$dts = [];
$t0 = microtime(true);

for ($j = 0; $j < 4; ++$j) {
  for ($i = 0; $i < 1000; ++$i) {
    $items_sorted = SortArrays::sortByWeightKey_itemsByWeight($items_unsorted, 'weight', SORT_NUMERIC);
  }

  $t0 = ($dts['itemsByWeight'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < 1000; ++$i) {
    $items_sorted = SortArrays::sortByWeightKey_keysByWeight($items_unsorted, 'weight', SORT_NUMERIC);
  }

  $t0 = ($dts['keysByWeight'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < 1000; ++$i) {
    $items_sorted = SortArrays::sortByWeightKey_weightWithFraction($items_unsorted, 'weight', SORT_NUMERIC);
  }

  $t0 = ($dts['weightWithFraction'][] = microtime(true) - $t0) + $t0;
}

print_r($dts);
