<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Models\FakeApi;

class FakeApiTest extends TestCase
{
    public function test_example()
    {
        $test = new FakeApi();
        $result = $test->ApproveOrder(11111111);
        $data = json_decode($result);
        $this->assertIsObject($data);
    }
    
}