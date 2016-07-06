<?php

namespace Donquixote\Stable\Sort;

abstract class SortBase implements SortInterface {

  /**
   * @param mixed[] $items
   * @param bool $preserveKeys
   */
  final public function sort(array &$items, $preserveKeys = true) {
    // An empty array would cause range() to return a non-empty array.
    // A one-valued array does not need to be sorted.
    if (count($items) > 1) {
      $items = $this->itemsGetSorted($items, $preserveKeys);
    }
  }

  /**
   * @param mixed[] $items_unsorted
   * @param bool $preserveKeys
   *
   * @return mixed[]
   */
  final public function itemsGetSorted(array $items_unsorted, $preserveKeys = true) {
    // An empty array would cause range() to return a non-empty array.
    // A one-valued array does not need to be sorted.
    return count($items_unsorted) > 1
      ? $this->itemsGetSortedNonEmpty($items_unsorted, $preserveKeys)
      : $items_unsorted;
  }

  /**
   * @param mixed[] $items_unsorted
   * @param bool $preserveKeys
   *
   * @return mixed[]
   */
  abstract protected function itemsGetSortedNonEmpty(array $items_unsorted, $preserveKeys = true);
}
