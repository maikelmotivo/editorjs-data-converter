<?php

namespace Motivo\EditorJsDataConverter;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Motivo\EditorJsDataConverter\Collections\RegisteredConvertersContract;
use Motivo\EditorJsDataConverter\Converters\Contracts\Converter;
use Motivo\EditorJsDataConverter\Exceptions\InvalidEditorDataException;

class DataConverter
{
    /** @var RegisteredConvertersContract */
    private $registeredConverters;

    /** @var string */
    private $html = '';

    /** @var array */
    private $blockData;

    public function __construct(RegisteredConvertersContract $registeredConverters)
    {
        $this->registeredConverters = $registeredConverters;
    }

    public function init(string $jsonData): string
    {
        $this->setBlockData($jsonData);

        $this->createHTmlString();

        return $this->getHtml();
    }

    private function createHTmlString(): void
    {
        foreach ($this->blockData as $item) {
            $this->setHtml(
                $this->callConverter($item)->toHtml(
                    $this->getItemData($item)
                )
            );
            dd($this->getHtml());
        }
    }

    private function callConverter(array $item): Converter
    {
        $type = Arr::get($item, 'type');

        if (! $type) {
            InvalidEditorDataException::noTypeField('Type field not found for block item');
        }

        $converter = Str::studly(Arr::get($item, 'type') . 'Converter');

        $converterClass = $this->registeredConverters->getConverter($converter);

        return new $converterClass;
    }

    public function setHtml(string $string): void
    {
        $this->html .= $string;
    }

    public function getHtml(): string
    {
        return $this->html;
    }

    private function setBlockData(string $jsonData): void
    {
        $arrayDataCollection = collect(json_decode($jsonData, true));

        if ($arrayDataCollection->has('blocks')) {
            $this->blockData = $arrayDataCollection->get('blocks');
        }

        InvalidEditorDataException::noBlocksContent(
            'The `blocks` field is missing from the given content'
        );
    }

    private function getItemData(array $item): array
    {
        if (! Arr::exists($item, 'data')) {
            InvalidEditorDataException::noDataField('No data field found for type `type`', Arr::get($item, 'type'));
        }

        return Arr::get($item, 'data');
    }
}
