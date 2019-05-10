<?php

namespace Motivo\EditorJsDataConverter;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Motivo\EditorJsDataConverter\Collections\RegisteredConverters;
use Motivo\EditorJsDataConverter\Converters\Contracts\Converter;
use ReflectionClass;
use Symfony\Component\Finder\Finder;

class ConverterLoader
{
    private const CONVERTER_PATH = __DIR__ . '/Converters';

    private $namespace = 'Motivo\\EditorJsDataConverter\\';

    public function load()
    {
        $paths = array_unique(Arr::wrap([
            self::CONVERTER_PATH,
            app('config')['editorjs.converter_path'],
        ]));

        $paths = array_filter($paths, function ($path) {
            return is_dir($path);
        });

        if (empty($paths)) {
            return null;
        }

        $namespace = $this->namespace;

        $registeredConverters = new RegisteredConverters();

        /** @var \Symfony\Component\Finder\SplFileInfo $converter */
        foreach ((new Finder)->in($paths)->files() as $converter) {
            $converter = $namespace.str_replace(
                ['/', '.php'],
                ['\\', ''],
                Str::after($converter->getPathname(), dirname(__FILE__) . DIRECTORY_SEPARATOR)
            );

            if (is_subclass_of($converter, Converter::class)
                && ! (new ReflectionClass($converter))->isAbstract()
                && ! (new ReflectionClass($converter))->isInterface()
            ) {
                $registeredConverters->put(class_basename($converter), $converter);
            }
        }

        return $registeredConverters;
    }
}
