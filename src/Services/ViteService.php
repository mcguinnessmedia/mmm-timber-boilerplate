<?php

namespace MMM\Services;

use MMM\Traits\Singleton;

class ViteService
{
  use Singleton;

  private string $distPath;
  private string $distUri;
  private ?array $manifest = null;
  private bool $manifestLoaded = false;
  private ?string $buildVersion = null;

  private function init(): void
  {
    $this->distPath = get_template_directory() . '/assets/dist';
    $this->distUri = get_template_directory_uri() . '/assets/dist';
    $this->loadManifest();
  }

  private function loadManifest(): void
  {
    $manifestPath = $this->distPath . '/.vite/manifest.json';

    if (!file_exists($manifestPath)) {
      add_action('admin_notices', function () {
        echo '<div class="notice notice-error"><p>'
          . 'Vite manifest not found. Run <code>npm run build</code>.'
          . '</p></div>';
      });
      return;
    }

    $this->buildVersion = (string) filemtime($manifestPath);

    $manifestContent = file_get_contents($manifestPath);
    $this->manifest = json_decode($manifestContent, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
      error_log('Failed to parse Vite manifest: ' . json_last_error_msg());
      return;
    }

    $this->manifestLoaded = true;
  }

  public function enqueue(string $handle, string $entry, array $dependencies = []): void
  {
    if (!$this->manifestLoaded) {
      error_log('Cannot enqueue assets: Vite manifest not loaded');
      return;
    }

    $jsUrl = $this->asset($entry);
    $cssUrls = $this->css($entry);

    if (!$jsUrl) {
      return;
    }

    add_action('wp_enqueue_scripts', function () use ($handle, $dependencies, $jsUrl, $cssUrls) {
      wp_enqueue_script(
        $handle,
        $jsUrl,
        $dependencies,
        $this->buildVersion,
        ['in_footer' => true, 'strategy' => 'defer']
      );
      wp_script_add_data($handle, 'type', 'module');

      foreach ($cssUrls as $index => $cssUrl) {
        wp_enqueue_style($handle . '-css-' . $index, $cssUrl, [], $this->buildVersion);
      }
    });
  }

  private function asset(string $entry): ?string
  {
    if (!$this->manifest) {
      error_log('Vite manifest not loaded');
      return null;
    }

    // Try direct lookup first (for full paths)
    if (isset($this->manifest[$entry])) {
      return $this->distUri . '/' . $this->manifest[$entry]['file'];
    }

    // Search by name field
    foreach ($this->manifest as $manifestEntry) {
      if (isset($manifestEntry['name']) && $manifestEntry['name'] === $entry) {
        return $this->distUri . '/' . $manifestEntry['file'];
      }
    }

    error_log('Vite asset not found in manifest: ' . $entry);
    return null;
  }

  private function css(string $entry): array
  {
    if (!$this->manifest) {
      return [];
    }

    $manifestEntry = null;

    // Try direct lookup first (for full paths)
    if (isset($this->manifest[$entry])) {
      $manifestEntry = $this->manifest[$entry];
    } else {
      // Search by name field
      foreach ($this->manifest as $item) {
        if (isset($item['name']) && $item['name'] === $entry) {
          $manifestEntry = $item;
          break;
        }
      }
    }

    if (!$manifestEntry || !isset($manifestEntry['css'])) {
      return [];
    }

    $cssFiles = [];
    foreach ($manifestEntry['css'] as $cssFile) {
      $cssFiles[] = $this->distUri . '/' . $cssFile;
    }

    return $cssFiles;
  }
}