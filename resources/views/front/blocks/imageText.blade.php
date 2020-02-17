<section class="container grid col-gap-8 row-gap-8 grid-flow-row-dense {{ $block->present()->imageTextContainerClass }}">
    @include('front.components.figure', [
        'src' => $block->image('image', 'desktop'),
        'alt' => $block->imageAltText('image'),
        'caption' => $block->imageCaption('image'),
        'classes' => $block->present()->imageTextImageClass
    ])

    <div class="{{ $block->present()->imageTextContentClass }}">
        {!! $block->translatedInput('text') !!}
    </div>
</section>
