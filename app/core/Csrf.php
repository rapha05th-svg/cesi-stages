<?php
final class Csrf {
  public static function token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
  }
  public static function check(): void {
    $token = $_POST['_csrf'] ?? '';
    if (!$token || !hash_equals($_SESSION['csrf'] ?? '', $token)) {
      http_response_code(419);
      echo "CSRF token invalid (419)";
      exit;
    }
  }
}
