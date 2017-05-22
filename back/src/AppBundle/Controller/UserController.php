<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * User controller.
 *
 * @Route("/myshoppinglist")
 */
class UserController extends Controller
{
  /**
   * Lists all user entities.
   *
   * @Route("/show", name="user_index")
   * @Method("GET")
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();

    $users = $em->getRepository('AppBundle:User')->findAll();

    $show = array();
    foreach($users as $user) {
      $tmp = array(
        "id" => $user->getId(),
        "name" => $user->getName());
      array_push($show, $tmp);
    }
    return new JsonResponse($show);
  }

  /**
   * Creates a new user entity.
   *
   * @Route("/new", name="user_new")
   * @Method({"GET", "POST"})
   */
  public function newAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $user = new User("Pierre");
    $em->persist($user);
    $em->flush();

    return $this->redirectToRoute('user_index');


    $user = new User();
    $form = $this->createForm('AppBundle\Form\UserType', $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($user);
      $em->flush();

      return $this->redirectToRoute('user_show', array('id' => $user->getId()));
    }

    return $this->render('user/new.html.twig', array(
      'user' => $user,
      'form' => $form->createView(),
    ));
  }

  /**
   * Displays a form to edit an existing user entity.
   *
   * @Route("/{userID}/edit", name="user_edit")
   * @Method({"GET", "POST"})
   */
  public function editAction(Request $request, $userID)
  {
    if($userID<1) {
      return new JsonResponse(array('error' => 'user'));
    }
    $em = $this->getDoctrine()->getManager();
    $user = $em->getRepository('AppBundle:User')->find($userID);
    if($user==NULL) {
      return new JsonResponse(array('error' => 'user'));
    }

    if (false) {
      //$user = $editForm->getData();
      $em->persist($shoppingList);
      $this->getDoctrine()->getManager()->flush();
    }

    return new JsonResponse(array('user' => $user));
  }

  /**
   * Deletes a user entity.
   *
   * @Route("/{userID}/delete", name="user_delete")
   * @Method("DELETE")
   */
  public function deleteAction(Request $request, $userID)
  {
    if($userID<1) {
      return new JsonResponse(array('error' => 'user'));
    }
    $em = $this->getDoctrine()->getManager();
    $user = $em->getRepository('AppBundle:User')->find($userID);
    if($user==NULL) {
      return new JsonResponse(array('error' => 'user'));
    }

    $em->remove($user);
    $em->flush();

    return $this->redirectToRoute('user_index');
  }
}
