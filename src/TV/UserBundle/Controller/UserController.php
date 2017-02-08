<?php

namespace TV\UserBundle\Controller;

use TV\UserBundle\Form\UserEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class UserController extends Controller
{
    public function indexAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
        
        $titlePage = 'Musiciens';
        $count = 0;
        $nbPerPage = 15;

        $listUsers = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVUserBundle:User')
            ->getActivedUsers($page, $nbPerPage)
        ;
        
        $nbPages = ceil(count($listUsers)/$nbPerPage);

        return $this->render('TVUserBundle:User:index.html.twig', array(
            'listUsers' => $listUsers,
            'nbPages' => $nbPages,
            'page' => $page,
            'titlePage' => $titlePage,
            'count' => $count,
        ));
    }
    
    
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        $user = $em->getRepository('TVUserBundle:User')->find($id);
        
        $actived = $user->isEnabled();
        $count = 0;
        $count2 = 0;
        
        $video = $user->getVideo();
        $video_preg = preg_replace('#watch\?v=#', "embed/", $video);

        if (null === $user) {
            throw new NotFoundHttpException("L'utilistaeur d'id ".$id." n'existe pas.");
        }
        
        if($actived === true || $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            return $this->render('TVUserBundle:User:view.html.twig', array(
                'currentUser' => $currentUser,
                'user' => $user,
                'count' => $count,
                'count2' => $count2,
                'video_preg' => $video_preg,
            ));
        }
        else{
            return $this->redirectToRoute('tv_findyourband_homepage');
        }
    }        
    
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        $user = $em->getRepository('TVUserBundle:User')->find($id);
        

        if (null === $user) {
            throw new NotFoundHttpException("L'utilisateur d'id ".$id." n'existe pas.");
        }
        
        if($currentUser == $user){
            $form = $this->get('form.factory')->create(UserEditType::class, $user);

            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                $image = $user->getImage();
                if(isset($image)){
                    $image->preUpload();
                }
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Utilisateur bien modifiée.');

                return $this->redirectToRoute('tv_user_view', array('id' => $user->getId()));
            }

            return $this->render('TVUserBundle:User:edit.html.twig', array(
              'user' => $user,
              'form'   => $form->createView(),
            ));
          }
      else{
          return $this->redirectToRoute('tv_user_view', array('id' => $user->getId()));
      }
    }
    
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('TVUserBundle:User')->find($id);

        if (null === $user) {
            throw new NotFoundHttpException("L'utilisateur d'id ".$id." n'existe pas.");
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "L'utilisateur a bien été supprimée.");

            return $this->redirectToRoute('tv_findyourband_homepage');
        }

        return $this->render('TVUserBundle:User:delete.html.twig', array(
            'user' => $user,
            'form'   => $form->createView(),
        ));
    }
       
    public function yourBandsAction($id)
    {
        $count = 0;
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('TVUserBundle:User')->find($id);

        return $this->render('TVUserBundle:User:yourbands.html.twig', array(
            'count' => $count,
            'user' => $user,
        ));
    }
    
    public function yourAdvertsAction($id)
    {
        $count = 0;
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('TVUserBundle:User')->find($id);
      
        return $this->render('TVUserBundle:User:youradverts.html.twig', array(
            'count' => $count,
            'user' => $user,
        ));
    }
    
    /**
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function bannishAction($id, Request $request) 
    {
        $em = $this->getDoctrine()->getManager(); 
        $user = $em->getRepository('TVUserBundle:User')->find($id);
        
        $hisadverts = $em->getRepository('TVFindyourbandBundle:Advert')->findByAuthor($user);
        
        $form = $this->get('form.factory')->create();
        
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            foreach($hisadverts as $hisadvert){
                $em->remove($hisadvert);
            }
            $user->setEnabled(false);
            $em->flush();
            
            return $this->redirectToRoute('tv_admin_users');
        }
        return $this->render('TVUserBundle:User:bannish.html.twig', array(
            'user' => $user,
            'form'   => $form->createView(),
        ));
    }
}
