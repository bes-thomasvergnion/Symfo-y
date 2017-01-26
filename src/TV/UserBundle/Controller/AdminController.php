<?php

namespace TV\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AdminController extends Controller
{
    public function indexAction()
    {
        $titlePage = 'Tableau de bord';

        $listAdverts = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVFindyourbandBundle:Advert')
            ->getAdvertsAdmin()
        ;
        
        $listBands = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVUserBundle:Band')
            ->getBandsAdmin()
        ;
        
        $listUsers = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVUserBundle:User')
            ->getUsersAdmin()
        ;
        
        return $this->render('TVUserBundle:Admin:index.html.twig', array(
            'listAdverts' => $listAdverts,
            'listBands' => $listBands,
            'listUsers' => $listUsers,
            'page' => $page,
        ));
    }
    
    public function advertsAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
        
        $nbPerPage = 20;

        $listAdverts = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVFindyourbandBundle:Advert')
            ->getAdverts($page, $nbPerPage)
        ;
        
        $nbPages = ceil(count($listAdverts)/$nbPerPage);

        return $this->render('TVUserBundle:Admin:adverts.html.twig', array(
            'listAdverts' => $listAdverts,
            'nbPages' => $nbPages,
            'page' => $page,
        ));
    }
    
    public function usersAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
        
        $nbPerPage = 20;
        
        $listUsers = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVUserBundle:User')
            ->getUsers($page, $nbPerPage)
        ;
        
        $nbPages = ceil(count($listUsers)/$nbPerPage);
        
        return $this->render('TVUserBundle:Admin:users.html.twig', array(
            'listUsers' => $listUsers,
            'nbPages' => $nbPages,
            'page' => $page,
        ));
    }
    
    public function bandsAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        $nbPerPage = 20;
        
        $listBands = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVUserBundle:Band')
            ->getBands($page, $nbPerPage)
        ;
        
        $nbPages = ceil(count($listBands)/$nbPerPage);
        
        return $this->render('TVUserBundle:Admin:bands.html.twig', array(
            'listBands' => $listBands,
            'nbPages' => $nbPages,
            'page' => $page,
        ));
    }
}