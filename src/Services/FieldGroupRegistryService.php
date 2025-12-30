<?php

namespace MMM\Services;

use MMM\FieldGroups\BaseFieldGroup;
use MMM\Traits\Singleton;
use InvalidArgumentException;

class FieldGroupRegistryService
{
  use Singleton;

  private array $fieldGroups = [];

  public function init(): void {
    add_action('acf/init', [$this, 'registerAll']);
  }

  public function registerAll(): void {
    foreach ($this->fieldGroups as $fieldGroupClass) {
      $fieldGroup = new $fieldGroupClass();
      $fieldGroup->register();
    }
  }

  public function register(string $fieldGroupClass): void
  {
    if (!is_subclass_of($fieldGroupClass, BaseFieldGroup::class)) {
      throw new InvalidArgumentException(
        "$fieldGroupClass is not a subclass of BaseFieldGroup"
      );
    }

    $this->fieldGroups[] = $fieldGroupClass;
  }
}