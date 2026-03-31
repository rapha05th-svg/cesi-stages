<?php
final class View {
  public static function render(string $template, array $data=[]): void {
    extract($data, EXTR_SKIP);
    $templateFile = __DIR__ . '/../views/' . $template . '.php';
    if (!file_exists($templateFile)) {
      throw new RuntimeException("View not found: $templateFile");
    }
    $GLOBALS['templateFile'] = $templateFile;
    require __DIR__ . '/../views/layout.php';
  }
}