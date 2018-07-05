<?php

namespace App\Tests\Generator;

use App\Generator\LockGenerator;
use PHPUnit\Framework\TestCase;

class LockGeneratorTest extends TestCase
{
    public function testGenerate()
    {
        $test = new LockGenerator();

        $this->assertSame(null, $test->generate('composer', 'akeneo/pim-enterprise-dev'));

    }
}