<?php

declare(strict_types=1);

namespace Montopolis\Slack\Tests\Domain;

use Montopolis\Slack\Domain\Block;
use Montopolis\Slack\Tests\TestCase;

class BlockTest extends TestCase
{
    public function test_it_is_instantiable()
    {
        $this->assertInstanceOf(Block::class, new Block([]));
    }
}
