<?php
class Pharmacy
{
    public $name;
    public $supportsPriorAuth;
    function __construct($name, $supportsPriorAuth)
    {
        $this->name = $name;
        $this->supportsPriorAuth = $supportsPriorAuth;
    }
    public function isSupportsPriorAuth() {
        if($this->supportsPriorAuth == "true"){
            return true;
        } else return false;
    }
}

class VisitedPharmacy extends Pharmacy
{
    function __construct($name, $supportsPriorAuth)
    {
        $this->name = $name;
        $this->supportsPriorAuth = $supportsPriorAuth;
    }
    public function compare($pharmacy) {

        if(!$this->isSupportsPriorAuth()){
            return false;
        } elseif ($this->name > $pharmacy->name ) {
            return false;
        } else return true;
    }
}

class NearestPharmacy extends Pharmacy
{
    public $copay;
    public $distance;

    function __construct($name,  $distance, $copay, $supportsPriorAuth)
    {
        $this->name = $name;
        $this->copay = $copay;
        $this->distance = $distance;
        $this->supportsPriorAuth = $supportsPriorAuth;
    }
    public function compare($pharmacy) {
   
        
        if(!$this->isSupportsPriorAuth()){
            return false;
         } 
        elseif ($this->copay > $pharmacy->copay ) {
             return false;
         } elseif ($this->copay < $pharmacy->copay ) {
            
             return true;
            
         }elseif ($this->distance > $pharmacy->distance ) {
            return false;
           
        } elseif ($this->distance < $pharmacy->distance ) {
            return true;
        } elseif ($this->name > $pharmacy->name ) {
            return false;
        } else return true;
    }
}