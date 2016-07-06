<?php

namespace Donquixote\Stable\Sort;

interface SortInterface {

  /**
   * @param mixed[] $items
   * @param bool $preserveKeys
   */
  public function sort(array &$items, $preserveKeys = true);

  /**
   * @param mixed[] $items_unsorted
   * @param bool $preserveKeys
   *
   * @return mixed[]
   */
  public function itemsGetSorted(array $items_unsorted, $preserveKeys = true);

}
