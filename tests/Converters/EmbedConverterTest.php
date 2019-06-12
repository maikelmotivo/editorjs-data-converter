<?php


namespace Motivo\EditorJsDataConverter\Tests\Converters;


use Illuminate\Support\Arr;
use Motivo\EditorJsDataConverter\Converters\EmbedConverter;
use Motivo\EditorJsDataConverter\Exceptions\InvalidEditorDataException;
use PHPUnit\Framework\TestCase;

class EmbedConverterTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            'correct_without_caption' => [
                [
                    'service' => 'youtube',
                    'embed' => 'www.youtube.com/embed/Fw5R3x-egbE',
                    'expects' => "<div class=\"embed-container\"><div class=\"embed-responsive embed-responsive-16by9\"><iframe class=\"embed-responsive-item\" src=\"www.youtube.com/embed/Fw5R3x-egbE\" frameborder=\"0\" allowFullscreen=\"true\"></iframe></div></div>",
                ]
            ],
            'correct_with_caption' => [
                [
                    'service' => 'youtube',
                    'embed' => 'www.youtube.com/embed/Fw5R3x-egbE',
                    'caption' => 'caption',
                    'expects' => "<div class=\"embed-container\"><div class=\"embed-responsive embed-responsive-16by9\"><iframe class=\"embed-responsive-item\" src=\"www.youtube.com/embed/Fw5R3x-egbE\" frameborder=\"0\" allowFullscreen=\"true\"></iframe></div><p class=\"caption\">caption</p></div>"
                ]
            ],
            'service_missing' => [
                [
                    'embed' => 'www.youtube.com/embed/Fw5R3x-egbE',
                ]
            ],
            'embed_missing' => [
                [
                    'service' => 'youtube',
                ]
            ],
            'invalid_service' => [
                [
                    'service' => 'invalid_service',
                    'embed' => 'www.youtube.com/embed/Fw5R3x-egbE',
                ]
            ],
        ];
    }

    /**
     * @dataProvider dataProvider
     * @test
     * @param array $data
     */
    public function to_html_returns_correct_html(array $data): void
    {
        $supportedServices = [
            'youtube',
        ];

        if(! Arr::has($data, 'service')) {
            $this->expectException(InvalidEditorDataException::class);
            $this->expectExceptionMessage('No embed service found');
        } elseif (! in_array(Arr::get($data, 'service'), $supportedServices)) {
            $this->expectException(InvalidEditorDataException::class);
            $this->expectExceptionMessage('Embed service \'' . Arr::get($data, 'service') . '\' not supported');
        } elseif (! Arr::has($data,'embed')) {
            $this->expectException(InvalidEditorDataException::class);
            $this->expectExceptionMessage('No embed url found');
        }

        $converter = new EmbedConverter();

        $html = $converter->toHtml($data);

        $this->assertEquals(Arr::get($data,'expects'), $html);
    }
}