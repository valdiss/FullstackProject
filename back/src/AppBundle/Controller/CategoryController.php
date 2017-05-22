<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Category controller.
 *
 * @Route("/category")
 */
class CategoryController extends Controller
{
  /**
   * Search a category
   *
   * @param Category $category The category entity
   * @return \Symfony\Component\Form\Form The form
   */
  public function searchCategory(Request $request, $userID, $name)
  {
    if(!is_numeric($userID) || is_numeric($name)) {
      return new JsonResponse(array('error' => 'format'));
    }
    if($userID<1) {
      return new JsonResponse(array('error' => 'user'));
    }
    if($name=="") {
      return new JsonResponse(array('error' => 'category'));
    }
    $em = $this->getDoctrine()->getManager();
    $user = $em->getRepository('AppBundle:User')->find($userID);
    if($user==NULL) {
      return new JsonResponse(array('error' => 'user'));
    }
    $categories = $user->getCategories();
    foreach($categories as $category) {
      if($name==$category->getName()) return $category;
    }
    return $this->forward('AppBundle:CategoryController:newCategory', array('userID' => $userID, 'category' => $name));
  }

  /**
   * create a category
   *
   * @param Category $category The category entity
   * @return \Symfony\Component\Form\Form The form
   */
  public function newCategory(Request $request, $userID, $name)
  {
    if(!is_numeric($userID) || is_numeric($name)) {
      return new JsonResponse(array('error' => 'format'));
    }
    if($userID<1) {
      return new JsonResponse(array('error' => 'user'));
    }
    if($name=="") {
      return new JsonResponse(array('error' => 'category'));
    }
    $em = $this->getDoctrine()->getManager();
    $user = $em->getRepository('AppBundle:User')->find($userID);
    if($user==NULL) {
      return new JsonResponse(array('error' => 'user'));
    }
    $category = new Category($user, $name);
    return $category;
  }


  /**
   * Lists all category entities.
   *
   * @Route("/", name="category_index")
   * @Method("GET")
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();

    $categories = $em->getRepository('AppBundle:Category')->findAll();

    return $this->render('category/index.html.twig', array(
      'categories' => $categories,
    ));
  }

  /**
   * Creates a new category entity.
   *
   * @Route("/new", name="category_new")
   * @Method({"GET", "POST"})
   */
  public function newAction(Request $request)
  {
    $category = new Category();
    $form = $this->createForm('AppBundle\Form\CategoryType', $category);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($category);
      $em->flush();

      return $this->redirectToRoute('category_show', array('id' => $category->getId()));
    }

    return $this->render('category/new.html.twig', array(
      'category' => $category,
      'form' => $form->createView(),
    ));
  }

  /**
   * Finds and displays a category entity.
   *
   * @Route("/{id}", name="category_show")
   * @Method("GET")
   */
  public function showAction(Category $category)
  {
    $deleteForm = $this->createDeleteForm($category);

    return $this->render('category/show.html.twig', array(
      'category' => $category,
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
   * Displays a form to edit an existing category entity.
   *
   * @Route("/{id}/edit", name="category_edit")
   * @Method({"GET", "POST"})
   */
  public function editAction(Request $request, Category $category)
  {
    $deleteForm = $this->createDeleteForm($category);
    $editForm = $this->createForm('AppBundle\Form\CategoryType', $category);
    $editForm->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $this->getDoctrine()->getManager()->flush();

      return $this->redirectToRoute('category_edit', array('id' => $category->getId()));
    }

    return $this->render('category/edit.html.twig', array(
      'category' => $category,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
   * Deletes a category entity.
   *
   * @Route("/{id}", name="category_delete")
   * @Method("DELETE")
   */
  public function deleteAction(Request $request, Category $category)
  {
    $form = $this->createDeleteForm($category);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($category);
      $em->flush();
    }

    return $this->redirectToRoute('category_index');
  }

  /**
   * Creates a form to delete a category entity.
   *
   * @param Category $category The category entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm(Category $category)
  {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('category_delete', array('id' => $category->getId())))
      ->setMethod('DELETE')
      ->getForm()
      ;
  }
}
