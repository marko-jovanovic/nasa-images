<?php

namespace NASA\Service;

use NASA\Helper\Http;
use NASA\Helper\NasaApiQueryBuilder;

use NASA\Enum\Rover;
use NASA\Enum\Camera;

use NASA\Exception\InvalidRoverException;
use NASA\Exception\InvalidCameraException;

class NasaApiService {
  private NasaApiQueryBuilder $query_builder;

  public function __construct(string $rover, string $camera) {
    if (!Rover::is_valid_name($rover)) {
      throw new InvalidRoverException($rover);
    }

    if (!Camera::is_valid_name($camera)) {
      throw new InvalidCameraException($camera);
    }

    $this->query_builder = new NasaApiQueryBuilder();
    $this->query_builder
      ->set_rover($rover)
      ->set_camera($camera);
  }

  public function get_rover_photos(string $date) {
    $url = $this->query_builder->set_date($date)->build();
    $result = Http::get($url);
    
    // Get first 3 images
    $image_urls = [];
    for($i = 0; $i < 3; $i++) {
      if ($result['photos'][$i]) {
        $image_urls[] = $result['photos'][$i]['img_src'];
      }
    }

    return $image_urls;
  }
}
