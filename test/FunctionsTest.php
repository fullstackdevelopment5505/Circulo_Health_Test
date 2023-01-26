<?php

use PHPUnit\Framework\TestCase;

require_once "test.php";

class FunctionsTest extends TestCase
{
    public function testValidate()
    {
        $pharmacy1 = array("Walgreens", "true");
        $this->assertSame(true, validate($pharmacy1,1));
	    $pharmacy2 = array("Walgreens", "4", "23", "true");
        $this->assertSame(true, validate($pharmacy2,2));
    }
    public function testSortMakeArray()
    {
        $pharmacy1 = new VisitedPharmacy("Aeya2", "true");
        $pharmacy2 = new VisitedPharmacy("DKeya", "false");
        $arr=array();
        array_push($arr,$pharmacy1);
        array_push($arr,$pharmacy2);
        $pharmacy = new VisitedPharmacy("CKeya", "true");
        $this->assertSame($pharmacy1->name, sortMakeArray($arr, $pharmacy)[0]->name);
        $this->assertSame($pharmacy->name, sortMakeArray($arr, $pharmacy)[1]->name);
    }

}
