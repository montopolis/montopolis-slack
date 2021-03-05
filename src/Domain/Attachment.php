<?php

declare(strict_types=1);

namespace Montopolis\Slack\Domain;

class Attachment
{
    protected $attrs;

    public function __construct(array $attrs = [])
    {
        // @todo: protected domain-layer with data validation

        $this->attrs = $attrs;
    }

    public function getAttributes(): array
    {
        return $this->attrs;
    }
}
