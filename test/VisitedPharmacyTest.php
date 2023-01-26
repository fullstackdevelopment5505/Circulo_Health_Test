<?php
use PHPUnit\Framework\TestCase;
require_once 'testClass.php';
class VisitedPharmacyTest extends TestCase
{

    public function testCompare()
    {
        $pharmacy = new Pharmacy("Walgreens", true);
        $visitedPharmacy = new VisitedPharmacy("CVS Pharmacy", true);
        $this->assertSame(true, $visitedPharmacy->compare($pharmacy));
    }

    public function test__construct()
    {
        $visitedPharmacy = new VisitedPharmacy("Walgreens", true);
        $this->assertSame('Walgreens', $visitedPharmacy->name);
        $this->assertSame(true, $visitedPharmacy->supportsPriorAuth);
    }
}
