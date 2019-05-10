<?php

namespace Motivo\EditorJsDataConverter\Exceptions;

use Exception;

class InvalidEditorDataException extends Exception
{
    public static function noBlocksContent(string $message, int $code = 0, ?callable $previous = null): self
    {
        return new static($message, $code, $previous);
    }

    public static function noTypeField(string $message, int $code = 0, ?callable $previous = null): self
    {
        return new static($message, $code, $previous);
    }

    public static function noDataField(string $message, int $code = 0, ?callable $previous = null): self
    {
        return new static($message, $code, $previous);
    }

    public static function noImageUrlFound(string $message, int $code = 0, ?callable $previous = null): self
    {
        return new static($message, $code, $previous);
    }
}
