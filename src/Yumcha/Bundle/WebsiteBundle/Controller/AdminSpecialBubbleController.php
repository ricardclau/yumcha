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

use Yumcha\Bundle\WebsiteBundle\Entity\SpecialBubble;
use Yumcha\Bundle\WebsiteBundle\Form\SpecialBubbleType;
use Yumcha\Bundle\WebsiteBundle\Form\SpecialBubbleFilterType;

/**
 * SpecialBubble controller.
 *
 * @Route("/admin/specialbubble", options={"i18n" = false})
 */
class AdminSpecialBubbleController extends Controller
{
    /**
     * Lists all SpecialBubble entities.
     *
     * @Route("/", name="admin_specialbubble")
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
        $filterForm = $this->createForm(new SpecialBubbleFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('YumchaWebsiteBundle:SpecialBubble')->createQueryBuilder('e');

        // Reset filter
        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'reset') {
            $session->remove('SpecialBubbleControllerFilter');
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
                $session->set('SpecialBubbleControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('SpecialBubbleControllerFilter')) {
                $filterData = $session->get('SpecialBubbleControllerFilter');
                $filterForm = $this->createForm(new SpecialBubbleFilterType(), $filterData);
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
            return $me->generateUrl('admin_specialbubble', array('page' => $page));
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
     * Creates a new SpecialBubble entity.
     *
     * @Route("/", name="admin_specialbubble_create")
     * @Method("POST")
     * @Template("YumchaWebsiteBundle:AdminSpecialBubble:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new SpecialBubble();
        $form = $this->createForm(new SpecialBubbleType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('admin_specialbubble_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new SpecialBubble entity.
     *
     * @Route("/new", name="admin_specialbubble_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new SpecialBubble();
        $form   = $this->createForm(new SpecialBubbleType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a SpecialBubble entity.
     *
     * @Route("/{id}", name="admin_specialbubble_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YumchaWebsiteBundle:SpecialBubble')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SpecialBubble entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SpecialBubble entity.
     *
     * @Route("/{id}/edit", name="admin_specialbubble_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YumchaWebsiteBundle:SpecialBubble')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SpecialBubble entity.');
        }

        $editForm = $this->createForm(new SpecialBubbleType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing SpecialBubble entity.
     *
     * @Route("/{id}/update", name="admin_specialbubble_update")
     * @Method("POST")
     * @Template("YumchaWebsiteBundle:AdminSpecialBubble:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YumchaWebsiteBundle:SpecialBubble')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SpecialBubble entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SpecialBubbleType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $entity->prepareFiles();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('admin_specialbubble_edit', array('id' => $id)));
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
     * Deletes a SpecialBubble entity.
     *
     * @Route("/{id}/delete", name="admin_specialbubble_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('YumchaWebsiteBundle:SpecialBubble')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SpecialBubble entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('admin_specialbubble'));
    }

    /**
     * Creates a form to delete a SpecialBubble entity by id.
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
