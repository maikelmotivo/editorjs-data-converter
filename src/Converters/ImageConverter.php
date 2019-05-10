<?php

namespace Motivo\EditorJsDataConverter\Converters;

use Illuminate\Support\Arr;
use Motivo\EditorJsDataConverter\Converters\Contracts\Converter;
use Motivo\EditorJsDataConverter\Exceptions\InvalidEditorDataException;
use Motivo\EditorJsDataConverter\Traits\WithHtml;

class ImageConverter implements Converter
{
    use WithHtml;

    public function toHtml(array $itemData): string
    {
        $fileUrl = $this->getFileUrl($itemData);

        return $this->html
            ->img($fileUrl, Arr::get($itemData, 'caption', ''))
            ->addClass($this->getImageClasses($itemData));
    }

    /**
     * @throws \Motivo\EditorJsDataConverter\Exceptions\InvalidEditorDataException
     */
    private function getFileUrl(array $itemData): string
    {
        $fileData = Arr::get($itemData, 'file', []);

        if (! Arr::has($fileData, 'url')) {
            throw InvalidEditorDataException::noImageUrlFound(
                sprintf('No image url found')
            );
        }

        return Arr::get($fileData, 'url');
    }

    private function getImageClasses(array $itemData): string
    {
        $imageClasses = '';

        $classTypes = [
            'withBorder' => 'with-border',
            'stretched' => 'stretched-image',
            'withBackground' => 'with-background',
        ];

        foreach ($classTypes as $classType => $class) {
            if (Arr::has($itemData, $classType) && Arr::get($itemData, $classType, false)) {
                $imageClasses .= sprintf(' %s', $class);
            }
        }

        return $imageClasses;
    }
}
