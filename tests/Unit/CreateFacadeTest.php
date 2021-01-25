<?php

namespace Anurat\AttExport\Tests\Unit;

use Anurat\AttExport\AttExport as Export;
use Anurat\AttExport\Facades\AttExport;
use Anurat\AttExport\Tests\TestCase;

class CreateFacadeTest extends TestCase
{
    public function testCreateFacade()
    {
        $options = [];
        $this->assertInstanceOf(Export::class, AttExport::config($options));
        $this->assertNull(AttExport::convert());
    }
}
