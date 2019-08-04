<?php

declare(strict_types=1);

namespace Montopolis\Slack\Domain;

interface SlackCredentialsRepository
{
    public function getCredentials(): SlackCredentials;
}
