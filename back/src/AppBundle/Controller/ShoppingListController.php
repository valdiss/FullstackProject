<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ShoppingList;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Shoppinglist controller.
 *
 * @Route("/myshoppinglist")
 */
class ShoppingListController extends Controller
{
  /**
   * Lists all shoppingList entities.
   *
   * @Route("/{userID}/show", name="shoppinglist_index")
   * @Method("GET")
   */
  public function indexAction(Request $request, $userID)
  {
    $em = $this->getDoctrine()->getManager();
    $shoppingLists = $em->getRepository('AppBundle:ShoppingList')->findAll();

    $tmp = array();
    foreach($shoppingLists as $shoppingList) {
      $tmp2 = array("id" => $shoppingList->getId(), "name" => $shoppingList->getName());
      array_push($tmp, $tmp2);
    }
    $show = array(
      'user' => $userID,
      'shoppingLists' => $tmp);

    return new JsonResponse($show);
  }

  /**
   * Creates a new shoppingList entity.
   *
   * @Route("/{userID}/new", name="shoppinglist_new")
   * @Method({"GET", "POST"})
   */
  public function newAction(Request $request, $userID)
  {
    if($userID<1) {
      return new JsonResponse(array('error' => 'user'));
    }
    $em = $this->getDoctrine()->getManager();
    $user = $em->getRepository('AppBundle:User')->find($userID);
    if($user==NULL) {
      return new JsonResponse(array('error' => 'user'));
    }

    $shoppingList = new Shoppinglist($user, "Coucou");
    $em->persist($shoppingList);
    $em->flush();

    return $this->redirectToRoute('shoppinglist_index', array('userID' => $userID));
  }

  /**
   * Finds and displays a shoppingList entity
   *
   * @Route("/{userID}/{shoppingListID}/show", name="shoppinglist_show")
   * @Method("GET")
   */
  public function showAction(Request $request, $userID, $shoppingListID)
  {
    if($userID<1) {
      return new JsonResponse(array('error' => 'user'));
    }
    if($shoppingListID<1) {
      return new JsonResponse(array('error' => 'shoppingList'));
    }
    $em = $this->getDoctrine()->getManager();
    $user = $em->getRepository('AppBundle:User')->find($userID);
    if($user==NULL) {
      return new JsonResponse(array('error' => 'user'));
    }
    $shoppingLists = $user->getShoppingLists();
    if($shoppingListID>count($shoppingLists)) {
      return new JsonResponse(array('error' => 'shoppingList'));
    }
    $shoppingList = $shoppingLists[$shoppingListID-1];

    $tmp = array();
    foreach($shoppingList->getProducts() as $product) {
      array_push($tmp, array(
        "id" => $product->getId(),
        "name" => $product->getName(),
        "quantity" => $product->getQuantity(),
        "bought" => $product->getBought()));
    }
    $tmp2 = array(
      "id" => $shoppingList->getId(),
      "name" => $shoppingList->getName(),
      "products" => $tmp);
    $show = array(
      'user' => $userID,
      'shoppingList' => $tmp2);

    return new JsonResponse($show);
  }

  /**
   * Displays a form to edit an existing shoppingList entity.
   *
   * @Route("/{userID}/{shoppingListID}/edit", name="shoppinglist_edit")
   * @Method({"GET", "POST"})
   */
  public function editAction(Request $request, $userID, $shoppingListID)
  {
    if($userID<1) {
      return new JsonResponse(array('error' => 'user'));
    }
    if($shoppingListID<1) {
      return new JsonResponse(array('error' => 'shoppingList'));
    }
    $em = $this->getDoctrine()->getManager();
    $user = $em->getRepository('AppBundle:User')->find($userID);
    if($user==NULL) {
      return new JsonResponse(array('error' => 'user'));
    }
    $shoppingLists = $em->getRepository('AppBundle:ShoppingList')->findByUser($userID);
    if($shoppingListID>count($shoppingLists)) {
      return new JsonResponse(array('error' => 'shoppingList'));
    }
    $shoppingList = $shoppingLists[$shoppingListID-1];

    if (false) {
      //$shoppingList = $editForm->getData();
      $em->persist($shoppingList);
      $this->getDoctrine()->getManager()->flush();
    }

    return new JsonResponse(array('shoppingList' => $shoppingList));
  }

  /**
   * Deletes a shoppingList entity.
   *
   * @Route("/{userID}/{shoppingListID}/delete", name="shoppinglist_delete")
   * @Method("GET")
   */
  public function deleteAction(Request $request, $userID, $shoppingListID)
  {
    if($userID<1) {
      return new JsonResponse(array('error' => 'user'));
    }
    if($shoppingListID<1) {
      return new JsonResponse(array('error' => 'shoppinglist'));
    }
    $em = $this->getDoctrine()->getManager();
    $user = $em->getRepository('AppBundle:User')->find($userID);
    if($user==NULL) {
      return new JsonResponse(array('error' => 'user'));
    }
    $shoppingLists = $em->getRepository('AppBundle:ShoppingList')->findByUser($userID);
    if($shoppingListID>count($shoppingLists)) {
      return new JsonResponse(array('error' => 'shoppinglist'));
    }
    $shoppingList = $shoppingLists[$shoppingListID-1];

    $em->remove($shoppingList);
    $em->flush();

    return $this->redirectToRoute('shoppinglist_index', array('userID' => $userID));
  }
}
