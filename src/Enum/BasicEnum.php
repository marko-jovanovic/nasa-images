<?php

namespace NASA\Enum;

abstract class BasicEnum {
  private static $const_cache_array = NULL;

  private static function get_constants() {
    if (self::$const_cache_array == NULL) {
      self::$const_cache_array = [];
    }

    $called_class = get_called_class();
    if (!array_key_exists($called_class, self::$const_cache_array)) {
      $reflect = new \ReflectionClass($called_class);
      self::$const_cache_array[$called_class] = $reflect->getConstants();
    }

    return self::$const_cache_array[$called_class];
  }

  public static function get_valid_values() {
    return join(', ', array_values(self::get_constants()));
  }

  public static function is_valid_name(string $name, $strict = false) {
    $constants = self::get_constants();

    if ($strict) {
      return array_key_exists($name, $constants);
    }

    $key = array_map('strtolower', array_keys($constants));
    return in_array(strtolower($name), $key);
  }

  public static function is_valid_value($value, $strict = true) {
    $values = array_values(self::get_constants());
    return in_array($value, $values, $strict);
  }
}
