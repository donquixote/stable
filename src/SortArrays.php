<?php

namespace Donquixote\Stable;

use Donquixote\Stable\Util\UtilBase;

final class SortArrays extends UtilBase {

  /**
   * @param int|null $sort_flags
   *
   * @return int|string
   */
  public static function sortFlagsGetNeutralValue($sort_flags = null) {
    // @todo Support more cases.
    if ($sort_flags === SORT_STRING) {
      return '';
    }
    else {
      return 0;
    }
  }

  /**
   * @param array[] $items_unsorted
   * @param string|int $weight_key
   * @param int $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightKey_keysByWeight(array $items_unsorted, $weight_key, $sort_flags = null) {

    $neutral_value = self::sortFlagsGetNeutralValue($sort_flags);

    $keys_by_weight = [];
    foreach ($items_unsorted as $k => $item) {
      if (isset($item[$weight_key])) {
        $keys_by_weight[(string)$item[$weight_key]][] = $k;
      }
      else {
        $keys_by_weight[$neutral_value][] = $k;
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
  public static function sortByWeightKey_itemsByWeight(array $items_unsorted, $weight_key, $sort_flags = null) {

    $neutral_value = self::sortFlagsGetNeutralValue($sort_flags);

    $items_by_weight = [];
    foreach ($items_unsorted as $k => $item) {
      if (isset($item[$weight_key])) {
        $items_by_weight[(string)$item[$weight_key]][$k] = $item;
      }
      else {
        $items_by_weight[$neutral_value][$k] = $item;
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
  public static function sortByWeightKey_weightWithFraction(array $items_unsorted, $weight_key, $sort_flags = null) {

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

  /**
   * @param array[] $items_unsorted
   * @param string|int $weight_key
   * @param int $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightKey_arrayMultisort(array $items_unsorted, $weight_key, $sort_flags = null) {

    $neutral_value = self::sortFlagsGetNeutralValue($sort_flags);

    $weights_by_key = [];
    foreach ($items_unsorted as $k => $item) {
      $weights_by_key[$k] = isset($item[$weight_key])
        ? $item[$weight_key]
        : $neutral_value;
    }

    $keys = array_keys($items_unsorted);
    $range = range(1, count($items_unsorted));
    array_multisort($weights_by_key, SORT_ASC, $sort_flags, $range, SORT_ASC, $keys);

    $items_sorted = [];
    foreach ($keys as $k) {
      $items_sorted[$k] = $items_unsorted[$k];
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
  public static function sortByWeightKey_backdrop(array $items_unsorted, $weight_key, $sort_flags = null) {
    self::backdrop_sort($items_unsorted, array('weight' => $sort_flags));
    return $items_unsorted;
  }

  /**
   * Sort an array based on user-provided keys within that array.
   *
   * @param array $array
   *   The input array to be sorted.
   * @param array $keys
   *   An array of keys on which to be sort. Each key of the $keys array is the
   *   key by which sorting will be done. Each value of the $keys array must be
   *   one of the PHP constants sorting, either SORT_NUMERIC or SORT_STRING.
   *   If an unindexed array is passed in, each value will be assumed to be the
   *   key by which sorting will be done, and all comparisons will be done as
   *   though SORT_NUMERIC were passed in for each key.
   */
  private static function backdrop_sort(array &$array, array $keys = array('weight')) {
    // Ensure all keys have a sort value.
    $new_keys = array();
    foreach ($keys as $index => $sort) {
      if (is_string($sort) && is_int($index)) {
        $new_keys[$sort] = SORT_NUMERIC;
      }
      else {
        if ($sort === SORT_NUMERIC || $sort === SORT_STRING) {
          $new_keys[$index] = $sort;
        }
        else {
          // Fallback behavior for unexpected values. Untranslated to allow this
          // function to be used anywhere within Backdrop.
          $new_keys[$index] = SORT_NUMERIC;
          trigger_error('backdrop_sort() expects the second parameter to be an array keyed by strings and each value of the array to be either SORT_NUMERIC or SORT_STRING.', E_USER_WARNING);
        }
      }
    }
    $keys = $new_keys;
    // If sorting on a single value, optimize the sorting to sort only on that
    // specific key without the overhead of recursive handling.
    if (count($keys) === 1) {
      $key = key($keys);
      $key_sort = reset($keys);
      if ($key_sort === SORT_STRING) {
        uasort($array, function($a, $b) use ($key) {
          if (!is_array($a) || !is_array($b)) {
            return 0;
          }
          if (!isset($a[$key])) {
            $a[$key] = '';
          }
          if (!isset($b[$key])) {
            $b[$key] = '';
          }
          return strnatcasecmp($a[$key], $b[$key]);
        });
      }
      else {
        uasort($array, function($a, $b) use ($key) {
          if (!is_array($a) || !is_array($b)) {
            return 0;
          }
          if (!isset($a[$key])) {
            $a[$key] = 0;
          }
          if (!isset($b[$key])) {
            $b[$key] = 0;
          }
          if ($a[$key] != $b[$key]) {
            return $a[$key] < $b[$key] ? -1 : 1;
          }
        });
      }
    }
    // If doing a multiple-key comparison, use a recursive callback.
    else {
      $keys_map = array_keys($keys);
      $recursive_callback = function ($a, $b, $key_index = 0) use ($keys, $keys_map, &$recursive_callback) {
        $key = $keys_map[$key_index];
        if (!is_array($a) || !is_array($b)) {
          return 0;
        }
        if (!isset($a[$key])) {
          $a[$key] = 0;
        }
        if (!isset($b[$key])) {
          $b[$key] = 0;
        }
        if ($a[$key] == $b[$key]) {
          // Sort on the next key if one exists.
          if (isset($keys_map[$key_index + 1])) {
            return $recursive_callback($a, $b, $key_index + 1);
          }
        }
        else {
          if ($keys[$key] === SORT_STRING) {
            return strnatcasecmp($a[$key], $b[$key]);
          }
          else {
            return ($a[$key] < $b[$key]) ? -1 : 1;
          }
        }
      };
      uasort($array, $recursive_callback);
    }
  }

}
