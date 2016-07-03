<?php

namespace Donquixote\Stable\Util;

class BenchUtil {

  /**
   * @param float[][] $dtss
   *   Collected benchmark results in milliseconds
   *   Format: $[$key][] = $dt, with count($dtss[$key]) === 100 for each key.
   * @param int|float $factor
   *   Factor by which to multiply each measured time.
   * @param int[] $percentiles
   *   Format: $[] = $percentile
   */
  public static function printPercentilesTable(array $dtss, $factor, array $percentiles = [25, 50, 75, 90]) {

    $rows = [];

    // Head row.
    $row = [''];
    foreach ($percentiles as $percentile) {
      $row[] = $percentile . '%';
    }

    $rows[] = $row;
    foreach ($dtss as $k => $dts) {
      if (100 !== $n = count($dts)) {
        throw new \InvalidArgumentException("Expecting exactly 100 data points for each key. Found $n data points instead for '$k'.");
      }
      sort($dts);
      $row = [$k];
      foreach ($percentiles as $percentile) {
        $row[] = round($factor * $dts[$percentile]);
      }
      $rows[] = $row;
    }

    $cols = [];
    foreach ($rows as $i_row => $row) {
      foreach ($row as $i_col => $cell) {
        $cols[$i_col][$i_row] = strlen($cell);
      }
    }

    $col_widths = array_map('max', $cols);

    print "\n";
    foreach ($rows as $row) {
      foreach ($row as $i_col => $cell) {
        if (0 === $i_col) {
          print str_pad($cell, $col_widths[$i_col]);
        }
        else {
          print '  ' . str_pad($cell, $col_widths[$i_col], ' ', STR_PAD_LEFT);
        }
      }
      print "\n";
    }
  }

}
