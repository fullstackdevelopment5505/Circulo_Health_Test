<?php
use PHPUnit\Framework\TestCase;
require_once 'testClass.php';
class NearestPharmacyTest extends TestCase
{

    public function testCompare()
    {
        $nearestPharmacy1 = new NearestPharmacy("Walgreens", "2.3", "5", "true");
        $nearestPharmacy2 = new NearestPharmacy("CVS Pharmacy", "2.3", "3", "true");
        $this->assertSame(false, $nearestPharmacy1->compare($nearestPharmacy2));
    }

    public function test__construct()
    {
        $nearestPharmacy = new NearestPharmacy("Walgreens", "4.5", "24", "true");
        $this->assertSame('Walgreens', $nearestPharmacy->name);
        $this->assertSame('4.5', $nearestPharmacy->distance);
        $this->assertSame('24', $nearestPharmacy->copay);
        $this->assertSame("true", $nearestPharmacy->supportsPriorAuth);
    }
}
