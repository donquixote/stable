<?php

use Donquixote\Stable\SortArrays;
use Donquixote\Stable\Util\BenchUtil;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$itemss_unsorted = [];
for ($j = 0; $j < 10; ++$j) {
  for ($i = 0; $i < 1000; ++$i) {
    $item = [
      'x' => uniqid('', false),
      'y' => uniqid('', false),
    ];
    $weight = mt_rand(-30, 30);
    if ($weight % 3 === 0) {
      $item['weight'] = $weight / 3;
    }
    $itemss_unsorted[$j][uniqid('', false)] = $item;
  }
}

$x = [];
$x[] = SortArrays::sortByWeightKeys_itemsByWeight($itemss_unsorted[0], ['weight' => SORT_NUMERIC, 'x' => SORT_STRING]);
$x[] = SortArrays::sortByWeightKeys_multisort($itemss_unsorted[0], ['weight' => SORT_NUMERIC, 'x' => SORT_STRING]);
$x[] = SortArrays::sortByWeightKeys_multisort_columns($itemss_unsorted[0], ['weight' => SORT_NUMERIC, 'x' => SORT_STRING]);
$x[] = SortArrays::sortByWeightKeys_multisort_columns1($itemss_unsorted[0], ['weight' => SORT_NUMERIC, 'x' => SORT_STRING]);
$x[] = SortArrays::sortByWeightKeys_multisort_columns1a($itemss_unsorted[0], ['weight' => SORT_NUMERIC, 'x' => SORT_STRING]);
$x[] = SortArrays::sortByWeightKeys_multisort_columns2($itemss_unsorted[0], ['weight' => SORT_NUMERIC, 'x' => SORT_STRING]);
$x[] = SortArrays::sortByWeightKeys_multisort_isArray($itemss_unsorted[0], ['weight' => SORT_NUMERIC, 'x' => SORT_STRING]);
$x[] = SortArrays::sortByWeightKeys_multisort_isArray_columns($itemss_unsorted[0], ['weight' => SORT_NUMERIC, 'x' => SORT_STRING]);
$x[] = SortArrays::sortByWeightKeys_multisort_isArray_columns_prepared($itemss_unsorted[0], ['weight' => SORT_NUMERIC, 'x' => SORT_STRING]);
$x[] = SortArrays::sortByWeightKeys_multisort_isArray_columns_prepared2($itemss_unsorted[0], ['weight' => SORT_NUMERIC, 'x' => SORT_STRING]);
$x[] = SortArrays::sortByWeightKeys_multisort_isArray_columns_prepared3($itemss_unsorted[0], ['weight' => SORT_NUMERIC, 'x' => SORT_STRING]);
$x[] = SortArrays::sortByWeightKeys_multisort_isArray_columns_prepared4($itemss_unsorted[0], ['weight' => SORT_NUMERIC, 'x' => SORT_STRING]);
$x[] = SortArrays::sortByWeightKeys_multisort_isArray_columns_prepared5($itemss_unsorted[0], ['weight' => SORT_NUMERIC, 'x' => SORT_STRING]);
$x[] = SortArrays::sortByWeightKeys_multisort_isArray_columns_prepared6($itemss_unsorted[0], ['weight' => SORT_NUMERIC, 'x' => SORT_STRING]);
$x[] = SortArrays::sortByWeightKeys_multisort_isArray_columns_prepared7($itemss_unsorted[0], ['weight' => SORT_NUMERIC, 'x' => SORT_STRING]);
for ($i = 1; $i < count($x); ++$i) {
  assert($x[0] === $x[$i], "Mismatch at $i.");
}

function itemGetWeights(array $item) {
  return [
    isset($item['weight']) ? $item['weight'] : 0,
    isset($item['x']) ? $item['x'] : '',
  ];
}

$n_repeat = 2;

$dtss = [];
$t0 = microtime(true);

for ($j = 0; $j < 100; ++$j) {
  $items_unsorted = $itemss_unsorted[$j % 10];

  for ($i = 0; $i < $n_repeat; ++$i) {
    $items_sorted = SortArrays::sortByWeightKeys_itemsByWeight($items_unsorted, ['weight' => SORT_NUMERIC, 'x' => SORT_STRING, 'y' => SORT_NUMERIC, 'z' => SORT_NUMERIC]);
  }

  $t0 = ($dtss['itemsByWeight'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < $n_repeat; ++$i) {
    $items_sorted = SortArrays::sortByWeightKeys_multisort($items_unsorted, ['weight' => SORT_NUMERIC, 'x' => SORT_STRING, 'y' => SORT_NUMERIC, 'z' => SORT_NUMERIC]);
  }

  $t0 = ($dtss['multisort'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < $n_repeat; ++$i) {
    $items_sorted = SortArrays::sortByWeightKeys_multisort_columns($items_unsorted, ['weight' => SORT_NUMERIC, 'x' => SORT_STRING, 'y' => SORT_NUMERIC, 'z' => SORT_NUMERIC]);
  }

  $t0 = ($dtss['multisort_columns'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < $n_repeat; ++$i) {
    $items_sorted = SortArrays::sortByWeightKeys_multisort_columns1($items_unsorted, ['weight' => SORT_NUMERIC, 'x' => SORT_STRING, 'y' => SORT_NUMERIC, 'z' => SORT_NUMERIC]);
  }

  $t0 = ($dtss['multisort_columns1'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < $n_repeat; ++$i) {
    $items_sorted = SortArrays::sortByWeightKeys_multisort_columns1a($items_unsorted, ['weight' => SORT_NUMERIC, 'x' => SORT_STRING, 'y' => SORT_NUMERIC, 'z' => SORT_NUMERIC]);
  }

  $t0 = ($dtss['multisort_columns1a'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < $n_repeat; ++$i) {
    $items_sorted = SortArrays::sortByWeightKeys_multisort_columns2($items_unsorted, ['weight' => SORT_NUMERIC, 'x' => SORT_STRING, 'y' => SORT_NUMERIC, 'z' => SORT_NUMERIC]);
  }

  $t0 = ($dtss['multisort_columns2'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < $n_repeat; ++$i) {
    $items_sorted = SortArrays::sortByWeightKeys_multisort_isArray($items_unsorted, ['weight' => SORT_NUMERIC, 'x' => SORT_STRING, 'y' => SORT_NUMERIC, 'z' => SORT_NUMERIC]);
  }

  $t0 = ($dtss['multisort_isArray'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < $n_repeat; ++$i) {
    $items_sorted = SortArrays::sortByWeightKeys_multisort_isArray_columns($items_unsorted, ['weight' => SORT_NUMERIC, 'x' => SORT_STRING, 'y' => SORT_NUMERIC, 'z' => SORT_NUMERIC]);
  }

  $t0 = ($dtss['multisort_isArray_columns'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < $n_repeat; ++$i) {
    $items_sorted = SortArrays::sortByWeightKeys_multisort_isArray_columns_prepared($items_unsorted, ['weight' => SORT_NUMERIC, 'x' => SORT_STRING, 'y' => SORT_NUMERIC, 'z' => SORT_NUMERIC]);
  }

  $t0 = ($dtss['multisort_isArray_columns_prepared'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < $n_repeat; ++$i) {
    $items_sorted = SortArrays::sortByWeightKeys_multisort_isArray_columns_prepared2($items_unsorted, ['weight' => SORT_NUMERIC, 'x' => SORT_STRING, 'y' => SORT_NUMERIC, 'z' => SORT_NUMERIC]);
  }

  $t0 = ($dtss['multisort_isArray_columns_prepared2'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < $n_repeat; ++$i) {
    $items_sorted = SortArrays::sortByWeightKeys_multisort_isArray_columns_prepared3($items_unsorted, ['weight' => SORT_NUMERIC, 'x' => SORT_STRING, 'y' => SORT_NUMERIC, 'z' => SORT_NUMERIC]);
  }

  $t0 = ($dtss['multisort_isArray_columns_prepared3'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < $n_repeat; ++$i) {
    $items_sorted = SortArrays::sortByWeightKeys_multisort_isArray_columns_prepared4($items_unsorted, ['weight' => SORT_NUMERIC, 'x' => SORT_STRING, 'y' => SORT_NUMERIC, 'z' => SORT_NUMERIC]);
  }

  $t0 = ($dtss['multisort_isArray_columns_prepared4'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < $n_repeat; ++$i) {
    $items_sorted = SortArrays::sortByWeightKeys_multisort_isArray_columns_prepared5($items_unsorted, ['weight' => SORT_NUMERIC, 'x' => SORT_STRING, 'y' => SORT_NUMERIC, 'z' => SORT_NUMERIC]);
  }

  $t0 = ($dtss['multisort_isArray_columns_prepared5'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < $n_repeat; ++$i) {
    $items_sorted = SortArrays::sortByWeightKeys_multisort_isArray_columns_prepared6($items_unsorted, ['weight' => SORT_NUMERIC, 'x' => SORT_STRING, 'y' => SORT_NUMERIC, 'z' => SORT_NUMERIC]);
  }

  $t0 = ($dtss['multisort_isArray_columns_prepared6'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < $n_repeat; ++$i) {
    $items_sorted = SortArrays::sortByWeightKeys_multisort_isArray_columns_prepared7($items_unsorted, ['weight' => SORT_NUMERIC, 'x' => SORT_STRING, 'y' => SORT_NUMERIC, 'z' => SORT_NUMERIC]);
  }

  $t0 = ($dtss['multisort_isArray_columns_prepared7'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < $n_repeat; ++$i) {
    $items_sorted = SortArrays::sortByWeightsCallback_callUserFunc($items_unsorted, 'itemGetWeights', ['weight' => SORT_NUMERIC, 'x' => SORT_STRING, 'y' => SORT_NUMERIC, 'z' => SORT_NUMERIC]);
  }

  $t0 = ($dtss['sortByWeightsCallback_callUserFunc'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < $n_repeat; ++$i) {
    $items_sorted = SortArrays::sortByWeightsCallback_arrayMap($items_unsorted, 'itemGetWeights', ['weight' => SORT_NUMERIC, 'x' => SORT_STRING, 'y' => SORT_NUMERIC, 'z' => SORT_NUMERIC]);
  }

  $t0 = ($dtss['sortByWeightsCallback_arrayMap'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < $n_repeat; ++$i) {
    $items_sorted = SortArrays::sortByWeightsCallback_rows($items_unsorted, 'itemGetWeights', ['weight' => SORT_NUMERIC, 'x' => SORT_STRING, 'y' => SORT_NUMERIC, 'z' => SORT_NUMERIC]);
  }

  $t0 = ($dtss['sortByWeightsCallback_rows'][] = microtime(true) - $t0) + $t0;
}

BenchUtil::printPercentilesTable($dtss, 100000, [4, 10, 25, 50, 75, 90, 96]);
