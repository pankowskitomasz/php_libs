<?php

class TPDOLink{
    private $connected;
    private $link;
    private $linkData;

    public function __construct($dbA=null,
        $hostA=null,
        $passA=null,
        $portA=null,
        $serverA=null,
        $userA=null){
        $this->connected = false;
        $this->link = null;
        $this->linkData = array(
            "database"=>$dbA,
            "host"=>$hostA,
            "password"=>$passA,
            "port"=>$portA,
            "server"=>$serverA,
            "user"=>$userA
        );
    }

    public function connect(){    
        if(isset($this->linkData["database"])   
        && isset($this->linkData["host"])       
        && isset($this->linkData["password"])   
        && isset($this->linkData["port"])
        && isset($this->linkData["server"])     
        && isset($this->linkData["user"])){     
        try {            
            $connStr = $this->linkData["server"].":";
            $connStr.= "host=".$this->linkData["host"].";";
            $connStr.= "port=".$this->linkData["port"].";";
            $connStr.= "dbname=".$this->linkData["database"].";";
            $this->link = new PDO($connStr,$this->linkData["user"],$this->linkData["password"]);
            $this->link->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION);
            $this->connected = true;
            return $this->connected;
            }
        catch(PDOException $err)
            {
            return false;
            }
        }        
    }

    public function disconnect(){
        $this->link = null;
        $this->connected = false;
    }

    public function execute($sqlStrA=null,$sqlStrParamsA=[]){
        if(isset($sqlStrA)
        && $this->connected){
            $stmt = $this->link->prepare($sqlStrA);
            if(is_array($sqlStrParamsA)
            && !empty($sqlStrParamsA)){
                foreach($sqlStrParamsA as $key => &$val){
                    $stmt->bindParam($key,$val);
                }
            }
            $stmt->execute();
            try{
                $res = $stmt->fetchAll();
                
            }
            catch(PDOException $err){
                $res = true;
            }
            $stmt->closeCursor();
            return $res;
            
        }
        return false;
    }

    public function getParam($paramA=null){
        if(isset($paramA)
        && array_key_exists($paramA,$this->linkData)){
            return $this->linkData[$paramA];
        }
        return false;
    }

    public function isConnected(){
        return $this->connected;
    }

    public function setParam($paramA=null,$valA=null){
        if(isset($paramA)
        && isset($valA)
        && array_key_exists($paramA,$this->linkData)){
            $this->linkData[$paramA] = $valA;
            return true;
        }
        return false;
    }
}

?>