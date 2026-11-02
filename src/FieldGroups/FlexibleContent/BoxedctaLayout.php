<?php

namespace MMM\FieldGroups\FlexibleContent;

use StoutLogic\AcfBuilder\FieldsBuilder;

class BoxedCtaLayout extends BaseLayout
{
  private const BACKGROUNDS = [
    'white'     => 'White',
    'light'     => 'Light Grey',
    'grey'      => 'Grey',
    'dark-blue' => 'Dark Blue',
  ];

  public function getName(): string
  {
    return 'boxed_cta';
  }

  protected function getLabel(): string
  {
    return 'Boxed Call to Action';
  }

  /**
   * This section manages its own background and spacing,
   * so skip the generic Section Settings and Motion tabs.
   */
  public function build(): FieldsBuilder
  {
    $this->fields = new FieldsBuilder( $this->getName() );
    $this->addFields();

    return $this->fields;
  }

  protected function addFields(): void
  {
    $this->fields
      // ---------- Intro ----------
      ->addTab( 'Content' )
      ->addButtonGroup( 'intro_alignment', [
        'label'         => __( 'Heading Alignment' ),
        'choices'       => [
          'left'   => 'Left',
          'center' => 'Center',
        ],
        'default_value' => 'left',
      ] )
      ->addText( 'heading', [
        'label'        => __( 'Heading' ),
        'instructions' => __( 'Optional. Leave empty if a Text box is the intro.' ),
      ] )
      ->addWysiwyg( 'content', [
        'label'        => __( 'Content' ),
        'toolbar'      => 'basic',
        'media_upload' => 0,
        'delay'        => true,
      ] )

      // ---------- Boxes ----------
      ->addTab( 'Boxes' )
      ->addRepeater( 'groups', [
        'label'        => __( 'Box Groups' ),
        'instructions' => __( 'Each group is its own grid with an optional subheading. Use one group if you don\'t need subheadings.' ),
        'layout'       => 'block',
        'button_label' => __( 'Add Group' ),
        'min'          => 1,
      ] )
        ->addText( 'subheading', [
          'label'   => __( 'Subheading' ),
          'wrapper' => [ 'width' => 60 ],
        ] )
        ->addButtonGroup( 'columns', [
          'label'         => __( 'Columns (desktop)' ),
          'choices'       => [ '2' => '2', '3' => '3', '4' => '4' ],
          'default_value' => '3',
          'wrapper'       => [ 'width' => 20 ],
        ] )
        ->addButtonGroup( 'row_size', [
          'label'         => __( 'Box Shape' ),
          'instructions'  => __( 'Square: Single boxes are square, Double + Tall boxes are big squares. Best for photo galleries.' ),
          'choices'       => [
            'default' => 'Default',
            'square'  => 'Square (gallery)',
          ],
          'default_value' => 'default',
          'wrapper'       => [ 'width' => 20 ],
        ] )
        ->addRepeater( 'cards', [
          'label'        => __( 'Boxes' ),
          'layout'       => 'block',
          'button_label' => __( 'Add Box' ),
          'collapsed'    => 'title',
          'min'          => 1,
        ] )

          // ----- Where the box gets its content -----
          ->addButtonGroup( 'source', [
            'label'         => __( 'Box Type' ),
            'instructions'  => __( 'Service and Industry pull the photo, name, excerpt and link from that page.' ),
            'choices'       => [
              'custom'   => 'Custom',
              'service'  => 'Service',
              'industry' => 'Industry',
            ],
            // Custom by default so boxes built before this option keep working
            'default_value' => 'custom',
          ] )
          ->addPostObject( 'service', [
            'label'         => __( 'Service' ),
            'post_type'     => [ 'service' ],
            'return_format' => 'id',
            'ui'            => 1,
            'required'      => true,
          ] )
            ->conditional( 'source', '==', 'service' )
          ->addPostObject( 'industry', [
            'label'         => __( 'Industry' ),
            'post_type'     => [ 'industry' ],
            'return_format' => 'id',
            'ui'            => 1,
            'required'      => true,
          ] )
            ->conditional( 'source', '==', 'industry' )

          // ----- Content (overrides for Service / Industry) -----
          ->addImage( 'image', [
            'label'         => __( 'Background Image' ),
            'instructions'  => __( 'Service/Industry: uses the featured image unless you pick one. Not used by Text boxes.' ),
            'return_format' => 'id',
            'preview_size'  => 'medium',
            'wrapper'       => [ 'width' => 30 ],
          ] )
          ->addText( 'title', [
            'label'        => __( 'Title' ),
            'instructions' => __( 'Service/Industry: uses the page name unless you type one.' ),
            'wrapper'      => [ 'width' => 35 ],
          ] )
          ->addLink( 'link', [
            'label'         => __( 'Link' ),
            'instructions'  => __( 'Makes the box clickable. Link text is used for the "Learn more" / button label.' ),
            'return_format' => 'array',
            'wrapper'       => [ 'width' => 35 ],
          ] )
            ->conditional( 'source', '==', 'custom' )
          ->addUrl( 'video', [
            'label'        => __( 'Video (optional)' ),
            'instructions' => __( 'YouTube or Vimeo link, or an .mp4 URL from the Media Library. Shows a play button over the image and opens the video in a pop-up. Takes the place of the link.' ),
            'placeholder'  => 'https://www.youtube.com/watch?v=...',
          ] )
          ->addTextarea( 'text', [
            'label'        => __( 'Description' ),
            'instructions' => __( 'Shown on Featured, Banner and Text styles. Service/Industry: uses the page excerpt unless you type one.' ),
            'rows'         => 3,
            'new_lines'    => '',
          ] )

          // ----- Look -----
          ->addSelect( 'style', [
            'label'         => __( 'Card Style' ),
            'choices'       => [
              'standard' => 'Standard (big title)',
              'featured' => 'Featured (title + description + learn more)',
              'banner'   => 'Banner (text left, button right)',
              'text'     => 'Text only (intro tile, no image)',
            ],
            'default_value' => 'featured',
            'wrapper'       => [ 'width' => 34 ],
          ] )
          ->addSelect( 'width', [
            'label'         => __( 'Width' ),
            'choices'       => [
              'single' => 'Single (1 column)',
              'half'   => 'Half row',
              'double' => 'Double (2 columns)',
              'full'   => 'Full row',
            ],
            'default_value' => 'single',
            'wrapper'       => [ 'width' => 33 ],
          ] )
          ->addSelect( 'height', [
            'label'         => __( 'Height' ),
            'choices'       => [
              'short'    => 'Short (banner strip)',
              'standard' => 'Standard',
              'tall'     => 'Tall (2 rows)',
            ],
            'default_value' => 'standard',
            'wrapper'       => [ 'width' => 33 ],
          ] )
        ->endRepeater()
      ->endRepeater()

      // ---------- Settings ----------
      ->addTab( 'Settings' )
      ->addSelect( 'background', [
        'label'         => __( 'Background Color' ),
        'choices'       => self::BACKGROUNDS,
        'default_value' => 'white',
      ] )
      ->addText( 'anchor_id', [
        'label'        => __( 'Anchor ID' ),
        'instructions' => __( 'Optional, no #' ),
      ] );
  }
}