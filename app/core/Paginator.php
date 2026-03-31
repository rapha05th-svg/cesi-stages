<?php
final class Paginator {
  public int $page;
  public int $perPage;
  public int $total;

  public function __construct(int $page, int $perPage, int $total) {
    $this->page = max(1, $page);
    $this->perPage = max(1, $perPage);
    $this->total = max(0, $total);
  }
  public function pages(): int { return (int)ceil($this->total / $this->perPage); }
  public function offset(): int { return ($this->page - 1) * $this->perPage; }
}
