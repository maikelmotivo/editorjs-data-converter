<?php


namespace Motivo\EditorJsDataConverter\Converters;


use Motivo\EditorJsDataConverter\Converters\Contracts\Converter;
use Motivo\EditorJsDataConverter\Traits\WithHtml;

class EmbedConverter implements Converter
{
    use WithHtml;

    public function toHtml(array $itemData): string
    {
        $container = $this->getContainer();
        $iframe = $this->getIframe($itemData['service'], $itemData['embed']);
        $caption = $this->getCaption($itemData['caption']);

        return $container->child([$iframe, $caption]);
    }

    private function getContainer()
    {
        return $this->html->element('div')->class('embed-container');
    }

    private function getIframeContainer()
    {
        return $this->html->element('div')->class('embed-responsive embed-responsive-16by9');
    }

    private function getCaption(?string $caption)
    {
        if ($caption) {
            return $this->html->element('p')->html($caption)->class('caption');
        }

        return null;
    }

    private function getIframe(string $service, string $url)
    {
        $container = $this->getIframeContainer();
        $iframe = $this->{'get' . ucfirst($service)}($url);

        return $container->child($iframe);
    }

    private function getYoutube(string $url)
    {
        $attrs = [
            'src' => $url,
            'frameborder' => '0',
            'allowFullscreen' => 'true',
        ];

        return $this->html->element('iframe')->attributes($attrs)->class('embed-responsive-item');
    }
}