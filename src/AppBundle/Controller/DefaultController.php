<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Source\Vector;
use APY\DataGridBundle\Grid\Column\BlankColumn;
use APY\DataGridBundle\Grid\Export\XmlExport;

use AppBundle\Grid\SampleListType;


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
     * @Route("/map", name="map")
     */
    public function mapAction(Request $request)
    {    	
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
    	
    	return $this->render('data_access.html.twig', array(
    			'legends' => $legends,
    			'siteTypes' => $siteTypes,
    			'automaticNetworks' => $automaticNetworks,
    			'zooms' => $zooms,
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
    	
    	$measure = $em->getRepository('AppBundle:Measurement')->getAllByStationAndNuclide($station, $nuclide);
    	// retrieve all active legends
    	//$legends = $em->getRepository('AppBundle:Legend')->findBy(array('hidden' => 0), array('sorting' => 'ASC'));
    	 
    	// retrieve all active site types
    	//$siteTypes = $em->getRepository('AppBundle:SiteType')->findBy(array('hidden' => 0), array('sorting' => 'ASC'));
    	 
    	// retrieve all active automatic networks
    	//$automaticNetworks = $em->getRepository('AppBundle:AutomaticNetwork')->findBy(array('hidden' => 0), array('sorting' => 'ASC'));
    	 
    	return $this->render('measures/index.html.twig', array(
    			'station' => $station, 'nuclide'=>$nuclide
    	));
    	/*
    	 return $this->render('default/radenviro.html.twig', [
    	 'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
    	 ]);*/
    	
    	// Creates the builder
    /*	$grid = $this->createGridBuilder(new Entity('AppBundle:Station'));
    	$grid
    	->add('id', 'numeric', ['primary' => 'true'])
    	->add('name', 'text')
    	->getGrid();
    	// Handles filters, sort, exports, action
    	$grid->handleRequest($request);
    	// Renders the grid
    	return $this->render('measures/index.html.twig', array('grid' => $grid));*/
    	
    }
    
    /**
     * @Route("/data/{type}/{id}", defaults={"id" = 0}, name="data")
     */
    public function dataAction($type, Request $request)
    {
    	$id = $request->attributes->get('id');
    	if($type=='nuclide') {
    	$data = [
    			'0' => [
    					'value' => 54,
    					'label' => 'Ruthénium 106',
    			],
    			'1' => [
    					'value' => 26,
    					'label' => 'Tritium',
    			],
    			'2' => [
    					'value' => 17,
    					'label' => 'Cobalt 60',
    			],
    			'3' => [
    					'value' => $id,
    					'label' => 'juste un test',
    			],
    			
    		];
    	}
    	if($type=='table') {
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
    
    
    public function lastMeasureAction()
    {
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
    	
          // corriger la requête
          
          $lastMeasure = $this->container->get('app.lastresult');
          if($lastMeasure->getLastResultByStation(1)=='Hello') {
          	throw new \Exception('Not a valid number!');
          }
          
          return $this->render('AppBundle:Measures:_last_measure.html.twig');
    }
    
    
    
    
    /**
     * @Route("/lmy", name="lmy")
     */
    public function lmyAction()
    {
    	// Creates the grid from the type
    	$grid = $this->createGrid(new SampleListType());
    	
    	// Handles filters, sorts, exports, ...
    	//$grid->handleRequest($request);
    	$grid->isReadyForRedirect();
    	return $this->render('AppBundle:Lmy:lmy.html.twig', ['grid' => $grid]);
    }
    
    /**
     * @return Grid
     */
    public function createGrid($type, Source $source = null, array $options = [])
    {
    	return $this->container->get('apy_grid.factory')->create($type, $source, $options);    	
    }
    
    
    
}
