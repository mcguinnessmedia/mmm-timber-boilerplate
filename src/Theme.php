<?php

namespace MMM;

use Timber\Timber;
use Timber\Site;
use MMM\Setup\Assets;

class Theme
{
  private static ?Theme $instance = null;
  private Assets $assets;

  /**
   * Singleton pattern for Theme instance
   * @return Theme
   */
  public static function getInstance(): Theme
  {
    if (null === self::$instance) {
      self::$instance = new Theme();
    }
    return self::$instance;
  }

  final private function __construct()
  {
    // Set Timber directory
    Timber::$dirname = ['views'];

    // Initialize assets
    $this->assets = new Assets();

    // Register hooks
    add_action('after_setup_theme', [$this, 'setup']);
    add_filter('timber/context', [$this, 'addToContext']);
    add_filter('use_block_editor_for_post_type', '__return_false');
  }

  // Prevent cloning
  private function __clone() {}

  // Prevent unserialization
  public function __wakeup()
  {
    throw new \Exception("Cannot unserialize singleton");
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