<?php

namespace MMM\Traits;

use MMM\FieldGroups\FlexibleContent\BaseLayout;

trait HasFlexibleContent
{
  protected array $layouts = [];

  public function registerLayout(BaseLayout $layout): void
  {
    $this->layouts[] = $layout;
  }
}