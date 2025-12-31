<?php

namespace MMM\Traits;

use MMM\FieldGroups\FlexibleContent\BaseLayout;
use MMM\Services\FlexibleContentRegistryService;

trait HasFlexibleContent
{
  protected array $layouts = [];

  public function registerLayout(BaseLayout $layout): void
  {
    $this->layouts[] = $layout;
    FlexibleContentRegistryService::getInstance()->register($layout);
  }
}