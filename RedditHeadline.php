<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RedditHeadline
 *
 * @author william
 */
class RedditHeadline {
    
    private $label;
    private $URL;

    public function __construct(
            $label,
            $URL
            ) {
        
        $this->label = $label;
        $this->URL = $URL;
        
    }
    
    public function getLabel(){
        
        return $this->label;
        
    }
    
    public function getURL(){
        
        return $this->URL;
        
    }
    
}
