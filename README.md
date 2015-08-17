# Dynamo

This library allows you to take an interface annotated with Doctrine annotations and generate a class.  It
handles all of the parsing, and provides events to hook into in order to create the method body based
on the annotations.

## Installation

    composer require tebru/dynamo
    
## Usage

Create a new generator object using the builder

    $generator = \Tebru\Dynamo\Generator::builder()
        ->namespacePrefix('My\Custom\Library')
        ->setCacheDir('path/to/cache/vendor-name')
        ->build();
        
There are many different options to use with the builder, however, for most all cases, the defaults outside
of the namespace prefix and cache dir will be fine.

The namespace prefix is required in order to get around class name conflicts.  The generator uses the full
interface name plus the prefix as the generated class name.  The prefix defaults to `Dynamo`.

The cache directory defaults to `/system/dir/dynamo`

After you have a generator, you can pass your interface name into it and it will create a file in your
cache directory

    $generator->createAndWrite(MyInterface::class);
