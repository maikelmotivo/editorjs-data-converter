<?php

namespace Motivo\EditorJsDataConverter;

use Illuminate\Support\ServiceProvider;
use Motivo\EditorJsDataConverter\Collections\RegisteredConverters;
use Motivo\EditorJsDataConverter\Collections\RegisteredConverters as RegisteredConvertersContract;
use Spatie\Html\HtmlServiceProvider;

class EditorJsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->bind(RegisteredConvertersContract::class, RegisteredConverters::class);

        $this->app->when(DataConverter::class)
            ->needs(RegisteredConvertersContract::class)
            ->give(function () {
                return (new ConverterLoader())->load();
            });

        $this->app->register(HtmlServiceProvider::class);
    }

    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/editorjs.php' => config_path('editorjs.php'),
            ], 'editorjs-config');
        }

        $this->mergeConfigFrom(__DIR__ . '/../config/editorjs.php', 'editorjs-config');
    }
}
