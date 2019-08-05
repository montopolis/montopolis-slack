# Montopolis Slack #

Provides a consistent, reliable wrapper around the Slack `chat.postMessage` API which can be used across all Montopolis apps.

## Setting up Slack App ##

Before you can use the library, you need to set up a OAuth-enabled Slack App. You can that [here](https://api.slack.com/apps).
 
1. Click "OAuth & Permissions"
1. Select the scope: "Send messages as ___ App (`chat:write:bot`)"
1. Copy the OAuth access token at the top of the page. This will be used in the instructions below.

## General Usage ##

```php
<?php

###
# For convenience, it's recommended that you wrap the `Fluent` helper in a global function: 
 
function slack() {
    $config = new \Montopolis\Slack\Infrastructure\ArraySlackConfigurationRepository([
        'slack' => ['token' => '___oauth-token-from-above___', 'default_channel' => 'general'],
    ]);
    $client = new \Montopolis\Slack\Infrastructure\HttpSlackClient($config, new \Montopolis\Slack\Application\MessageTransformer());
    return new Fluent($client);
}

# It can then be used as such:

slack()
    ->channel('support')
    ->message('This is the Slack Message')
    ->send();
```

## Laravel Usage ##

The only difference with Laravel is that we'll typically lean on the app container to resolve dependencies for us:

```php
<?php

    # In AppServiceProvider.php:...
    public function register()
    {
        $this->app->bind(Fluent::class, function ($app) {
            
            # This assumes config/services.php has a `slack` key containing `token` and `default_channel`:
            $config = new \Montopolis\Slack\Infrastructure\ArraySlackConfigurationRepository(config('services'));
            
            $client = new \Montopolis\Slack\Infrastructure\HttpSlackClient($config, new \Montopolis\Slack\Application\MessageTransformer());
            return new Fluent($client);
        });
    }
    # etc...
    
    # In helpers.php:...
    function slack() {
        return app()->make(Fluent::class);
    }
    # etc...
    
    # In application:
    slack()
        ->channel('support')
        ->message('This is sent from a Laravel app')
        ->send();
```

## Run the tests

```bash
./vendor/bin/phpunit tests/
PHPUnit 8.3.3 by Sebastian Bergmann and contributors.

............                                                      12 / 12 (100%)

Time: 105 ms, Memory: 6.00 MB

OK (12 tests, 12 assertions)
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.