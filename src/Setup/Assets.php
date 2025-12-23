<?php

namespace MMM\Setup;

use MMM\Services\ViteService;

class Assets
{
  private ViteService $vite;
  public function __construct()
  {
    $this->vite = ViteService::getInstance();
    $this->enqueue();
  }

  public function enqueue(): void
  {
    $this->vite->enqueue('mmm-main', 'main');
  }
}