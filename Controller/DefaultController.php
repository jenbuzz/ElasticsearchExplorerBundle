<?php

namespace DanLyn\ElasticsearchExplorerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DanLynElasticsearchExplorerBundle:Default:index.html.twig');
    }
}
