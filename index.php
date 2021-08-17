<?php

require_once __DIR__ . '/vendor/autoload.php';

use NASA\Controller\NasaApiController;
use NASA\Enum\Camera;
use NASA\Enum\Rover;

if (count($argv) < 4) {
  trigger_error(
    sprintf(
      "%s\n%s\n%s\n",
      "Invalid parameters passed. The script should be invoked in the following manner: php index.php [rover] [camera] [date]",
      "\tPossible rovers are: " . Rover::get_valid_values() . ' or NULL',
      "\tPossible cameras are: " . Camera::get_valid_values() . ' or NULL'
    ),
    E_USER_WARNING
  );
}

$rover  = $argv[1] === 'NULL' ? Rover::CURIOSITY : $argv[1];
$camera = $argv[2] === 'NULL' ? Camera::NAVCAM : $argv[2];
$date   = $argv[3] === 'NULL' ? null : $argv[3];

$nasa_api_controller = new NasaApiController($rover, $camera);

if ($date) {
  $date_test = DateTime::createFromFormat('Y-m-d', $date);
  $is_valid_date = $date_test && $date_test->format('Y-m-d') === $date;
  
  if (!$is_valid_date) {
    trigger_error("Invalid date passed: $date. Valid date format is: Y-m-d", E_USER_WARNING);
  }

  var_dump($nasa_api_controller->get_rover_photos($date));
} else {
  var_dump($nasa_api_controller->get_rover_photos_for_last_10_days());
}
