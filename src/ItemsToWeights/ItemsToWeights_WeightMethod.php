<?php

namespace Donquixote\Stable\ItemsToWeights;

class ItemsToWeights_WeightMethod implements ItemsToWeightsInterface {

  /**
   * @var string
   */
  private $methodName;

  /**
   * @var mixed
   */
  private $else;

  /**
   * @param string $methodName
   * @param mixed $else
   */
  public function __construct($methodName, $else) {
    $this->methodName = $methodName;
    $this->else = $else;
  }

  /**
   * @param mixed[] $items
   *
   * @return mixed[]
   */
  public function itemsGetWeights(array $items) {
    $methodName = $this->methodName;
    $weights = [];
    foreach ($items as $item) {
      $weights[] = method_exists($item, $methodName)
        ? $item->$methodName()
        : $this->else;
    }
    return $weights;
  }
}
