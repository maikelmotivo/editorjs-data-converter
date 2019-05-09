<?php

namespace Motivo\EditorJsDataConverter;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Motivo\EditorJsDataConverter\Collections\RegisteredConverters;
use Motivo\EditorJsDataConverter\Converters\Contracts\Converter;
use ReflectionClass;
use Symfony\Component\Finder\Finder;

class EditorJsServiceProvider extends ServiceProvider
{
    private const CONVERTER_PATH = __DIR__ . '/Converters';

    private $namespace = 'Motivo\\EditorJsDataConverter\\';

    /** @var RegisteredConverters */
    private $registeredConverters;

    public function __construct($app)
    {
        parent::__construct($app);

        $this->registeredConverters = new RegisteredConverters();
    }

    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/editorjs.php' => config_path('editorjs.php'),
            ], 'editorjs-config');
        }

        //if (! $this->app->runningInConsole()) {
            $this->registerConverters();
        //}

        $this->app->singleton(RegisteredConverters::class, $this->registeredConverters);

        $this->app->when(DataConverter::class)
            ->needs(RegisteredConverters::class)
            ->give(function () {
                return $this->registeredConverters;
            });
    }

    private function registerConverters(): void
    {
        $projectconverterPath = $this->app['config']['editorjs.converter_path'];

        $paths = [
            $projectconverterPath,
            self::CONVERTER_PATH,
        ];

        $paths = array_unique(Arr::wrap($paths));

        $paths = array_filter($paths, function ($path) {
            return is_dir($path);
        });

        if (empty($paths)) {
            return;
        }

        $namespace = $this->namespace;

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
                $this->registeredConverters->put(class_basename($converter), $converter);
            }
        }
    }
}
