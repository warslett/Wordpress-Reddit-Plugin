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
    
    private $redditNode;

    public function __construct($redditNode) {
        
        $this->redditNode = $redditNode;
        
    }
    
    public function getLabel(){
        
        return $this->redditNode->
                getElementsByTagName("a")->
                item(1)->
                nodeValue;
    }
    
    public function getURL(){
        
        $url = $this->redditNode->
                getElementsByTagName("a")->
                item(1)->getAttributeNode("href")->
                value;
        
        if (!preg_match('/^(http|https)/', $url)) {
            $url = "http://www.reddit.com" . $url;
        }
        
        return $url;
    }
    
}
