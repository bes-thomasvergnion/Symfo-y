<?php

namespace TV\FindyourbandBundle\Controller;

use TV\FindyourbandBundle\Entity\Advert;
use TV\FindyourbandBundle\Form\AdvertType;
use TV\FindyourbandBundle\Form\AdvertEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AdvertController extends Controller
{
    public function indexAction($page)
    {        
        if ($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
        
        $titlePage = 'Annonces';
        $count = 0;     
        $nbPerPage = 5;

        $listAdverts = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVFindyourbandBundle:Advert')
            ->getAdverts($page, $nbPerPage)
        ;
        
        $nbPages = ceil(count($listAdverts)/$nbPerPage);
        
        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
        
        $listProvinces = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVFindyourbandBundle:Province')
            ->getProvinces()
        ;

        return $this->render('TVFindyourbandBundle:Advert:index.html.twig', array(
            'listAdverts' => $listAdverts,
            'listProvinces' => $listProvinces,
            'nbPages' => $nbPages,
            'page' => $page,
            'titlePage' => $titlePage,
            'count' => $count,
        ));
    }
    
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $advert = $em->getRepository('TVFindyourbandBundle:Advert')->find($id);

        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }

        return $this->render('TVFindyourbandBundle:Advert:view.html.twig', array(
            'advert' => $advert,
        ));
    }        
    
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function addAction(Request $request)
    {
        $advert = new Advert();
        
        $advert->setAuthor($this->container->get('security.token_storage')->getToken()->getUser());
        
        $form = $this->get('form.factory')->create(AdvertType::class, $advert);
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
               
            $em = $this->getDoctrine()->getManager();
            $em->persist($advert);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

            return $this->redirectToRoute('tv_findyourband_adverts_view', array('id' => $advert->getId()));
        }
        
        return $this->render('TVFindyourbandBundle:Advert:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $advert = $em->getRepository('TVFindyourbandBundle:Advert')->find($id);
        
        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }
        
        $user = $advert->getAuthor();
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();

        if($currentUser == $user || $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            $form = $this->get('form.factory')->create(AdvertEditType::class, $advert);

            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');
                return $this->redirectToRoute('tv_findyourband_adverts_view', array('id' => $advert->getId()));
            }

            return $this->render('TVFindyourbandBundle:Advert:edit.html.twig', array(
                'advert' => $advert,
                'form'   => $form->createView(),
            ));
        }
        else{
            return $this->redirectToRoute('tv_findyourband_adverts_view', array('id' => $advert->getId()));
        }
    }
    
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $advert = $em->getRepository('TVFindyourbandBundle:Advert')->find($id);

        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }

        $form = $this->get('form.factory')->create();
        
        $user = $advert->getAuthor();
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        
        if($currentUser == $user || $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){

            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                $em->remove($advert);
                $em->flush();

                $request->getSession()->getFlashBag()->add('info', "L'annonce a bien été supprimée.");

                return $this->redirectToRoute('tv_findyourband_homepage');
            }

            return $this->render('TVFindyourbandBundle:Advert:delete.html.twig', array(
                'advert' => $advert,
                'form'   => $form->createView(),
            ));
        }
        else{
            return $this->redirectToRoute('tv_findyourband_adverts_view', array('id' => $advert->getId()));
        }
    }
}
