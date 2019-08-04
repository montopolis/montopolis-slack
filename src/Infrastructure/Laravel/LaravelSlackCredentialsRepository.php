<?php

declare(strict_types=1);

namespace Montopolis\Slack\Infrastructure\Laravel;

use Montopolis\Slack\Domain\SlackCredentials;
use Montopolis\Slack\Domain\SlackCredentialsRepository;

class LaravelSlackCredentialsRepository implements SlackCredentialsRepository
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function getCredentials(): SlackCredentials
    {
        # @todo: is this the best way to handle it?
        return new SlackCredentials($this->config['slack']['token']);
    }
}