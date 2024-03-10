<?php
// Online PHP compiler to run PHP program online
// Print "Try programiz.pro" message
class Solution {

    /**
     * @param Integer[] $nums
     * @return Integer
     */
    function firstMissingPositive($nums) {
        $result = [];
    foreach($nums as $num){ 
        if($num > 0) $result[] = $num;   
    }
    //print_r($result);
   sort($result);
    $i = 1;
    $last = 0;
    foreach($result as $n){
        if($last == $n) $i--; // Check for repeated elements 
        else if($i != $n) return $i;//

        $i++;
        $last = $n;    //las-1    
       

    }

    return $i;

        
    }
}
$nums=[8,9,1,4,5];
$invoke = new Solution();
$res = $invoke->firstMissingPositive($nums);
echo  $res;
?>