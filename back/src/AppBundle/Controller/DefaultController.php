<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;


class DefaultController extends Controller
{
    /**
   * @Route("/", name="homepage")
        *  @Method({"GET", "POST"})
   */
  public function indexAction()
  {
      return new Response(file_get_contents('./ng-index.html'), 200);
  }


    /**
     * @Route("/myshoppinglist", name="shoppinglistpage")
     * @Method({"GET", "POST"})
     */
     
    public function megaAction(Request $request)
    {

      $postparams = json_decode($request->getContent());

        return new Response(print_r($postparams, true)) ;


    }
}
