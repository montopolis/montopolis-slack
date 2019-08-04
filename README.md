# Montopolis Slack #

Provides a consistent, reliable wrapper around the Slack `chat.postMessage` API which can be used across all Montpolis apps.

## Setting up apps ##

https://api.slack.com/apps

Click "OAuth & Permissions"

Select scopes:

* Send messages as Slashnode Test App (`chat:write:bot`)
* Send messages as user (`chat:write:user`) ???

Copy the OAuth access token at the top of the page.

## Testing ##

```bash
./vendor/bin/phpunit
```

## Usage ##

```php
<?php

$client = new \Montopolis\Slack\Slack([
    'api' => '???' 
]);

$message = new \Montopolis\Slack\Domain\Message([
    'channel' => '#general',
    'message' => 'This is the message',
    'sender' => 'Name of the Sender',
    'attachments' => [
        new \Montopolis\Slack\Domain\Attachment([
            'something' => 'something_else',
        ]),    
    ],
    'blocks' => [
        new \Montopolis\Slack\Domain\Block([]),    
    ],
]);

$client->sendMessage($message);
```

or via helper:

```php
<?php

# Needs to be set up in `helpers.php` 
slack()->message();
slack()->messageWithAttachments();
```