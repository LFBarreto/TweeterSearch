<?php

namespace AppBundle\Services;

class TwitterSearch
{
    protected $twitter;

    public function __construct($endroidTwitter) {

        $this->twitter = $endroidTwitter;

    }

    public function getlastTweets($search,$limit){
        $response = $this->twitter->query('search/tweets', 'GET', 'json',array('q'=>'%23'.$search,'count'=>$limit));
        $tweets = json_decode($response->getContent(),true);
        return $tweets;
    }
}