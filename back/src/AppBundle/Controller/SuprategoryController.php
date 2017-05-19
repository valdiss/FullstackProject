<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Suprategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Suprategory controller.
 *
 * @Route("suprategory")
 */
class SuprategoryController extends Controller
{
    /**
     * Lists all suprategory entities.
     *
     * @Route("/", name="suprategory_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $suprategories = $em->getRepository('AppBundle:Suprategory')->findAll();

        return $this->render('suprategory/index.html.twig', array(
            'suprategories' => $suprategories,
        ));
    }

    /**
     * Creates a new suprategory entity.
     *
     * @Route("/new", name="suprategory_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $suprategory = new Suprategory();
        $form = $this->createForm('AppBundle\Form\SuprategoryType', $suprategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($suprategory);
            $em->flush();

            return $this->redirectToRoute('suprategory_show', array('id' => $suprategory->getId()));
        }

        return $this->render('suprategory/new.html.twig', array(
            'suprategory' => $suprategory,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a suprategory entity.
     *
     * @Route("/{id}", name="suprategory_show")
     * @Method("GET")
     */
    public function showAction(Suprategory $suprategory)
    {
        $deleteForm = $this->createDeleteForm($suprategory);

        return $this->render('suprategory/show.html.twig', array(
            'suprategory' => $suprategory,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing suprategory entity.
     *
     * @Route("/{id}/edit", name="suprategory_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Suprategory $suprategory)
    {
        $deleteForm = $this->createDeleteForm($suprategory);
        $editForm = $this->createForm('AppBundle\Form\SuprategoryType', $suprategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('suprategory_edit', array('id' => $suprategory->getId()));
        }

        return $this->render('suprategory/edit.html.twig', array(
            'suprategory' => $suprategory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a suprategory entity.
     *
     * @Route("/{id}", name="suprategory_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Suprategory $suprategory)
    {
        $form = $this->createDeleteForm($suprategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($suprategory);
            $em->flush();
        }

        return $this->redirectToRoute('suprategory_index');
    }

    /**
     * Creates a form to delete a suprategory entity.
     *
     * @param Suprategory $suprategory The suprategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Suprategory $suprategory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('suprategory_delete', array('id' => $suprategory->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
