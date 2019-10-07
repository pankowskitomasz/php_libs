<?php

class TUser{
    private $link;
    private $userData;

    public function __construct($dbLinkA=null){
        $this->userData = array(
            "ACTIVATED"=>false,
            "EMAIL"=>null,
            "ID"=>null,
            "NAME"=>null,
            "PASSWORD"=>null
        );
        $this->link = $dbLinkA;
    }

    public function getById($idA=null){
        if(isset($idA)
        && isset($this->link)
        && $this->link->isConnected()){
            $sql = "SELECT * FROM USERS ";
            $sql.= "WHERE ID = :ida";
            $data = $this->execute($sql,[':ida'=>$idA]);
            if($data && !empty($data)){
                foreach($data as $key=>$val){
                    $this->setData($key,$val);
                }
            }

        }
        return false;
    }

    public function getByName($nameA=null){
        if(isset($nameA)
        && isset($this->link)
        && $this->link->isConnected()){
            $sql = "SELECT * FROM USERS ";
            $sql.= "WHERE NAME = :namea";
            $data = $this->execute($sql,[':namea'=>$nameA]);
            if($data && !empty($data)){
                foreach($data as $key=>$val){
                    $this->setData($key,$val);
                }
            }

        }
        return false;
    }
    public function getData($dataA=null){
        if(isset($dataA)
        && array_key_exists($dataA,$this->userData)){
            return $this->userData[$dataA];
        }
        return false;
    }

    public function getLink(){
        return $this->link;
    }

    public function save(){
        if(isset($this->link)
        && $this->link->isConnected()){
            if(isset($this->userData["ID"])){
                $sqlStr = "UPDATE USERS SET ";
                $sqlStr.= "NAME=:namea,";
                $sqlStr.= "PASSWORD=:passworda,";
                $sqlStr.= "EMAIL=:emaila,";
                $sqlStr.= "ACTIVATED=:activateda ";
                $sqlStr.= "WHERE ID=:ida";
                $this->link->execute($sqlStr,[
                    ":activateda"=>$this->userData["ACTIVATED"],
                    ":emaila"=>$this->userData["EMAIL"],
                    ":ida"=>$this->userData["ID"],
                    ":namea"=>$this->userData["NAME"],
                    ":passworda"=>$this->userData["PASSWORD"]
                ]);
            }
            else{
                $sqlStr = "INSERT INTO USERS(NAME,PASSWORD,EMAIL,ACTIVATED) ";
                $sqlStr.= "VALUES(:namea,:passworda,:emaila,:activateda)";
                $this->link->execute($sqlStr,[
                    ":activateda"=>$this->userData["ACTIVATED"],
                    ":emaila"=>$this->userData["EMAIL"],
                    ":passworda"=>$this->userData["PASSWORD"],
                    ":namea"=>$this->userData["NAME"]
                ]);
            }
            return true;
        }
        return false;
    }

    public function setActive(){
        $this->userData['ACTIVATED'] = true;
        return $this->save();
    }

    public function setData($dataA=null,$valA=null){
        if(isset($dataA)
        && array_key_exists($dataA,$this->userData)){
            $this->userData[$dataA] = $valA;
        }
    }

    public function setInactive(){
        $this->userData['ACTIVATED'] = false;
        return $this->save();
    }

    public function setLink($dbLinkA=null){
        $this->link = $dbLinkA;
    }
}


?>