<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/myshoppinglist", name="homepage")
     * @Method("POST")
     */
    public function megaAction(Request $request)
    {
      $postparams = $request->request->all();

      return "mon" . print_r($postparams,true);

      $serializer = $this->get('serializer');  /* $this->container->get */
      $jsonContent = $serializer->serialize($jsonContent, 'json');
      return new Response($jsonContent); // should be $reports as $doctrineobject is not serialized

    }


}
