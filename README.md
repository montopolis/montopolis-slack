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
 
function slack(): \Montopolis\Slack\Fluent 
{
    $config = new \Montopolis\Slack\Infrastructure\ArraySlackConfigurationRepository([
        'slack' => ['token' => '___oauth-token-from-above___', 'default_channel' => 'general', 'fallback_to_default' => true],
    ]);
    $client = new \Montopolis\Slack\Infrastructure\HttpSlackClient($config, new \Montopolis\Slack\Application\MessageTransformer());
    return new \Montopolis\Slack\Fluent($client);
}

# It can then be used as such:

slack()
    ->channel('support')
    ->text('This is the Slack Message')
    ->send();
```

## Laravel Usage ##

The only difference with Laravel is that we'll typically lean on the app container to resolve dependencies for us:

```php
<?php

    # In AppServiceProvider.php:...
    public function register()
    {
        $this->app->bind(\Montopolis\Slack\Fluent::class, function ($app) {
            
            # This assumes config/services.php has a `slack` key containing `token` and `default_channel`:
            $config = new \Montopolis\Slack\Infrastructure\ArraySlackConfigurationRepository(config('services'));
            
            $client = new \Montopolis\Slack\Infrastructure\HttpSlackClient($config, new \Montopolis\Slack\Application\MessageTransformer());
            return new \Montopolis\Slack\Fluent($client);
        });
    }
    # etc...
    
    # In helpers.php:...
    function slack(): \Montopolis\Slack\Fluent 
    {
        return app()->make(\Montopolis\Slack\Fluent::class);
    }
    # etc...
    
    # In application:
    slack()
        ->channel('support')
        ->text('This is sent from a Laravel app')
        ->send();
```

## Sending blocks

You can use the (Block Kit Builder)[https://api.slack.com/tools/block-kit-builder] to design your blocks. It should be posted as a PHP array as shown below: 

```php
<?php

    slack()
        ->channel('support')
        ->blocks([
            [
                "type" => "section",
                "text" => [
                    "type" => "mrkdwn",
                    "text" => "Hello, Assistant to the Regional Manager Dwight! *Michael Scott* wants to know where you'd like to take the Paper Company investors to dinner tonight.\n\n *Please select a restaurant:*"
                ],
            ],
            [
                "type" => "divider",
            ],
            [
                "type" => "section",
                "text" => [
                    "type" => "mrkdwn",
                    "text" => "*Farmhouse Thai Cuisine*\n:star::star::star::star: 1528 reviews\n They do have some vegan options, like the roti and curry, plus they have a ton of salad stuff and noodles can be ordered without meat!! They have something for everyone here"
                ],
                "accessory" => [
                    "type" => "image",
                    "image_url" => "https://s3-media3.fl.yelpcdn.com/bphoto/c7ed05m9lC2EmA3Aruue7A/o.jpg",
                    "alt_text" => "alt text for image"
                ],
            ],
            [
                "type" => "actions",
                "elements" => [
                    [
                        "type" => "button",
                        "text" => [
                            "type" => "plain_text",
                            "text" => "Farmhouse",
                            "emoji" => true,
                        ],
                        "value" => "click_me_123",
                    ],
                ]
            ],
        ]);
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