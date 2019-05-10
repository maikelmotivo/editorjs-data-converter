<?php

namespace Motivo\EditorJsDataConverter\Converters\Contracts;

interface Converter
{
    public function toHtml(array $itemData): string;
}
