<?php

namespace Donquixote\Stable\ItemsToWeights;

class ItemsToWeights_Callback implements ItemsToWeightsInterface {

  /**
   * @var callable
   */
  private $weightCallback;

  /**
   * @param callable $weightCallback
   */
  public function __construct($weightCallback) {
    $this->weightCallback = $weightCallback;
  }

  /**
   * @param mixed[] $items
   *
   * @return mixed[]
   */
  public function itemsGetWeights(array $items) {
    return array_map($this->weightCallback, $items);
  }
}
