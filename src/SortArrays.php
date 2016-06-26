<?php

namespace Donquixote\Stable;

use Donquixote\Stable\Util\UtilBase;

final class SortArrays extends UtilBase {

  /**
   * @param array[] $items_unsorted
   * @param string|int $weight_key
   * @param int $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightKey_keysByWeight(array &$items_unsorted, $weight_key, $sort_flags = null) {

    $keys_by_weight = [];
    foreach ($items_unsorted as $k => $item) {
      if (isset($item[$weight_key])) {
        $keys_by_weight[(string)$item[$weight_key]][] = $k;
      }
      else {
        $keys_by_weight[0][] = $k;
      }
    }

    ksort($keys_by_weight, $sort_flags);

    $items_sorted = [];
    foreach ($keys_by_weight as $weight => $keys) {
      foreach ($keys as $k) {
        $items_sorted[$k] = $items_unsorted[$k];
      }
    }

    return $items_sorted;
  }

  /**
   * @param array[] $items_unsorted
   * @param string|int $weight_key
   * @param int $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightKey_itemsByWeight(array &$items_unsorted, $weight_key, $sort_flags = null) {

    $items_by_weight = [];
    foreach ($items_unsorted as $k => $item) {
      if (isset($item[$weight_key])) {
        $items_by_weight[(string)$item[$weight_key]][$k] = $item;
      }
      else {
        $items_by_weight[0][$k] = $item;
      }
    }

    ksort($items_by_weight, $sort_flags);

    $items_sorted = [];
    foreach ($items_by_weight as $weight => $items_in_group) {
      $items_sorted += $items_in_group;
    }

    return $items_sorted;
  }

  /**
   * @param array[] $items_unsorted
   * @param string|int $weight_key
   * @param int $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightKey_weightWithFraction(array &$items_unsorted, $weight_key, $sort_flags = null) {

    $weights_by_key = [];
    $step = 0.01 / count($items_unsorted);
    $fraction = 0;
    foreach ($items_unsorted as $k => $item) {
      $weights_by_key[$k] = isset($item[$weight_key])
        ? $item[$weight_key] + $fraction
        : $fraction;
      $fraction += $step;
    }

    asort($weights_by_key, $sort_flags);

    $items_sorted = [];
    foreach ($weights_by_key as $k => $weight) {
      $items_sorted[$k] = $items_unsorted[$k];
    }

    return $items_sorted;
  }

}
