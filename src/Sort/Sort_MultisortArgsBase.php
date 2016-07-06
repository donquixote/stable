<?php

namespace Donquixote\Stable\Sort;

abstract class Sort_MultisortArgsBase extends SortBase {

  /**
   * @param mixed[] $items_unsorted
   * @param bool $preserveKeys
   *
   * @return mixed[]
   */
  protected function itemsGetSortedNonEmpty(array $items_unsorted, $preserveKeys = TRUE) {

    $args = $this->itemsGetMultisortArgs($items_unsorted);

    $args[] = range(0, count($items_unsorted) - 1);
    $args[] =& $items_unsorted;

    if ($preserveKeys) {
      $keys = array_keys($items_unsorted);
      $args[] =& $keys;
      call_user_func_array('array_multisort', $args);

      return array_combine($keys, $items_unsorted);
    }
    else {
      call_user_func_array('array_multisort', $args);

      return array_values($items_unsorted);
    }
  }

  /**
   * @param mixed[] $items_unsorted
   *
   * @return mixed[]
   */
  abstract protected function itemsGetMultisortArgs(array $items_unsorted);
}
