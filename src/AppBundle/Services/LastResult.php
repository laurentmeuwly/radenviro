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
	
	public function getLastResultByStationAndIsotope($station, $nuclide)
	{
		// Getting doctrine manager
		//$allstation = $this->em->getRepository("AppBundle:Station")->findOneById($station);
		$conn = $this->em->getConnection();
		
		// retrieve last result for current station and isotope
		/*
		SELECT r.*
		FROM measurement m
		LEFT JOIN result r ON r.measurement_id=m.id
		WHERE m.referenceDate=
		
		(SELECT max(m.referenceDate)
				FROM measurement m
				LEFT JOIN sample s ON m.sample_id=s.id
				WHERE s.station_id=$station)
		AND r.nuclide_id=$nuclide
		*/
		
		$sub = $this->em->createQueryBuilder('sq');
		$sub
		->select('MAX(m.referencedate)')
		->from('AppBundle:Measurement', 'm')
		->join('m.sample', 's')
		->andWhere('s.station = :station')
		
		;

		
		$qb = $this->em->createQueryBuilder();
		$qb
		->select('r')
		->from('AppBundle:Result', 'r')
		->join('r.measurement', 'rm')
		->join('rm.sample', 'ms')
		;
		
		$qb
		->andWhere('rm.referencedate = (' . $sub->getDQL() . ')')
		->andWhere('r.nuclide = :nuclide')
		->andWhere('ms.station = :station')
		->setParameter('nuclide', $nuclide)
		->setParameter('station', $station)
		->setMaxResults(1)
		;
		
		$result = $qb->getQuery()->getOneOrNullResult();

		return $result;
	}
}