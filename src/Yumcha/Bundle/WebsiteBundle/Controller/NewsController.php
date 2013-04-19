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
        $apcKey = 'yumcha_fb_news';

        if (apc_exists($apcKey)) {
            $news = apc_fetch($apcKey);
        } else {
            $news = json_decode($this->get('buzz')->get(
                'https://www.facebook.com/feeds/page.php?id=211061718986660&format=json',
                ['User-Agent' => $this->getRequest()->headers->get('User-Agent')]
            )->getContent());

            apc_store($apcKey, $news, 1800);
        }

        return ['news' => $news];
    }
}