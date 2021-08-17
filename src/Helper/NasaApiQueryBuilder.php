<?php

namespace NASA\Helper;

use NASA\Config\ApiConfig;

class NasaApiQueryBuilder {
  private $base_url = ApiConfig::NASA_API;
  private $api_key = ApiConfig::API_KEY;

  private $rover = 'curiosity';
  private $camera = 'NAVCAM';
  private $date = '';

  public function set_date($date) {
    $this->date = $date;
    return $this;
  }

  public function set_rover($rover) {
    $this->rover = $rover;
    return $this;
  }

  public function set_camera($camera) {
    $this->camera = $camera;
    return $this;
  }

  public function build() {
    return sprintf(
      "{$this->base_url}/rovers/%s/photos?earth_date=%s&camera=%s&api_key={$this->api_key}",
      $this->rover,
      $this->date,
      $this->camera
    );
  }
}