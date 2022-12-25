# command-bus-bundle

# common-bus

Communication system that transfers message object between application middlewares.

## Install

```bash
$ composer require volodymyr-klymniuk/common-bus
```

## Register the bundle:

```php
// config/bundles.php
return [
    ...
    VKCommonBusBundle\VKCommonBusBundle::class => ['all' => true],
];
```

## Create your bus

```php
<?php
namespace App\CommandBus;

use VKCommonBusBundle\AbstractCommonBus;
/**
 * Class MetadataCollectorCommonBus
 */
class MetadataCollectorCommonBus extends AbstractCommonBus
{
    /**
     * @return string Supported Message class name
     */
    public function supports(): string
    {
        return \App\Document\Metadata::class;
    }
}
```

## Create bus middleware

```php
<?php
use VKCommonBusBundle\Envelope;
use VKCommonBusBundle\Middleware\MiddlewareInterface;
use VKCommonBusBundle\Stack\StackInterface;
/**
 * Class SearchMetadataMiddleware
 */
class SearchMetadataMiddleware implements MiddlewareInterface
{
    /**
     * @inheritdoc
     */
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        /** @var \App\Document\Metadata $message */
        $message = $envelope->getMessage();
        // Your code
        return $stack->next()->handle($envelope, $stack);
    }
}
```


## Register bus middleware handles

```yaml
    App\CommonBus\MetadataCollectorCommandBus:
        arguments:
            $middlewareHandlers:
                - '@App\CommonBus\Middleware\SearchMetadataMiddleware'
                - '@App\CommonBus\Middleware\SearchMetadataMiddleware_1'
                - '@App\CommonBus\Middleware\SearchMetadataMiddleware_2'
                - '@App\CommonBus\Middleware\SearchMetadataMiddleware_3'
                - '@App\CommonBus\Middleware\SearchMetadataMiddleware_4'
```

# Enjoy!