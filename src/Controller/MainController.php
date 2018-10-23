<?php
/**
 * Created by IntelliJ IDEA.
 * User: Elio
 * Date: 06/10/2018
 * Time: 11:01
 */

namespace App\Controller;


use App\Services\MainService;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController
{
    private $logger;

    /**
     * @Route("/")
     */
    public function homepage(MainService $debg){
        $info = $debg->getInfo();
        dump($info);
        $response = new JsonResponse(array('data' => 123));
        $response->headers->set("Access-Control-Allow-Origin:",'*');
        $response->setStatusCode(200);
        return $response;
    }
    /**
     * @Route("/pepe")
     * @Method({"POST"})
     */
    public function show(Request $request, LoggerInterface $logger){

        $user = $request->getContent();
        //$response->headers->set("Access-Control-Allow-Origin:",'*');
        $response = new JsonResponse($user);
        return $response;
    }

}