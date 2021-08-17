<?php

namespace NASA\Exception;

use NASA\Enum\Rover;

class InvalidRoverException extends \Exception {
  public function __construct($rover) {
    parent::__construct("Invalid rover name passed: $rover. Valid values are: " . Rover::get_valid_values(), 0, null);
  }
}
