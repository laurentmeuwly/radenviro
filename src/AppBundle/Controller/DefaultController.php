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


use Omines\DataTablesBundle\Adapter\ArrayAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\DateTimeColumn;
use Omines\DataTablesBundle\Controller\DataTablesTrait;
use Omines\DataTablesBundle\DataTableState;





class DefaultController extends Controller
{
	use DataTablesTrait;
    
    /**
     * @Route("/tabmap/{nuclide}", defaults={"nuclide"=21}, name="tabmap")
     */
    public function tabmapAction($nuclide=21, Request $request)
    {
    	
    	
    	// build the table for last measure per station
    	$rawsql = $this->getDtRequest($nuclide);
    	$statement1 = $this->getDoctrine()->getManager()->getConnection()->prepare($rawsql);
    	$statement1->execute();
    	$resultdb = $statement1->fetchAll();
    	
    	$table = $this->createDataTable()
    	->add('referenceDate', DateTimeColumn::class, ['format' => 'd-m-Y', 'label' => 'table.refdate', 'className' => 'bold'])
    	->add('limited', TextColumn::class, ['label' => 'table.limited', 'visible' => false])
    	->add('value', TextColumn::class, ['label' => 'table.value', 'raw' => true, 'render' => function($value, $context) {
    		if($context['limited']==0) {
    			return sprintf('%.1e', $context['value']);
    		} else {
    			return sprintf('&lt; %.1e', $context['value']);
    		}
    	
    	}])
    	->add('error', TextColumn::class, ['label' => 'table.error', 'render' => function($value, $context) {
    		if($context['error']=='') return '';
    		else return sprintf('%.1e', $context['error']);
    	}])
    	->add('unit', TextColumn::class, ['label' => 'table.unit'])
    	->add('nuclide', TextColumn::class, ['label' => 'table.nuclide'])
    	->add('station', TextColumn::class, ['label' => 'table.station'])
    	->createAdapter(ArrayAdapter::class, $resultdb)
    	->handleRequest($request);
    	
    	
    	if ($table->isCallback()) {
    		return $table->getResponse();
    	}
    	
    	return $this->render('_tabtemp.html.twig', array(
    		'datatable' => $table,
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
    	
    	//return new JsonResponse($data);
    	return $this->render('measures/datas/graph.html.twig', array(
    			'results' => $result
    	));
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
    	date_default_timezone_set("UTC");  // this is not the right place to keep...
    	
    	$dataNwg = array();
		$dataVal = array();
		$unit = '';
		$message = '';
    	$limit_low = 0;
    	$limit_high = 0;
    	$show_fluctuation = false;
    	
    	$em = $this->getDoctrine()->getManager();
    	$station = $em->getRepository('AppBundle:Station')->findOneById(array('id'=> $request->get('station')));
    	$nuclide = $em->getRepository('AppBundle:Nuclide')->findOneById(array('id'=> $request->get('nuclide') ));
		$results = $em->getRepository('AppBundle:Measurement')->getAllByStationAndNuclide($station, $nuclide);
		
		$resultsCommentsStation = $em->getRepository('AppBundle:ResultComment')->findBy(['station'=>$station, 'active'=>true]);
		$resultsCommentsNetwork = $em->getRepository('AppBundle:ResultComment')->findBy(['station'=>null, 'network'=>$station->getNetwork(), 'active'=>true]);
		
    	$fluctuations = $em->getRepository('AppBundle:IsotopeStationFluctuation')->findOneBy([
    	    'station'=>$request->get('station'),
    	    'nuclide'=>$request->get('nuclide')
    	]);
    	
    	if($fluctuations) {
    	    if($fluctuations->getActive()) {
    	        $show_fluctuation = true;
    	        $limit_low = $fluctuations->getFluctuationMin();
    	        $limit_high = $fluctuations->getFluctuationMax();
    	    }
    	}
		
    	foreach($results as $result)
    	{
			$message = '';
    		$unit = $em->getRepository('AppBundle:ResultUnit')->findOneById(array('id'=> $result['result_unit_id']))->getCode();
    		$date = \DateTime::createFromFormat('Y-m-d H:i:s', $result['referenceDate']);
    		$data[] = [ $date->getTimeStamp()*1000, (float)$result['value'], $result['limited'], (float)$result['error'], $unit ];
			
			// check if a message has to be displayed with the result
			foreach($resultsCommentsNetwork as $resultsComments) {
				if( $date >= $resultsComments->getDateFrom() && $date <= $resultsComments->getDateTo()) {
					$message .=  html_entity_decode($resultsComments->getComment());
					$message .= '<br/>';
				}
			}
			// check if a message has to be displayed with the result
			foreach($resultsCommentsStation as $resultsComments) {
				if( $date >= $resultsComments->getDateFrom() && $date <= $resultsComments->getDateTo()) {
					$message .=  html_entity_decode($resultsComments->getComment());
					$message .= '<br/>';
				}
			}
			
    		if($result['limited']=='1') {
    			$dataNwg[] = [$date->getTimeStamp()*1000, (float)$result['value'], $result['limited'], (float)$result['error'], 
					$unit, $message ];
    		} else {
    			$dataVal[] = [$date->getTimeStamp()*1000, (float)$result['value'], $result['limited'], (float)$result['error'],
						$unit, $message ];
    		}
    	}
    	    	
    	$serie = [
    		'unit' => $unit,
    	    'limit_low' => $limit_low,
    	    'limit_high'=> $limit_high,
    	    'show_fluctuation'=>$show_fluctuation,
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
    	->setNotSortableFields(array(0,1,2,3,4,5))
    	->setHiddenFields(array(1))
    	->setEntity("AppBundle:Result", "r")
    	->setOrder("m.referencedate", "desc")
    	->setFields(
	    			array(
	    					$this->get('translator')->trans('table.refdate')	=> 'm.referencedate',
	    					$this->get('translator')->trans('table.limited')	=> 'r.limited',
	    					$this->get('translator')->trans('table.value')		=> 'r.value',	
	    					$this->get('translator')->trans('table.error')		=> 'r.error',
	    					$this->get('translator')->trans('table.unit')		=> 'u.code',
	    					$this->get('translator')->trans('table.station')	=> 'st.code',
	    					"_identifier_"  => 'r.id'
	    			)
    			)
    			->setRenderer(
    					function(&$data) use ($controller_instance)
    					{
    						$nwg = false;
    						$renderer = 'AppBundle:Renderers:_scinumber.html.twig';
    			
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
    								
    							if ($key == 1) // r.limited
    							{
    								if($value) {
    									$renderer = 'AppBundle:Renderers:_nwg.html.twig';
    								} else {
    									$renderer = 'AppBundle:Renderers:_scinumber.html.twig';
    								}
    							}
    								
    							if ($key == 2) // r.value
    							{
    			
    								if($value) {
    									$data[$key] = $controller_instance
    									->get('templating')
    									->render(
    											$renderer,
    											array('data' => $value)
    											);
    								}
    							}
    								
    							if ($key == 3) // r.error
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
    
    
    /**
     * Grid action
     * @Route("/dtlastresult", name="dtlastresult")
     * @return Response
     */
    public function dtLastResultAction(Request $request)
    {
    	$nuclide = $request->get('nuclide');
    	$legend = $request->get('legend');
    
    	return $this->dtLastResult($nuclide, $legend)->execute();
    }
    
    /**
     * set datatable configs
     * @return \Waldo\DatatableBundle\Util\Datatable
     */
    private function dtLastResult($nuclide=null, $legend=null) {
    
    	// TODO: no specific test here, but just return empty array
    	if($nuclide==null) {
    		$nuclide=21;
    	}
    	if($legend==null) {
    		$legend=1;
    	}
    	$station=7;
    	 
    	// query builder
    	$rawsql = 'SELECT r.limited, r.value, r.error, u.code as unit, r.nuclide_id as nuclide, m.id, m.referenceDate, st.code as station, st.id
FROM result r
left join measurement m on r.measurement_id=m.id
left join sample s on m.sample_id=s.id
left join station st on s.station_id=st.id
left join result_unit u on m.result_unit_id=u.id
INNER JOIN
(SELECT max(m.referenceDate) as maxdate, st.code as st_code
FROM measurement m
left join sample s on m.sample_id=s.id
left join station st on s.station_id=st.id
WHERE st.code LIKE "HV%"
group by st.code) AS groupe1
    
ON m.referenceDate=groupe1.maxdate
and st.code=groupe1.st_code
WHERE r.nuclide_id=21';
    	 
    	/*$statement1 = $this->getDoctrine()->getManager()->getConnection()->prepare($rawsql);
    	$statement1->execute();
    	 $resultdb = $statement1->fetchAll();
    	  
    	 var_dump($resultdb);
    	 die();
    	 */
    	// build subquery
    	$qb2 = $this->getDoctrine()->getManager()->createQueryBuilder();
    	//$qb2->select('m', 'MAX(m.referenceDate AS maxdate)', 's', 'st')
    	$qb2->select('m', $qb2->expr()->max('m.referenceDate'). ' AS maxdate', 's', 'st')
    	->from("AppBundle:Measurement", "m")
    	->leftJoin('m.sample', 's', \Doctrine\ORM\Query\Expr\Join::LEFT_JOIN)
    	->leftJoin('s.station', 'st', \Doctrine\ORM\Query\Expr\Join::LEFT_JOIN)
    	->where('st.code = :station')
    	->setParameters(array('station' => 'HV-POS'))
    	->groupBy('st.code')
    	;
    	 
    	 
    	$qb = $this->getDoctrine()->getManager()->createQueryBuilder();
    	$qb->select('r','m','u','s','st')
    	->from("AppBundle:Result", "r")
    	->leftJoin('r.measurement', 'm', \Doctrine\ORM\Query\Expr\Join::LEFT_JOIN)
    	->leftJoin('m.resultUnit', 'u', \Doctrine\ORM\Query\Expr\Join::LEFT_JOIN)
    	->leftJoin('m.sample', 's', \Doctrine\ORM\Query\Expr\Join::LEFT_JOIN)
    	->leftJoin('s.station', 'st', \Doctrine\ORM\Query\Expr\Join::LEFT_JOIN)
    	->leftJoin('r.nuclide', 'n', \Doctrine\ORM\Query\Expr\Join::LEFT_JOIN)
    	->innerJoin(sprintf('(%s)', $qb2->getDql()). ' AS groupe1', 'm.referenceDate = groupe1.maxdate')
    	->where('st.id = :station AND n.id = :nuclide')
    
    	->setParameters(array('station' => $station,'nuclide' => $nuclide))
    	->orderBy("m.referencedate", "desc")
    	;
    	 
    
    
    	// table heading
    	// $this;
    	 
    	$datatable = $this->get('datatable')
    	->setDatatableId('dta-tst2')
    	->setFields(
    			array(
    					$this->get('translator')->trans('table.refdate')	=> 'm.referencedate',
    					$this->get('translator')->trans('table.limited')	=> 'r.limited',
    					$this->get('translator')->trans('table.value')		=> 'r.value',
    					$this->get('translator')->trans('table.error')		=> 'r.error',
    					$this->get('translator')->trans('table.unit')		=> 'u.code',
    					$this->get('translator')->trans('table.station')	=> 'st.code',
    					"_identifier_"  => 'r.id'
    			)
    			);
    	 
    	/*
    	 * Cette partie fonctionne mais ne permet pas de sous-requête complexe
    	 *
    	 $datatable = $this->get('datatable')
    	 ->setDatatableId('dta-tst2')
    	 ->setGlobalSearch(false)
    	 ->setSearch(false)
    	 ->setNotSortableFields(array(0,1,2,3,4))
    	 ->setHiddenFields(array(1))
    	 ->setEntity("AppBundle:Result", "r")
    	 ->setOrder("m.referencedate", "desc")
    	 ->addJoin('r.measurement', 'm', \Doctrine\ORM\Query\Expr\Join::LEFT_JOIN)
    	 ->addJoin('m.resultUnit', 'u', \Doctrine\ORM\Query\Expr\Join::LEFT_JOIN)
    	 ->addJoin('m.sample', 's', \Doctrine\ORM\Query\Expr\Join::LEFT_JOIN)
    	 ->addJoin('s.station', 'st', \Doctrine\ORM\Query\Expr\Join::LEFT_JOIN)
    	 ->addJoin('r.nuclide', 'n', \Doctrine\ORM\Query\Expr\Join::LEFT_JOIN)
    	 ->setWhere(                                                     // set your dql where statement
    	 'st.id = :station AND n.id = :nuclide',
    	 array('station' => $station,'nuclide' => $nuclide)
    	 )
    	 ->setFields(
    	 array(
    	 $this->get('translator')->trans('table.refdate')	=> 'm.referencedate',
    	 $this->get('translator')->trans('table.limited')	=> 'r.limited',
    	 $this->get('translator')->trans('table.value')		=> 'r.value',
    	 $this->get('translator')->trans('table.error')		=> 'r.error',
    	 $this->get('translator')->trans('table.unit')		=> 'u.code',
    	 $this->get('translator')->trans('table.station')	=> 'st.code',
    	 "_identifier_"  => 'r.id'
    	 )
    	 )
    	 ->setRenderer(
    	 function(&$data) use ($controller_instance)
    	 {
    	 $nwg = false;
    	 $renderer = 'AppBundle:Renderers:_scinumber.html.twig';
    
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
    
    	 if ($key == 1) // r.limited
    	 {
    	 if($value) {
    	 $renderer = 'AppBundle:Renderers:_nwg.html.twig';
    	 } else {
    	 $renderer = 'AppBundle:Renderers:_scinumber.html.twig';
    	 }
    	 }
    
    	 if ($key == 2) // r.value
    	 {
    
    	 if($value) {
    	 $data[$key] = $controller_instance
    	 ->get('templating')
    	 ->render(
    	 $renderer,
    	 array('data' => $value)
    	 );
    	 }
    	 }
    
    	 if ($key == 3) // r.error
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
    	  
    	 ;
    	 */
    	//$datatable->getQueryBuilder()->getDoctrineQueryBuilder()->setMaxResults(1);
    	 
    	$datatable->getQueryBuilder()->setDoctrineQueryBuilder($qb);
    	 
    	return $datatable;
    }
    
    
    
    
    
    

}
