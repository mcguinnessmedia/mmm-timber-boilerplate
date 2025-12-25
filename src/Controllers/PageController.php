<?php

namespace MMM\Controllers;

use Timber\Timber;
use MMM\Models\Post;

class PageController extends BaseController
{
  public function render(): void
  {
    $this->renderView(
      'pages/page.twig',
      [
        'post' => Timber::get_post(get_the_ID()),
      ]
    );
  }
}