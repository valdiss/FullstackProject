<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Product controller.
 *
 * @Route("product")
 */
class ProductController extends Controller
{
  /**
   * Creates a new product entity.
   *
   * @Route("/{userID}/{shoppingListID}/new", name="product_new")
   * @Method({"GET", "POST"})
   */
  public function newAction(Request $request, $userID, $shoppingListID)
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

    $product = new Product($shoppingList, null, "Lait", 12);
    $em->persist($product);
    $em->flush();

    return $this->redirectToRoute('shoppinglist_show', array('userID' => $userID, 'shoppingListID' => $shoppingListID));
  }

  /**
   * Finds and displays a product entity.
   *
   * @Route("/{userID}/{shoppingListID}/{productID}/show", name="product_show")
   * @Method("GET")
   */
  public function showAction(Request $request, $userID, $shoppingListID, $productID)
  {
    if($userID<1) {
      return new JsonResponse(array('error' => 'user'));
    }
    if($shoppingListID<1) {
      return new JsonResponse(array('error' => 'shoppingList'));
    }
    if($productID<1) {
      return new JsonResponse(array('error' => 'product'));
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
    $products = $shoppingList->getProducts();
    if($productID>count($products)) {
      return new JsonResponse(array('error' => 'product'));
    }
    $product = $products[$productID-1];

    $tmp = array(
      "id" => $product->getId(),
      "name" => $product->getName(),
      "quantity" => $product->getQuantity(),
      "bought" => $product->getBought());
    $show = array(
      "user" => $userID,
      "shoppingList" => $shoppingListID,
      "product" => $tmp);

    return new JsonResponse($show);
  }

  /**
   * Displays a form to edit an existing product entity.
   *
   * @Route("/{id}/edit", name="product_edit")
   * @Method({"GET", "POST"})
   */
  public function editAction(Request $request, Product $product)
  {
    $deleteForm = $this->createDeleteForm($product);
    $editForm = $this->createForm('AppBundle\Form\ProductType', $product);
    $editForm->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $this->getDoctrine()->getManager()->flush();

      return $this->redirectToRoute('product_edit', array('id' => $product->getId()));
    }

    return $this->render('product/edit.html.twig', array(
      'product' => $product,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
   * Deletes a product entity.
   *
   * @Route("/{id}", name="product_delete")
   * @Method("DELETE")
   */
  public function deleteAction(Request $request, Product $product)
  {
    $form = $this->createDeleteForm($product);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($product);
      $em->flush();
    }

    return $this->redirectToRoute('product_index');
  }

  /**
   * Creates a form to delete a product entity.
   *
   * @param Product $product The product entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm(Product $product)
  {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('product_delete', array('id' => $product->getId())))
      ->setMethod('DELETE')
      ->getForm()
      ;
  }
}
