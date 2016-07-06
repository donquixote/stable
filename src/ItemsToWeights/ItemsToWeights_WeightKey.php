<?php

namespace Donquixote\Stable\ItemsToWeights;

class ItemsToWeights_WeightKey implements ItemsToWeightsInterface {

  /**
   * @var int|string
   */
  private $weightKey;

  /**
   * @var mixed
   */
  private $else;

  /**
   * @param string|int $weightKey
   * @param mixed $else
   */
  public function __construct($weightKey, $else) {
    $this->weightKey = $weightKey;
    $this->else = $else;
  }

  /**
   * @param mixed[] $items
   *
   * @return mixed[]
   */
  public function itemsGetWeights(array $items) {
    $weights = [];
    foreach ($items as $item) {
      $weights[] = isset($item[$this->weightKey]) ? $item[$this->weightKey] : $this->else;
    }
    return $weights;
  }
}
