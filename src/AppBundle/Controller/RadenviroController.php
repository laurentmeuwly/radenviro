<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Omines\DataTablesBundle\Adapter\ArrayAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\DateTimeColumn;
use Omines\DataTablesBundle\Controller\DataTablesTrait;


class RadenviroController extends Controller
{
	use DataTablesTrait;
	
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
	
	/**
	 * @Route("/measures/{station}", name="measures")
	 */
	public function measuresAction($station, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$currentStation = $em->getRepository('AppBundle:Station')->findOneById(array('id'=>$station));
		$legend = $em->getRepository('AppBundle:LegendStation')->findOneByStation(array('station'=>$station));
		 
		$availableNuclides = $em->getRepository('AppBundle:Nuclide')->getNuclidesList($station,$legend->getLegend());
		 
		// initiate the datatable result
		$this->datatableResult();
		 
		return $this->render('measures/measures_history.html.twig', array(
				'station' => $currentStation,
				'nuclides' => $availableNuclides,
		));
		 
	}
	
	
	/**
	 * @Route("/map2", name="map2")
	 */
	public function mapAction(Request $request)
	{
		$session = $request->getSession();
		 
		$nuclide = $request->query->get('nuclide');
		if($nuclide==null) $nuclide=21;
		$session->set('nuclide', $nuclide);
		 
		$isAjax = $request->isXmlHttpRequest();
	
		$nuclide = $session->get('nuclide');
		//$session->get('station');
		 
	
		 
		// Getting doctrine manager
		$em = $this->getDoctrine()->getManager();
	
		// retrieve all active legends
		$legends = $em->getRepository('AppBundle:Legend')->findBy(array('active' => 1), array('position' => 'ASC'));
	
		// retrieve all active site types
		$siteTypes = $em->getRepository('AppBundle:SiteType')->findBy(array('active' => 1), array('position' => 'ASC'));
	
		// retrieve all active automatic networks
		$automaticNetworks = $em->getRepository('AppBundle:AutomaticNetwork')->findBy(array('active' => 1), array('position' => 'ASC'));
	
		// retrieve all zoom areas
		$zooms = $em->getRepository('AppBundle:MapZoom')->findAll();
	
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
		->add('station', TextColumn::class, ['label' => 'table.station'])
		->createAdapter(ArrayAdapter::class, $resultdb)
		->handleRequest($request);
	
		if ($table->isCallback()) {
			return $table->getResponse();
		}
	
		return $this->render('main_map2.html.twig', array(
				'legends' => $legends,
				'siteTypes' => $siteTypes,
				'automaticNetworks' => $automaticNetworks,
				'zooms' => $zooms,
				'datatable' => $table,
		));
	
	}
	
	
	public function getDtRequest($nuclide)
	{
		if($nuclide==NULL) $nuclide=21;
		
		// query builder
		$rawsql = 'SELECT r.limited, r.value, r.error, u.code as unit, r.nuclide_id, m.id, m.referenceDate, st.code as station, st.id
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
WHERE st.code LIKE "%"
group by st.code) AS groupe1
  
ON m.referenceDate=groupe1.maxdate
and st.code=groupe1.st_code
WHERE r.nuclide_id=' . $nuclide
	. ' ORDER BY m.referenceDate DESC';
	 
	return $rawsql;
	}
	
}