<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {	
    	return $this->render('default/radenviro.html.twig', [
    			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
    	]);
    }
    
    /**
     * @Route("/advanced", name="advanced")
     * @Security("has_role('ROLE_AUTEUR') and has_role('ROLE_AUTRE')")
     */
    public function advancedAction(Request $request)
    {   	
    	return $this->render('default/radenviro.html.twig', [
    			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
    	]);
    }
    
    /**
     * @Route("/map", name="map")
     */
    public function mapAction(Request $request)
    {    	
    	// Getting doctrine manager
    	$em = $this->getDoctrine()->getManager();
    	
    	// retrieve all active legends
    	$legends = $em->getRepository('AppBundle:Legend')->findBy(array('hidden' => 0), array('sorting' => 'ASC'));
    	
    	// retrieve all active site types
    	$siteTypes = $em->getRepository('AppBundle:SiteType')->findBy(array('hidden' => 0), array('sorting' => 'ASC'));
    	
    	// retrieve all active automatic networks
    	$automaticNetworks = $em->getRepository('AppBundle:AutomaticNetwork')->findBy(array('hidden' => 0), array('sorting' => 'ASC'));
    	
    	return $this->render('data_access.html.twig', array(
    			'legends' => $legends,
    			'siteTypes' => $siteTypes,
    			'automaticNetworks' => $automaticNetworks,
    	));
    	/*
    	return $this->render('default/radenviro.html.twig', [
    			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
    	]);*/
    }
    
    /**
     * @Route("/news", name="news")
     */
    public function newsAction(Request $request)
    {
    	// Getting doctrine manager
    	$em = $this->getDoctrine()->getManager();
    	
    	// retrieve the page to display
    	$page = $em->getRepository('AppBundle:Page')->findOneBy(array('code' => 'news'));

    	return $this->render('iframe.html.twig', array(
    			'page' => $page,
    	));
    }
    
    /**
     * @Route("/radair", name="radair")
     */
    public function radairAction(Request $request)
    {
    	// Getting doctrine manager
    	$em = $this->getDoctrine()->getManager();
    	 
    	// retrieve the page to display
    	$page = $em->getRepository('AppBundle:Page')->findOneBy(array('code' => 'radair'));

    	return $this->render('iframe.html.twig', array(
    			'page' => $page,
    	));
    }
    
    /**
     * @Route("/information", name="information")
     */
    public function informationAction(Request $request)
    {
    	// Getting doctrine manager
    	$em = $this->getDoctrine()->getManager();
    	 
    	// retrieve the page to display
    	$page = $em->getRepository('AppBundle:Page')->findOneBy(array('code' => 'informations'));
    	
    	return $this->render('iframe.html.twig', array(
    			'page' => $page,
    	));
    }
    
    /**
     * @Route("/convert", name="convert")
     */
    public function convertTranslation(Request $request)
    {
    	// Getting doctrine manager
    	$em = $this->getDoctrine()->getManager();
    	// retrieve all stations
    	$items = $em->getRepository('AppBundle:Country')->findAll();
    	
    	
    	foreach($items as $item)
    	{		
    		$item->translate('fr')->setName($item->getNameFr());
    		$item->translate('de')->setName($item->getNameDe());
    		$item->translate('it')->setName($item->getNameIt());
    		$item->translate('en')->setName($item->getNameEn());
    		
    		/*$item->translate('fr')->setDescription($item->getDescriptionFr());
    		$item->translate('de')->setDescription($item->getDescriptionDe());
    		$item->translate('it')->setDescription($item->getDescriptionIt());
    		$item->translate('en')->setDescription($item->getDescriptionEn());*/
    		
    			
    		$item->mergeNewTranslations();
    			
    		$em->flush();
    		
    	}
    	
    	return $this->render('base.html.twig');
    }
}
