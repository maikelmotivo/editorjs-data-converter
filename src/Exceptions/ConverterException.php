<?php

namespace Motivo\EditorJsDataConverter\Exceptions;

use Exception;

class ConverterException extends Exception
{
    public static function noConverterRegistered(string $message, int $code = 0, ?callable $previous = null): self
    {
        return new static($message, $code, $previous);
    }
}
