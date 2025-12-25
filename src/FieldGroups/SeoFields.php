<?php

namespace MMM\FieldGroups;

class SeoFields extends BaseFieldGroup
{
  protected function getTitle(): string
  {
    return 'SEO Metadata';
  }

  protected function getLocation(): array
  {
    return [
      ['post_type', '==', 'post'],
      ['post_type', '!=', 'post'],
    ];
  }

  protected function addFields(): void
  {
    $this->fields
      ->addGroup('seo_metadata')
        ->addText('title')
        ->addTextarea('description')
        ->addImage('image')
      ->endGroup();
  }
}