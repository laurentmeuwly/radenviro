<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Datatables\MeasurementDatatable;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use APY\DataGridBundle\Grid\Source\Entity;
//use APY\DataGridBundle\Grid\Source\Vector;
use AppBundle\Entity\Sample;
use AppBundle\Entity\Station;
use AppBundle\Entity\Network;
use AppBundle\Entity\Nuclide;
use AppBundle\Form\AdvancedSearchType;
use AppBundle\Entity\PredefinedNuclideList;


class AdvancedController extends Controller
{    
	
	public function form1Action(Request $request)
	{
		
		
		$network = new Network();
	
		$form = $this->createForm(AdvancedSearchType::class, $network);
	
		$form->handleRequest($request);
	
		if ($form->isValid()) {
				
			return $this->render('default/radenviro.html.twig', [
					'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			]);
		}
	
		return $this->render('AppBundle:Advanced:advancedsearch.html.twig', array('form' => $form->createView()));
		
	}
	
	
	/**
	 * 
	 * 
	 * @return Response
	 */
	public function formZoneAction(Request $request) {
	
		//$request = $this->handleRequest($request);
		$em = $this->getDoctrine()->getManager();
	
		if($request->isXmlHttpRequest()) { // pour vérifier la présence d'une requete Ajax
	
			$id = '';
			$id = $request->get('id');
	
			if ($id != '') {
	
				$stations = $em->getRepository('AppBundle:Stations')->getStations($id);
				echo $stations;
	
				$tabStations = array();
				$i = 0;
	
				foreach($stations as $station) { // transformer la réponse à la requete en tableau qui replira le select pour stations
	
					$tabStations[$i]['id'] = $station->getId();
					$tabStations[$i]['nom'] = $station->getName();
					$i++;
				}
	
				$response = new Response();
	
				$data = json_encode($tabStations); // formater le résultat de la requête en json
	
				$response->headers->set('Content-Type', 'application/json');
				$response->setContent($data);
	
				return $response;
			}
	
		} else {
	
			return new Response('BIM ça plante');
		}
	}
	
	/**
	 * Lists all network.
	 * @Route("/netsearch", name="netsearch")
	 * @return Response
	 */
	public function ajouterTestAction() {
	
		$em = $this->getDoctrine()->getManager();
		$network = $em->getRepository('AppBundle:Network');
	
		$networks = new Network;
		$form=$this->createForm('AppBundle\Form\AdvancedSearchType');
		
		return $this->render('AppBundle:Advanced:form.html.twig', 
				array('form' => $form->createView(), 'network' => $networks ));
		
		
	}
	
	public function getStations($id)
	{
		$q = $this->_em->createQuery("SELECT e FROM AppBundle:Stations e JOIN AppBundle:Network p WITH e.network = :id");
		$q->setParameter('id',$id);
		return $q->getResult();
	}
	
	/**
	 * Lists all entities.
	 * @Route("/advlist", name="advlist")
	 * @return Response
	 */
	public function advlistAction()
	{
		$this->datatable2();                                                         // call the datatable config initializer
		return $this->render('AppBundle:Advanced:sample.html.twig');                 // replace "XXXMyBundle:Module:index.html.twig" by yours
	}

	
	/**
	 * appel principal du contrôleur
	 * @Route("/advanced", name="advanced")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function advancedAction(Request $request)
	{
		$session = $request->getSession();
		$isAjax = $request->isXmlHttpRequest();

		
		$network = new Network();
		$predefinedNuclideList = new PredefinedNuclideList();
		$nuclide = new Nuclide();
		$netId = 0;
		$form = $this->createForm(AdvancedSearchType::class);
		$form->handleRequest($request);
		
		// if call from main menu, we have neither Ajax query nor submitted form, so clean the session variable
		if(!$form->isSubmitted() && !$isAjax) {
			$session->remove('network');
			$session->remove('displayList');
			$session->remove('nuclide');
		}
		
		
		if ($form->isSubmitted() && $form->isValid()) {
			$data = $request->request->get('advanced_search');
			$session->set('network', $data['network']);
			$session->set('displayList', $data['displayList']);
			$session->set('nuclide', $data['nuclide']);
		}
		
		$datatable = null;
		if($session->get('network')>0) {
			/** @var DatatableInterface $datatable */
			$datatable = $this->get('sg_datatables.factory')->create(MeasurementDatatable::class);
			$datatable->buildDatatable();
			
			if ($isAjax) {
				$responseService = $this->get('sg_datatables.response');
				$responseService->setDatatable($datatable);
				$datatableQueryBuilder = $responseService->getDatatableQueryBuilder();
				$datatableQueryBuilder->buildQuery();
				
				if($session->get('network')>0) {
					
					$qb = $datatableQueryBuilder->getQb();
					$qb->andWhere('sample.network = :network');
					$qb->setParameter('network', $session->get('network'));
					
				}
			
				return $responseService->getResponse();
			}
		}
		
		return $this->render('AppBundle::myGrid.html.twig', array(
				'datatable' => $datatable,
				'form' => $form->createView(),
		));
	}
	
	/**
	 * Finds and displays a Sample entity.
	 *
	 * @param Sample $sample
	 *
	 * Route("/{id}", name = "toto", options = {"expose" = true})
	 *
	 * @return Response
	 */
	public function showAction(Sample $sample)
	{
		return $this->render('AppBundle::show.html.twig', array(
				'sample' => $sample
		));
	}
	
	
    /**
     * @Route("/adv", name="adv")
     */
     // * @Security("has_role('ROLE_AUTEUR') and has_role('ROLE_AUTRE')")
    public function advAction(Request $request)
    {   	
    	// temp data
    	$demo = array(
    			array(
    					'id' => 1,
    					'publisher_id' => 112,
    					'title' => 'book1',
    					'authors' => array('author1', 'author2'),
    					'publication' => '2012-04-06',
    					'createDate' => '2012-04-06 22:34:56',
    					'pages' => 320,
    					'multilanguage' => 1
    			),
    			array(
    					'id' => 2,
    					'publisher_id' => 105,
    					'title' => 'book2',
    					'authors' => array('author1', 'author3'),
    					'publication' => 'Apr. 6, 2012',
    					'createDate' => '2012-04-06 10:34:56PM',
    					'pages' => 480,
    					'multilanguage' => true
    			),
    	);
    	
    	$session = $request->getSession();
		$isAjax = $request->isXmlHttpRequest();

		
		$network = new Network();
		$form = $this->createForm(AdvancedSearchType::class, $network);
		$form->handleRequest($request);
		
		// if call from main menu, we have neither Ajax query nor submitted form, so clean the session variable
		if(!$form->isValid() && !$isAjax) {
			$session->remove('network');
		}
		
		
		if ($form->isValid()) {
			$data = $request->request->get('advanced_search');
			$session->set('network', $data['network']);
		}
		
		/*
    	$em = $this->getDoctrine()->getManager();
    	$networks = $em->getRepository('AppBundle:Network')->findBy(array());
    	//findAll() === findBy(array())
    	*/
		//$source = new Vector($demo);
		$source = new Entity('AppBundle:Sample');
		
		
		
		
		$grid = $this->get('grid');
		
		
		
		if ($isAjax) {
							
			if($session->get('network')>0) {
				$source->manipulateQuery(
						function($qb)
						{
							$qb->andWhere('network.id = :network');
							$qb->setParameter('network', $session->get('network'));
						}
				);
			}
		
			//return 'salut';//$responseService->getResponse();
		}
		
		$grid->setSource($source);
		$grid->isReadyForRedirect();
		
		
    	return $this->render('AppBundle::myGrid2.html.twig', array(
    			'network' => $session->get('network'),
    			'form' => $form->createView(),
    			'grid' => $grid,
    	));
    	
    	/*return $this->render('AppBundle::myGrid.html.twig', array(
    			'datatable' => $datatable,
    			'form' => $form->createView(),
    	));*/
    }
    
    public function rempliAction(Request $request)
    {
    	
    
    	if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
    	{
    		$id = $request->request->get('id');
    		$selecteur = $request->request->get('select');
    		 
    		if ($id != null)
    		{
    			$data = $this->getDoctrine()
    			->getManager()
    			->getRepository('AppBundle:'.$selecteur)
    			->$selecteur($id);
    			 
    			return new JsonResponse($data);
    		}
    	}
    	return new Response("Nonnn ....");
    }
    
    
    
    /**
     * Grid action
     * @Route("/tab", name="last_result")
     * @return Response
     */
    public function lastResAction(Request $request)
    {
    	return $this->dtLastResult($request->query->get('id'))->execute();
    }
    
    /**
     * Grid action
     * @Route("/dt", name="datatable")
     * @return Response
     */
    public function gridAction()
    {
    	return $this->datatable()->execute();                                      // call the "execute" method in your grid action
    }
    
    /**
     * Grid action
     * @Route("/dt2", name="datatable2")
     * @return Response
     */
    public function grid2Action()
    {
    	return $this->datatable2()->execute();                                      // call the "execute" method in your grid action
    }
    
    /**
     * Lists all entities.
     * @Route("/list/{id}", name="list")
     * @return Response
     */
    public function tab5Action(Request $request)
    {
    	// Getting doctrine manager
    	$em = $this->getDoctrine()->getManager();
    
    	// retrieve all active legends
    	//$legends = $em->getRepository('AppBundle:Legend')->findBy(array('hidden' => 0), array('sorting' => 'ASC'));
    
    	 //$request->query->get('id')
    	$this->dtLastResult($request->query->get('id'));                                                     
    	
    	return $this->render('tab_small.html.twig');
    }
    
    /**
     * Lists all entities.
     * @Route("/list2", name="datatable_list")
     * @return Response
     */
    public function indexAction(Request $request)
    {
    	// Getting doctrine manager
    	$em = $this->getDoctrine()->getManager();
    	 
    	// retrieve all active legends
    	$legends = $em->getRepository('AppBundle:Legend')->findBy(array('hidden' => 0), array('sorting' => 'ASC'));
    	 
    	// retrieve all active site types
    	$siteTypes = $em->getRepository('AppBundle:SiteType')->findBy(array('hidden' => 0), array('sorting' => 'ASC'));
    	 
    	// retrieve all active automatic networks
    	$automaticNetworks = $em->getRepository('AppBundle:AutomaticNetwork')->findBy(array('hidden' => 0), array('sorting' => 'ASC'));
    	
    	// retrieve all zoom areas
    	$zooms = $em->getRepository('AppBundle:MapZoom')->findAll();
    	//$zooms = $em->getRepository('AppBundle:MapZoom')->findBy(array('name' => 'CERN'));
    	
    	//$this->datatable();                                                         // call the datatable config initializer
    	//$this->datatable2();
    	$this->dtLastResult(2);
    	return $this->render('data_access.html.twig', array(
    			'legends' => $legends,
    			'siteTypes' => $siteTypes,
    			'automaticNetworks' => $automaticNetworks,
    			'zooms' => $zooms,
    	));
    }
    
    /**
     * @Route("/paginate", name="station_paginate")
     */
    public function paginateAction(Request $request)
    {
    	$length = $request->get('length');
    	$length = $length && ($length!=-1)?$length:0;
    
    	$start = $request->get('start');
    	$start = $length?($start && ($start!=-1)?$start:0)/$length:0;
    
    	$search = $request->get('search');
    	$filters = [
    			'query' => @$search['value']
    	];
    
    	$stations = $this->getDoctrine()->getRepository('AppBundle:Station')->search(
    			$filters, $start, $length
    			);
    		
    	$output = array(
    			'data' => array(),
    			'recordsFiltered' => count($this->getDoctrine()->getRepository('AppBundle:Station')->search($filters, 0, false)),
    			'recordsTotal' => count($this->getDoctrine()->getRepository('AppBundle:Station')->search(array(), 0, false))
    	);
    
    	foreach ($stations as $station) {
    		$output['data'][] = [
    				'id' => $station->getId(),
    				'code' => $station->getCode(),
    				'longitude' => $station->getLongitude(),
    		];
    	}
    
    	return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);
    }
    
    
    /**
     * set datatable configs
     * @return \Waldo\DatatableBundle\Util\Datatable
     */
    private function datatable() {
    	return $this->get('datatable')
    	->setGlobalSearch(false)
    	->setSearch(false)
    	->setDatatableId('dta-tst')
    	 ->setEntity("AppBundle:Canton", "x")                          // replace "XXXMyBundle:Entity" by your entity
    	->setFields(
    			array(
    					"Code"          => 'x.code',                        
    					"Name (DE)"         => 'x.nameDe',
    					"Name (FR)"         => 'x.nameFr',
    					//"Sub"           => '(SELECT i FROM ... ) as sub',   // you can set sub DQL request, you MUST ALWAYS define an alias
    					"_identifier_"  => 'x.id')                          // you have to put the identifier field without label. Do not replace the "_identifier_"
    			)
    			/*->setWhere(                                                     // set your dql where statement
    					'x.code like :code',
    					array('code' => 'V%')
    					)*/
    			//->setOrder("x.code", "desc")                               // it's also possible to set the default order
    			;
    }
    
    /**
     * set datatable configs
     * @return \Waldo\DatatableBundle\Util\Datatable
     */
    private function datatable2() {
    	return $this->get('datatable')
    	->setDatatableId('dta-tst2')
    	->setEntity("AppBundle:Station", "x")                          // replace "XXXMyBundle:Entity" by your entity
    	->setFields(
    			array(
    					"Code"          => 'x.code',                        // Declaration for fields:
    					//"Total"         => 'COUNT(x.id) as total',      // Use SQL commands, you must always define an alias
    					//"Sub"           => '(SELECT i FROM ... ) as sub',   // you can set sub DQL request, you MUST ALWAYS define an alias
    					"_identifier_"  => 'x.id')                          // you have to put the identifier field without label. Do not replace the "_identifier_"
    			)
    			/*->setWhere(                                                     // set your dql where statement
    			 'x.code like :code',
    					array('code' => 'V%')
    					)*/
    	//->setOrder("x.code", "desc")                               // it's also possible to set the default order
    	;
    }
    
    /**
     * set datatable configs
     * @return \Waldo\DatatableBundle\Util\Datatable
     */
    private function dtLastResult($id) {
    	$controller_instance = $this;
    	return $this->get('datatable')
    	->setGlobalSearch(false)
    	->setSearch(false)
    	->setDatatableId('dta-last_result')
    	->setEntity("AppBundle:Result", "x")                          
    	->setFields(
    			array(
    					"Date"          => 'm.referencedate', 
    					"Result"          => 'x.value',                        
    					"Uncertaintly"         => 'x.error',
    					"Unit"			=> 'u.code',
    					"Station"           => 'st.code',   
    					"_identifier_"  => 'x.id')                          
    			)
    	/*->setRenderers(
    			array(
    					0 => array(
    							'view' => 'AppBundle:Renderers:_date.html.twig', // Path to the template
    							'params' => array( 
    							),
    					),
    			)
    		)*/
    	->setRenderer(
    			function(&$data) use ($controller_instance) {
    				foreach ($data as $key => $value) {
    					
    					if ($key == 0) {            // 0 => date field
    						$val = json_encode($value);
    						$val2 = json_decode($val, true);
    						$data[$key] = $controller_instance
    						->get('templating')
    						->render(
    								'AppBundle:Renderers:_date.html.twig',
    								array('data' => $val2['date'])
    								);
    					}
    				}
    			}
    		)
    	->setWhere(                                                     // set your dql where statement
    			 'm.id = :id',
    					array('id' => '1')
    					)
    	//->addJoin('x.nuclide', 'n', \Doctrine\ORM\Query\Expr\Join::LEFT_JOIN)
    	->addJoin('x.measurement', 'm', \Doctrine\ORM\Query\Expr\Join::LEFT_JOIN)
    	->addJoin('m.sample', 's', \Doctrine\ORM\Query\Expr\Join::LEFT_JOIN)
    	->addJoin('s.station', 'st', \Doctrine\ORM\Query\Expr\Join::LEFT_JOIN)
    	->addJoin('m.resultUnit', 'u', \Doctrine\ORM\Query\Expr\Join::LEFT_JOIN)
    	//->setOrder("x.code", "desc")                               
    	;
    }
}
