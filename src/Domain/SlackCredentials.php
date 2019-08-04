<?php

declare(strict_types=1);

namespace Montopolis\Slack\Domain;

class SlackCredentials
{
    protected $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
