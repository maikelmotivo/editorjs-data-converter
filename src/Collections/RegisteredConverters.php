<?php

namespace Motivo\EditorJsDataConverter\Collections;

use Illuminate\Support\Collection;
use Motivo\EditorJsDataConverter\Converters\Contracts\Converter;
use Motivo\EditorJsDataConverter\Exceptions\ConverterException;

class RegisteredConverters extends Collection implements RegisteredConvertersContract
{
    public function getConverter(string $key): Converter
    {
        if (! $this->has($key)) {
            ConverterException::noConverterRegistered(sprintf('No converter registered for type `%s`', $type));
        }

        $converterClass = $this->get($key);

        return new $converterClass;
    }
}
