<?php
final class Auth {
  public static function check(): bool { return isset($_SESSION['user']); }
  public static function id(): ?int { return $_SESSION['user']['id'] ?? null; }
  public static function role(): ?string { return $_SESSION['user']['role'] ?? null; }
  public static function email(): ?string { return $_SESSION['user']['email'] ?? null; }

  public static function login(array $userRow): void {
    session_regenerate_id(true);
    $_SESSION['user'] = ['id'=>$userRow['id'], 'email'=>$userRow['email'], 'role'=>$userRow['role']];
  }
  public static function logout(): void {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time()-42000,
        $params["path"], $params["domain"], true, true
      );
    }
    session_destroy();
  }
}
