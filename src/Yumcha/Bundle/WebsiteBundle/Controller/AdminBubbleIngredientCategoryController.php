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

use Yumcha\Bundle\WebsiteBundle\Entity\BubbleIngredientCategory;
use Yumcha\Bundle\WebsiteBundle\Form\BubbleIngredientCategoryType;
use Yumcha\Bundle\WebsiteBundle\Form\BubbleIngredientCategoryFilterType;

/**
 * BubbleIngredientCategory controller.
 *
 * @Route("/admin/bubbleingredientcategory", options={"i18n" = false})
 */
class AdminBubbleIngredientCategoryController extends Controller
{
    /**
     * Lists all BubbleIngredientCategory entities.
     *
     * @Route("/", name="admin_bubbleingredientcategory")
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
        $filterForm = $this->createForm(new BubbleIngredientCategoryFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('YumchaWebsiteBundle:BubbleIngredientCategory')->createQueryBuilder('e');

        // Reset filter
        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'reset') {
            $session->remove('BubbleIngredientCategoryControllerFilter');
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
                $session->set('BubbleIngredientCategoryControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('BubbleIngredientCategoryControllerFilter')) {
                $filterData = $session->get('BubbleIngredientCategoryControllerFilter');
                $filterForm = $this->createForm(new BubbleIngredientCategoryFilterType(), $filterData);
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
            return $me->generateUrl('admin_bubbleingredientcategory', array('page' => $page));
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
     * Creates a new BubbleIngredientCategory entity.
     *
     * @Route("/", name="admin_bubbleingredientcategory_create")
     * @Method("POST")
     * @Template("YumchaWebsiteBundle:AdminBubbleIngredientCategory:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new BubbleIngredientCategory();
        $form = $this->createForm(new BubbleIngredientCategoryType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('admin_bubbleingredientcategory_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new BubbleIngredientCategory entity.
     *
     * @Route("/new", name="admin_bubbleingredientcategory_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new BubbleIngredientCategory();
        $form   = $this->createForm(new BubbleIngredientCategoryType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a BubbleIngredientCategory entity.
     *
     * @Route("/{id}", name="admin_bubbleingredientcategory_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YumchaWebsiteBundle:BubbleIngredientCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BubbleIngredientCategory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing BubbleIngredientCategory entity.
     *
     * @Route("/{id}/edit", name="admin_bubbleingredientcategory_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YumchaWebsiteBundle:BubbleIngredientCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BubbleIngredientCategory entity.');
        }

        $editForm = $this->createForm(new BubbleIngredientCategoryType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing BubbleIngredientCategory entity.
     *
     * @Route("/{id}/update", name="admin_bubbleingredientcategory_update")
     * @Method("POST")
     * @Template("YumchaWebsiteBundle:AdminBubbleIngredientCategory:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YumchaWebsiteBundle:BubbleIngredientCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BubbleIngredientCategory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new BubbleIngredientCategoryType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('admin_bubbleingredientcategory_edit', array('id' => $id)));
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
     * Deletes a BubbleIngredientCategory entity.
     *
     * @Route("/{id}/delete", name="admin_bubbleingredientcategory_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('YumchaWebsiteBundle:BubbleIngredientCategory')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find BubbleIngredientCategory entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('admin_bubbleingredientcategory'));
    }

    /**
     * Lists all Bubble Ingredient entities.
     *
     * @Route("/{id}/ingredients", requirements={"id" = "\d+"}, name="admin_bubbleingredientcategory_ingredients")
     * @Template()
     */
    public function ingredientsAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YumchaWebsiteBundle:BubbleIngredientCategory')->find($id);
        if (!$entity instanceof BubbleIngredientCategory) {
            throw $this->createNotFoundException('Unable to find BubbleIngredientCategory entity.');
        }

        return array(
            'entity' => $entity,
        );
    }

    /**
     * Creates a form to delete a BubbleIngredientCategory entity by id.
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
