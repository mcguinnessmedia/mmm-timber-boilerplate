<?php

namespace MMM;

use Timber\Timber;
use Timber\Site;

class Theme
{
  private static ?Theme $instance = null;

  /**
   * Singleton pattern for Theme instance
   * @return Theme
   */
  public static function getInstance(): Theme {
    if (null === self::$instance) {
      self::$instance = new Theme();
    }
    return self::$instance;
  }

  final private function __construct() {
    add_action('after_setup_theme', [$this, 'setup']);
    add_filter('timber/context', [$this, 'add_to_context']);
    add_filter('use_block_editor_for_post_type', '__return_false');

    Timber::$dirname = ['views'];
  }

  /**
   * Initialize key theme supports and nav menus
   * @return void
   */
  public static function setup(): void {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');

    register_nav_menus([
      'primary' => __('Primary Menu'),
    ]);
  }

  public function addToContext(array $context): array {
    $context['site'] = new Site();

    return $context;
  }
}