<?php

namespace NASA\Cache;

class KeyValueFileCache implements KeyValueCache {
  private string $cache_file_url;
  private KeyValueMemoryCache $cache;

  public function __construct(string $cache_name) {
    $this->cache_file_url = dirname(__DIR__, 2) . "/cache/$cache_name.txt";

    // If cache file does not exist create one
    if (!is_file($this->cache_file_url)) {
      file_put_contents($this->cache_file_url, "");
    }

    // Try to load cache file
    $cache_content = file_get_contents($this->cache_file_url);
    $decoded_cache_content = json_decode($cache_content, true);

    // Check if cache file is corrupted
    if (!$decoded_cache_content) {
      trigger_error("Cache file corrupted, re-creating new file.", E_USER_WARNING);
      file_put_contents($this->cache_file_url, "");
      $this->cache = new KeyValueMemoryCache();
    } else {
      $this->cache = new KeyValueMemoryCache($decoded_cache_content);
    }
  }

  public function add($key, $value, $override = false) {
    if (!$this->cache->exist($key) || $override) {
      $this->cache->add($key, $value, $override);
      file_put_contents($this->cache_file_url, $this->cache->get_cache_as_json());
      return;
    }

    trigger_error("You attempted to add already existing key: $key", E_USER_WARNING);
  }

  public function remove($key) {
    if ($this->cache->exist($key)) {
      $this->cache->remove($key);
      file_put_contents($this->cache_file_url, $this->cache->get_cache_as_json());
      return;
    }

    trigger_error("You attempted to delete non-existing key: $key", E_USER_WARNING);
  }

  public function get($key) {
    if ($this->cache->exist($key)) {
      return $this->cache->get($key);
    }

    trigger_error("You attempted to access non-existing key: $key", E_USER_WARNING);
  }

  public function exist($key) {
    return $this->cache->exist($key);
  }
}
