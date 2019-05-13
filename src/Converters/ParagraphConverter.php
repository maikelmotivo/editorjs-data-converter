<?php

namespace Motivo\EditorJsDataConverter\Converters;

use Illuminate\Support\Arr;
use Motivo\EditorJsDataConverter\Converters\Contracts\Converter;
use Motivo\EditorJsDataConverter\Traits\WithHtml;

class ParagraphConverter implements Converter
{
    use WithHtml;

    public function toHtml(array $itemData): string
    {
        return $this->html
            ->element('p')
            ->html(Arr::get($itemData, 'text', ''));
    }
}
