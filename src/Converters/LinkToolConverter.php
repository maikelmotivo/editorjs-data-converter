<?php

namespace Motivo\EditorJsDataConverter\Converters;

use Illuminate\Support\Arr;
use Motivo\EditorJsDataConverter\Converters\Contracts\Converter;
use Motivo\EditorJsDataConverter\Traits\WithHtml;

class LinkToolConverter implements Converter
{
    use WithHtml;

    public function toHtml(array $itemData): string
    {
        return $this->html->a(Arr::get($itemData, 'link'), Arr::get($itemData, 'link'));
    }
}
