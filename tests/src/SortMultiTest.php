<?php

namespace Donquixote\Stable\Tests;

use Donquixote\Stable\Sort\Sort_Multi;
use Donquixote\Stable\Sort\SortInterface;

class SortMultiTest extends \PHPUnit_Framework_TestCase {

  /**
   * @return mixed[][]
   *   Format: $[$dataset_name] = [$items_unsorted, $items_sorted_expected]
   */
  public function providerSort() {

    $datasets = [
      'zero' => [
        [],
        [],
      ],
      'one' => [
        [
          0 => ['pos 0', 'weight' => -10],
        ],
        [
          0 => ['pos 0', 'weight' => -10],
        ],
      ],
      'multiple' => [
        [
          0 => ['pos 0', 'weight' => -10],
          1 => ['pos 1', 'b'],
          2 => ['pos 2', 'weight' => 2],
          3 => ['pos 3', 'a'],
          4 => ['pos 4', 'weight' => 0.2],
          5 => ['pos 5', 'weight' => 0.1],
          8 => ['pos 8', 'weight' => 0],
          'x' => ['x', 'weight' => 0],
          'y' => ['y', 'weight' => 0],
          'z' => ['z', 'weight' => 2],
          10 => ['pos 10', 'weight' => -5],
          11 => ['pos 11', 'weight' => -7],
        ],
        [
          0 => ['pos 0', 'weight' => -10],
          11 => ['pos 11', 'weight' => -7],
          10 => ['pos 10', 'weight' => -5],
          8 => ['pos 8', 'weight' => 0],
          'x' => ['x', 'weight' => 0],
          'y' => ['y', 'weight' => 0],
          3 => ['pos 3', 'a'],
          1 => ['pos 1', 'b'],
          5 => ['pos 5', 'weight' => 0.1],
          4 => ['pos 4', 'weight' => 0.2],
          2 => ['pos 2', 'weight' => 2],
          'z' => ['z', 'weight' => 2],
        ],
      ],
    ];

    $sorts = [];

    $sorts['byWeightKey'] = Sort_Multi::begin()
      ->byWeightKey('weight', SORT_NUMERIC)
      ->byWeightKey(1, SORT_STRING);

    $sorts['byWeightCallback'] = Sort_Multi::begin()
      ->byWeightCallback(
        function(array $item) {
          return isset($item['weight']) ? $item['weight'] : 0;
        },
        SORT_NUMERIC)
      ->byWeightCallback(
        function(array $item) {
          return isset($item[1]) ? $item[1] : 0;
        },
        SORT_STRING);

    $datasets_combined = [];
    foreach ($sorts as $sort_name => $sort) {
      foreach ($datasets as $dataset_name => $dataset) {
        $dataset[] = $sort;
        $datasets_combined[$sort_name . ': ' . $dataset_name] = $dataset;
      }
    }

    return $datasets_combined;
  }

  /**
   * @param array $items_unsorted
   * @param array $items_sorted_expected
   * @param \Donquixote\Stable\Sort\SortInterface $sort
   *
   * @covers ::byWeightKey
   * @dataProvider providerSort
   */
  public function testByWeightKey(array $items_unsorted, array $items_sorted_expected, SortInterface $sort) {

    static::assertSameArrays(
      $items_sorted_expected,
      $sort->itemsGetSorted($items_unsorted));

    static::assertSameArrays(
      array_values($items_sorted_expected),
      $sort->itemsGetSorted($items_unsorted, false));

    $items = $items_unsorted;
    $sort->sort($items);
    static::assertSameArrays($items_sorted_expected, $items);

    $items = $items_unsorted;
    $sort->sort($items, false);
    static::assertSameArrays(array_values($items_sorted_expected), $items);
  }

  /**
   * @param array[] $expected
   * @param array[] $actual
   */
  private static function assertSameArrays(array $expected, array $actual) {
    static::assertEquals($expected, $actual);
    static::assertEquals(self::exportArrayOrder($expected), self::exportArrayOrder($actual));
    static::assertEquals(array_keys($expected), array_keys($actual));
    static::assertSame($expected, $actual);
  }

  /**
   * @param array[] $items
   *
   * @return string
   */
  private static function exportArrayOrder(array $items) {
    $lines = [];
    foreach ($items as $k => $item) {
      $lines[] = json_encode($k) . ': ' . json_encode($item);
    }
    return implode("\n", $lines);
  }

}
