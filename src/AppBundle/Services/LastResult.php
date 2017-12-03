<?php

namespace AppBundle\Services;

use Doctrine\ORM\EntityManager;

class LastResult
{
	protected $em;
	
	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}
	
	public function getLastResultByStationAndIsotope($station, $isotope)
	{
		// Getting doctrine manager
		$allstation = $this->em->getRepository("AppBundle:Station")->findOneById($station);
		
		// retrieve last result for current station and isotope
		
		return $allstation;//'Station id=' . $station . ' / Isotope id=' . $isotope;
	}
}