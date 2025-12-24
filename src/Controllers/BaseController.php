<?php

namespace MMM\Controllers;

use Timber\Timber;

abstract class BaseController
{
  protected array $context = [];

  public function __construct()
  {
    $this->context = Timber::context();
  }

  abstract public function render(): void;

  protected function renderView(string $template, array $data = []): void
  {
    Timber::render(
      $template,
      array_merge($this->context, $data)
    );
  }
}