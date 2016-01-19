<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle::layout.html.twig',array('message'=>'Bienvenue sur Tweeter-Search!'));
    }

    /**
     * @Route("/search/",name="searchTweet")
     * @Method({"GET"})
     */
    public function searchAction(Request $request)
    {
            $query=$request->query->get('q');
            $query= str_replace(' ','%23',$query);
            $limit=20;

            $result = $this->get('twitter_search')->getlastTweets($query,$limit);

            $tweets = array();
            $errors='';
            if(array_key_exists('statuses',$result)){
                for($i=0;$i<count($result['statuses']);$i++){
                    $tweets[$i]=array(
                        'text'=>$result['statuses'][$i]['text'],
                        'user_image'=>$result['statuses'][$i]['user']['profile_image_url'],
                        'created_at'=>$result['statuses'][$i]['created_at'],
                        'screen_name'=>$result['statuses'][$i]['user']['screen_name']
                    );

                };
            }else{
                $errors='Une erreur serveur est survenue';
            };

            return $this->render('AppBundle::layout.html.twig',array('message'=>'Les '.count($tweets).' derniers tweet pour:'.$query ,'tweets'=>$tweets, 'errors'=>$errors));

    }
}
