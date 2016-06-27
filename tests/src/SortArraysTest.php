<?php

namespace Donquixote\Stable\Tests;

use Donquixote\Stable\SortArrays;

class SortArraysTest extends \PHPUnit_Framework_TestCase {

  public function testSortFlagsGetNeutralValue() {
    static::assertSame(0, SortArrays::sortFlagsGetNeutralValue(SORT_NUMERIC));
    static::assertSame('', SortArrays::sortFlagsGetNeutralValue(SORT_STRING));
  }

  public function testSortByWeight() {

    $items_unsorted = [
      0 => ['pos 0', 'weight' => -10],
      1 => ['pos 1'],
      2 => ['pos 2', 'weight' => 2],
      3 => ['pos 3'],
      4 => ['pos 4', 'weight' => 0.2],
      5 => ['pos 5', 'weight' => 0.1],
      8 => ['pos 8', 'weight' => 0],
      'x' => ['x', 'weight' => 0],
      'y' => ['y', 'weight' => 0],
      'z' => ['z', 'weight' => 2],
      10 => ['pos 10', 'weight' => -5],
      11 => ['pos 11', 'weight' => -7],
    ];

    $items_sorted_expected = [
      0 => ['pos 0', 'weight' => -10],
      11 => ['pos 11', 'weight' => -7],
      10 => ['pos 10', 'weight' => -5],
      1 => ['pos 1'],
      3 => ['pos 3'],
      8 => ['pos 8', 'weight' => 0],
      'x' => ['x', 'weight' => 0],
      'y' => ['y', 'weight' => 0],
      5 => ['pos 5', 'weight' => 0.1],
      4 => ['pos 4', 'weight' => 0.2],
      2 => ['pos 2', 'weight' => 2],
      'z' => ['z', 'weight' => 2],
    ];

    static::assertEqualArrays(
      $items_sorted_expected,
      SortArrays::sortByWeightKey_itemsByWeight($items_unsorted, 'weight', SORT_NUMERIC));

    static::assertEqualArrays(
      $items_sorted_expected,
      SortArrays::sortByWeightKey_keysByWeight($items_unsorted, 'weight', SORT_NUMERIC));

    static::assertEqualArrays(
      $items_sorted_expected,
      SortArrays::sortByWeightKey_weightWithFraction($items_unsorted, 'weight', SORT_NUMERIC));
  }

  public static function testSortByWeightKeys() {

    $items_unsorted = [
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
    ];

    $items_sorted_expected = [
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
    ];

    static::assertEqualArrays(
      $items_sorted_expected,
      SortArrays::sortByWeightKeys_itemsByWeight(
        $items_unsorted,
        [
          'weight' => SORT_NUMERIC,
          1 => SORT_STRING,
        ]));
  }

  /**
   * @param array[] $expected
   * @param array[] $actual
   */
  private static function assertEqualArrays(array $expected, array $actual) {
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
    return implode(
      "\n",
      array_map(
        function(array $item) {
          return $item[0];
        },
        $items));
  }

}
