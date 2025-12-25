<?php

namespace MMM;

use MMM\FieldGroups\SeoFields;
use MMM\Models\Post;
use Timber\{Timber, Site};
use MMM\Setup\{Assets, Security};
use MMM\Services\FieldGroupRegistryService;
use MMM\Traits\Singleton;

class Theme
{
  use Singleton;

  private Assets $assets;
  private Security $security;


  private function init():void
  {
    // Set Timber directory
    Timber::$dirname = ['views'];

    // Initialize assets
    $this->assets = new Assets();

    // Add WordPress security
    $this->security = Security::getInstance();

    // Register hooks
    add_action('after_setup_theme', [$this, 'setup']);
    add_filter('use_block_editor_for_post_type', '__return_false');

    // Register Timber necessities
    add_filter('timber/context', [$this, 'addToContext']);
    add_filter('timber/post/classmap', [$this, 'classmap']);

    $this->registerFieldGroups();
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

  public function classmap(array $classmap): array
  {
    $classmap['post'] = Post::class;
    $classmap['page'] = Post::class;

    return $classmap;
  }

  private function registerFieldGroups(): void
  {
    $fieldsRegistry = new FieldGroupRegistryService();

    // Add field groups here
    $fieldsRegistry->register(SeoFields::class);

    $fieldsRegistry->init();
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