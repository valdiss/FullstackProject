<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ShoppingList;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Shoppinglist controller.
 *
 * @Route("shoppinglist")
 */
class ShoppingListController extends Controller
{
    /**
     * Lists all shoppingList entities.
     *
     * @Route("/", name="shoppinglist_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $shoppingLists = $em->getRepository('AppBundle:ShoppingList')->findAll();

        return $this->render('shoppinglist/index.html.twig', array(
            'shoppingLists' => $shoppingLists,
        ));
    }

    /**
     * Creates a new shoppingList entity.
     *
     * @Route("/new", name="shoppinglist_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $shoppingList = new Shoppinglist();
        $form = $this->createForm('AppBundle\Form\ShoppingListType', $shoppingList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($shoppingList);
            $em->flush();

            return $this->redirectToRoute('shoppinglist_show', array('id' => $shoppingList->getId()));
        }

        return $this->render('shoppinglist/new.html.twig', array(
            'shoppingList' => $shoppingList,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a shoppingList entity.
     *
     * @Route("/{id}", name="shoppinglist_show")
     * @Method("GET")
     */
    public function showAction(ShoppingList $shoppingList)
    {
        $deleteForm = $this->createDeleteForm($shoppingList);

        return $this->render('shoppinglist/show.html.twig', array(
            'shoppingList' => $shoppingList,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing shoppingList entity.
     *
     * @Route("/{id}/edit", name="shoppinglist_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ShoppingList $shoppingList)
    {
        $deleteForm = $this->createDeleteForm($shoppingList);
        $editForm = $this->createForm('AppBundle\Form\ShoppingListType', $shoppingList);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('shoppinglist_edit', array('id' => $shoppingList->getId()));
        }

        return $this->render('shoppinglist/edit.html.twig', array(
            'shoppingList' => $shoppingList,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a shoppingList entity.
     *
     * @Route("/{id}", name="shoppinglist_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ShoppingList $shoppingList)
    {
        $form = $this->createDeleteForm($shoppingList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($shoppingList);
            $em->flush();
        }

        return $this->redirectToRoute('shoppinglist_index');
    }

    /**
     * Creates a form to delete a shoppingList entity.
     *
     * @param ShoppingList $shoppingList The shoppingList entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ShoppingList $shoppingList)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('shoppinglist_delete', array('id' => $shoppingList->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
