<?php

namespace TV\FindyourbandBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TV\FindyourbandBundle\Entity\Search;
use TV\FindyourbandBundle\Form\SearchType;
use TV\FindyourbandBundle\Form\SearchBandType;

class FilterController extends Controller
{
    public function indexAdvertAction()
    {
        $form = $this->get('form.factory')->create(SearchType::class, null, ['action'=>$this->generateUrl('tv_findyourband_filter_select_advert',[], \Symfony\Component\Routing\Router::ABSOLUTE_URL)]);

        return $this->render('TVFindyourbandBundle:Aside:filter.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function selectAdvertAction(Request $request, $page)
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $nbPerPage = 5;
       
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($search);
            $em->flush();
        }

        $listAdverts = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVFindyourbandBundle:Advert')
            ->getAdvertsWithFilters($search, $page, $nbPerPage)
        ;
        $nbPages = ceil(count($listAdverts)/$nbPerPage);
        
        return $this->render('TVFindyourbandBundle:Advert:list.html.twig', array(
            'listAdverts' => $listAdverts,
            'nbPerPage' => $nbPerPage,
            'nbPages' => $nbPages,
            'page' => $page,
            
        ));
    }
    
    public function indexUserAction()
    {
        $form = $this->get('form.factory')->create(SearchType::class, null, ['action'=>$this->generateUrl('tv_findyourband_filter_select_user',[], \Symfony\Component\Routing\Router::ABSOLUTE_URL)]);

        return $this->render('TVFindyourbandBundle:Aside:filter.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function selectUserAction(Request $request, $page)
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $nbPerPage = 10;
        $count = 0;
     
       
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($search);
            $em->flush();
        }

        $listUsers = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVUserBundle:User')
            ->getUsersWithFilters($search, $page, $nbPerPage)
        ;
        $nbPages = ceil(count($listUsers)/$nbPerPage);
        
        return $this->render('TVUserBundle:User:list.html.twig', array(
            'listUsers' => $listUsers,
            'count' => $count,
            'nbPerPage' => $nbPerPage,
            'nbPages' => $nbPages,
            'page' => $page,
        ));
    }
    
    public function indexBandAction()
    {
        $form = $this->get('form.factory')->create(SearchBandType::class, null, ['action'=>$this->generateUrl('tv_findyourband_filter_select_band',[], \Symfony\Component\Routing\Router::ABSOLUTE_URL)]);

        return $this->render('TVFindyourbandBundle:Aside:filter-band.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function selectBandAction(Request $request, $page)
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);    
        $count = 0;
        $nbPerPage = 20;
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($search);
            $em->flush();
        }

        $listBands = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVUserBundle:Band')
            ->getBandsWithFilters($search, $page, $nbPerPage)
        ;
        $nbPages = ceil(count($listBands)/$nbPerPage);
        
        return $this->render('TVUserBundle:Band:list.html.twig', array(
            'listBands' => $listBands,
            'count' => $count,
            'nbPerPage' => $nbPerPage,
            'nbPages' => $nbPages,
            'page' => $page,
        ));
    }
}
