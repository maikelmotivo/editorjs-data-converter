<?php

namespace Motivo\EditorJsDataConverter\Tests\Converters;

use Illuminate\Support\Str;
use Motivo\EditorJsDataConverter\Converters\ListConverter;
use PHPUnit\Framework\TestCase;

class ListConverterTest extends TestCase
{
    private const UNORDERED_LIST = 'ul';
    private const ORDERED_LIST = 'ol';

    public function listProvider(): array
    {
        return [
            'ordered list' => [
                [
                    'style' => 'ordered',
                    'items' => [
                        'item one',
                        'item two',
                    ],
                ],
            ],
            'unordered list' => [
                [
                    'style' => 'unordered',
                    'items' => [
                        'item one',
                        'item two',
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider listProvider
     * @test
     * @param array $data
     */
    public function to_html_method_returns_correct_html(array $data): void
    {
        $listConverter = new ListConverter();

        $this->assertSame(
            $this->generateExpectedList($data),
            $listConverter->toHtml($data)
        );
    }

    private function generateExpectedList(array $data): string
    {
        $listStyle = constant('self::' . Str::upper($data['style'] . '_list'));

        $listElement = '';

        $openTag = sprintf('<%1$s>', $listStyle);

        $listElement .= $openTag;

        foreach ($data['items'] as $item) {
            $listElement .= sprintf('<li>%s</li>', $item);
        }

        $listElement .= sprintf('</%1$s>', $listStyle);

        return $listElement;
    }
}
