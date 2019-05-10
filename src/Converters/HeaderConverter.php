<?php

namespace Motivo\EditorJsDataConverter\Converters;

use Illuminate\Support\Arr;
use Motivo\EditorJsDataConverter\Converters\Contracts\Converter;
use Motivo\EditorJsDataConverter\Traits\WithHtml;

class HeaderConverter implements Converter
{
    use WithHtml;

    public function toHtml(array $itemData): string
    {
        return $this->html
            ->element(sprintf('h%s', Arr::get($itemData, 'level', '1')))
            ->text(Arr::get($itemData, 'text', ''));
    }
}
