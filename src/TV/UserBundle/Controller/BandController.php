<?php

namespace TV\UserBundle\Controller;

use TV\UserBundle\Entity\Band;
use TV\UserBundle\Form\BandType;
use TV\UserBundle\Form\BandEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class BandController extends Controller
{
    public function indexAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
        
        $titlePage = 'Groupes';
        $count = 0;
        $nbPerPage = 10;

        $listBands = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVUserBundle:Band')
            ->getBands($page, $nbPerPage)
        ;
        
        $nbPages = ceil(count($listBands)/$nbPerPage);

        return $this->render('TVUserBundle:Band:index.html.twig', array(
            'listBands' => $listBands,
            'nbPages' => $nbPages,
            'page' => $page,
            'titlePage' => $titlePage,
            'count' => $count,
        ));
    }
    
    
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
       
        $band = $em->getRepository('TVUserBundle:Band')->findFull($id);
        $video = $band->getVideo();
        $video_preg = preg_replace('#watch\?v=#', "embed/", $video);
       
        if (null === $band) {
          throw new NotFoundHttpException("L'utilistaeur d'id ".$id." n'existe pas.");
        }

        return $this->render('TVUserBundle:Band:view.html.twig', array(
            'band' => $band,
            'video_preg' => $video_preg,
        ));
    }
//    
//    /**
//    * @Security("has_role('ROLE_USER')")
//    */
    public function addAction(Request $request)
    {
        $band = new Band();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $user->addBand($band);       
        $band->setAdministrator($user);
        
        $form = $this->get('form.factory')->create(BandType::class, $band);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($band);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Groupes ajouté.');

            return $this->redirectToRoute('tv_band_view', array('id' => $band->getId()));
        }

        return $this->render('TVUserBundle:Band:add.html.twig', array(
          'form'   => $form->createView(),
        ));
    }
    
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $band = $em->getRepository('TVUserBundle:Band')->find($id);

        if (null === $band) {
            throw new NotFoundHttpException("L'utilisateur d'id ".$id." n'existe pas.");
        }
      
        $form = $this->get('form.factory')->create(BandEditType::class, $band);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            // Inutile de persister ici, Doctrine connait déjà notre annonce
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Groupe bien modifiée.');

            return $this->redirectToRoute('tv_band_view', array('id' => $band->getId()));
        }

        return $this->render('TVUserBundle:Band:edit.html.twig', array(
          'band' => $band,
          'form'   => $form->createView(),
        ));
    }
    
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $band = $em->getRepository('TVUserBundle:Band')->find($id);

        if (null === $band) {
          throw new NotFoundHttpException("Le groupe d'id ".$id." n'existe pas.");
        }

        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
          $em->remove($band);
          $em->flush();

          $request->getSession()->getFlashBag()->add('info', "Le groupe a bien été supprimée.");

          return $this->redirectToRoute('tv_findyourband_homepage');
        }

        return $this->render('TVUserBundle:Band:delete.html.twig', array(
          'band' => $band,
          'form'   => $form->createView(),
        ));
    }
}
