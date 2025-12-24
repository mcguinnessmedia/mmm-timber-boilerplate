<?php

namespace MMM\Traits;

use Exception;
use MMM\Theme;

trait Singleton
{
  private static ?self $instance;

  public static function getInstance(): self
  {
    if (null === self::$instance) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  abstract private function __construct();

  final protected function __clone(): void {}

  /**
   * @return void
   * @throws Exception
   */
  final protected function __wakeup(): void {
    throw new Exception("Cannot unserialize singleton");
  }
}