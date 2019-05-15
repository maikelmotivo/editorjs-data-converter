# EditorJS ata Converter

A package to convert JSON data that Editor.js generates back to html so it can be used.

## Installation
You can install this package by running the following command in your project:
```bash
composer require motivo/editorjs-data-converter
```

## How to use it

To convert the json string so it will return HTML you will need to do the following
```php
resolve(DataConverter::class)->init(json_decode($jsonContent))
``` 

## Testing

```bash
make test
```

## License

The Mozilla Public License Version 2.0 (mpl-2.0). Please see [License File](LICENSE) for more information.
