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
	 * @Route("/measures/{station}", name="measures")
	 */
	public function measuresAction($station, Request $request)
	{
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('new/data_content_mobile.html.twig');
        } elseif($mobileDetector->isTablet()) {
            return $this->render('new/data_content_tablet.html.twig');
        } else {
            return $this->render('new/data_content_pc.html.twig');
        }

		$em = $this->getDoctrine()->getManager();
		$currentStation = $em->getRepository('AppBundle:Station')->findOneById(array('id'=>$station));
		$legend = $em->getRepository('AppBundle:LegendStation')->findOneByStation(array('station'=>$station));
		 
		$availableNuclides = $em->getRepository('AppBundle:Nuclide')->getNuclidesList($station,$legend->getLegend());
		 
		// initiate the datatable result
		$this->datatableResult();
		$header = $request->get('header');
         
        //return $this->render('new/measures/measures_history.html.twig');
        
        return $this->render('new/measures/measures_history.html.twig', array(
            'station' => $currentStation,
            'nuclides' => $availableNuclides,
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
}