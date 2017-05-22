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
 * @Route("/myshoppinglist")
 */
class ProductController extends Controller
{
  /**
   * Creates a new product entity.
   *
   * @Route("/{userID}/{shoppingListID}/new", name="product_new")
   * @Method({"GET", "POST"})
   */
  public function newProduct(Request $request, $userID, $shoppingListID)
  {
    $params = json_decode($request->getContent(), true);

    if(!is_numeric($userID) || !is_numeric($shoppingListID)) {
      return new JsonResponse(array('error' => 'format'));
    }
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
    if($params['category']) {
      $category = $this->forward('AppBundle:CategoryController:searchCategory', array('userID' => $userID, 'category' => $params['category']));
    } else {
      $category = null;
    }

    $product = new Product($shoppingList, $category, $params['article'], $params['quantity']);
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
  public function showProduct(Request $request, $userID, $shoppingListID, $productID)
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


  //Not implemented yet
  /**
   * Displays a form to edit an existing product entity.
   *
   * @Route("/{id}/edit", name="product_edit")
   * @Method({"GET", "POST"})
   */
  public function editProduct(Request $request, Product $product)
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
  public function deleteProduct(Request $request, Product $product)
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
}
