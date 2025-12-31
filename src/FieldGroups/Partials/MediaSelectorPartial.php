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
          ]
        ])
      ->addImage('image')->conditional('type', '==', 'image')
      ->addGallery('gallery')->conditional('type', '==', 'slider')
      ->addTextarea('embed')->conditional('type', '==', 'embed')
      // TODO: add support for multiple video upload types (files for MP4, WebM, responsive sizes, etc)
      ->addFile('upload')->conditional('type', '==', 'upload')
    ->endGroup();

    return $fields;
  }
}