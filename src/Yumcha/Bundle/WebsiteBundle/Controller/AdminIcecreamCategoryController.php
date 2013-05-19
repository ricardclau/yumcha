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

use Yumcha\Bundle\WebsiteBundle\Entity\IcecreamCategory;
use Yumcha\Bundle\WebsiteBundle\Form\IcecreamCategoryType;
use Yumcha\Bundle\WebsiteBundle\Form\IcecreamCategoryFilterType;

/**
 * IcecreamCategory controller.
 *
 * @Route("/admin/icecreamcategory", options={"i18n" = false})
 */
class AdminIcecreamCategoryController extends Controller
{
    /**
     * Lists all IcecreamCategory entities.
     *
     * @Route("/", name="admin_icecreamcategory")
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
        $filterForm = $this->createForm(new IcecreamCategoryFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('YumchaWebsiteBundle:IcecreamCategory')->createQueryBuilder('e');

        // Reset filter
        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'reset') {
            $session->remove('IcecreamCategoryControllerFilter');
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
                $session->set('IcecreamCategoryControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('IcecreamCategoryControllerFilter')) {
                $filterData = $session->get('IcecreamCategoryControllerFilter');
                $filterForm = $this->createForm(new IcecreamCategoryFilterType(), $filterData);
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
            return $me->generateUrl('admin_icecreamcategory', array('page' => $page));
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
     * Creates a new IcecreamCategory entity.
     *
     * @Route("/", name="admin_icecreamcategory_create")
     * @Method("POST")
     * @Template("YumchaWebsiteBundle:AdminIcecreamCategory:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new IcecreamCategory();
        $form = $this->createForm(new IcecreamCategoryType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('admin_icecreamcategory_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new IcecreamCategory entity.
     *
     * @Route("/new", name="admin_icecreamcategory_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new IcecreamCategory();
        $form   = $this->createForm(new IcecreamCategoryType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a IcecreamCategory entity.
     *
     * @Route("/{id}", name="admin_icecreamcategory_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YumchaWebsiteBundle:IcecreamCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IcecreamCategory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing IcecreamCategory entity.
     *
     * @Route("/{id}/edit", name="admin_icecreamcategory_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YumchaWebsiteBundle:IcecreamCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IcecreamCategory entity.');
        }

        $editForm = $this->createForm(new IcecreamCategoryType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing IcecreamCategory entity.
     *
     * @Route("/{id}/update", name="admin_icecreamcategory_update")
     * @Method("POST")
     * @Template("YumchaWebsiteBundle:AdminIcecreamCategory:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YumchaWebsiteBundle:IcecreamCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IcecreamCategory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new IcecreamCategoryType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('admin_icecreamcategory_edit', array('id' => $id)));
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
     * Deletes a IcecreamCategory entity.
     *
     * @Route("/{id}/delete", name="admin_icecreamcategory_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('YumchaWebsiteBundle:IcecreamCategory')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find IcecreamCategory entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('admin_icecreamcategory'));
    }

    /**
     * Lists all IcrecreamFlavours entities.
     *
     * @Route("/{id}/flavours", requirements={"id" = "\d+"}, name="admin_icecreamcategory_flavours")
     * @Template()
     */
    public function flavoursAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YumchaWebsiteBundle:IcecreamCategory')->find($id);
        if (!$entity instanceof IcecreamCategory) {
            throw $this->createNotFoundException('Unable to find IcecreamCategory entity.');
        }

        return array(
            'entity' => $entity,
        );
    }

    /**
     * Creates a form to delete a IcecreamCategory entity by id.
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
