<?php 

namespace NASA\Controller;

use NASA\Cache\KeyValueFileCache;
use NASA\Service\NasaApiService;

class NasaApiController {
  private KeyValueFileCache $cache;
  private NasaApiService $nasa_api_service;

  public function __construct(string $rover, string $camera) {
    $this->nasa_api_service = new NasaApiService($rover, $camera);
    $this->cache = new KeyValueFileCache($rover);
  }

  public function get_rover_photos(string $date) {
    if ($this->cache->exist($date)) {
      return $this->cache->get($date);
    }

    $image_urls = $this->nasa_api_service->get_rover_photos($date);
    $this->cache->add($date, $image_urls);

    return $image_urls;
  }

  public function get_rover_photos_for_last_10_days() {
    $result = [];

    for($i = 0; $i < 10; $i++) {
      $days_ago = date('Y-m-d', strtotime("-$i days", strtotime(date('Y-m-d'))));
      $this->nasa_api_service->get_rover_photos($days_ago);

      $result[$days_ago] = $this->cache->get($days_ago);
    }

    return $result;
  }
}
