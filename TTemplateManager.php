<?php

class TTemplateManager{
    private $templateList;

    public function __construct(){
        $this->templateList = array();
    }

    public function addTemplate($templateNameA,$templateContentA){
        $this->templateList[$templateNameA] = $templateContentA;
    }

    public function count(){
        return count($this->templateList);
    }

    public function delTemplate($templateNameA){
        if(array_key_exists($templateNameA,$this->templateList)){
            unset($this->templateList[$templateNameA]);
        }
    }

    public function getTemplate($templateNameA){
        if(array_key_exists($templateNameA,$this->templateList)){
            return $this->templateList[$templateNameA];
        }
    }

    public function getTemplateNames(){
        if(!empty($this->templateList)){
            return array_keys($this->templateList);
        }
    }


}

?>