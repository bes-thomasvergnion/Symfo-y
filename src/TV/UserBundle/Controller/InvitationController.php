<?php

namespace TV\UserBundle\Controller;

use TV\UserBundle\Entity\Invitation;
use TV\UserBundle\Entity\User;
use TV\UserBundle\Entity\Band;
use TV\UserBundle\Form\InvitationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class InvitationController extends Controller
{
    
    public function indexAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        return $this->render('TVUserBundle:Invitation:index.html.twig', array(
            'user' => $user,
        ));
    }
    
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function addAction(Request $request, User $receiver)
    {
        $invitation = new Invitation();
        
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $invitation->setSender($user);
        $invitation->setReceiver($receiver);       
        
        $form = $this->get('form.factory')->create(InvitationType::class, $invitation, array('user' => $user,));

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($invitation);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Groupes ajouté.');

            return $this->redirectToRoute('tv_findyourband_homepage');
        }

        return $this->render('TVUserBundle:Invitation:add.html.twig', array(
            'form'   => $form->createView(),
            'invitation' => $invitation,
        ));
    }
    
    public function acceptAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $invitation = $em->getRepository('TVUserBundle:Invitation')->find($id);
        
        $bandsender = $invitation->getBand();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        
        $bandsender->addUser($user);
        $em->persist($bandsender);
        $em->flush();
        
        return $this->redirectToRoute('tv_invitation_delete', array('id' => $id));
    }
    
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $invitation = $em->getRepository('TVUserBundle:Invitation')->find($id);
        $em->remove($invitation);
        $em->flush();
        return $this->redirectToRoute('tv_invitation_index');
    }
}