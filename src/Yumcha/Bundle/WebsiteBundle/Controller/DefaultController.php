<?php

namespace Yumcha\Bundle\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/shop", name="shop")
     * @Template()
     * @return array
     */
    public function shopAction()
    {
        return [];
    }

    /**
     * @Route("/icecreams", name="icecreams")
     * @Template()
     * @return array
     */
    public function icecreamsAction()
    {
        return [];
    }

    /**
     * @Route("/bubbles", name="bubbles")
     * @Template()
     * @return array
     */
    public function bubblesAction()
    {
        return [];
    }
}
