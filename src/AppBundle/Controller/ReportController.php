<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use AppBundle\Entity\Sample;
use AppBundle\Entity\Measurement;
//use AppBundle\Entity\Product;

class ReportController extends Controller
{
	/**
	 * @Route("/printSample/{id}", name="printSample")
	 */
	public function printReportAction($id, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		 
		$sample = $em->getRepository('AppBundle:Sample')->findOneByNumber($id);	// 1 measurement
		//$sample = $em->getRepository('AppBundle:Sample')->findOneByNumber('17-01642'); // 2 measurements
		//$measure = $em->getRepository('AppBundle:Measurement')->findOneById('15883');
		
		/*$measures = $sample->getMeasurements();
		foreach($measures as $meas) {
			echo $meas->getQuantity() . '<br/>';
		}
		var_dump($sample->getMeasurements());
		//die();
		*/
		$filePath = '/var/www/test.pdf';
		
		/*return $this->render('AppBundle:Report:printSample.html.twig', array(
				'sample' => $sample,
		));*/
		
		$html = $this->renderView('AppBundle:Report:printSample.html.twig', array(
				'sample' => $sample,
		));
		
		// remove old file
		if (file_exists($filePath)) {
			unlink($filePath);
		}
		
		return new Response(
				$this->get('knp_snappy.pdf')->getOutputFromHtml($html),
				200,
				array(
						'Content-Type'          => 'application/pdf',
						'Content-Disposition'   => 'attachment; filename="file.pdf"'
				)
		);
	}
}