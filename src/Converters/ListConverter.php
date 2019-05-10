<?php

namespace Motivo\EditorJsDataConverter\Converters;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Motivo\EditorJsDataConverter\Converters\Contracts\Converter;
use Motivo\EditorJsDataConverter\Traits\WithHtml;

class ListConverter implements Converter
{
    use WithHtml;

    private const UNORDERED_LIST = 'ul';
    private const ORDERED_LIST = 'ol';

    public function toHtml(array $itemData): string
    {
        $listStyle = constant(
            Str::upper(
                sprintf(
                    'self::%s_list',
                    Arr::get($itemData, 'style', 'unordered')
                )
            )
        );

        $listElement = $this->html
            ->element($listStyle);

        $listItems = '';

        foreach (Arr::get($itemData, 'items') as $item) {
            $listItems .= $this->html->element('li')->text($item);
        }

        return $listElement->html($listItems);
    }
}
