<?php

namespace MMM\FieldGroups;

use MMM\Traits\HasFlexibleContent;
use MMM\FieldGroups\FlexibleContent\{TwoColumnLayout};

class PageContent extends BaseFieldGroup
{
  use HasFlexibleContent;

  public function __construct()
  {
    $this->registerLayout(new TwoColumnLayout());
  }

  public function getTitle(): string
  {
    return 'Page Content';
  }

  protected function getLocation(): array
  {
    return [
      ['post_type', '==', 'page']
    ];
  }

  protected function addFields(): void
  {
    $flexibleContent = $this->fields->addFlexibleContent('components',
     [
       'label' => __('Components', 'mcguinnessmedia'),
       'button_label' => __('Add Component', 'mcguinnessmedia'),
     ]);

    foreach ($this->layouts as $layout) {
      $builder = $layout->build();
      $config = $layout->getConfig();

      $flexibleContent->addLayout($builder, $config);

    }
  }
}