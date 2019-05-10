<?php

namespace Motivo\EditorJsDataConverter\Converters;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Motivo\EditorJsDataConverter\Converters\Contracts\Converter;
use Motivo\EditorJsDataConverter\Traits\WithHtml;

class TableConverter implements Converter
{
    use WithHtml;

    public function toHtml(array $itemData): string
    {
        $content = $this->createHtmlContent(Arr::get($itemData, 'content', []));

        return $this->html->element('table')->html($content);
    }

    private function createHtmlContent(array $contentData)
    {
        $rowElements = '';

        foreach ($contentData as $row) {
            $columnElements = '';

            foreach ($row as $columns) {
                $columnElements .= $this->html
                    ->element('td')
                    ->html(preg_replace_array('/(<([^>]+)>)/i', [""], $columns));
            }

            $rowElements .= $this->html
                ->element('tr')
                ->html($columnElements);
        }

        return $rowElements;
    }
}
