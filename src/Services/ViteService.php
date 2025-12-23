<?php

namespace MMM\Services;

class ViteService
{
  private static ?ViteService $instance = null;
  private string $distPath;
  private string $distUri;
  private ?array $manifest = null;
  private bool $manifestLoaded = false;

  private function __construct()
  {
    $this->distPath = get_template_directory() . '/assets/dist';
    $this->distUri = get_template_directory_uri() . '/assets/dist';
    $this->loadManifest();
  }

  public static function getInstance(): self
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  // Prevent cloning
  private function __clone() {}

  // Prevent unserialization
  public function __wakeup()
  {
    throw new \Exception("Cannot unserialize singleton");
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
        null,
        ['in_footer' => true, 'strategy' => 'defer']
      );
      wp_script_add_data($handle, 'type', 'module');

      foreach ($cssUrls as $index => $cssUrl) {
        wp_enqueue_style($handle . '-css-' . $index, $cssUrl, [], null);
      }
    });
  }

  private function asset(string $entry): ?string
  {
    if (!$this->manifest || !isset($this->manifest[$entry])) {
      error_log('Vite asset not found in manifest: ' . $entry);
      return null;
    }

    return $this->distUri . '/' . $this->manifest[$entry]['file'];
  }

  private function css(string $entry): array
  {
    if (!$this->manifest || !isset($this->manifest[$entry]['css'])) {
      return [];
    }

    $cssFiles = [];
    foreach ($this->manifest[$entry]['css'] as $cssFile) {
      $cssFiles[] = $this->distUri . '/' . $cssFile;
    }

    return $cssFiles;
  }
}