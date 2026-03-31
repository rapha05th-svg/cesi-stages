<?php
final class Validator {
  public static function email(string $v): bool { return filter_var($v, FILTER_VALIDATE_EMAIL) !== false; }
  public static function str(string $v, int $min=1, int $max=255): bool {
    $len = mb_strlen(trim($v));
    return $len >= $min && $len <= $max;
  }
  public static function int($v, int $min=0, int $max=PHP_INT_MAX): bool {
    if (!is_numeric($v)) return false;
    $i = (int)$v;
    return $i >= $min && $i <= $max;
  }
}
