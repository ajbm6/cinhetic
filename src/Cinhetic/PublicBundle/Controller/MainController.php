<?php

namespace Cinhetic\PublicBundle\Controller;

use Doctrine\Common\Util\Debug;
use Cinhetic\PublicBundle\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;


class MainController extends Controller
{

    /**
     * Homepage Get Started
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction()
    {
        return $this->render('CinheticPublicBundle:Main:home.html.twig');
    }


    /**
     * Homepage Get Started
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function oneAction()
    {
        return $this->render('CinheticPublicBundle:Apprentissage:01.html.twig');
    }


    /**
     * Apprentissage Get Started
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function apprentissageAction()
    {
        return $this->render('CinheticPublicBundle:Apprentissage:apprentissage.html.twig');
    }


    /**
     * Main Dashboard Homepage
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $paybox = $this->get('lexik_paybox.request_handler');
        $paybox->setParameters(array(
            'PBX_CMD'          => 'CMD'.time(),
            'PBX_DEVISE'       => '978',
            'PBX_PORTEUR'      => 'test@paybox.com',
            'PBX_RETOUR'       => 'Mt:M;Ref:R;Auto:A;Erreur:E',
            'PBX_TOTAL'        => '1000',
            'PBX_TYPEPAIEMENT' => 'CARTE',
            'PBX_TYPECARTE'    => 'CB',
            'PBX_EFFECTUE'     => $this->generateUrl('lexik_paybox_return', array('status' => 'success'), true),
            'PBX_REFUSE'       => $this->generateUrl('lexik_paybox_return', array('status' => 'denied'), true),
            'PBX_ANNULE'       => $this->generateUrl('lexik_paybox_return', array('status' => 'canceled'), true),
            'PBX_RUF1'         => 'POST',
            'PBX_REPONDRE_A'   => $this->generateUrl('lexik_paybox_ipn', array('time' => time()), true),
        ));


        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator'); //je mets en place la pagination

        $movies = $em->getRepository('CinheticPublicBundle:Movies')->getAllMovies();
        $cities = $em->getRepository('CinheticPublicBundle:Cinema')->getCitiesOfMovies();
        $seances = $em->getRepository('CinheticPublicBundle:Sessions')->getNextSessions();
        $categories = $em->getRepository('CinheticPublicBundle:Categories')->findAll();
        $tags = $em->getRepository('CinheticPublicBundle:Tags')->findAll();

        $pagination = $paginator->paginate(
            $movies,
            $this->get('request')->query->get('page', 1) /*page number*/,
            5
        );


        return $this->render('CinheticPublicBundle:Main:index.html.twig',  array(
            'movies' => $pagination,
            'cities' => $cities,
            'seances' => $seances,
            'categories' => $categories,
            'tags' => $tags,
            'url'  => $paybox->getUrl(),
            'form' => $paybox->getForm()->createView()
        ));
    }

    /**
     * Sample action of a confirmation payment page on witch the user is sent
     * after he seizes his payment informations on the Paybox's platform.
     * This action must only containts presentation logic.
     */
    public function buildPayboxAction()
    {
        $status = $this->get('request')->query->get('status');
        return $this->render(
            'CinheticPublicBundle:Main:return.html.twig',
            array(
                'status'     => $status,
            )
        );
    }

    /**
     * Sample action of a confirmation payment page on witch the user is sent
     * after he seizes his payment informations on the Paybox's platform.
     * This action must only containts presentation logic.
     */
    public function responsePayboxAction()
    {

        //messages flash se jouant qu'une seule fois
        $this->get('session')->getFlashBag()->add(
            'success',
            'Votre commande de votre film a bien été prise en compte'
        );

        //redirections
        return $this->redirect($this->generateUrl('Cinhetic_public_homepage'));
    }

    /**
     * Sample action of a confirmation payment page on witch the user is sent
     * after he seizes his payment informations on the Paybox's platform.
     * This action must only containts presentation logic.
     */
    public function returnPayboxPayboxAction($time)
    {
        return $this->render(
            'CinheticPublicBundle:Main:time.html.twig',
            array(
                'time'     => $time,
            )
        );
    }

    /**
     * Search Action
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction($word = null)
    {
        $form = $this->createForm(new SearchType(), null, array(
            'action' => $this->generateUrl('Cinhetic_public_search'),
            'method' => 'POST',
        ));

        return $this->render('CinheticPublicBundle:Slots:search.html.twig',
            array('form' => $form->createView(), 'word' => $word)
        );
    }



    /**
     * Login Authentification
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        return $this->render('CinheticPublicBundle:Main:login.html.twig', array(
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }

}
