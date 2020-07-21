<?php

declare(strict_types=1);

namespace Montopolis\Slack\Infrastructure;

use Montopolis\Slack\Domain\SlackConfigurationRepository;
use Montopolis\Slack\Domain\SlackCredentials;

class ArraySlackConfigurationRepository implements SlackConfigurationRepository
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function getCredentials(): SlackCredentials
    {
        return new SlackCredentials($this->config['slack']['token']);
    }

    public function getDefaultChannel(): string
    {
        return $this->config['slack']['default_channel'] ?? 'general';
    }

    public function getFallbackToDefault(): bool
    {
        return !empty($this->config['slack']['fallback_to_default'])
            ? $this->config['slack']['fallback_to_default'] : false;
    }
}
