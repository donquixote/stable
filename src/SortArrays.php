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
   *
   * @return array[]
   */
  public static function sortByWeightKey_itemsByWeight_floatval(array $items_unsorted, $weight_key) {

    $items_by_weight = [];
    foreach ($items_unsorted as $k => $item) {
      if (isset($item[$weight_key])) {
        /** @noinspection TypesCastingWithFunctionsInspection */
        $items_by_weight[(string)floatval($item[$weight_key])][$k] = $item;
      }
      else {
        $items_by_weight[0][$k] = $item;
      }
    }

    ksort($items_by_weight, SORT_NUMERIC);

    $items_sorted = [];
    foreach ($items_by_weight as $weight => $items_in_group) {
      $items_sorted += $items_in_group;
    }

    return $items_sorted;
  }

  /**
   * @param array[] $items_unsorted
   * @param string|int $weight_key
   *
   * @return array[]
   */
  public static function sortByWeightKey_itemsByWeight_castFloat(array $items_unsorted, $weight_key) {

    $items_by_weight = [];
    foreach ($items_unsorted as $k => $item) {
      if (isset($item[$weight_key])) {
        $items_by_weight[(string)(float)$item[$weight_key]][$k] = $item;
      }
      else {
        $items_by_weight[0][$k] = $item;
      }
    }

    ksort($items_by_weight, SORT_NUMERIC);

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
  public static function sortByWeightKey_itemsByWeight_isArray(array $items_unsorted, $weight_key, $sort_flags = null) {

    $neutral_value = self::sortFlagsGetNeutralValue($sort_flags);

    $items_by_weight = [];
    foreach ($items_unsorted as $k => $item) {
      if (is_array($item) && isset($item[$weight_key])) {
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
  public static function sortByWeightKey_itemsByWeight_arrayKeyExists(array $items_unsorted, $weight_key, $sort_flags = null) {

    $neutral_value = self::sortFlagsGetNeutralValue($sort_flags);

    $items_by_weight = [];
    foreach ($items_unsorted as $k => $item) {
      if (array_key_exists($weight_key, $item)) {
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
  public static function sortByWeightKey_itemsByWeight_knownKey(array $items_unsorted, $weight_key, $sort_flags = null) {

    $items_by_weight = [];
    foreach ($items_unsorted as $k => $item) {
      $items_by_weight[(string)$item[$weight_key]][$k] = $item;
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
  public static function sortByWeightKey_itemsByWeightStrtolower(array $items_unsorted, $weight_key, $sort_flags = null) {

    $neutral_value = self::sortFlagsGetNeutralValue($sort_flags);

    $items_by_weight = [];
    foreach ($items_unsorted as $k => $item) {
      if (isset($item[$weight_key])) {
        $items_by_weight[strtolower($item[$weight_key])][$k] = $item;
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
  public static function sortByWeightKey_itemsByWeightMbStrtolower(array $items_unsorted, $weight_key, $sort_flags = null) {

    $neutral_value = self::sortFlagsGetNeutralValue($sort_flags);

    $items_by_weight = [];
    foreach ($items_unsorted as $k => $item) {
      if (isset($item[$weight_key])) {
        $items_by_weight[mb_strtolower($item[$weight_key])][$k] = $item;
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
   * @param int[] $sort_flags_by_weight_key
   *   Format: $[$weight_key] = $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightKeys_itemsByWeight(array $items_unsorted, array $sort_flags_by_weight_key) {

    $sort_flags = reset($sort_flags_by_weight_key);
    $weight_key = key($sort_flags_by_weight_key);
    unset($sort_flags_by_weight_key[$weight_key]);
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
    if ([] === $sort_flags_by_weight_key) {
      foreach ($items_by_weight as $weight => $items_in_group) {
        $items_sorted += $items_in_group;
      }
    }
    else {
      foreach ($items_by_weight as $weight => $items_in_group) {
        if (1 !== count($items_in_group)) {
          $items_sorted += self::sortByWeightKeys_itemsByWeight($items_in_group, $sort_flags_by_weight_key);
        }
        else {
          $items_sorted += $items_in_group;
        }
      }
    }

    return $items_sorted;
  }

  /**
   * @param array[] $items_unsorted
   * @param int[] $sort_flags_by_weight_key
   *   Format: $[$weight_key] = $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightKeys_multisort(array $items_unsorted, array $sort_flags_by_weight_key) {

    $neutral_weights = [];
    foreach ($sort_flags_by_weight_key as $weight_key => $sort_flags) {
      $neutral_weights[$weight_key] = self::sortFlagsGetNeutralValue($sort_flags);
    }

    $weightss = [];
    foreach ($items_unsorted as $k => $item) {
      foreach ($sort_flags_by_weight_key as $weight_key => $sort_flags) {
        $weightss[$weight_key][] = isset($item[$weight_key])
          ? $item[$weight_key]
          : $neutral_weights[$weight_key];
      }
    }

    $args = [];
    foreach ($weightss as $weight_key => $weights) {
      $args[] = $weights;
      $args[] = $sort_flags_by_weight_key[$weight_key];
    }

    $args[] = range(0, count($items_unsorted) - 1);
    $keys = array_keys($items_unsorted);
    $args[] =& $keys;
    $args[] =& $items_unsorted;

    call_user_func_array('array_multisort', $args);

    return array_combine($keys, $items_unsorted);
  }

  /**
   * @param array[] $items_unsorted
   * @param int[] $sort_flags_by_weight_key
   *   Format: $[$weight_key] = $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightKeys_multisort_columns(array $items_unsorted, array $sort_flags_by_weight_key) {

    $args = [];
    foreach ($sort_flags_by_weight_key as $weight_key => $sort_flags) {
      $neutral_weight = self::sortFlagsGetNeutralValue($sort_flags);
      $weights = [];
      foreach ($items_unsorted as $item) {
        $weights[] = isset($item[$weight_key])
          ? $item[$weight_key]
          : $neutral_weight;
      }
      $args[] = $weights;
      $args[] = $sort_flags;
    }

    $args[] = range(0, count($items_unsorted) - 1);
    $keys = array_keys($items_unsorted);
    $args[] =& $keys;
    $args[] =& $items_unsorted;

    call_user_func_array('array_multisort', $args);

    return array_combine($keys, $items_unsorted);
  }

  /**
   * @param array[] $items_unsorted
   * @param int[] $sort_flags_by_weight_key
   *   Format: $[$weight_key] = $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightKeys_multisort_columns1(array $items_unsorted, array $sort_flags_by_weight_key) {

    $keys = array_keys($items_unsorted);
    $n = count($items_unsorted);

    $args = [];
    foreach ($sort_flags_by_weight_key as $weight_key => $sort_flags) {
      $neutral_weight = self::sortFlagsGetNeutralValue($sort_flags);
      $weights = array_fill(0, $n, $neutral_weight);
      $i = 0;
      foreach ($items_unsorted as $item) {
        if (isset($item[$weight_key])) {
          $weights[$i] = $item[$weight_key];
        }
        ++$i;
      }
      $args[] = $weights;
      $args[] = $sort_flags;
    }

    $args[] = range(0, $n - 1);
    $args[] =& $keys;
    $args[] =& $items_unsorted;

    call_user_func_array('array_multisort', $args);

    return array_combine($keys, $items_unsorted);
  }

  /**
   * @param array[] $items_unsorted
   * @param int[] $sort_flags_by_weight_key
   *   Format: $[$weight_key] = $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightKeys_multisort_columns1a(array $items_unsorted, array $sort_flags_by_weight_key) {

    $keys = array_keys($items_unsorted);
    $n = count($items_unsorted);

    $empty_columns = [
      0 => array_fill(0, $n, 0),
      '' => array_fill(0, $n, ''),
    ];

    $args = [];
    foreach ($sort_flags_by_weight_key as $weight_key => $sort_flags) {
      $neutral_weight = self::sortFlagsGetNeutralValue($sort_flags);
      $weights = $empty_columns[$neutral_weight];
      $i = 0;
      foreach ($items_unsorted as $item) {
        if (isset($item[$weight_key])) {
          $weights[$i] = $item[$weight_key];
        }
        ++$i;
      }
      $args[] = $weights;
      $args[] = $sort_flags;
    }

    $args[] = range(0, $n - 1);
    $args[] =& $keys;
    $args[] =& $items_unsorted;

    call_user_func_array('array_multisort', $args);

    return array_combine($keys, $items_unsorted);
  }

  /**
   * @param array[] $items_unsorted
   * @param int[] $sort_flags_by_weight_key
   *   Format: $[$weight_key] = $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightKeys_multisort_columns2(array $items_unsorted, array $sort_flags_by_weight_key) {

    $keys = array_keys($items_unsorted);

    $args = [];
    foreach ($sort_flags_by_weight_key as $weight_key => $sort_flags) {
      $neutral_weight = self::sortFlagsGetNeutralValue($sort_flags);
      $weights = array_fill_keys($keys, $neutral_weight);
      foreach ($items_unsorted as $k => $item) {
        if (isset($item[$weight_key])) {
          $weights[$k] = $item[$weight_key];
        }
      }
      $args[] = $weights;
      $args[] = $sort_flags;
    }

    $args[] = range(0, count($items_unsorted) - 1);
    $args[] =& $keys;
    $args[] =& $items_unsorted;

    call_user_func_array('array_multisort', $args);

    return array_combine($keys, $items_unsorted);
  }

  /**
   * @param array[] $items_unsorted
   * @param int[] $sort_flags_by_weight_key
   *   Format: $[$weight_key] = $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightKeys_multisort_isArray(array $items_unsorted, array $sort_flags_by_weight_key) {

    $neutral_weights = [];
    foreach ($sort_flags_by_weight_key as $weight_key => $sort_flags) {
      $neutral_weights[$weight_key] = self::sortFlagsGetNeutralValue($sort_flags);
    }

    $weightss = [];
    foreach ($items_unsorted as $item) {
      foreach ($sort_flags_by_weight_key as $weight_key => $sort_flags) {
        $weightss[$weight_key][] = is_array($item) && isset($item[$weight_key])
          ? $item[$weight_key]
          : $neutral_weights[$weight_key];
      }
    }

    $args = [];
    foreach ($weightss as $weight_key => $weights) {
      $args[] = $weights;
      $args[] = $sort_flags_by_weight_key[$weight_key];
    }

    $args[] = range(0, count($items_unsorted) - 1);
    $keys = array_keys($items_unsorted);
    $args[] =& $keys;
    $args[] =& $items_unsorted;

    call_user_func_array('array_multisort', $args);

    return array_combine($keys, $items_unsorted);
  }

  /**
   * @param array[] $items_unsorted
   * @param int[] $sort_flags_by_weight_key
   *   Format: $[$weight_key] = $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightKeys_multisort_isArray_columns(array $items_unsorted, array $sort_flags_by_weight_key) {

    $args = [];
    foreach ($sort_flags_by_weight_key as $weight_key => $sort_flags) {
      $neutral_weight = self::sortFlagsGetNeutralValue($sort_flags);
      $weights = [];
      foreach ($items_unsorted as $item) {
        $weights[] = is_array($item) && isset($item[$weight_key])
          ? $item[$weight_key]
          : $neutral_weight;
      }
      $args[] = $weights;
      $args[] = $sort_flags;
    }

    $args[] = range(0, count($items_unsorted) - 1);
    $keys = array_keys($items_unsorted);
    $args[] =& $keys;
    $args[] =& $items_unsorted;

    call_user_func_array('array_multisort', $args);

    return array_combine($keys, $items_unsorted);
  }

  /**
   * @param array[] $items_unsorted
   * @param int[] $sort_flags_by_weight_key
   *   Format: $[$weight_key] = $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightKeys_multisort_isArray_columns_prepared(array $items_unsorted, array $sort_flags_by_weight_key) {

    $rows = [];
    foreach ($items_unsorted as $k => $item) {
      $rows[] = is_array($item) ? $item : [];
    }

    $args = [];
    foreach ($sort_flags_by_weight_key as $weight_key => $sort_flags) {
      $neutral_weight = self::sortFlagsGetNeutralValue($sort_flags);
      $weights = [];
      foreach ($rows as $row) {
        $weights[] = isset($row[$weight_key])
          ? $row[$weight_key]
          : $neutral_weight;
      }
      $args[] = $weights;
      $args[] = $sort_flags;
    }

    $args[] = range(0, count($items_unsorted) - 1);
    $keys = array_keys($items_unsorted);
    $args[] =& $keys;
    $args[] =& $items_unsorted;

    call_user_func_array('array_multisort', $args);

    return array_combine($keys, $items_unsorted);
  }

  /**
   * @param array[] $items_unsorted
   * @param int[] $sort_flags_by_weight_key
   *   Format: $[$weight_key] = $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightKeys_multisort_isArray_columns_prepared2(array $items_unsorted, array $sort_flags_by_weight_key) {

    $rows = $items_unsorted;
    foreach (array_diff_key($items_unsorted, array_filter($items_unsorted, 'is_array')) as $k => $item) {
      $rows[$k] = [];
    }

    $args = [];
    foreach ($sort_flags_by_weight_key as $weight_key => $sort_flags) {
      $neutral_weight = self::sortFlagsGetNeutralValue($sort_flags);
      $weights = [];
      foreach ($rows as $row) {
        $weights[] = isset($row[$weight_key])
          ? $row[$weight_key]
          : $neutral_weight;
      }
      $args[] = $weights;
      $args[] = $sort_flags;
    }

    $args[] = range(0, count($items_unsorted) - 1);
    $keys = array_keys($items_unsorted);
    $args[] =& $keys;
    $args[] =& $items_unsorted;

    call_user_func_array('array_multisort', $args);

    return array_combine($keys, $items_unsorted);
  }

  /**
   * @param array[] $items_unsorted
   * @param int[] $sort_flags_by_weight_key
   *   Format: $[$weight_key] = $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightKeys_multisort_isArray_columns_prepared3(array $items_unsorted, array $sort_flags_by_weight_key) {

    $rows = array_replace(
      array_fill(0, count($items_unsorted), []),
      array_filter(array_values($items_unsorted), 'is_array'));

    $args = [];
    foreach ($sort_flags_by_weight_key as $weight_key => $sort_flags) {
      $neutral_weight = self::sortFlagsGetNeutralValue($sort_flags);
      $weights = [];
      foreach ($rows as $row) {
        $weights[] = isset($row[$weight_key])
          ? $row[$weight_key]
          : $neutral_weight;
      }
      $args[] = $weights;
      $args[] = $sort_flags;
    }

    $args[] = range(0, count($items_unsorted) - 1);
    $keys = array_keys($items_unsorted);
    $args[] =& $keys;
    $args[] =& $items_unsorted;

    call_user_func_array('array_multisort', $args);

    return array_combine($keys, $items_unsorted);
  }

  /**
   * @param array[] $items_unsorted
   * @param int[] $sort_flags_by_weight_key
   *   Format: $[$weight_key] = $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightKeys_multisort_isArray_columns_prepared4(array $items_unsorted, array $sort_flags_by_weight_key) {

    $rows = $items_unsorted;
    foreach (array_keys(array_map('is_array', $items_unsorted), false, true) as $k) {
      $rows[$k] = [];
    }

    $args = [];
    foreach ($sort_flags_by_weight_key as $weight_key => $sort_flags) {
      $neutral_weight = self::sortFlagsGetNeutralValue($sort_flags);
      $weights = [];
      foreach ($rows as $row) {
        $weights[] = isset($row[$weight_key])
          ? $row[$weight_key]
          : $neutral_weight;
      }
      $args[] = $weights;
      $args[] = $sort_flags;
    }

    $args[] = range(0, count($items_unsorted) - 1);
    $keys = array_keys($items_unsorted);
    $args[] =& $keys;
    $args[] =& $items_unsorted;

    call_user_func_array('array_multisort', $args);

    return array_combine($keys, $items_unsorted);
  }

  /**
   * @param array[] $items_unsorted
   * @param int[] $sort_flags_by_weight_key
   *   Format: $[$weight_key] = $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightKeys_multisort_isArray_columns_prepared5(array $items_unsorted, array $sort_flags_by_weight_key) {

    $rows = $items_unsorted;
    foreach ($rows as &$rowx) {
      if (!is_array($rowx)) {
        $rowx = [];
      }
    }
    unset($rowx);

    $args = [];
    foreach ($sort_flags_by_weight_key as $weight_key => $sort_flags) {
      $neutral_weight = self::sortFlagsGetNeutralValue($sort_flags);
      $weights = [];
      foreach ($rows as $row) {
        $weights[] = isset($row[$weight_key])
          ? $row[$weight_key]
          : $neutral_weight;
      }
      $args[] = $weights;
      $args[] = $sort_flags;
    }

    $args[] = range(0, count($items_unsorted) - 1);
    $keys = array_keys($items_unsorted);
    $args[] =& $keys;
    $args[] =& $items_unsorted;

    call_user_func_array('array_multisort', $args);

    return array_combine($keys, $items_unsorted);
  }

  /**
   * @param array[] $items_unsorted
   * @param int[] $sort_flags_by_weight_key
   *   Format: $[$weight_key] = $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightKeys_multisort_isArray_columns_prepared6(array $items_unsorted, array $sort_flags_by_weight_key) {

    $keys = array_keys($items_unsorted);
    $items = array_values($items_unsorted);
    $n = count($items_unsorted);
    $array_items = array_filter($items, 'is_array');

    $args = [];
    foreach ($sort_flags_by_weight_key as $weight_key => $sort_flags) {
      $neutral_weight = self::sortFlagsGetNeutralValue($sort_flags);
      $weights = array_fill(0, $n, $neutral_weight);
      foreach ($array_items as $i => $item) {
        if (isset($item[$weight_key])) {
          $weights[$i] = $item[$weight_key];
        }
      }
      $args[] = $weights;
      $args[] = $sort_flags;
    }

    $args[] = range(0, $n - 1);
    $args[] =& $keys;
    $args[] =& $items;

    call_user_func_array('array_multisort', $args);

    return array_combine($keys, $items);
  }

  /**
   * @param array[] $items_unsorted
   * @param int[] $sort_flags_by_weight_key
   *   Format: $[$weight_key] = $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightKeys_multisort_isArray_columns_prepared7(array $items_unsorted, array $sort_flags_by_weight_key) {

    $keys = array_keys($items_unsorted);
    $array_items = array_filter($items_unsorted, 'is_array');

    $args = [];
    foreach ($sort_flags_by_weight_key as $weight_key => $sort_flags) {
      $neutral_weight = self::sortFlagsGetNeutralValue($sort_flags);
      $weights = array_fill_keys($keys, $neutral_weight);
      foreach ($array_items as $i => $item) {
        if (isset($item[$weight_key])) {
          $weights[$i] = $item[$weight_key];
        }
      }
      $args[] = $weights;
      $args[] = $sort_flags;
    }

    $args[] = range(0, count($items_unsorted) - 1);
    $args[] =& $keys;
    $args[] =& $items_unsorted;

    call_user_func_array('array_multisort', $args);

    return array_combine($keys, $items_unsorted);
  }

  /**
   * @param array[] $items_unsorted
   * @param callable $weights_callback
   * @param int[] $sort_flags_by_weight_key
   *   Format: $[$weight_key] = $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightsCallback_rows(array $items_unsorted, $weights_callback, array $sort_flags_by_weight_key) {
    $weight_rows = array_map($weights_callback, $items_unsorted);

    $neutral_weights = [];
    foreach ($sort_flags_by_weight_key as $weight_key => $sort_flags) {
      $neutral_weights[$weight_key] = self::sortFlagsGetNeutralValue($sort_flags);
    }

    $weight_columns = [];
    foreach ($weight_rows as $weight_row) {
      $item_weights = $weight_row + $neutral_weights;
      foreach ($item_weights as $weight_key => $weight) {
        $weight_columns[$weight_key][] = $weight;
      }
    }

    $args = [];
    foreach ($sort_flags_by_weight_key as $weight_key => $sort_flags) {
      $args[] = $weight_columns[$weight_key];
      if (SORT_REGULAR !== $sort_flags) {
        $args[] = $sort_flags;
      }
      if (isset($sort_directions[$weight_key]) && SORT_DESC === $sort_directions[$weight_key]) {
        $args[] = SORT_DESC;
      }
    }

    $args[] = range(0, count($items_unsorted) - 1);
    $keys = array_keys($items_unsorted);
    $args[] =& $keys;
    $args[] =& $items_unsorted;

    # var_export(array_map(function($x) {return is_array($x) ? count($x) : "#$x";}, $args));
    # exit();

    call_user_func_array('array_multisort', $args);

    return array_combine($keys, $items_unsorted);
  }

  /**
   * @param array[] $items_unsorted
   * @param callable $weights_callback
   * @param int[] $sort_flags_by_weight_key
   *   Format: $[$weight_key] = $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightsCallback_callUserFunc(array $items_unsorted, $weights_callback, array $sort_flags_by_weight_key) {
    $weight_rows = [];
    foreach ($items_unsorted as $k => $item) {
      $weight_rows[$k] = call_user_func($weights_callback, $item);
    }

    $args = [];
    foreach ($sort_flags_by_weight_key as $weight_key => $sort_flags) {
      $neutral_weight = self::sortFlagsGetNeutralValue($sort_flags);
      $weights = [];
      foreach ($weight_rows as $weight_row) {
        $weights[] = isset($weight_row[$weight_key]) ? $weight_row[$weight_key] : $neutral_weight;
      }
      $args[] = $weights;
      $args[] = $sort_flags;
    }

    $args[] = range(0, count($items_unsorted) - 1);
    $keys = array_keys($items_unsorted);
    $args[] =& $keys;
    $args[] =& $items_unsorted;

    call_user_func_array('array_multisort', $args);

    return array_combine($keys, $items_unsorted);
  }

  /**
   * @param array[] $items_unsorted
   * @param callable $weights_callback
   * @param int[] $sort_flags_by_weight_key
   *   Format: $[$weight_key] = $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightsCallback_arrayMap(array $items_unsorted, $weights_callback, array $sort_flags_by_weight_key) {
    $weight_rows = array_map($weights_callback, $items_unsorted);

    $args = [];
    foreach ($sort_flags_by_weight_key as $weight_key => $sort_flags) {
      $neutral_weight = self::sortFlagsGetNeutralValue($sort_flags);
      $weights = [];
      foreach ($weight_rows as $k => $weight_row) {
        $weights[] = isset($weight_row[$weight_key]) ? $weight_row[$weight_key] : $neutral_weight;
      }
      $args[] = $weights;
      $args[] = $sort_flags;
    }

    $args[] = range(0, count($items_unsorted) - 1);
    $keys = array_keys($items_unsorted);
    $args[] =& $keys;
    $args[] =& $items_unsorted;

    call_user_func_array('array_multisort', $args);

    return array_combine($keys, $items_unsorted);
  }

  /**
   * @param array[] $items_unsorted
   * @param string|int $weight_key
   *
   * @return array[]
   */
  public static function sortByWeightKey_weightWithFraction(array $items_unsorted, $weight_key) {

    $weights_by_key = [];
    $step = 0.01 / count($items_unsorted);
    $fraction = 0;
    foreach ($items_unsorted as $k => $item) {
      $weights_by_key[$k] = isset($item[$weight_key])
        ? $item[$weight_key] + $fraction
        : $fraction;
      $fraction += $step;
    }

    asort($weights_by_key, SORT_NUMERIC);

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
  public static function sortByWeightKey_arrayMultisort_arrayCombine(array $items_unsorted, $weight_key, $sort_flags = null) {

    $neutral_value = self::sortFlagsGetNeutralValue($sort_flags);

    $weights_by_key = [];
    foreach ($items_unsorted as $k => $item) {
      $weights_by_key[$k] = isset($item[$weight_key])
        ? $item[$weight_key]
        : $neutral_value;
    }

    $keys = array_keys($items_unsorted);
    $range = range(1, count($items_unsorted));
    array_multisort($weights_by_key, SORT_ASC, $sort_flags, $range, SORT_ASC, $keys, $items_unsorted);

    return array_combine($keys, $items_unsorted);
  }

  /**
   * @param array[] $items_unsorted
   * @param string|int $weight_key
   * @param int $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightKey_arrayMultisort_arrayReplace(array $items_unsorted, $weight_key, $sort_flags = null) {

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

    return array_replace(array_fill_keys($keys, null), $items_unsorted);
  }

  /**
   * @param array[] $items_unsorted
   * @param string|int $weight_callback
   * @param int $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightCallback_arrayMultisort(array $items_unsorted, $weight_callback, $sort_flags = null) {

    $weights_by_key = [];
    foreach ($items_unsorted as $k => $item) {
      $weights_by_key[$k] = $weight_callback($item);
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
   * @param string|int $weight_callback
   * @param int $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightCallback_arrayMultisort_callUserFunc(array $items_unsorted, $weight_callback, $sort_flags = null) {

    $weights_by_key = [];
    foreach ($items_unsorted as $k => $item) {
      $weights_by_key[$k] = call_user_func($weight_callback, $item);
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
   * @param string|int $weights_callback
   * @param int $sort_flags
   *
   * @return array[]
   */
  public static function sortByWeightsCallback_arrayMultisort(array $items_unsorted, $weights_callback, $sort_flags = null) {

    $weights_by_key = $weights_callback($items_unsorted);

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
  public static function sortByWeightKey_schwartzian(array $items_unsorted, $weight_key, $sort_flags = null) {

    $neutral_value = self::sortFlagsGetNeutralValue($sort_flags);

    $weights_by_key = [];
    $i = 0;
    foreach ($items_unsorted as $k => $item) {
      $weights_by_key[$k] = isset($item[$weight_key])
        ? [$item[$weight_key], ++$i]
        : [$neutral_value, ++$i];
    }

    asort($weights_by_key);

    $items_sorted = [];
    foreach ($weights_by_key as $k => $_) {
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
    self::backdrop_sort($items_unsorted, array($weight_key => $sort_flags));
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
          /** @noinspection TypeUnsafeComparisonInspection */
          if ($a[$key] != $b[$key]) {
            return $a[$key] < $b[$key] ? -1 : 1;
          }
          return 0;
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
        /** @noinspection TypeUnsafeComparisonInspection */
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
        return 0;
      };
      uasort($array, $recursive_callback);
    }
  }

}
