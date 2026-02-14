<?php

namespace MMM\Traits;

use Exception;

trait Singleton
{
  private static ?self $instance = null;

  public static function getInstance(): self
  {
    if (null === self::$instance) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  final private function __construct() {
    $this->init();
  }

  /**
   * Initialize the theme class. Used to protect the constructor.
   * @return void
   */
  abstract private function init(): void;

  final protected function __clone(): void {}

  /**
   * @return void
   * @throws Exception
   */
  final protected function __wakeup(): void {
    throw new Exception("Cannot unserialize singleton");
  }
}