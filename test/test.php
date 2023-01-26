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
 * @author     Author <anhqtrandeveloper@gmail.com>
 * @copyright  2023-2024 Anh Tran
 * @license    
 * @version    0.1
 * @since      
 * @deprecated 
 */

/**
 * The array of result pharmacies
 * @global array
 */
$arrResultPharmacy=[];

/**
 * The array of visited pharmacies **B**
 * @global array
 */
$arrVisitedPharmacy=[];

/**
 * The array of near pharmacies **C**
 * @global array
 */
$arrNearestPharmacy=[];

/**
 * Given number to return **X**
 * @global int $count
 */
$count=0;
/**
 * @inputSolution()
 * @param 
 * @return
 */
function inputSolution(){
    global $arrResultPharmacy,$arrVisitedPharmacy,$arrNearestPharmacy,$count;
    $sInputFileName = readline("Command: ");
    (is_file($sInputFileName) && (filesize($sInputFileName)!=0)) or die("invalid file");
    $file = fopen($sInputFileName, "r") or die("Unable to open file!");
    while(!feof($file)) {
        $arrFileContent=explode(":",fgets($file));
        $nArrayLength=count($arrFileContent);
        switch($nArrayLength)
        {
            case 1:  //
                
                is_numeric($arrFileContent[0]) or die("no number");
                $count = (int)$arrFileContent[0];
                
             break;
             case in_array($nArrayLength, range(2,3)): //
                if(validate($arrFileContent,1)) 
                $arrVisitedPharmacy=sortMakeArray($arrVisitedPharmacy,new VisitedPharmacy($arrFileContent[0],strtolower(trim($arrFileContent[1]))));
                
             break;
             case $nArrayLength >= 4 ://
                if(validate($arrFileContent,2))
                $arrNearestPharmacy=sortMakeArray($arrNearestPharmacy,new NearestPharmacy($arrFileContent[0],$arrFileContent[1],$arrFileContent[2],strtolower(trim($arrFileContent[3]))));
             break ;
             default:
             break;    
        }
    }
    
    fclose($file);
    
}

function getResultSolution(){
    global $arrResultPharmacy,$arrVisitedPharmacy,$arrNearestPharmacy,$count;
    $step = 1;
    $cntVisited=0;
    $cntNearest =0;
    $cntNotEnough=0;
   
    while(($cntNotEnough+$cntNearest+$cntVisited) < $count)
    {
        
        switch($step){
            case 1:
                
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
            case 2:
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
            case 3:
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
            default:
                array_push($arrResultPharmacy,"Not enough data");
                $cntNotEnough++;
        }
        
    }
    
}
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
function validate($arrayData, $type){
    
    $arrayLength = count($arrayData);
    if ($type==1) {
      
        if($arrayLength==2){
            if(isBool($arrayData[1]))
            {
                return true;
            }else 
                return false;
        } else 
            return false;
    }
    if ($type==2) {
        
        if($arrayLength==4){
            if(is_numeric($arrayData[1]) && (is_numeric($arrayData[2])&&is_int((int)$arrayData[2])) && isBool($arrayData[3])) {
                return true;
            } else 
                return false;
        } else 
            return false;
    }
}

function isBool($var) {
    if(strcasecmp(trim($var),'true') == 0)
        return true;
    else if(strcasecmp(trim($var),'false') == 0)
        return true;
    else 
        return false;
}
/**
	 * 
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

function sortMakeArray($array, $pharmacy) {
    if(count($array)==0)
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

?>