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
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use JMS\SerializerBundle\Annotation\ExclusionPolicy;
use JMS\SerializerBundle\Annotation\Exclude;

$encoders = array(new JsonEncoder());
$normalizers = array(new ObjectNormalizer());

$serializer = new Serializer($normalizers, $encoders);


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
    $params = json_decode($request->getContent(), true);
    var_dump($params);
    if($params['action']=="create") {
      if($params['article']) return $this->redirectToRoute('product_new', array('userID' => 1, 'shoppingListID' => 1));
    }

    return new Response(print_r($params, true)) ;

    $serializer = $this->get('serializer');  /* $this->container->get */
    $jsonContent = $serializer->serialize($jsonContent, 'json');
    return new Response($jsonContent); // should be $reports as $doctrineobject is not serialized
  }
}
