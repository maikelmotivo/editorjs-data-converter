<?php

namespace Motivo\EditorJsDataConverter\Collections\Contracts;

use Motivo\EditorJsDataConverter\Converters\Contracts\Converter;

interface RegisteredConverters
{
    public function getConverter(string $key, string $type): Converter;
}
