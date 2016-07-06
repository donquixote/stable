<?php

namespace Donquixote\Stable\ItemsToWeights;

class ItemsToWeights_WeightProperty implements ItemsToWeightsInterface {

  /**
   * @var string
   */
  private $propertyName;

  /**
   * @var mixed
   */
  private $else;

  /**
   * @param string $propertyName
   * @param mixed $else
   */
  public function __construct($propertyName, $else) {
    $this->propertyName = $propertyName;
    $this->else = $else;
  }

  /**
   * @param mixed[] $items
   *
   * @return mixed[]
   */
  public function itemsGetWeights(array $items) {
    $propertyName = $this->propertyName;
    $weights = [];
    foreach ($items as $item) {
      $weights[] = isset($item->$propertyName)
        ? $item->$propertyName
        : $this->else;
    }
    return $weights;
  }
}
