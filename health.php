<?php
/**
 * Circulo Take Home Test
 *
 * At Circulo Health, you need to make a list of **X** pharmacies for a specific patient based * on their previously visited pharmacies, the distance away (miles) copay amount (dollars), * * and whether or not they support prior authorization
 *
 * PHP version 8.1.12
 *
 * LICENSE: 
 *
 * @license    
 * @version    0.1
 * @since      
 * @deprecated 
 */

/**
 * The array of result pharmacies
 * @global array
 */
$arrResultPharmacy = [];

/**
 * The array of visited pharmacies **B**
 * @global array
 */
$arrVisitedPharmacy = [];

/**
 * The array of near pharmacies **C**
 * @global array
 */
$arrNearestPharmacy = [];

/**
 * Given number to return **X**
 * @global int $count
 */
$count=0;

inputSolution();
getResultSolution();
outputSolution();

/**
 * make gloab arrays from input file
 * @param
 * @throws 
 * @return
 */ 
function inputSolution(){
    global $arrResultPharmacy,$arrVisitedPharmacy,$arrNearestPharmacy,$count;
    $sInputFileName = readline("Command: ");
    (is_file($sInputFileName) && (filesize($sInputFileName)!= 0)) or die("invalid file");
    $file = fopen($sInputFileName, "r") or die("Unable to open file!");
    while(!feof($file)) {
        $arrFileContent=explode(":",fgets($file));
        $nArrayLength=count($arrFileContent);
        switch($nArrayLength)
        {
            case 1:  //get the number to display from the csv file
                is_numeric($arrFileContent[0]) or die("no number");
                $count = (int)$arrFileContent[0];
             break;
             case in_array($nArrayLength, range(2,3)): //get a list of the visited pharmacies
                if(validate($arrFileContent,1)) 
                $arrVisitedPharmacy=sortMakeArray($arrVisitedPharmacy,new VisitedPharmacy($arrFileContent[0],strtolower(trim($arrFileContent[1]))));
             break;
             case $nArrayLength >= 4 : //get a list of the nearest pharmacies
                if(validate($arrFileContent,2))
                $arrNearestPharmacy=sortMakeArray($arrNearestPharmacy,new NearestPharmacy($arrFileContent[0],$arrFileContent[1],$arrFileContent[2],strtolower(trim($arrFileContent[3]))));
             break ;
             default:
             break;    
        }
    }
    fclose($file);
}

/**
 * make result array for output
 * @param
 * @throws 
 * @return
 */
function getResultSolution(){
    global $arrResultPharmacy,$arrVisitedPharmacy,$arrNearestPharmacy,$count;
    $step = 1;
    $cntVisited=0;
    $cntNearest =0;
    $cntNotEnough=0;
   
    while(($cntNotEnough+$cntNearest+$cntVisited) < $count)
    {
        switch($step){
            case 1: //get a list of the arranged pharmacies being visited 
                if($cntVisited < count($arrVisitedPharmacy))
                {
                    if($arrVisitedPharmacy[$cntVisited]->isSupportsPriorAuth())
                    {
                        array_push($arrResultPharmacy,$arrVisitedPharmacy[$cntVisited]->name);
                        $cntVisited++;
                    }
                    else  
                        $step = 2;  
                }else 
                    $step = 2;
             
            break;
            case 2://get a list of the arranged pharmacies being nearest
                if($cntNearest < count($arrNearestPharmacy))
                {
                    if($arrNearestPharmacy[$cntNearest]->isSupportsPriorAuth())
                    {
                        array_push($arrResultPharmacy,$arrNearestPharmacy[$cntNearest]->name);
                        $cntNearest++;
                    }
                    else  
                        $step = 3;  
                }else 
                    $step = 3;
            break;
            case 3://get a list of the rest arranged pharmacies being visited
                if($cntVisited < count($arrVisitedPharmacy))
                {
                    if(!$arrVisitedPharmacy[$cntVisited]->isSupportsPriorAuth())
                    {
                        array_push($arrResultPharmacy,$arrVisitedPharmacy[$cntVisited]->name);
                        $cntVisited++;
                    }
                    else  
                        $step = 4;  
                }else 
                    $step = 4;
            break;
            default: //fill up the rest list in "Not enough data" string
                array_push($arrResultPharmacy,"Not enough data");
                $cntNotEnough++;
        }
        
    }
    
}

/**
 * output result
 * @param
 * @throws 
 * @return
 */
function outputSolution(){
    Global $count,$arrResultPharmacy;
    echo "-----------------------------|\n";
    echo "Pharmacies's list ( X = $count )\n";
    echo "-----------------------------|\n";
    $i = 1;
    foreach ($arrResultPharmacy as $name){
        echo $i.": ";
        echo "$name"."\n";
        echo "-----------------------------|\n";
        $i++;
    }
}

/**
 * output result
 * @param array $arrayData array of visited pharmacies
 * @param int $type case 1,visited pharmacies or case 2,nearest pharmacies
 * @throws 
 * @return
 */
function validate($arrayData, $type){
    $arrayLength = count($arrayData);
    if ($type==1) {
      
        if($arrayLength == 2){
            if(isBool($arrayData[1]))
            {
                return true;
            }else 
                return false;
        } else 
            return false;
    }
    if ($type == 2) {
        
        if($arrayLength == 4){
            if(is_numeric($arrayData[1]) && (is_numeric($arrayData[2])&&is_int((int)$arrayData[2])) && isBool($arrayData[3])) {
                return true;
            } else 
                return false;
        } else 
            return false;
    }
}

/**
 * output result
 * @param string $var validate string of bool format
 * @throws 
 * @return
 */
function isBool($var) {
    if(strcasecmp(trim($var),'true') == 0)
        return true;
    else if(strcasecmp(trim($var),'false') == 0)
        return true;
    else 
        return false;
}

/**
 * output result
 * @param array $array array of the pharmacy objects
 * @param object $pharmacy
 * @throws 
 * @return
 */
function sortMakeArray($array, $pharmacy) {
    if(count($array) == 0)
    {
        array_push($array, $pharmacy);
        return $array;   
    }
    $arrTemp = array();
    $lastValue = end($array);
    while ($pharmacy->compare($lastValue) == true) {
        array_push($arrTemp, $lastValue);
        array_pop($array);
        $lastValue = end($array);
    }
    array_push($array, $pharmacy);
    $array = array_merge($array, array_reverse($arrTemp));
    return $array;
}

/**
 * abstract class for the Pharmacy Object
 *
 * class is an abstract concept of the pharmacy
 *
 * @license    
 * @version   
 * @link       
 * @since      
 */ 
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

/**
 * abstract class for the visited pharmacy Object
 *
 * class is an abstract concept of the visited pharmacy
 *
 * @license    
 * @version   
 * @link       
 * @since      
 */ 
class VisitedPharmacy extends Pharmacy
{
    function __construct($name, $supportsPriorAuth)
    {
        $this->name = $name;
        $this->supportsPriorAuth = $supportsPriorAuth;
    }

    /**
     * compare conditons to objects of the class pharmacy
     * @param object $pharmacy object of class pharmacy
     * @throws 
     * @return bool 
     */
    public function compare($pharmacy) {

        if(!$this->isSupportsPriorAuth()){
            return false;
        } elseif ($this->name > $pharmacy->name ) {
            return false;
        } else return true;
    }
}

/**
 * abstract class for the nearest pharmacy Object
 *
 * class is an abstract concept of the nearest pharmacy
 *
 * @license    
 * @version   
 * @link       
 * @since      
 */ 
class NearestPharmacy extends Pharmacy
{
    public $copay;
    public $distance;

    function __construct($name,  $distance,$copay, $supportsPriorAuth)
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
?>