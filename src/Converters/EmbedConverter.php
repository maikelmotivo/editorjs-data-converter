<?php

namespace Motivo\EditorJsDataConverter\Converters;

use Motivo\EditorJsDataConverter\Converters\Contracts\Converter;
use Motivo\EditorJsDataConverter\Traits\WithHtml;
use Spatie\Html\Elements\Element;
use Illuminate\Support\Arr;

class EmbedConverter implements Converter
{
    use WithHtml;

    public function toHtml(array $itemData): string
    {
        $container = $this->getContainer();

        $iframe = $this->getIframe(Arr::get($itemData, 'service'), Arr::get($itemData, 'embed'));

        $caption = $this->getCaption(Arr::get($itemData, 'caption'));

        return $container->child([$iframe, $caption]);
    }

    private function getContainer(): Element
    {
        return $this->html->element('div')->class('embed-container');
    }

    private function getIframeContainer(): Element
    {
        return $this->html->element('div')->class('embed-responsive embed-responsive-16by9');
    }

    private function getCaption(?string $caption): ?Element
    {
        if ($caption) {
            return $this->html->element('p')->html($caption)->class('caption');
        }

        return null;
    }

    private function getIframe(string $service, string $url): Element
    {
        $container = $this->getIframeContainer();
        $iframe = $this->{'get' . ucfirst($service)}($url);

        return $container->child($iframe);
    }

    private function getYoutube(string $url): Element
    {
        $attrs = [
            'src' => $url,
            'frameborder' => '0',
            'allowFullscreen' => 'true',
        ];

        return $this->html->element('iframe')->attributes($attrs)->class('embed-responsive-item');
    }
}