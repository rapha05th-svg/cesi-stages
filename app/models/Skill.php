<?php
final class Skill {
  public static function all(): array {
    return DB::pdo()->query("SELECT * FROM skills ORDER BY label")->fetchAll();
  }
}
