<?php

namespace MMM\FieldGroups\FlexibleContent;

use MMM\FieldGroups\Partials\ContentPartial;

class StatsLayout extends BaseLayout
{
  public function getName(): string
  {
    return 'stats';
  }

  protected function getLabel(): string
  {
    return 'Stats';
  }

  protected function addFields(): void
  {
    $this->fields
      ->addTab('Content')
      ->addFields(ContentPartial::get())

      ->addTab('Stats')
      ->addButtonGroup('style', [
        'label' => 'Stat Style',
        'choices' => [
          'circles'  => 'Circles',
          'cards'    => 'Cards',
          'features' => 'Features + Image',
        ],
        'default_value' => 'circles',
      ])

      // ---------- Circles / Cards ----------
      ->addRepeater('stats', [
        'layout' => 'block',
        'button_label' => 'Add Stat',
        'max' => 4,
      ])
        ->conditional('style', '!=', 'features')
        ->addField('icon', 'font-awesome', [
          'label' => 'Icon',
          'save_format' => 'class',
          'allow_null' => 1,
          'show_preview' => 1,
          'wrapper' => ['width' => '20'],
        ])
        ->addText('number', [
          'required' => true,
          'instructions' => 'e.g. 2K, 600, 1.8K',
          'wrapper' => ['width' => '20'],
        ])
        ->addText('suffix', [
          'instructions' => 'e.g. +',
          'wrapper' => ['width' => '15'],
        ])
        ->addText('label', [
          'required' => true,
          'wrapper' => ['width' => '30'],
        ])
        ->addSelect('accent', [
          'instructions' => 'Circles style only.',
          'choices' => [
            'grey' => 'Grey',
            'blue' => 'Blue',
          ],
          'default_value' => 'grey',
          'wrapper' => ['width' => '15'],
        ])
      ->endRepeater()

      // ---------- Features + Image ----------
      ->addRepeater('features', [
        'label' => 'Features',
        'layout' => 'table',
        'button_label' => 'Add Feature',
        'instructions' => 'Shown in two columns. 4 works best.',
      ])
        ->conditional('style', '==', 'features')
        ->addField('icon', 'font-awesome', [
          'label' => 'Icon',
          'save_format' => 'class',
          'allow_null' => 1,
          'show_preview' => 1,
          'wrapper' => ['width' => '25'],
        ])
        ->addTextarea('text', [
          'label' => 'Text',
          'required' => true,
          'rows' => 2,
          'new_lines' => '',
          'wrapper' => ['width' => '75'],
        ])
      ->endRepeater()
      ->addImage('image', [
        'label' => 'Side Image',
        'return_format' => 'array',
        'preview_size' => 'medium',
      ])
        ->conditional('style', '==', 'features');
  }
}