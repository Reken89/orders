<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Controllers\IndexController;

class IndexControllerTest extends TestCase
{
    public function test_example()
    {
        $controller = new IndexController();
        $data = $controller->RecordInfo(1, "10-11-2024", 1200, 1, 800, 1, 500, 1, 1000, 0);
        $this->assertIsArray($data);
        $this->assertEquals(true, $data['status']);
    }
    
}

