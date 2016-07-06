<?php

namespace Donquixote\Stable\Util;

class StableSortHelperUtil {

  /**
   * Sorts items by an array of weights.
   *
   * @param mixed[] $items_unsorted
   *   Array of items to be sorted.
   *   The array *must not* be empty.
   * @param int[]|float[]|string[]|mixed[] $weights
   *   Must have same count as the items.
   * @param int $sort_flags
   *   E.g. SORT_NUMERIC or SORT_STRING.
   * @param int $sort_direction
   *
   * @return mixed[]
   *   Sorted items.
   *   Format: $[$k] === $items_unsorted[$k]
   */
  public static function sortByWeightsNonEmpty(array $items_unsorted, array $weights, $sort_flags, $sort_direction = SORT_ASC) {

    $keys = array_keys($items_unsorted);
    $range = range(0, count($items_unsorted) - 1);

    array_multisort($weights, $sort_flags, $sort_direction, $range, SORT_NUMERIC, $keys, $items_unsorted);

    return array_combine($keys, $items_unsorted);
  }


}
