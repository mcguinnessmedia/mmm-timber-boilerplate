<?php

namespace MMM\Services;

use MMM\Traits\Singleton;
use Twig\TwigFilter;

class TwigFilterService
{
  use Singleton;

  public function registerFilters( $twig )
  {
    $twig->addFilter(new TwigFilter('tel', function ( ?string $phone ): string {
      if ( !$phone ) {
        return '';
      }
      return preg_replace('/[^0-9+]/', '', $phone);
    }));

    $twig->addFilter(new TwigFilter('obfuscateEmail', fn( $e ) => antispambot($e)));

    $twig->addFilter(new TwigFilter('slugify', function($text) {
      $text = strtolower($text);
      $text = preg_replace('/[\s_]+/', '-', $text);
      $text = preg_replace('/[^a-z0-9\-]/', '', $text);
      $text = preg_replace('/-+/', '-', $text);
      return trim($text, '-');
    }));

    return $twig;
  }

  private function init(): void
  {
    add_filter('timber/twig', [$this, 'registerFilters']);
  }
}