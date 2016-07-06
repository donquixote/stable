<?php

namespace Donquixote\Stable\ItemsToWeights;

interface ItemsToWeightsInterface {

  /**
   * @param mixed[] $items
   *
   * @return mixed[]
   */
  public function itemsGetWeights(array $items);

}
