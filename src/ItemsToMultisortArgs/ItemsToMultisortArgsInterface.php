<?php

namespace Donquixote\Stable\ItemsToMultisortArgs;

interface ItemsToMultisortArgsInterface {

  /**
   * @param mixed[] $items_unsorted
   *
   * @return mixed[]
   */
  public function itemsGetMultisortArgs(array $items_unsorted);

}
