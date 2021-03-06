<?php

/**
 * Description of RedditFeed
 * 
 * Class describing a feed object which loads headlines from reddit
 *
 * @author William Arslett <wia2@aber.ac.uk>
 */
include 'RedditHeadline.php';

class RedditFeed {

    private $redditDOM;
    private $headlines;

    public function __construct() {

        //new DOM Object
        $this->redditDOM = new DOMDocument();

        //get reddit source from transient or load current source
        if ( false === ( $reddit_body = get_transient('reddit_resp') ) ) {
            $resp = wp_remote_get('http://www.reddit.com');
            $reddit_body=$resp[body];
            set_transient('reddit_resp',$reddit_body,60*60*6);
        }

        //HTML 5 doesn't include a DTD which confuses libxml so suppress errors
        libxml_use_internal_errors(true);

        $this->redditDOM->loadHTML($reddit_body);

        //clear libXML errors
        libxml_clear_errors();
        libxml_use_internal_errors(false);

        //load headlines from reddit source
        $headlinestable = $this->redditDOM->getElementById("siteTable");
        $this->headlines = array();

        foreach ($headlinestable->childNodes as $child) {

            if ($child->textContent != NULL &&
                            $child->
                            getElementsByTagName("a")->
                            item(1)->
                    nodeValue != "random subreddit"
            ) {
                array_push($this->headlines, new RedditHeadline($child));
            }
        }

        usort($this->headlines, "compareHeadlines");
    }

    public function getHeadlines() {

        //output feed as in formatted HTML
        $output = "<ol>";

        foreach ($this->headlines as $headline) {

            $output .= '<li><a href="';
            $output .= $headline->getURL();
            $output .= '" target="_blank">';
            $output .= $headline->getLabel();
            $output .= '</a></li>';
            $output .= "\n";
        }

        $output .= "</ol>";

        return $output;
    }

}

// For comparing headlines for usort (inbuilt quicksort for objects)
function compareHeadlines($hl1, $hl2) {
    return $hl2->getRating() - $hl1->getRating();
}
