<?php

namespace Motivo\EditorJsDataConverter\Test\Converters;

use Motivo\EditorJsDataConverter\Converters\ParagraphConverter;
use PHPUnit\Framework\TestCase;

class ParagraphConverterTest extends TestCase
{
    /** @test */
    public function to_html_method_returns_correct_html(): void
    {
        $data = ['text' => 'This is a test'];

        $paragraphConverter = new ParagraphConverter();

        $this->assertSame(
            sprintf('<p>%s</p>', $data['text']),
            $paragraphConverter->toHtml($data)
        );
    }
}
