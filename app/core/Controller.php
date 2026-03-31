<?php
abstract class Controller {
  protected function view(string $template, array $data=[]): void {
    View::render($template, $data);
  }
  protected function redirect(string $path): void {
    $base = App::config()['app']['base_path'] ?? '';
    header("Location: " . $base . $path);
    exit;
  }
  protected function requireLogin(): void {
    if (!Auth::check()) $this->redirect('/login');
  }
  protected function requireRole(array $roles): void {
    $this->requireLogin();
    if (!in_array(Auth::role(), $roles, true)) {
      http_response_code(403);
      echo "403 Forbidden";
      exit;
    }
  }
  protected function flash(string $type, string $msg): void {
    $_SESSION['flash'][] = ['type'=>$type,'msg'=>$msg];
  }
}
