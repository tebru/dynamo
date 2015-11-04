<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Unit\Model;

use Tebru\Dynamo\Model\Body;
use Tebru\Dynamo\Test\Unit\MockeryTestCase;

/**
 * Class BodyTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class BodyTest extends MockeryTestCase
{
    public function testAdding()
    {
        $body = new Body();
        $body->add('my new line');
        $this->assertSame('my new line', (string)$body);
    }

    public function testAddMultipleLines()
    {
        $body = new Body();
        $body->add('my new line');
        $body->add('my new line2');
        $this->assertSame('my new linemy new line2', (string)$body);
    }

    public function testAddWithStringReplacement()
    {
        $body = new Body();
        $body->add('my %s line', 'new');
        $this->assertSame('my new line', (string)$body);
    }

    public function testAddWithMultipleStringReplacement()
    {
        $body = new Body();
        $body->add('%s %s %s%d', 'my', 'new', 'line', 2);
        $this->assertSame('my new line2', (string)$body);
    }
}
