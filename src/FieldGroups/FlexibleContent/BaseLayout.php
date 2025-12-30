<?php

namespace MMM\FieldGroups\FlexibleContent;

use StoutLogic\AcfBuilder\FieldsBuilder;
use StoutLogic\AcfBuilder\FieldNameCollisionException;

abstract class BaseLayout {
  protected FieldsBuilder $fields;

  abstract protected function getName(): string;
  abstract protected function getLabel(): string;

  /**
   * @return void
   * @throws FieldNameCollisionException
   */
  abstract protected function addFields(): void;

  /**
   * @return FieldsBuilder
   * @throws FieldNameCollisionException
   */
  public function build(): FieldsBuilder
  {
    $this->fields = new FieldsBuilder($this->getName());
    $this->addFields();
    return $this->fields;
  }

  public function getView(): string
  {
    return 'views/partials/sections/' . $this->getName() . '.twig';
  }

  public function getLayoutConfig(): array
  {
    return [
      'name' => $this->getName(),
      'label' => $this->getLabel(),
      'display' => $this->getDisplay(),
      'min' => $this->getMin(),
      'max' => $this->getMax(),
    ];
  }

  protected function getDisplay(): string
  {
    return 'block';
  }

  protected function getMin(): string
  {
    return '';
  }

  protected function getMax(): string
  {
    return '';
  }
}