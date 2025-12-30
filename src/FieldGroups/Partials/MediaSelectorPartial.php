<?php

namespace MMM\FieldGroups\Partials;

use StoutLogic\AcfBuilder\FieldsBuilder;

class MediaSelectorPartial extends BasePartial {
  public static function get(): FieldsBuilder
  {
    $fields = new FieldsBuilder('media_selector');

    $fields->addGroup('media')
        ->addRadio('type', [
          'label' => 'Media Type',
          'choices' => [
            'image' => 'Image',
            'slider' => 'Slider',
            'embed' => 'Embedded Video',
            'upload' => 'Uploaded Video',
            'mux' => 'Mux Video',
          ]
        ])
      ->addImage('image')->conditional('type', '==', 'image')
      ->addGallery('gallery')->conditional('type', '==', 'slider')
      ->addTextarea('embed')->conditional('type', '==', 'embed')
      ->addFile('upload')->conditional('type', '==', 'upload')
      ->addText('mux')->conditional('type', '==', 'mux')
    ->endGroup();

    return $fields;
  }
}