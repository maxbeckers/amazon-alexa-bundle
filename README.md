# Amazon alexa symfony bundle
This bundle is a simple helper to create an Amazon Echo (Alexa) endpoint to your symfony project. You only need to add the Bundle to your project and create some handlers for the alexa requests, configured in [amazon alexa backend](https://developer.amazon.com/alexa).

## Requirements
- PHP 8.2+
- Symfony 6.4+

## Install via composer
Require the bundle via composer:
```
composer require maxbeckers/amazon-alexa-bundle
```

## Enable the Bundle
Add the bundle to your `config/bundles.php`:
```php
return [
    // ...existing bundles...
    MaxBeckers\AmazonAlexaBundle\MaxBeckersAmazonAlexaBundle::class => ['all' => true],
];
```

## Enable Routing
Then add the Bundle endpoint for alexa to `config/routes.yaml`.
```yaml
# config/routes.yaml
maxbeckers_amazon_alexa:
    path: /alexa/
    controller: MaxBeckers\AmazonAlexaBundle\Controller\AmazonAlexaController::amazonRequestAction
```

## Create handlers
To add Handlers for alexa, create them as a service and tag them with `maxbeckers_amazon_alexa.request_handler`.
How to create a handler see [maxbeckers/amazon-alexa-php](https://github.com/maxbeckers/amazon-alexa-php).

```yaml
# config/services.yaml
services:
    Example\MyIntentHandler:
        arguments:
            - '@MaxBeckers\AmazonAlexa\Helper\ResponseHelper'
        tags:
            - 'maxbeckers_amazon_alexa.request_handler'
```

## Generate ssml
For ssml use the `MaxBeckers\AmazonAlexa\Helper\SsmlGenerator` service to create valid ssml. 

```php
use MaxBeckers\AmazonAlexa\Helper\SsmlGenerator;

class MyService
{
    public function __construct(
        private readonly SsmlGenerator $ssmlGenerator
    ) {
    }

    public function generateSsml(): string
    {
        // add a message
        $this->ssmlGenerator->say('Hello World');
        $ssml = $this->ssmlGenerator->getSsml();
        // $ssml === '<speak>Hello World</speak>'
        
        return $ssml;
    }
}
```

For backward compatibility, you can still use the service ID:
```php
$ssmlGenerator = $this->container->get('maxbeckers_amazon_alexa.ssml_generator');
```
