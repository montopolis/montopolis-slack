<?php

declare(strict_types=1);

namespace Montopolis\Slack\Tests;

use Montopolis\Slack\Slack;

class SlackTest extends TestCase
{
    public function test_it_is_instantiable()
    {
        $this->assertInstanceOf(Slack::class, new Slack(''));
    }

    /**
     * @todo: remove this!
     */
    public function test_it_sends()
    {
        $slack = new Slack();
        $slack->sendTest();
    }
}