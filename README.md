# Amazon alexa symfony bundle
This bundle is a simlpe helper to create an Amazon Echo (Alexa) endpoint to your symfony project. You only need to add the Bundle to your project and create some handlers for the alexa requests, configured in [amazon alexa backend](https://developer.amazon.com/alexa).

## Install via composer
Require the bundle via composer:
```
composer require maxbeckers/amazon-alexa-bundle
```
## Enable Routing
Then add the Bundle endpoint for alexa to `config/routes.yaml`.
```
# config/routes.yaml
maxbeckers_amazon_alexa:
    path:     /alexa/ # the url, the alexa endpoint should be available 
    defaults: { _controller: MaxBeckersAmazonAlexaBundle:AmazonAlexa:amazonRequest }
```
## Create handlers
To add Handlers for alexa, create them as a service and tag them with `maxbeckers_amazon_alexa.request_handler`.
How to create a handler see [maxbeckers/amazon-alexa-php](https://github.com/maxbeckers/amazon-alexa-php).
```
services:
    example.my_handler:
        class: Example\MyIntentHandler
        arguments:
            - '@maxbeckers_amazon_alexa.response_helper' # ResponseHelper
        tags:
            - 'maxbeckers_amazon_alexa.request_handler'
```
## Generate ssml
For ssml use the `maxbeckers_amazon_alexa.ssml_generator` service to create valid ssml. 
```php
$ssmlGenerator = $this->get('maxbeckers_amazon_alexa.ssml_generator');

// add a message
$ssmlGenerator->say('Hallo World');
$ssml = $ssmlGenerator->getSsml();
// $ssml === '<speak>Hallo World</speak>'

```
