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
  $items_unsorted[uniqid('', false)] = $item;
}

$x0 = SortArrays::sortByWeightKey_itemsByWeight($items_unsorted, 'weight', SORT_NUMERIC);
$x0 = SortArrays::sortByWeightKey_itemsByWeight_isArray($items_unsorted, 'weight', SORT_NUMERIC);
$x1 = SortArrays::sortByWeightKey_keysByWeight($items_unsorted, 'weight', SORT_NUMERIC);
$x2 = SortArrays::sortByWeightKey_weightWithFraction($items_unsorted, 'weight', SORT_NUMERIC);
$xm = SortArrays::sortByWeightKey_arrayMultisort($items_unsorted, 'weight', SORT_NUMERIC);
$x3 = SortArrays::sortByWeightKey_backdrop($items_unsorted, 'weight', SORT_NUMERIC);
assert($x0 === $x1);
assert($x0 === $x2);
assert($x0 === $xm);
// This is not the same, because the backdrop sort is not stable.
# assert($x0 === $x3);
assert($x0 == $x3);

$dtss = [];
$t0 = microtime(true);

for ($j = 0; $j < 100; ++$j) {

  for ($i = 0; $i < 100; ++$i) {
    $items_sorted = SortArrays::sortByWeightKey_itemsByWeight_isArray($items_unsorted, 'weight', SORT_NUMERIC);
  }

  $t0 = ($dtss['itemsByWeight_isArray'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < 100; ++$i) {
    $items_sorted = SortArrays::sortByWeightKey_itemsByWeight($items_unsorted, 'weight', SORT_NUMERIC);
  }

  $t0 = ($dtss['itemsByWeight'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < 100; ++$i) {
    $items_sorted = SortArrays::sortByWeightKey_keysByWeight($items_unsorted, 'weight', SORT_NUMERIC);
  }

  $t0 = ($dtss['keysByWeight'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < 100; ++$i) {
    $items_sorted = SortArrays::sortByWeightKey_weightWithFraction($items_unsorted, 'weight', SORT_NUMERIC);
  }

  $t0 = ($dtss['weightWithFraction'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < 100; ++$i) {
    $items_sorted = SortArrays::sortByWeightKey_arrayMultisort($items_unsorted, 'weight', SORT_NUMERIC);
  }

  $t0 = ($dtss['arrayMultisort'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < 100; ++$i) {
    $items_sorted = SortArrays::sortByWeightKey_backdrop($items_unsorted, 'weight', SORT_NUMERIC);
  }

  $t0 = ($dtss['backdrop (NOT STABLE!)'][] = microtime(true) - $t0) + $t0;
}

BenchUtil::printPercentilesTable($dtss, 10000);
