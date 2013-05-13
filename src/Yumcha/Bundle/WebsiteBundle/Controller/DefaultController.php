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
        return [];
    }

    /**
     * @Route("/shop", name="shop")
     * @Template()
     * @return array
     */
    public function shopAction()
    {
        $texts = $this->getDoctrine()
            ->getRepository('YumchaWebsiteBundle:Text')
            ->getMultipleNames([
                'quesignificayumcha_titol',
                'quesignificayumcha_text',
                'volstreballambnosaltres_titol',
                'volstreballambnosaltres_text',
                'yumchashop_lateral',
                'yumchashop_text'
            ]);

        return [
            'texts' => $texts,
        ];
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
