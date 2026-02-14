<?php
/** @noinspection SpellCheckingInspection */

namespace MMM\Setup;

use MMM\Traits\Singleton;

class Security
{
  use Singleton;

  /**
   * Add security headers to harden the WordPress instance.
   * @return void
   */
  public function addSecurityHeaders(): void
  {
    if (!is_admin()) {
      header('X-Content-Type-Options: nosniff');
      header('X-Frame-Options: SAMEORIGIN');
      header('X-XSS-Protection: 1; mode=block');
      header('Referrer-Policy: no-referrer-when-cross-origin');
    }
  }

  private function init(): void
  {
    remove_action('wp_head', 'wp_generator');

    add_filter('xmlrpc_enabled', '__return_false');

    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');

    if (!defined('DISALLOW_FILE_EDIT')) {
      define('DISALLOW_FILE_EDIT', true);
    }

    add_action('send_headers', [$this, 'addSecurityHeaders']);
  }
}