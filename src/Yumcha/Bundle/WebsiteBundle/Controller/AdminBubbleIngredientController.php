<?php

namespace Yumcha\Bundle\WebsiteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrapView;

use Yumcha\Bundle\WebsiteBundle\Entity\BubbleIngredient;
use Yumcha\Bundle\WebsiteBundle\Form\BubbleIngredientType;
use Yumcha\Bundle\WebsiteBundle\Form\BubbleIngredientFilterType;

/**
 * BubbleIngredient controller.
 *
 * @Route("/admin/bubbleingredient", options={"i18n" = false})
 */
class AdminBubbleIngredientController extends Controller
{
    /**
     * Lists all BubbleIngredient entities.
     *
     * @Route("/", name="admin_bubbleingredient")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        list($filterForm, $queryBuilder) = $this->filter();

        list($entities, $pagerHtml) = $this->paginator($queryBuilder);

        return array(
            'entities' => $entities,
            'pagerHtml' => $pagerHtml,
            'filterForm' => $filterForm->createView(),
        );
    }

    /**
    * Create filter form and process filter request.
    *
    */
    protected function filter()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $filterForm = $this->createForm(new BubbleIngredientFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('YumchaWebsiteBundle:BubbleIngredient')->createQueryBuilder('e');

        // Reset filter
        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'reset') {
            $session->remove('BubbleIngredientControllerFilter');
        }

        // Filter action
        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'filter') {
            // Bind values from the request
            $filterForm->bind($request);

            if ($filterForm->isValid()) {
                // Build the query from the given form object
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
                // Save filter to session
                $filterData = $filterForm->getData();
                $session->set('BubbleIngredientControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('BubbleIngredientControllerFilter')) {
                $filterData = $session->get('BubbleIngredientControllerFilter');
                $filterForm = $this->createForm(new BubbleIngredientFilterType(), $filterData);
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
            }
        }

        return array($filterForm, $queryBuilder);
    }

    /**
    * Get results from paginator and get paginator view.
    *
    */
    protected function paginator($queryBuilder)
    {
        // Paginator
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $currentPage = $this->getRequest()->get('page', 1);
        $pagerfanta->setCurrentPage($currentPage);
        $entities = $pagerfanta->getCurrentPageResults();

        // Paginator - route generator
        $me = $this;
        $routeGenerator = function($page) use ($me)
        {
            return $me->generateUrl('admin_bubbleingredient', array('page' => $page));
        };

        // Paginator - view
        $translator = $this->get('translator');
        $view = new TwitterBootstrapView();
        $pagerHtml = $view->render($pagerfanta, $routeGenerator, array(
            'proximity' => 3,
            'prev_message' => $translator->trans('views.index.pagprev', array(), 'JordiLlonchCrudGeneratorBundle'),
            'next_message' => $translator->trans('views.index.pagnext', array(), 'JordiLlonchCrudGeneratorBundle'),
        ));

        return array($entities, $pagerHtml);
    }

    /**
     * Creates a new BubbleIngredient entity.
     *
     * @Route("/", name="admin_bubbleingredient_create")
     * @Method("POST")
     * @Template("YumchaWebsiteBundle:AdminBubbleIngredient:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new BubbleIngredient();
        $form = $this->createForm(new BubbleIngredientType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('admin_bubbleingredient_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new BubbleIngredient entity.
     *
     * @Route("/new", name="admin_bubbleingredient_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new BubbleIngredient();
        $form   = $this->createForm(new BubbleIngredientType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a BubbleIngredient entity.
     *
     * @Route("/{id}", name="admin_bubbleingredient_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YumchaWebsiteBundle:BubbleIngredient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BubbleIngredient entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing BubbleIngredient entity.
     *
     * @Route("/{id}/edit", name="admin_bubbleingredient_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YumchaWebsiteBundle:BubbleIngredient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BubbleIngredient entity.');
        }

        $editForm = $this->createForm(new BubbleIngredientType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing BubbleIngredient entity.
     *
     * @Route("/{id}/update", name="admin_bubbleingredient_update")
     * @Method("POST")
     * @Template("YumchaWebsiteBundle:AdminBubbleIngredient:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YumchaWebsiteBundle:BubbleIngredient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BubbleIngredient entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new BubbleIngredientType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('admin_bubbleingredient_edit', array('id' => $id)));
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.update.error');
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a BubbleIngredient entity.
     *
     * @Route("/{id}/delete", name="admin_bubbleingredient_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('YumchaWebsiteBundle:BubbleIngredient')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find BubbleIngredient entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('admin_bubbleingredient'));
    }

    /**
     * Creates a form to delete a BubbleIngredient entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
