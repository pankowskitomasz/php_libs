<?php

class TToken{
    private $randomTxtSize;
    private $similarChars;

    private function encode($tokenA){
        return sha1($tokenA);
    }

    public function __construct($randomTxtSizeA=20,$similarCharsA=false){
        $this->randomTxtSize = $randomTxtSizeA;
        $this->similarChars = $similarCharsA;
    }

    public function createToken($baseStrA=null){
        $token = Date("dmYHis");
        if(isset($baseStrA)){
            $token.= $baseStrA;
        }
        else{
            $token.= self::randomText($this->randomTxtSize,$this->similarChars);
        }
        return $this->encode($token);
    }

    public function getRandomTextSize(){
        return $this->randomTxtSize;
    }

    public function getSimilarChars(){
        return $this->similarChars;
    }

    public static function randomText($lengthA=20,$similarCharsA=true){
        $charArr = array_flip(array_merge(range(0,9),range('a','z'),range('A','Z')));
        if($similarCharsA){
            unset(
                $charArr[0],
                $charArr[1],
                $charArr[2],
                $charArr[5],
                $charArr[6],
                $charArr[8],
                $charArr[9],
                $charArr['b'],
                $charArr['g'],
                $charArr['l'],
                $charArr['o'],
                $charArr['s'],
                $charArr['q'],
                $charArr['u'],
                $charArr['v'],
                $charArr['z'],
                $charArr['B'],
                $charArr['I'],
                $charArr['O'],
                $charArr['Q'],
                $charArr['S'],
                $charArr['U'],
                $charArr['V'],
                $charArr['Z']
            );
        }
        for($i=0,$text='';$i<$lengthA;$i++){
            $text.=array_rand($charArr);
        } 
        return $text;  
    }

    public function setRandomTextSize($valA=20){
        $this->randomTxtSize = $valA;
    }

    public function setSimilarChars($valA=false){
        $this->similarChars = $valA;
    }
}

?>