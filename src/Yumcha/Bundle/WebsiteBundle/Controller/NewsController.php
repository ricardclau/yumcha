<?php

namespace Yumcha\Bundle\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class NewsController extends Controller
{
    /**
     * @Route("/news", name="news")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }
}