<?php

namespace NASA\Cache;

interface KeyValueCache {
  public function add($key, $value, $override);
  public function remove($key);
  public function get($key);
  public function exist($key);
}
