<?php
use PHPUnit\Framework\TestCase;
require_once 'testClass.php';
class PharmacyTest extends TestCase
{

    public function test__construct()
    {
        $pharmacy = new Pharmacy("Walgreens", true);
        $this->assertSame('Walgreens', $pharmacy->name);
        $this->assertSame(true, $pharmacy->supportsPriorAuth);
    }

    public function testIsSupportsPriorAuth()
    {
        $pharmacy = new Pharmacy("Walgreens", true);
        $this->assertSame(true, $pharmacy->isSupportsPriorAuth());
    }
}