<?php

declare(strict_types=1);

namespace Montopolis\Slack;

use Montopolis\Slack\Application\MessageTransformer;
use Montopolis\Slack\Domain\Message;
use Montopolis\Slack\Infrastructure\Http\HttpSlackClient;
use Montopolis\Slack\Infrastructure\Laravel\LaravelSlackCredentialsRepository;

class Slack
{
    public function sendTest()
    {
        $message = new Message([
            'channel' => 'general',
            'text' => 'This is the text',
            'icon_emoji' => ':robot_face:',
            'username' => 'New User',
            'attachments' => [],
            'blocks' => [],
        ]);
        $config = ['slack' => ['token' => "@todo"]];
        $client = new HttpSlackClient(new LaravelSlackCredentialsRepository($config), new MessageTransformer());
        $client->sendMessage($message);
    }

    public function getAttachmentJson()
    {
        /*
    "attachments": [
        {
            "fallback": "Required plain-text summary of the attachment.",
            "color": "#2eb886",
            "pretext": "Optional text that appears above the attachment block",
            "author_name": "Bobby Tables",
            "author_link": "http://flickr.com/bobby/",
            "author_icon": "http://flickr.com/icons/bobby.jpg",
            "title": "Slack API Documentation",
            "title_link": "https://api.slack.com/",
            "text": "Optional text that appears within the attachment",
            "fields": [
                {
                    "title": "Priority",
                    "value": "High",
                    "short": false
                }
            ],
            "image_url": "http://my-website.com/path/to/image.jpg",
            "thumb_url": "http://example.com/path/to/thumb.png",
            "footer": "Slack API",
            "footer_icon": "https://platform.slack-edge.com/img/default_application_icon.png",
            "ts": 123456789
        }
    ]
         */
    }
}