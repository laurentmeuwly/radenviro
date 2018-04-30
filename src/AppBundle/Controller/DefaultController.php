<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Validator\Constraints\DateTime;

use APY\DataGridBundle\Grid\Source\Entity;

use AppBundle\Datatables\MeasurementDatatable;
use AppBundle\Datatables\LastResultDatatable;

use AppBundle\Datatables\ResultDatatable;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {	
    	return $this->render('radenviro.html.twig', [
    			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
    	]);
    }
    
    /**
     * appel principal du contrôleur
     * @Route("/mainmap", name="mainmap")
     */
    public function mainmapAction(Request $request)
    {
    	$isAjax = $request->isXmlHttpRequest();
    	
    	$datatable = null;
    	
    		/** @var DatatableInterface $datatable */
    		$datatable = $this->get('sg_datatables.factory')->create(LastResultDatatable::class);
    		$datatable->buildDatatable();
    			
    		if ($isAjax) {
    			$responseService = $this->get('sg_datatables.response');
    			$responseService->setDatatable($datatable);
    			$datatableQueryBuilder = $responseService->getDatatableQueryBuilder();
    				
    			return $responseService->getResponse();
    		}
    	
    	
    	return $this->render('AppBundle::mainmap.html.twig', array(
    			'datatable' => $datatable
    	));
    	
    }
    
    
    /**
     * @Route("/map", name="map")
     */
    public function mapAction(Request $request)
    {    	
    	$isAjax = $request->isXmlHttpRequest();
    	
    	// Getting doctrine manager
    	$em = $this->getDoctrine()->getManager();
    	
    	// retrieve all active legends
    	$legends = $em->getRepository('AppBundle:Legend')->findBy(array('active' => 1), array('position' => 'ASC'));
    	//dump($legends);
    	//die();
    	// retrieve all active site types
    	$siteTypes = $em->getRepository('AppBundle:SiteType')->findBy(array('active' => 1), array('position' => 'ASC'));
    	
    	// retrieve all active automatic networks
    	$automaticNetworks = $em->getRepository('AppBundle:AutomaticNetwork')->findBy(array('active' => 1), array('position' => 'ASC'));
    	
    	// retrieve all zoom areas
    	$zooms = $em->getRepository('AppBundle:MapZoom')->findAll();
    	/*var_dump($zooms);
    	die();*/
    	
    	
    	
    	/*$datatable = null;
    	
    		
    		$datatable = $this->get('sg_datatables.factory')->create(MeasurementDatatable::class);
    		$datatable->buildDatatable();
    			
    		if ($isAjax) {
    			$responseService = $this->get('sg_datatables.response');
    			$responseService->setDatatable($datatable);
    			$datatableQueryBuilder = $responseService->getDatatableQueryBuilder();
    			$datatableQueryBuilder->buildQuery();
    	
    			
    					
    			$qb = $datatableQueryBuilder->getQb();
    			$qb->andWhere('network.id = :network');
    			$qb->setParameter('network', '10');
    			
    			return $responseService->getResponse();
    		}*/
    	
    	
    	$datatable=NULL;
    	$datatable = $this->get('sg_datatables.factory')->create(LastResultDatatable::class);
    	$datatable->buildDatatable();
    	
    	if ($isAjax) {
    		$responseService = $this->get('sg_datatables.response');
    		$responseService->setDatatable($datatable);
    		$datatableQueryBuilder = $responseService->getDatatableQueryBuilder();
    		$datatableQueryBuilder->buildQuery();
    		
    		$qb = $datatableQueryBuilder->getQb();
    		$qb->andWhere($qb->expr()->gte('measurement.referencedate', ':date_min'));
    		$qb->setParameter('date_min', '2018-01-01');
    			
    		return $responseService->getResponse();
    	}
    	
    	
    	return $this->render('main_map.html.twig', array(
    			'legends' => $legends,
    			'siteTypes' => $siteTypes,
    			'automaticNetworks' => $automaticNetworks,
    			'zooms' => $zooms,
    			'datatable' => $datatable,
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
    
    
    /**
     * @Route("/measures/{id}", name="measures")
     */
    public function measuresAction($id, Request $request)
    {
    	// Getting doctrine manager
    	$em = $this->getDoctrine()->getManager();
    	$station = $em->getRepository('AppBundle:Station')->findOneById(array('id'=>$id));
    	$nuclide = $em->getRepository('AppBundle:Nuclide')->findOneById(array('id'=>21));
    	//$results = $em->getRepository('AppBundle:Measurement')->getAllByStationAndNuclide($station, $nuclide);
    	
    	// initiate the datatable result
    	$this->datatableResult();
    	
    	return $this->render('measures/measures_history.html.twig', array(
    			'station' => $station,
    			'nuclide' => $nuclide,
    	));
    	
    }
    
    /*
     OLD VERSION 
     * @Route("/measures/{id}", name="measures")
     
    public function measuresAction($id, Request $request)
    {
    	$isAjax = $request->isXmlHttpRequest();
    	
    	// Getting doctrine manager
    	$em = $this->getDoctrine()->getManager();
    	$station = $em->getRepository('AppBundle:Station')->findOneById(array('id'=>$id));
    	$nuclide = $em->getRepository('AppBundle:Nuclide')->findOneById(array('id'=>21));
    	//$results = $em->getRepository('AppBundle:Measurement')->getAllByStationAndNuclide($station, $nuclide);
    	
    	$datatable = $this->get('sg_datatables.factory')->create(ResultDatatable::class);
    	$datatable->buildDatatable();
    	
    	if ($isAjax) {
    		$station2 = $em->getRepository('AppBundle:Station')->findOneById(array('id'=>7));
    		$meas = $em->getRepository('AppBundle:Mesurement')->findOneById(array('id'=>20158));
    		$responseService = $this->get('sg_datatables.response');
    		$responseService->setDatatable($datatable);
    		$datatableQueryBuilder = $responseService->getDatatableQueryBuilder();
    		$datatableQueryBuilder->buildQuery();
    	
    		//if($session->get('network')>0) {
    		
    			$qb = $datatableQueryBuilder->getQb();
    			$qb->andWhere('measurement = :station');
    			//$qb->andWhere('nuclide = :nuclide');
    			$qb->setParameter('station', $meas);
    			//$qb->setParameter('nuclide', 21);
    		
    		//}
    		return $responseService->getResponse();
    	}
    	 
    	$this->datatable2();
    	
    	return $this->render('measures/measures_history.html.twig', array(
    			'station' => $station,
    			'nuclide' => $nuclide,
    			'datatable' => $datatable
    	));
    	
    }
    */
     
    
    /**
     * @Route("/measures/data/{type}/{id}.datas", name="measuresData")
     */
    public function measuresDataAction($type, $id, Request $request)
    {
    	$nuclide = $request->query->get('nuclide');
    	$station = $id;
    	
    	// Getting doctrine manager
    	$em = $this->getDoctrine()->getManager();
    	
    	$station = $em->getRepository('AppBundle:Station')->findOneById(array('id'=>$id));
    	
    	$results = $station->resultsByNuclide(array('nuclide'=>$nuclide));
    	/*echo $nuclide;
    	echo $station;
    	echo $type;
    	
    	dump($request);
    	die();*/
    	//return new JsonResponse($data);
    	return $this->render('measures/datas/graph.html.twig', array(
    			'results' => $result
    	));
    }
    
    /**
     * @Route("/data/{type}/{id}", defaults={"id" = 0}, name="data")
     */
    public function dataAction($type, Request $request)
    {
    	$legends = array();
    	$data = array();
    	
    	$id = $request->attributes->get('id');
    	    	
    	$legends = $request->query->get('legends');
    	
    	// Getting doctrine manager
    	$em = $this->getDoctrine()->getManager();
    	 

    	if($type=='nuclide') {
    		$results = $em->getRepository('AppBundle:Legend')->getNuclideByLegends(array('legends'=>$legends));
    		$i=0;
    		foreach($results as $result) {
    			$data[$i]['value'] = $result->getNuclide()->getId();
    			$data[$i]['label'] = $result->getNuclide()->getName();
    			$i++;
    		}
    	}
    	if($type=='tab') {
    		$data = [
    				'0' => [
    						'value' => 12,
    						'label' => 'test',
    				],
    				'1' => [
    						'value' => 24,
    						'label' => 'autre',
    				],
    				'2' => [
    						'value' => 56,
    						'label' => 'blala',
    				],
    		];
    	}
    	return new JsonResponse($data);
    }
    
    /**
     * @return GridBuilder
     */
    public function createGridBuilder(Source $source = null, array $options = [])
    {
    	return $this->container->get('apy_grid.factory')->createBuilder('grid', $source, $options);
    }
    
    /**
     * @Route("/grid", name="grid")
     */
    public function gridAction()
    { 	
    	// Creates a simple grid based on your entity
    	$source = new Entity('AppBundle:Sample');
    
    	// Get a Grid instance
    	$grid = $this->get('grid');
    
    	// Attach the source to the grid
    	$grid->setSource($source);
    	//$MyBlankColumn = new BlankColumn(array('id' => 'myBlankColumn', 'title' => 'LMY', 'size' => '54'));
    	 
    	
    	// configuration of the grid
    	$grid->setId('sample');
    	$grid->setMaxResults(500);
    	//$grid->setPersistence(true); // globally set in config.yml
    	$grid->setLimits(array(20, 50, 100));
    	//$grid->addColumn($MyBlankColumn, 2);
    	//$grid->addExport(new XMLExport('XML Export', 'export'));
    	
    	
    	$grid->isReadyForRedirect();
    
    	// Return the response of the grid to the template
    	return $grid->getGridResponse('::advanced.html.twig', array('grid' => $grid));

    	
    }
    
    /**
     * @Route("/last", name="last")
     */
    public function lastMeasureAction(Request $request)
    {
    	$session = $request->getSession();
    	$isAjax = $request->isXmlHttpRequest();
    	
    	// just for testing purpose
    	$session->set('nuclide', 21 );
    	$session->set('station', 7);  	
    	
    	
    	// attention 2 boucles imbriquées dans radenviro PROD
    	/*
    	  @last_results_by_nuclide = nil
  def last_results_by_nuclide(nuclide)
    unless nuclide.nil?
      @last_results_by_nuclide = {} if @last_results_by_nuclide.nil?
      key = nuclide.id
      unless @last_results_by_nuclide.has_key?(key)
        @last_results_by_nuclide[key] = []
        measurement = nil
        self.results.by_nuclides(nuclide).ordered_by_date_desc.each do |result|
          measurement = result.measurement_id if measurement.nil?
          if measurement == result.measurement_id
            @last_results_by_nuclide[key] << result
          else
            break
          end
        end
      end
      return @last_results_by_nuclide[key]
    end
    return []
  end
    	 */
          
          
          $datatable = null;
          if($session->get('nuclide')>0) {
          		
          	/** @var DatatableInterface $datatable */
          	$datatable = $this->get('sg_datatables.factory')->create(LastResultDatatable::class);
          	$datatable->buildDatatable();
          		
          	if ($isAjax) {
          		$responseService = $this->get('sg_datatables.response');
          		$responseService->setDatatable($datatable);
          		$datatableQueryBuilder = $responseService->getDatatableQueryBuilder();
          		$datatableQueryBuilder->buildQuery();
          				
          		$qb = $datatableQueryBuilder->getQb();
          		$qb->andWhere('nuclide = :nuclide');
          		$qb->setParameter('nuclide', $session->get('nuclide'));
          			
          		return $responseService->getResponse();
          	}
          }
          
          return $this->render('AppBundle:Measures:_last_measure.html.twig', array('datatable' => $datatable,));
    }
    
    
    
    
    /**
     * @Route("/lmy", name="lmy")
     */
    public function lmyAction(Request $request)
    {
    	// Creates the grid from the type
    	//$grid = $this->createGrid(new SampleListType());
    	
    	// Handles filters, sorts, exports, ...
    	//$grid->handleRequest($request);
    	//$grid->isReadyForRedirect();
    	//return $this->render('AppBundle:Lmy:lmy.html.twig', ['grid' => $grid]);
    	return $this->render('AppBundle:Lmy:lmy.html.twig');
    }
    
    /**
     * @return Grid
     */
    public function createGrid($type, Source $source = null, array $options = [])
    {
    	return $this->container->get('apy_grid.factory')->create($type, $source, $options);    	
    }
    
    
    
    
    
    /**
     * @Route("/graph", name="graph")
     */
    public function graphAction(Request $request)
    {
    	$dataNwg = array();
    	$dataVal = array();
    	$unit = '';
    	
    	$em = $this->getDoctrine()->getManager();
    	$station = $em->getRepository('AppBundle:Station')->findOneById(array('id'=> $request->get('station')));
    	$nuclide = $em->getRepository('AppBundle:Nuclide')->findOneById(array('id'=> $request->get('nuclide') ));
    	$results = $em->getRepository('AppBundle:Measurement')->getAllByStationAndNuclide($station, $nuclide);
    	
    	foreach($results as $result)
    	{
    		$unit = $em->getRepository('AppBundle:ResultUnit')->findOneById(array('id'=> $result['result_unit_id']))->getCode();
    		$date = \DateTime::createFromFormat('Y-m-d H:i:s', $result['referenceDate']);
    		$data[] = [ $date->getTimeStamp()*1000, (float)$result['value'], $result['limited'], (float)$result['error'], $unit ];
    		
    		if($result['limited']=='1') {
    			$dataNwg[] = [$date->getTimeStamp()*1000, (float)$result['value'], $result['limited'], (float)$result['error'], 
    				$unit ];
    		} else {
    			$dataVal[] = [$date->getTimeStamp()*1000, (float)$result['value'], $result['limited'], (float)$result['error'],
    					$unit ];
    		}
    	}
    	    	
    	$serie = [
    		'unit' => $unit,
    		'limit_low' => 0.00000025,
    		'limit_high'=> 0.00000060,
    		'data' => $data,
    			'data_nwg' => $dataNwg,
    			'data_val' => $dataVal,
    	];
    	 
    	 
    	return new JsonResponse($serie);
    }
    
    /**
     * @Route("/table", name="table")
     */
    public function tableAction(Request $request)
    {
    	$data = [
    	/* Dec 2017 */
    	[1512086400000,171.05],
    	[1512345600000,169.80],
    	[1512432000000,169.64],
    	[1512518400000,169.01],
    	[1512604800000,169.32],
    	[1512691200000,169.37],
    	[1512950400000,172.67],
    	[1513036800000,171.70],
    	[1513123200000,172.27],
    	[1513209600000,172.22],
    	[1513296000000,173.97],
    	[1513555200000,176.42],
    	[1513641600000,174.54],
    	[1513728000000,174.35],
    	[1513814400000,175.01],
    	[1513900800000,175.01],
    	[1514246400000,170.57],
    	[1514332800000,170.60],
    	[1514419200000,171.08],
    	[1514505600000,169.23],
    	/* Jan 2018 */
    	[1514851200000,172.26],
    	[1514937600000,172.23],
    	[1515024000000,173.03],
    	[1515110400000,175.00],
    	[1515369600000,174.35],
    	[1515456000000,174.33],
    	[1515542400000,174.29],
    	[1515628800000,175.28],
    	[1515715200000,177.09],
    	[1516060800000,176.19],
    	[1516147200000,179.10],
    	[1516233600000,179.26],
    	[1516320000000,178.46],
    	[1516579200000,177.00],
    	[1516665600000,177.04],
    	[1516752000000,174.22],
    	[1516838400000,171.11]
    	];
    	
    	
    	return new JsonResponse($data);
    }
    
    /**
     * Lists some result entities.
     *
     * @param Request $request
     *
     * @Route("/dtres", name="dtres")
     * @return Response
     */
    public function dtresAction(Request $request)
    {
    	$isAjax = $request->isXmlHttpRequest();
    
    	// Get your Datatable ...
    	//$datatable = $this->get('app.datatable.post');
    	//$datatable->buildDatatable();
    
    	// or use the DatatableFactory
    	/** @var DatatableInterface $datatable */
    	$datatable = $this->get('sg_datatables.factory')->create(LastResultDatatable::class);
    	$datatable->buildDatatable();
    
    	if ($isAjax) {
    		$responseService = $this->get('sg_datatables.response');
    		$responseService->setDatatable($datatable);
    		$responseService->getDatatableQueryBuilder();
    
    		return $responseService->getResponse();
    	}
    
    	return $this->render('::_tab.html.twig', array(
    			'datatable' => $datatable,
    	));
    }
    
    /**
     * Grid action
     * @Route("/tableresult", name="tableresult")
     * @return Response
     */
    public function datatableResultAction(Request $request)
    {
    	$nuclide = $request->get('nuclide');
    	$station = $request->get('station');

    	return $this->datatableResult($nuclide, $station)->execute();
    }
    
    /**
     * set datatable configs
     * @return \Waldo\DatatableBundle\Util\Datatable
     */
    private function datatableResult($nuclide=null, $station=null) {
    	
    	// TODO: no specific test here, but just return empty array
    	if($nuclide==null) {
    		$nuclide=21;
    	}
    	if($station==null) {
    		$station=7;
    	}
    	
    	// table heading
    	$date = $this->get('translator')->trans('table.refdate');
    	
    	$controller_instance = $this;
    	return $this->get('datatable')
    	->setDatatableId('dta-tst2')
    	->setGlobalSearch(false)
    	->setSearch(false)
    	->setNotSortableFields(array(0,1,2,3,4))
    	->setEntity("AppBundle:Result", "r")
    	->setOrder("m.referencedate", "desc")
    	->setFields(
	    			array(
	    					$this->get('translator')->trans('table.refdate')	=> 'm.referencedate',
	    					$this->get('translator')->trans('table.value')		=> 'r.displayValue',	// TODO: don't use this extra field. Here just as workaround to allow display some additional character
	    					$this->get('translator')->trans('table.error')		=> 'r.error',
	    					$this->get('translator')->trans('table.unit')		=> 'u.code',
	    					$this->get('translator')->trans('table.station')	=> 'st.code',
	    					"_identifier_"  => 'r.id'
	    			)
    			)
    			->setRenderer(
    					function(&$data) use ($controller_instance)
    					{
    						foreach ($data as $key => $value)
    						{
    							if ($key == 0) // m.referencedate
    							{
    								$data[$key] = $controller_instance
    								->get('templating')
    								->render(
    										'AppBundle:Renderers:_date.html.twig',
    										array('data' => $value)
    										);
    							}
    							
    							if ($key == 2) // r.error
    							{
    								if($value) {
    								$data[$key] = $controller_instance
    								->get('templating')
    								->render(
    										'AppBundle:Renderers:_scinumber.html.twig',
    										array('data' => $value)
    										);
    								}
    							}
    						}
    			}
    			)
    	->addJoin('r.measurement', 'm', \Doctrine\ORM\Query\Expr\Join::LEFT_JOIN)
    	->addJoin('m.resultUnit', 'u', \Doctrine\ORM\Query\Expr\Join::LEFT_JOIN)
    	->addJoin('m.sample', 's', \Doctrine\ORM\Query\Expr\Join::LEFT_JOIN)
    	->addJoin('s.station', 'st', \Doctrine\ORM\Query\Expr\Join::LEFT_JOIN)
    	->addJoin('r.nuclide', 'n', \Doctrine\ORM\Query\Expr\Join::LEFT_JOIN)
    	
    	->setWhere(                                                     // set your dql where statement
    			 'st.id = :station AND n.id = :nuclide',
    					array('station' => $station,'nuclide' => $nuclide)
    					)
    
    	//->setOrder("x.code", "desc")                               // it's also possible to set the default order
    	;
    }
    
    
    
}
