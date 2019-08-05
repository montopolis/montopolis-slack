<?php

declare(strict_types=1);

namespace Montopolis\Slack\Tests\Domain;

use Assert\InvalidArgumentException;
use Montopolis\Slack\Domain\Message;
use Montopolis\Slack\Tests\TestCase;

class MessageTest extends TestCase
{
    public function test_it_is_instantiable()
    {
        $this->assertInstanceOf(Message::class, new Message(['text' => 'Message']));
    }

    public function test_it_requires_valid_attributes()
    {
        $this->expectException(InvalidArgumentException::class);
        new Message([]);
    }
}