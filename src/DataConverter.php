<?php

namespace Motivo\EditorJsDataConverter;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Motivo\EditorJsDataConverter\Collections\RegisteredConverters;
use Motivo\EditorJsDataConverter\Converters\Contracts\Converter;
use Motivo\EditorJsDataConverter\Exceptions\ConverterException;
use Motivo\EditorJsDataConverter\Exceptions\InvalidEditorDataException;

class DataConverter
{
    /** @var RegisteredConverters */
    private $registeredConverters;

    /** @var string */
    private $html = '';

    /** @var array */
    private $blockData;

    private function __construct(string $jsonData, ?RegisteredConverters $registeredConverters = null)
    {
        $this->registeredConverters = collect($registeredConverters);

        $this->setBlockData($jsonData);

        $this->createHTmlString();
    }

    public static function create(string $jsonData): string
    {
        return (new static($jsonData))->getHtml();
    }

    private function createHTmlString(): void
    {
        foreach ($this->blockData as $item) {
            dd($this->callConverter($item));

            $this->setHtml($this->callConverter($item)->toHtml());
        }
    }

    private function callConverter(array $item): ?Converter
    {
        dump($item);
        $type = Arr::get($item, 'type');

        if (! $type) {
            InvalidEditorDataException::noTypeField('Type field not found for block item');
        }

        $converter = Str::studly(Arr::get($item, 'type'));

        dd($this->registeredConverters);

        if ($this->registeredConverters->has($converter)) {
            dd($this->registeredConverters->get($converter));
            return $this->registeredConverters->get($converter);
        }

        ConverterException::noConverterRegistered(sprintf('No converter registered for type `%s`', $type));
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
}
