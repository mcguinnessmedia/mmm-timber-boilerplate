<?php

namespace MMM;

use Timber\Timber;
use Timber\Site;
use MMM\Setup\{Assets, Security};
use MMM\Traits\Singleton;

class Theme
{
  use Singleton;

  private static ?Theme $instance = null;
  private Assets $assets;
  private Security $security;

  private function init():void
  {
    // Set Timber directory
    Timber::$dirname = ['views'];

    // Initialize assets
    $this->assets = new Assets();

    // Add WordPress security
    $this->security = new Security();

    // Register hooks
    add_action('after_setup_theme', [$this, 'setup']);
    add_filter('timber/context', [$this, 'addToContext']);
    add_filter('use_block_editor_for_post_type', '__return_false');
  }

  /**
   * Initialize key theme supports and nav menus
   * @return void
   */
  public function setup(): void
  {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');

    register_nav_menus([
      'primary' => __('Primary Menu'),
    ]);
  }

  /**
   * Add site data to Timber context
   * @param array $context
   * @return array
   */
  public function addToContext(array $context): array
  {
    $context['site'] = new Site();

    return $context;
  }
}