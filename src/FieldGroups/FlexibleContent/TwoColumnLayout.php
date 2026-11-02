<?php

namespace MMM\FieldGroups\FlexibleContent;

use MMM\FieldGroups\Partials\{ContentPartial, MediaSelectorPartial};

class TwoColumnLayout extends BaseLayout {
  public function getName(): string
  {
    return 'two-column';
  }

  protected function getLabel(): string
  {
    return 'Two Column';
  }

  protected function addFields(): void
  {
    $this->fields
      ->addTab('Content')
      ->addButtonGroup( 'alignment', [
          'label' => 'Image Side',
          'choices' => [
            'left' => 'Image Left',
            'right' => 'Image Right',
          ],
          'default_value' => 'right',
        ]
      )
      ->addFields( ContentPartial::get() )
      ->addTab('Media')
      ->addFields( MediaSelectorPartial::get() );
  }
}