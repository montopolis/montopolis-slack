<?php

declare(strict_types=1);

namespace Montopolis\Slack\Domain;

use Assert\Assertion;

class Message
{
    protected $attrs;

    ###
    # See https://api.slack.com/methods/chat.postMessage
    protected $keys = [
        'channel',
        'text',
        'as_user',
        'attachments',
        'blocks',
        'icon_emoji',
        'icon_url',
        'link_names',
        'mrkdwn',
        'parse',
        'reply_broadcast',
        'thread_ts',
        'unfurl_links',
        'unfurl_media',
        'username',
    ];

    public function __construct($attrs = [])
    {
        foreach ($attrs as $key => $_) {
            Assertion::inArray($key, $this->keys);
        }

        ###
        # Required
        Assertion::keyExists($attrs, 'channel');
        Assertion::string($attrs['channel']);

        Assertion::keyExists($attrs, 'text');
        Assertion::string($attrs['text']);

        ###
        # Optional
        if (isset($attrs['as_user'])) Assertion::boolean($attrs['as_user']);
        if (isset($attrs['attachments'])) Assertion::isArray($attrs['attachments']);
        if (isset($attrs['blocks'])) Assertion::isArray($attrs['blocks']);
        if (isset($attrs['icon_emoji'])) Assertion::string($attrs['icon_emoji']);
        if (isset($attrs['icon_url'])) Assertion::url($attrs['icon_url']);
        if (isset($attrs['link_names'])) Assertion::boolean($attrs['link_names']);
        if (isset($attrs['mrkdwn'])) Assertion::boolean($attrs['mrkdwn']);
        if (isset($attrs['parse'])) Assertion::string($attrs['parse']);
        if (isset($attrs['reply_broadcast'])) Assertion::boolean($attrs['reply_broadcast']);
        if (isset($attrs['thread_ts'])) Assertion::string($attrs['thread_ts']);
        if (isset($attrs['unfurl_links'])) Assertion::boolean($attrs['unfurl_links']);
        if (isset($attrs['unfurl_media'])) Assertion::boolean($attrs['unfurl_media']);
        if (isset($attrs['username'])) Assertion::string($attrs['username']);

        $this->attrs = $attrs;
    }

    public function getAttributes()
    {
        return $this->attrs;
    }
}
