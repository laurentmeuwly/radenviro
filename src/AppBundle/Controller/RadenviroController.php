<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;




class RadenviroController extends Controller
{
	
	
	/**
	 * @Route("/", name="radenviro")
	 */
	public function indexAction($_locale=NULL, Request $request)
	{
		if($_locale==NULL) {
			$currentLocale = strtolower(str_split($_SERVER['HTTP_ACCEPT_LANGUAGE'], 2)[0]);
		} else {
			$currentLocale = $_locale;
		}
	
		return $this->redirectToRoute('static', ['page'=>'news', '_locale' => $currentLocale]);
	}
	
	/**
	 * @Route("/s/{page}", name="static")
	 * 
	 */
	public function wpPageAction($page, Request $request)
	{
		// Getting doctrine manager
		$em = $this->getDoctrine()->getManager();
		 
		// retrieve the page to display
		$wpURL = $em->getRepository('AppBundle:Page')->findOneBy(array('code' => $page));
	
		if($wpURL==NULL) {
			return $this->redirectToRoute('homepage');
		}
		
		return $this->render('iframe.html.twig', array(
				'page' => $wpURL,
		));
	}
	
	
	
	
}