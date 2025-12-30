<?php

namespace MMM\FieldGroups\Partials;

use StoutLogic\AcfBuilder\FieldsBuilder;
use StoutLogic\AcfBuilder\FieldNameCollisionException;

abstract class BasePartial {
  /**
   * @return FieldsBuilder
   * @throws FieldNameCollisionException
   */
  abstract public static function get(): FieldsBuilder;
}