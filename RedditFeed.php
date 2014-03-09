<?php

/**
 * Description of RedditFeed
 *
 * @author william
 */
include 'RedditHeadline.php';

class RedditFeed {

    private $redditDOM;
    private $headlines;

    public function __construct() {

        //new DOM Object
        $this->redditDOM = new DOMDocument();

        $resp = wp_remote_get('http://www.reddit.com');

        //HTML 5 doesn't include a DTD which confuses libxml so suppress errors
        libxml_use_internal_errors(true);

        $this->redditDOM->loadHTML($resp['body']);

        //clear libXML errors
        libxml_clear_errors();
        libxml_use_internal_errors(false);

        //load headlines from reddit
        $headlinestable = $this->redditDOM->getElementById("siteTable");
        $this->headlines = array();

        foreach ($headlinestable->childNodes as $child) {

            if ($child->textContent != NULL) {
                $headline_link = $child->getElementsByTagName("a")->item(1);
                array_push($this->headlines, new RedditHeadline(
                        $headline_link->nodeValue, $headline_link->getAttributeNode("href")->value
                        )
                );
            }
        }
    }
    
    public function getHeadlines(){
        
        $output="";
        
        foreach($this->headlines as $headline){
            
            $output .= '<a href="';
            $output .= $headline->getURL();
            $output .= '">';
            $output .= $headline->getLabel();
            $output .= '</a><br/>';
            $output .= "\n";
            
        }
        
        return $output;
        
    }
    
}