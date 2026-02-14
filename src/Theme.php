<?php

namespace MMM;

use MMM\FieldGroups\{PageContent, SeoFields};
use MMM\Models\Post;
use MMM\Services\{FieldGroupRegistryService, PostTypeRegistryService, TwigFilterService, ViteService};
use MMM\Setup\Security;
use MMM\Traits\Singleton;
use Timber\{Site, Timber};

class Theme
{
  use Singleton;

  private Security $security;
  private TwigFilterService $twigFilterService;

  /**
   * Initialize key theme supports and nav menus.
   * @return void
   */
  public function setup(): void
  {
    add_theme_support('post-thumbnails');

    register_nav_menus([
      'primary' => __('Primary Menu'),
    ]);
  }

  /**
   * Add models to the Timber classmap.
   * For use in the `timber/post/classmap` hook.
   * @param array $classmap
   * @return array
   */
  public function classmap(array $classmap): array
  {
    $classmap['post'] = Post::class;
    $classmap['page'] = Post::class;

    return $classmap;
  }

  /**
   * Add site data to Timber context.
   * @param array $context
   * @return array
   */
  public function addToContext(array $context): array
  {
    $context['site'] = new Site();
    $context['menu'] = Timber::get_menu('primary');

    return $context;
  }

  private function init(): void
  {
    // Set Timber directory
    Timber::$dirname = ['views'];

    // Enqueue assets
    $this->enqueue();

    // Add WordPress security
    $this->security = Security::getInstance();

    // Add extra Twig filters
    $this->twigFilterService = TwigFilterService::getInstance();

    // Register hooks
    add_action('after_setup_theme', [$this, 'setup']);
    add_filter('use_block_editor_for_post_type', '__return_false');

    // Register Timber necessities
    add_filter('timber/context', [$this, 'addToContext']);
    add_filter('timber/post/classmap', [$this, 'classmap']);

    $this->registerPostTypes();
    $this->registerFieldGroups();
  }

  /**
   * Enqueue assets using the ViteService.
   * @return void
   */
  function enqueue(): void
  {
    $vite = ViteService::getInstance();
    $vite->enqueue('mmm-main', 'main');
  }

  /**
   * Register ACF field groups using the FieldGroupRegistryService.
   * @return void
   */
  private function registerFieldGroups(): void
  {
    $fieldsRegistry = FieldGroupRegistryService::getInstance();

    // Add field groups here
    $fieldsRegistry->register(SeoFields::class);
    $fieldsRegistry->register(PageContent::class);

    $fieldsRegistry->init();
  }

  /**
   * Register post types using the PostTypeRegistryService.
   * @return void
   */
  private function registerPostTypes(): void {
    $postTypeRegistry = PostTypeRegistryService::getInstance();

    // $postTypeRegistry->register(BasePostType::class);
  }
}