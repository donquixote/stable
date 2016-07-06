<?php

namespace Donquixote\Stable\ItemsToWeightsCombiner;

use Donquixote\Stable\ItemsToWeights\ItemsToWeights_Callback;
use Donquixote\Stable\ItemsToWeights\ItemsToWeights_WeightKey;
use Donquixote\Stable\ItemsToWeights\ItemsToWeights_WeightMethod;
use Donquixote\Stable\ItemsToWeights\ItemsToWeightsInterface;

trait ItemsToWeightsCombinerTrait {

  /**
   * @param string $methodName
   * @param mixed $else
   *   Value to use if the method does not exist.
   * @param int $sortFlags
   * @param int $sortDirection
   *
   * @return static
   */
  public function byWeightMethod($methodName, $sortFlags = SORT_REGULAR, $sortDirection = SORT_ASC) {
    $else = ($sortFlags === SORT_NUMERIC) ? 0 : '';
    return $this->byItemsToWeights(
      new ItemsToWeights_WeightMethod($methodName, $else),
      $sortFlags,
      $sortDirection);
  }

  /**
   * @param $weightCallback
   * @param int $sortFlags
   * @param int $sortDirection
   *
   * @return static
   */
  public function byWeightCallback($weightCallback, $sortFlags = SORT_REGULAR, $sortDirection = SORT_ASC) {
    return $this->byItemsToWeights(
      new ItemsToWeights_Callback($weightCallback),
      $sortFlags,
      $sortDirection);
  }

  /**
   * @param string|int $weightKey
   * @param mixed $else
   *   Value to use if the array key does not exist.
   * @param int $sortFlags
   * @param int $sortDirection
   *
   * @return static
   */
  public function byWeightKey($weightKey, $sortFlags = SORT_REGULAR, $sortDirection = SORT_ASC) {
    $else = ($sortFlags === SORT_NUMERIC) ? 0 : '';
    return $this->byItemsToWeights(
      new ItemsToWeights_WeightKey($weightKey, $else),
      $sortFlags,
      $sortDirection);
  }

  abstract protected function byItemsToWeights(ItemsToWeightsInterface $itemsToWeights, $sortFlags = SORT_REGULAR, $sortDirection = SORT_ASC);

}
