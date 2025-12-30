<?php

namespace MMM\FieldGroups\Partials;

use StoutLogic\AcfBuilder\FieldsBuilder;

class ContentPartial extends BasePartial {
  public static function get(): FieldsBuilder
  {
    $fields = new FieldsBuilder('section_content');

    $fields->addGroup('content')
        ->addText('heading', ['required' => true])
        ->addWysiwyg('content', ['required' => true])
        ->addRepeater('buttons')
          ->addLink('button')
        ->endRepeater()
      ->endGroup();

    return $fields;
  }
}