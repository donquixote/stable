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
  $items_unsorted[uniqid('', false)] = $item;
}

$ids = [];
for ($i = 0; $i < 1000; ++$i) {
  $ids[] = uniqid('', false);
}

$weight_callback = function($item) {
  return isset($item['x']) ? $item['x'] : '';
};

$x = [];
$x[] = SortArrays::sortByWeightKey_itemsByWeight($items_unsorted, 'x', SORT_NATURAL);
$x[] = SortArrays::sortByWeightKey_itemsByWeightStrtolower($items_unsorted, 'x', SORT_NATURAL);
$x[] = SortArrays::sortByWeightKey_itemsByWeightMbStrtolower($items_unsorted, 'x', SORT_NATURAL);
$x[] = SortArrays::sortByWeightKey_arrayMultisort($items_unsorted, 'x', SORT_NATURAL);
$x[] = SortArrays::sortByWeightCallback_arrayMultisort($items_unsorted, 'item_get_weight', SORT_NATURAL);
$x[] = SortArrays::sortByWeightCallback_arrayMultisort($items_unsorted, $weight_callback, SORT_NATURAL);
$x[] = SortArrays::sortByWeightsCallback_arrayMultisort($items_unsorted, 'items_get_weights', SORT_NATURAL);
$x[] = SortArrays::sortByWeightKey_schwartzian($items_unsorted, 'x');
assert($x[0] === $x[1]);
assert($x[0] === $x[2]);
assert($x[0] === $x[3]);
assert($x[0] === $x[4]);
assert($x[0] === $x[5]);
assert($x[0] === $x[6]);
// The schwartzian does not use SORT_NATURAL, so it will not produce the same order.
assert($x[0] == $x[7]);

function item_get_weight($item) {
  return isset($item['x']) ? $item['x'] : '';
}

function items_get_weights(array $items) {
  $weights = [];
  foreach ($items as $k => $item) {
    $weights[$k] = isset($item['x']) ? $item['x'] : '';
  }
  return $weights;
}

$dtss = [];
$t0 = microtime(true);

for ($j = 0; $j < 100; ++$j) {
  for ($i = 0; $i < 100; ++$i) {
    $items_sorted = SortArrays::sortByWeightKey_itemsByWeight($items_unsorted, 'x', SORT_NATURAL | SORT_FLAG_CASE);
  }

  $t0 = ($dtss['itemsByWeight (FLAWED!!)'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < 100; ++$i) {
    $items_sorted = SortArrays::sortByWeightKey_itemsByWeightStrtolower($items_unsorted, 'x', SORT_NATURAL);
  }

  $t0 = ($dtss['itemsByWeightStrtolower'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < 100; ++$i) {
    $items_sorted = SortArrays::sortByWeightKey_itemsByWeightMbStrtolower($items_unsorted, 'x', SORT_NATURAL);
  }

  $t0 = ($dtss['itemsByWeightMbStrtolower'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < 100; ++$i) {
    $items_sorted = SortArrays::sortByWeightKey_arrayMultisort($items_unsorted, 'x', SORT_NATURAL | SORT_FLAG_CASE);
  }

  $t0 = ($dtss['arrayMultisort'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < 100; ++$i) {
    $items_sorted = SortArrays::sortByWeightCallback_arrayMultisort($items_unsorted, 'item_get_weight', SORT_NATURAL);
  }

  $t0 = ($dtss['weightCallback function'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < 100; ++$i) {
    $items_sorted = SortArrays::sortByWeightCallback_arrayMultisort($items_unsorted, $weight_callback, SORT_NATURAL);
  }

  $t0 = ($dtss['weightCallback closure'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < 100; ++$i) {
    $items_sorted = SortArrays::sortByWeightsCallback_arrayMultisort($items_unsorted, 'items_get_weights', SORT_NATURAL);
  }

  $t0 = ($dtss['weightsCallback function'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < 100; ++$i) {
    $items_sorted = SortArrays::sortByWeightKey_schwartzian($items_unsorted, 'x', SORT_NATURAL);
  }

  $t0 = ($dtss['schwartzian (FLAWED!!)'][] = microtime(true) - $t0) + $t0;
}

BenchUtil::printPercentilesTable($dtss, 10000);
