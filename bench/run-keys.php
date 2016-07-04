<?php

use Donquixote\Stable\SortArrays;
use Donquixote\Stable\Util\BenchUtil;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$itemss_unsorted = [];
for ($j = 0; $j < 10; ++$j) {
  for ($i = 0; $i < 100; ++$i) {
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
assert($x[0] === $x[1]);

$dtss = [];
$t0 = microtime(true);

for ($j = 0; $j < 100; ++$j) {
  $items_unsorted = $itemss_unsorted[$j % 10];

  for ($i = 0; $i < 100; ++$i) {
    $items_sorted = SortArrays::sortByWeightKeys_itemsByWeight($items_unsorted, ['weight' => SORT_NUMERIC, 'x' => SORT_STRING]);
  }

  $t0 = ($dtss['itemsByWeight'][] = microtime(true) - $t0) + $t0;

  for ($i = 0; $i < 100; ++$i) {
    $items_sorted = SortArrays::sortByWeightKeys_multisort($items_unsorted, ['weight' => SORT_NUMERIC, 'x' => SORT_STRING]);
  }

  $t0 = ($dtss['multisort'][] = microtime(true) - $t0) + $t0;
}

BenchUtil::printPercentilesTable($dtss, 10000, [4, 10, 25, 50, 75, 90, 96]);
