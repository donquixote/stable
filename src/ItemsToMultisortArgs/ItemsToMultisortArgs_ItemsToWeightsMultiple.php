<?php

namespace Donquixote\Stable\ItemsToMultisortArgs;

use Donquixote\Stable\ItemsToWeights\ItemsToWeightsInterface;

class ItemsToMultisortArgs_ItemsToWeightsMultiple implements ItemsToMultisortArgsInterface {

  /**
   * @var mixed[]
   */
  private $multisortArgs = [];

  /**
   * @var \Donquixote\Stable\ItemsToWeights\ItemsToWeightsInterface[]
   */
  private $itemsToWeightss = [];

  /**
   * @param \Donquixote\Stable\ItemsToWeights\ItemsToWeightsInterface $itemsToWeights
   * @param int $sortFlags
   * @param int $sortDirection
   *
   * @return $this
   */
  public function byItemsToWeights(ItemsToWeightsInterface $itemsToWeights, $sortFlags = SORT_REGULAR, $sortDirection = SORT_ASC) {
    $clone = clone $this;
    $i = count($this->multisortArgs);
    $clone->multisortArgs[] = [];
    if (SORT_REGULAR !== $sortFlags) {
      $clone->multisortArgs[] = $sortFlags;
    }
    if (SORT_ASC !== $sortFlags) {
      $clone->multisortArgs[] = $sortDirection;
    }
    $clone->itemsToWeightss[$i] = $itemsToWeights;
    return $clone;
  }

  /**
   * @param mixed[] $items_unsorted
   *
   * @return mixed[]
   */
  public function itemsGetMultisortArgs(array $items_unsorted) {
    $multisortArgs = $this->multisortArgs;
    foreach ($this->itemsToWeightss as $i => $itemsToWeights) {
      $multisortArgs[$i] = $itemsToWeights->itemsGetWeights($items_unsorted);
    }
    return $multisortArgs;
  }
}
