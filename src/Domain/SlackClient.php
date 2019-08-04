<?php

declare(strict_types=1);

namespace Montopolis\Slack\Domain;

interface SlackClient
{
    public function sendMessage(Message $message): bool;
}
