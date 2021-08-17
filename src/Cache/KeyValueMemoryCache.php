<?php

namespace NASA\Cache;

class KeyValueMemoryCache implements KeyValueCache {
  private $cache = [];

  public function __construct($cache = []) {
    $this->cache = $cache;
  }

  public function add($key, $image_array, $override = false) {
    if (!array_key_exists($key, $this->cache) || $override) {
      $this->cache[$key] = $image_array;
      return;
    }

    trigger_error("You attempted to add already existing key: $key", E_USER_WARNING);
  }

  public function remove($key) {
    if (array_key_exists($key, $this->cache)) {
      unset($this->cache[$key]);
      return;
    }

    trigger_error("You attempted to delete non-existing key: $key", E_USER_WARNING);
  }

  public function get($key) {
    if (array_key_exists($key, $this->cache)) {
      return $this->cache[$key];
    }

    trigger_error("You attempted to access non-existing key: $key", E_USER_WARNING);
  }

  public function exist($key) {
    return array_key_exists($key, $this->cache);
  }

  public function get_cache_as_json() {
    return json_encode($this->cache);
  }
}
