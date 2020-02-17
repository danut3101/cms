<?php

declare(strict_types=1);

return [

    // Layout to use when rendering a single block in the editor
    'block_single_layout' => 'front.layouts.blocks',

    // Path where a view file per block type is stored
    'block_views_path' => 'front.blocks',

    // Custom mapping of block types and views
    'block_views_mappings' => [],

    // Indicates if childs should be rendered when using repeater in blocks
    'block_preview_render_childs' => false,

    // Allows setting a custom presenter to a block model
    'block_presenter_path' => Code4Romania\Cms\Presenters\BlockPresenter::class,

    'blocks' => [
        'accordion' => [
            'title'      => 'Accordion',
            'icon'       => 'media-list',
            'component'  => 'a17-block-accordion',
        ],
        'embed' => [
            'title'      => 'Embed',
            'icon'       => 'revision-single',
            'component'  => 'a17-block-embed',
        ],
        'quote' => [
            'title'      => 'Quote',
            'icon'       => 'quote',
            'component'  => 'a17-block-quote',
        ],
        'imageGrid' => [
            'title'      => 'Image grid',
            'icon'       => 'fix-grid',
            'component'  => 'a17-block-imagegrid',
        ],
        'imageText' => [
            'title'      => 'Image with text',
            'icon'       => 'image-text',
            'component'  => 'a17-block-imagetext',
        ],
        'callToAction' => [
            'title'      => 'Call to action',
            'icon'       => 'colors',
            'component'  => 'a17-block-calltoaction',
        ],
        'newsletter' => [
            'title'      => 'Subscribe to newsletter',
            'icon'       => 'info',
            'component'  => 'a17-block-newsletter',
        ],
        'text' => [
            'title'      => 'Text',
            'icon'       => 'text',
            'component'  => 'a17-block-text',
        ],
    ],
    'repeaters' => [
        'accordionItem' => [
            'title'      => 'Item',
            'trigger'    => 'Add accordion item',
            'component'  => 'a17-block-accordionitem',
            'max'        => 20,
        ],
    ],

];