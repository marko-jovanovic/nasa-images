<?php

namespace NASA\Exception;

use NASA\Enum\Camera;

class InvalidCameraException extends \Exception {
  public function __construct($camera) {
    parent::__construct("Invalid camera name passed: $camera. Valid values are: " . Camera::get_valid_values(), 0, null);
  }
}
