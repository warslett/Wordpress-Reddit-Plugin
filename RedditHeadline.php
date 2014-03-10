<?php

/**
 * Description of RedditHeadline
 *
 * Class defining a reddit headline object and methods for extracting the data
 * 
 * @author William Arslett <wia2@aber.ac.uk>
 */
class RedditHeadline {
    
    private $redditNode;

    public function __construct($redditNode) {
        
        $this->redditNode = $redditNode;
        
    }
    
    private function getLinkNode(){
        
        //if the headline has no thumbnail use the first link
        $link = $this->redditNode->
                getElementsByTagName("a")->
                item(0);
        
        
        //otherwise use the second link
        if(preg_match('/^thumbnail/', $link->getAttributeNode("class")->value)){
            $link = $this->redditNode->
                getElementsByTagName("a")->
                item(1);
        }
        
        return $link;
        
    }
    
    public function getLabel(){
        
        return $this->getLinkNode()->nodeValue;
        
    }
    
    public function getURL(){
        
        $url = $this->getLinkNode()->getAttributeNode("href")->value;
        
        /* if the URL is relative as opposed to absolute we have to prefix the
         * reddit url so that it links correctly on this site.
         */
        if (!preg_match('/^(http|https)/', $url)) {
            $url = "http://www.reddit.com" . $url;
        }
        
        return $url;
        
    }
    
    public function getRating(){
        
        return intval($this->redditNode->
                getElementsByTagName("div")->
                item(3)->
                nodeValue);
        
    }
    
}
