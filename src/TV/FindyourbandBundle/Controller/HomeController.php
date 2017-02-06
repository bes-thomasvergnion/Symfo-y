<?php

namespace TV\FindyourbandBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        $titlePage = 'Accueil';

        $listAdverts = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVFindyourbandBundle:Advert')
            ->getAdvertsHome()
        ;
        
        $listBands = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVUserBundle:Band')
            ->getBandsHome()
        ;
        
        $listUsers = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVUserBundle:User')
            ->getUsersHome()
        ;
        
        return $this->render('TVFindyourbandBundle:Pages:index.html.twig', array(
            'listAdverts' => $listAdverts,
            'listBands' => $listBands,
            'listUsers' => $listUsers,
            'titlePage' => $titlePage,
        ));
    }
}
