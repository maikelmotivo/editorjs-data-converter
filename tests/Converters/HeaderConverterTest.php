<?php

namespace Motivo\EditorJsDataConverter\Test\Converters;

use Illuminate\Support\Arr;
use Motivo\EditorJsDataConverter\Converters\HeaderConverter;
use PHPUnit\Framework\TestCase;

class HeaderConverterTest extends TestCase
{
    public function headingDataProvider()
    {
        return [
            'heading with h1' => [['level' => 1, 'text' => 'heading 1']],
            'heading with h2' => [['level' => 2, 'text' => 'heading 2']],
            'heading with h3' => [['level' => 3, 'text' => 'heading 3']],
            'heading with h4' => [['level' => 4, 'text' => 'heading 4']],
            'heading with h5' => [['level' => 5, 'text' => 'heading 5']],
            'heading with h6' => [['level' => 6, 'text' => 'heading 6']],
        ];
    }

    /**
     * @dataProvider headingDataProvider
     * @test
     */
    public function to_html_method_returns_correct_html(array $data): void
    {
        $headingConverter = new HeaderConverter();

        $this->assertSame(
            sprintf(
                '<h%1$s>%2$s</h%1$s>',
                Arr::get($data, 'level', 1),
                Arr::get($data, 'text', '')
            ),
            $headingConverter->toHtml($data)
        );
    }
}
