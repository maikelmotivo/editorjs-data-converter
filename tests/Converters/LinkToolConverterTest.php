<?php

namespace Motivo\EditorJsDataConverter\Tests\Converters;

use Illuminate\Support\Arr;
use Motivo\EditorJsDataConverter\Converters\LinkToolConverter;
use PHPUnit\Framework\TestCase;

class LinkToolConverterTest extends TestCase
{
    /** @test */
    public function to_html_method_returns_correct_html(): void
    {
        $data = ['link' => 'motivo.nl'];

        $linkToolConverter = new LinkToolConverter();


        $this->assertSame(
            sprintf('<a href="%1$s">%1$s</a>', Arr::get($data, 'link')),
            $linkToolConverter->toHtml($data)
        );
    }
}
