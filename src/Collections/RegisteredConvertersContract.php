<?php

namespace Motivo\EditorJsDataConverter\Collections;

use Motivo\EditorJsDataConverter\Converters\Contracts\Converter;

interface RegisteredConvertersContract
{
    public function getConverter(string $key): Converter;
}
