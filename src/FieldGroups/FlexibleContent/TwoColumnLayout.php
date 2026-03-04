<?php

namespace MMM\FieldGroups\FlexibleContent;

use MMM\FieldGroups\Partials\ContentPartial;
use MMM\FieldGroups\Partials\MediaSelectorPartial;

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
      ->addRadio( 'alignment', [
          'label' => 'Alignment',
          'choices' => [
            'left' => 'Left',
            'right' => 'Right',
          ],
          'default_value' => 'left',
        ]
      )
      ->addFields( ContentPartial::get() )
      ->addFields( MediaSelectorPartial::get() );
  }
}