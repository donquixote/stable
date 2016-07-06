<?php

namespace Donquixote\Stable\Sort;

use Donquixote\Stable\ItemsToWeights\ItemsToWeightsInterface;

class Sort_ItemsToWeights extends SortBase {

  /**
   * @var \Donquixote\Stable\ItemsToWeights\ItemsToWeightsInterface
   */
  private $itemsToWeights;

  /**
   * @var int
   */
  private $sortFlags;

  /**
   * @var int
   */
  private $sortDirection;

  /**
   * @param \Donquixote\Stable\ItemsToWeights\ItemsToWeightsInterface $itemsToWeights
   * @param int $sortFlags
   *   E.g. SORT_NUMERIC
   * @param int $sortDirection
   */
  public function __construct(ItemsToWeightsInterface $itemsToWeights, $sortFlags = SORT_REGULAR, $sortDirection = SORT_ASC) {
    $this->itemsToWeights = $itemsToWeights;
    $this->sortFlags = $sortFlags;
    $this->sortDirection = $sortDirection;
  }

  /**
   * @param mixed[] $items_unsorted
   * @param bool $preserveKeys
   *
   * @return mixed[]
   */
  protected function itemsGetSortedNonEmpty(array $items_unsorted, $preserveKeys = TRUE) {

    if (count($items_unsorted) < 2) {
      return $items_unsorted;
    }

    $weights = $this->itemsToWeights->itemsGetWeights($items_unsorted);
    $range = range(0, count($items_unsorted) - 1);

    if ($preserveKeys) {
      $keys = array_keys($items_unsorted);
      array_multisort($weights, $this->sortFlags, $this->sortDirection, $range, SORT_NUMERIC, $keys, $items_unsorted);

      return array_combine($keys, $items_unsorted);
    }
    else {
      $items = array_values($items_unsorted);
      array_multisort($weights, $this->sortFlags, $this->sortDirection, $range, SORT_NUMERIC, $items);

      return array_values($items_unsorted);
    }
  }
}
