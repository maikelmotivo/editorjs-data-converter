<?php

namespace Motivo\EditorJsDataConverter\Converters;

use Illuminate\Support\Arr;
use Motivo\EditorJsDataConverter\Converters\Contracts\Converter;

class ParagraphConverter implements Converter
{
    public function toHtml(array $itemData): string
    {
        return html()->element('p')->text(Arr::get($itemData, 'text', ''));
    }
}
