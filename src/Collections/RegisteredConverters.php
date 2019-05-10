<?php

namespace Motivo\EditorJsDataConverter\Collections;

use Illuminate\Support\Collection;
use Motivo\EditorJsDataConverter\Collections\Contracts\RegisteredConverters as RegisteredConvertersContract;
use Motivo\EditorJsDataConverter\Converters\Contracts\Converter;
use Motivo\EditorJsDataConverter\Exceptions\ConverterException;

class RegisteredConverters extends Collection implements RegisteredConvertersContract
{
    /**
     * @throws \Motivo\EditorJsDataConverter\Exceptions\ConverterException
     */
    public function getConverter(string $key, string $type): Converter
    {
        if (! $this->has($key)) {
            throw ConverterException::noConverterRegistered(sprintf('No converter registered for type `%s`', $type));
        }

        $converterClass = $this->get($key);

        return new $converterClass();
    }
}
