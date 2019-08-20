<?php

declare(strict_types=1);

namespace Montopolis\Slack\Domain;

interface SlackConfigurationRepository
{
    public function getCredentials(): SlackCredentials;

    public function getDefaultChannel(): string;

    public function getFallbackToDefault(): bool;
}
