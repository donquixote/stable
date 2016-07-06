<?php

namespace Donquixote\Stable\Sort;

use Donquixote\Stable\ItemsToWeightsCombiner\ItemsToWeightsCombinerTrait;

class Sort_Multi extends Sort_ItemsToWeightsMultipleBase {

  use ItemsToWeightsCombinerTrait;

  /**
   * @return static
   */
  public static function begin() {
    return new self;
  }
}
