<?php

namespace Motivo\EditorJsDataConverter\Converters;

use Illuminate\Support\Arr;
use Motivo\EditorJsDataConverter\Converters\Contracts\Converter;

class HeaderConverter implements Converter
{
    public function toHtml(array $itemData): string
    {
        return html()
            ->element(sprintf('h%s', Arr::get($itemData, 'level', '1')))
            ->text(Arr::get($itemData, 'text', ''));
    }
}
