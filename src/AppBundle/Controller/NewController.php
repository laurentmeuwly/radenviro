<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Validator\Constraints\DateTime;

use APY\DataGridBundle\Grid\Source\Entity;

use AppBundle\Datatables\MeasurementDatatable;
use AppBundle\Datatables\ResultDatatable;

use Omines\DataTablesBundle\Adapter\ArrayAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\DateTimeColumn;
use Omines\DataTablesBundle\Controller\DataTablesTrait;
use Omines\DataTablesBundle\DataTableState;

class NewController extends Controller
{
	/**
     * @Route("/map", name="v2-map")
     */
    public function mapAction(Request $request)
    {    	
		// Getting doctrine manager
		$em = $this->getDoctrine()->getManager();

		// retrieve all active legends
    	$legends = $em->getRepository('AppBundle:Legend')->findBy(array('active' => 1), array('position' => 'ASC'));

		$mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
			$settings = $em->getRepository('AppBundle:Settings')->findOneById('1');
			return $this->render('v2/measures/selector_for_mobile.html.twig', ['legends' => $legends, 
				'message' => $settings->getMobileMsg()]);
        } elseif($mobileDetector->isTablet()) {
            $settings = $em->getRepository('AppBundle:Settings')->findOneById('1');
			return $this->render('v2/measures/selector_for_mobile.html.twig', ['legends' => $legends, 
				'message' => $settings->getMobileMsg()]);
        } else {

    	// retrieve all active site types
    	$siteTypes = $em->getRepository('AppBundle:SiteType')->findBy(array('active' => 1), array('position' => 'ASC'));
    	
    	// retrieve all active automatic networks
    	$automaticNetworks = $em->getRepository('AppBundle:AutomaticNetwork')->findBy(array('active' => 1), array('position' => 'ASC'));
    	
    	// retrieve all zoom areas
    	$zooms = $em->getRepository('AppBundle:MapZoom')->findAll();
    	
		return $this->render('v2/map/main.html.twig', array(
				'legends' => $legends,
				'siteTypes' => $siteTypes,
				'automaticNetworks' => $automaticNetworks,
				'zooms' => $zooms,	
		));
	}
	}
	
    /**
	 * @Route("/measures/{station}", name="v2-measures")
	 */
	public function measuresAction($station, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$currentStation = $em->getRepository('AppBundle:Station')->findOneById(array('id'=>$station));
		$legend = $em->getRepository('AppBundle:LegendStation')->findOneByStation(array('station'=>$station));
		
		$availableNuclides = $em->getRepository('AppBundle:Nuclide')->getNuclidesList($station,$legend->getLegend());
		
		// initiate the datatable result
		$this->datatableResult();
		$header = $request->get('header');

        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('v2/measures/measures_history_mobile.html.twig', array(
				'station' => $currentStation,
				'nuclides' => $availableNuclides,
				'lang' => $request->getLocale()
			));
        } elseif($mobileDetector->isTablet()) {
            return $this->render('v2/measures/measures_history_mobile.html.twig', array(
				'station' => $currentStation,
				'nuclides' => $availableNuclides,
				'lang' => $request->getLocale()
			));
        } else {
			return $this->render('v2/measures/measures_history.html.twig', array(
				'station' => $currentStation,
				'nuclides' => $availableNuclides,
				'lang' => $request->getLocale()
			));
		}
	}

	
	/**
	 * @Route("/ajaxlegendstation", name="v2-ajaxlegendstation")
	 */
	public function ajaxLegendStation(Request $request) {
		$data=null;	 
		
		$legend = $request->request->get('legend_id');
		
		if(null !== $legend) {
			
			$em = $this->getDoctrine()->getManager();
			$results = $em->getRepository('AppBundle:Legend')->getStationByLegend($legend);
			
			$i=0;
			foreach($results as $result) {
				$data[$i]['id'] = $result->getStation()->getId();
				$data[$i]['name'] = $result->getStation()->getName();
				$i++;
			}
			return new JsonResponse($data);
		}
		return new Response("Nonnn ....");
		
	}
    
    /**
	 * Grid action
	 * @Route("/tableresult", name="v2-tableresult")
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
}