<?php

declare(strict_types=1);

namespace Montopolis\Slack;

use Montopolis\Slack\Domain\Message;
use Montopolis\Slack\Domain\SlackClient;

class Fluent
{
    protected $attrs = [];

    protected $slackClient;

    public function __construct(SlackClient $slackClient)
    {
        $this->slackClient = $slackClient;
    }

    public function channel(string $channel): self
    {
        $this->attrs['channel'] = $channel;
        return $this;
    }

    public function text(string $text): self
    {
        $this->attrs['text'] = $text;
        return $this;
    }

    public function as_user(bool $as_user): self
    {
        $this->attrs['as_user'] = $as_user;
        return $this;
    }

    public function attachments(array $attachments): self
    {
        $this->attrs['attachments'] = $attachments;
        return $this;
    }

    public function add_attachment(array $attachment): self
    {
        if (empty($this->attrs['attachments'])) {
            $this->attrs['attachments'] = [];
        }
        $this->attrs['attachments'][] = $attachment;
        return $this;
    }

    public function blocks(array $blocks): self
    {
        $this->attrs['blocks'] = $blocks;
        return $this;
    }

    public function add_block(array $block): self
    {
        if (empty($this->attrs['blocks'])) {
            $this->attrs['blocks'] = [];
        }
        $this->attrs['blocks'][] = $block;
        return $this;
    }

    public function icon_emoji(string $icon_emoji): self
    {
        $this->attrs['icon_emoji'] = $icon_emoji;
        return $this;
    }

    public function icon_url(string $icon_url): self
    {
        $this->attrs['icon_url'] = $icon_url;
        return $this;
    }

    public function link_names(bool $link_names): self
    {
        $this->attrs['link_names'] = $link_names;
        return $this;
    }

    public function mrkdwn(bool $mrkdwn): self
    {
        $this->attrs['mrkdwn'] = $mrkdwn;
        return $this;
    }

    public function parse(string $parse): self
    {
        $this->attrs['parse'] = $parse;
        return $this;
    }

    public function reply_broadcast(bool $reply_broadcast): self
    {
        $this->attrs['reply_broadcast'] = $reply_broadcast;
        return $this;
    }

    public function thread_ts(string $thread_ts): self
    {
        $this->attrs['thread_ts'] = $thread_ts;
        return $this;
    }

    public function unfurl_links(bool $unfurl_links): self
    {
        $this->attrs['unfurl_links'] = $unfurl_links;
        return $this;
    }

    public function unfurl_media(bool $unfurl_media): self
    {
        $this->attrs['unfurl_media'] = $unfurl_media;
        return $this;
    }

    public function username(string $username): self
    {
        $this->attrs['username'] = $username;
        return $this;
    }

    public function token(string $token): self
    {
        $this->attrs['token'] = $token;
        return $this;
    }

    protected function asMessage(): Message
    {
        return new Message($this->attrs);
    }

    public function send(): bool
    {
        $message = $this->asMessage();
        return $this->slackClient->sendMessage($message);
    }
}