<?php

namespace MMM\FieldGroups;

use ReflectionClass;
use StoutLogic\AcfBuilder\FieldsBuilder;

abstract class BaseFieldGroup
{
  protected FieldsBuilder $fields;

  public function getKey(): string
  {
    $className = (new ReflectionClass($this))->getShortName();
    return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $className));
  }

  public function register():void
  {
    if (function_exists('acf_add_local_field_group')) {
      acf_add_local_field_group($this->build()->build());
    }
  }

  public function build(): FieldsBuilder
  {
    $this->fields = new FieldsBuilder($this->getKey());

    $this->addFields();
    $this->setLocation();

    return $this->fields;
  }

  abstract protected function addFields(): void;

  protected function setLocation(): void
  {
    foreach ($this->getLocation() as $location) {
      $this->fields->setLocation(...$location);
    }
  }

  abstract protected function getLocation(): array;

  abstract protected function getTitle(): string;
}