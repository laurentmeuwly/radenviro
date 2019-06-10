<?php

namespace AppBundle\Services;

use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Connection;
use Symfony\Component\Validator\Constraints\DateTime;

use AppBundle\Entity\Canton;
use AppBundle\Entity\Country;
use AppBundle\Entity\Element;
use AppBundle\Entity\Nuclide;
use AppBundle\Entity\Method;
use AppBundle\Entity\QuantityUnit;
use AppBundle\Entity\ResultUnit;
use AppBundle\Entity\SampleType;
use AppBundle\Entity\Type;
use AppBundle\Entity\BagCode;
use AppBundle\Entity\Laboratory;
use AppBundle\Entity\Network;
use AppBundle\Entity\Station;
use AppBundle\Entity\Sample;
use AppBundle\Entity\Measurement;
use AppBundle\Entity\Result;

class Synchronizer
{
	protected $em;
	protected $conn;
	
	public function __construct(EntityManager $em, Connection $dbalConnection)
	{
		$this->em = $em;
		$this->conn = $dbalConnection;
	}
	
	
	public function synchronize(String $startDate=null)
	{
		$nb = array();
		//$nb['canton'] = $this->syncCanton();
		//$nb['country'] = $this->syncCountry();
		//$nb['element'] = $this->syncElement();
		//$nb['nuclide'] = $this->syncNuclide();
		//$nb['method'] = $this->syncMethod();
		//$nb['qty_unit'] = $this->syncQtyUnit();
		//$nb['res_unit'] = $this->syncResUnit();
		//$nb['sample_type'] = $this->syncSampleType();
		//$nb['type'] = $this->syncType();
		//$nb['bag_code'] = $this->syncBagCode();
		//$nb['laboratory'] = $this->syncLaboratory();
		//$nb['network'] = $this->syncNetwork();
		//$nb['station'] = $this->syncStation();
		$nb['sample'] = $this->syncSample($startDate);
		return $nb;
	}
	
	public function syncCanton()
	{
		//count($this->em->getRepository("AppBundle:Canton")->findAll());
		
		$res['added']=0;
		$res['threated']=0;
		
		$result_src = $this->conn->query('SELECT * FROM canton');
		while($data_src = $result_src->fetch()) {
			$data_dst = $this->em->getRepository("AppBundle:Canton")->findOneByCode($data_src['code']);
			
			if(!is_object($data_dst)){
				$data_dst = new Canton();
				$data_dst->setCode($data_src['code']);
				$res['added']++;
			}
			$data_dst->translate('fr')->setName($data_src['name_fr']);
			$data_dst->translate('de')->setName($data_src['name_de']);
			
			$this->em->persist($data_dst);
			$data_dst->mergeNewTranslations();
			$this->em->flush();
			$this->em->clear();
			$res['threated']++;
		}
		return $res;
		
	}
	
	public function syncCountry()
	{
		$res['added']=0;
		$res['threated']=0;
		
		$result_src = $this->conn->query('SELECT * FROM country');
		while($data_src = $result_src->fetch()) {
			$data_dst = $this->em->getRepository("AppBundle:Country")->findOneByCode($data_src['code']);
				
			if(!is_object($data_dst)){
				$data_dst = new Country();
				$data_dst->setCode($data_src['code']);
				$res['added']++;
			}
			$data_dst->translate('fr')->setName($data_src['name_fr']);
			$data_dst->translate('de')->setName($data_src['name_de']);
			$data_dst->translate('en')->setName($data_src['name_en']);
				
			$this->em->persist($data_dst);
			$data_dst->mergeNewTranslations();
			$this->em->flush();
			$this->em->clear();
			$res['threated']++;
		}
		return $res;
	
	}
	
	public function syncElement()
	{
		$res['added']=0;
		$res['threated']=0;
	
		$result_src = $this->conn->query('SELECT * FROM element');
		while($data_src = $result_src->fetch()) {
			$data_dst = $this->em->getRepository("AppBundle:Element")->findOneByZ($data_src['Z']);
	
			if(!is_object($data_dst)){
				$data_dst = new Element();
				$data_dst->setZ($data_src['Z']);
				$res['added']++;
			}
			$data_dst->setSymbol($data_src['symbol']);
			$data_dst->translate('fr')->setName($data_src['name_fr']);
			$data_dst->translate('de')->setName($data_src['name_de']);
			$data_dst->translate('en')->setName($data_src['name_en']);
	
			$this->em->persist($data_dst);
			$data_dst->mergeNewTranslations();
			$this->em->flush();
			$this->em->clear();
			$res['threated']++;
		}
		return $res;
	
	}
	
	public function syncNuclide()
	{
		$res['added']=0;
		$res['threated']=0;
		
		return $res;
		
	}
	
	public function syncMethod()
	{
		$res['added']=0;
		$res['threated']=0;
	
		$result_src = $this->conn->query('SELECT * FROM enum_method');
		while($data_src = $result_src->fetch()) {
			$data_dst = $this->em->getRepository("AppBundle:Method")->findOneByCode($data_src['id']);
		
			if(!is_object($data_dst)){
				$data_dst = new Method();
				$data_dst->setCode($data_src['id']);
				$res['added']++;
			}
			$data_dst->translate('fr')->setName($data_src['text_fr']);
			$data_dst->translate('de')->setName($data_src['text_de']);
		
			$this->em->persist($data_dst);
			$data_dst->mergeNewTranslations();
			$this->em->flush();
			$this->em->clear();
			$res['threated']++;
		}
		return $res;
	
	}
	
	public function syncQtyUnit()
	{
		$res['added']=0;
		$res['threated']=0;
	
		$result_src = $this->conn->query('SELECT * FROM enum_quantity_unit');
		while($data_src = $result_src->fetch()) {
			$data_dst = $this->em->getRepository("AppBundle:QuantityUnit")->findOneByCode($data_src['id']);
		
			if(!is_object($data_dst)){
				$data_dst = new QuantityUnit();
				$data_dst->setCode($data_src['id']);
				$res['added']++;
			}
					
			$this->em->persist($data_dst);
			$this->em->flush();
			$this->em->clear();
			$res['threated']++;
		}
		return $res;
	
	}
	
	public function syncResUnit()
	{
		$res['added']=0;
		$res['threated']=0;
	
		$result_src = $this->conn->query('SELECT * FROM enum_results_unit');
		while($data_src = $result_src->fetch()) {
			$data_dst = $this->em->getRepository("AppBundle:ResultUnit")->findOneByCode($data_src['id']);
		
			if(!is_object($data_dst)){
				$data_dst = new ResultUnit();
				$data_dst->setCode($data_src['id']);
				$res['added']++;
			}
				
			$this->em->persist($data_dst);
			$this->em->flush();
			$this->em->clear();
			$res['threated']++;
		}
		return $res;
	
	}
	
	public function syncSampleType()
	{
		$res['added']=0;
		$res['threated']=0;
	
		$result_src = $this->conn->query('SELECT * FROM enum_sample_type');
		while($data_src = $result_src->fetch()) {
			$data_dst = $this->em->getRepository("AppBundle:SampleType")->findOneByCode($data_src['id']);
		
			if(!is_object($data_dst)){
				$data_dst = new SampleType();
				$data_dst->setCode($data_src['id']);
				$res['added']++;
			}
			$data_dst->translate('fr')->setName($data_src['text_fr']);
			$data_dst->translate('de')->setName($data_src['text_de']);
		
			$this->em->persist($data_dst);
			$data_dst->mergeNewTranslations();
			$this->em->flush();
			$this->em->clear();
			$res['threated']++;
		}
		return $res;
	
	}
	
	public function syncType()
	{
		$res['added']=0;
		$res['threated']=0;
		
		$result_src = $this->conn->query('SELECT * FROM enum_type');
		while($data_src = $result_src->fetch()) {
			$data_dst = $this->em->getRepository("AppBundle:Type")->findOneByCode($data_src['id']);
		
			if(!is_object($data_dst)){
				$data_dst = new Type();
				$data_dst->setCode($data_src['id']);
				$res['added']++;
			}
			$data_dst->translate('fr')->setName($data_src['text_fr']);
			$data_dst->translate('de')->setName($data_src['text_de']);
		
			$this->em->persist($data_dst);
			$data_dst->mergeNewTranslations();
			$this->em->flush();
			$this->em->clear();
			$res['threated']++;
		}
		return $res;
	
	}
	
	public function syncBagCode()
	{
		$res['added']=0;
		$res['threated']=0;
	
		$result_src = $this->conn->query('SELECT * FROM warencode');
		while($data_src = $result_src->fetch()) {
			$data_dst = $this->em->getRepository("AppBundle:BagCode")->findOneBy(array('code' => $data_src['code'], 'version' => $data_src['version']));
		
			if(!is_object($data_dst)){
				$data_dst = new BagCode();
				$data_dst->setCode($data_src['code']);
				$data_dst->setVersion($data_src['version']);
				$res['added']++;
			}
			$data_dst->translate('fr')->setName($data_src['text_fr']);
			$data_dst->translate('de')->setName($data_src['text_de']);
			$data_dst->translate('it')->setName($data_src['text_it']);
		
			$this->em->persist($data_dst);
			$data_dst->mergeNewTranslations();
			$this->em->flush();
			$this->em->clear();
			$res['threated']++;
		}
		return $res;
	
	}
	
	public function syncLaboratory()
	{
		$res['added']=0;
		$res['threated']=0;
		
		$result_src = $this->conn->query('SELECT * FROM labor');
		while($data_src = $result_src->fetch()) {
			$data_dst = $this->em->getRepository("AppBundle:Laboratory")->findOneByCode($data_src['code']);
		
			if(!is_object($data_dst)){
				$data_dst = new Laboratory();
				$data_dst->setCode($data_src['code']);
				$data_dst->setActive(false);
				$res['added']++;
			}
			$data_dst->translate('fr')->setName($data_src['name_fr']);
			$data_dst->translate('de')->setName($data_src['name_de']);
			$data_dst->translate('it')->setName($data_src['name_it']);
		
			$this->em->persist($data_dst);
			$data_dst->mergeNewTranslations();
			$this->em->flush();
			$this->em->clear();
			$res['threated']++;
		}
		return $res;
	
	}
	
	public function syncNetwork()
	{
		$res['added']=0;
		$res['threated']=0;
	
		$result_src = $this->conn->query('SELECT * FROM network');
		while($data_src = $result_src->fetch()) {
			$data_dst = $this->em->getRepository("AppBundle:Network")->findOneByCode($data_src['code']);
		
			if(!is_object($data_dst)){
				$data_dst = new Network();
				$data_dst->setCode($data_src['code']);
				$data_dst->setActive(false);
				$res['added']++;
			}
			$data_dst->translate('fr')->setName($data_src['name_fr']);
			$data_dst->translate('de')->setName($data_src['name_de']);
		
			$this->em->persist($data_dst);
			$data_dst->mergeNewTranslations();
			$this->em->flush();
			$this->em->clear();
			$res['threated']++;
		}
		return $res;
	
	}
	
	public function syncStation()
	{
		$res['added']=0;
		$res['threated']=0;
	
		$result_src = $this->conn->query('SELECT distinct(station) as code, network FROM sample');
		while($data_src = $result_src->fetch()) {
			$data_dst = $this->em->getRepository("AppBundle:Station")->findOneByCode($data_src['code']);
		
			if(!is_object($data_dst)){
				$data_dst = new Station();
				$data_dst->setCode($data_src['code']);
				$data_dst->setActive(false);
				$res['added']++;
			}
			//$data_dst->translate('fr')->setName($data_src['name_fr']);
			//$data_dst->translate('de')->setName($data_src['name_de']);
			
			$network = $this->em->getRepository("AppBundle:Network")->findOneByCode($data_src['network']);
			if(is_object($network)){
				$data_dst->setNetwork($network);
			}
		
			$this->em->persist($data_dst);
			$data_dst->mergeNewTranslations();
			$this->em->flush();
			$this->em->clear();
			$res['threated']++;
		}
		return $res;
	
	}
	
	/*
	 * From now, were are in very dynamic tables, with large data
	 * For performance purpose we synchronise only new element
	 * Measurement and Result should only be sync after Sample was synced
	 */
	public function syncSample(String $startDate = null)
	{
		// TODO: validate input format for $startDate
		$res['added']=0;
		$res['threated']=0;
		if($startDate) {
			$result_src = $this->conn->query('SELECT * FROM sample WHERE mtime>="'.$startDate.'"');
		} else {
			$result_src = $this->conn->query('SELECT * FROM sample');
		}
		
		while($data_src = $result_src->fetch()) {
			$data_dst = $this->em->getRepository("AppBundle:Sample")->findOneByNumber($data_src['num']);
			if(!is_object($data_dst)){
				$data_dst = new Sample();
				$data_dst->setNumber($data_src['num']);
				$data_dst->setInsitu($data_src['in_situ']==='Y');
				$data_dst->setDescription($data_src['description']);
				
				$mtime = $data_src['mtime']!='' ?
					$mtime = \DateTime::createFromFormat('Y-m-d H:i:s', $data_src['mtime']) : null;
				$data_dst->setMtime($mtime);
				
				$sam_date = $data_src['sam_date']!='' ?
					$sam_date = \DateTime::createFromFormat('Y-m-d H:i:s', $data_src['sam_date']) : null;
				$data_dst->setSamdate($sam_date); 
				
				$sam_end_date = $data_src['sam_end_date']!='' ?
					$sam_end_date = \DateTime::createFromFormat('Y-m-d H:i:s', $data_src['sam_end_date']) : null;
				$data_dst->setSamenddate($sam_end_date);
				
				$data_dst->setSamcoordinatesystem($data_src['sam_coord_system']);
				$data_dst->setSamcoordinateunit($data_src['sam_coord_unit']);
				$data_dst->setSamx($data_src['sam_x']);
				$data_dst->setSamy($data_src['sam_y']);
				$data_dst->setSamzip($data_src['sam_postcode']);
				$data_dst->setSamlocality($data_src['sam_town']);
				
				$data_dst->setSamcanton($this->em->getRepository("AppBundle:Canton")->findOneByCode($data_src['sam_canton']));
				$data_dst->setSamcountry($this->em->getRepository("AppBundle:Country")->findOneByCode($data_src['sam_country']));
				
				$data_dst->setSamcomment($data_src['sam_comment']);
				
				if($data_src['ori_same']=='Y') {
				    $data_dst->setOrisame(1);
				} else {
				    $data_dst->setOrisame(0);
				}
				
				$ori_date = $data_src['ori_date']!='' ?
					$ori_date = \DateTime::createFromFormat('Y-m-d H:i:s', $data_src['ori_date']) : null;
				$data_dst->setOridate($ori_date);
				
				$data_dst->setOricoordinatesystem($data_src['ori_coord_system']);
				$data_dst->setOricoordinateunit($data_src['ori_coord_unit']);
				$data_dst->setOrix($data_src['ori_x']);
				$data_dst->setOriy($data_src['ori_y']);
				$data_dst->setOrizip($data_src['ori_postcode']);
				$data_dst->setOrilocality($data_src['ori_town']);
				
				$data_dst->setOricanton($this->em->getRepository("AppBundle:Canton")->findOneByCode($data_src['ori_canton']));
				$data_dst->setOricountry($this->em->getRepository("AppBundle:Country")->findOneByCode($data_src['ori_country']));
				
				$data_dst->setOricomment($data_src['ori_comment']);
				$data_dst->setDoserate($data_src['dose_rate']);
				$data_dst->setQuantity($data_src['quantity']);
				$data_dst->setQuantityUnit($this->em->getRepository("AppBundle:QuantityUnit")->findOneByCode($data_src['quantity_unit']));
				$data_dst->setSurface($data_src['surface']);
				$data_dst->setGrassyield($data_src['grass_yield']);
				$data_dst->setSoillayer($data_src['soil_layer']);
				$data_dst->setComment($data_src['comments']);
				
				$data_dst->setBagCode($this->em->getRepository("AppBundle:BagCode")->findOneBy(array('code' => $data_src['bag_code'], 'version' => $data_src['bag_code_version'])));
				$data_dst->setLaboratory($this->em->getRepository("AppBundle:Laboratory")->findOneByCode($data_src['labor']));
				$data_dst->setType($this->em->getRepository("AppBundle:Type")->findOneByCode($data_src['type']));
				$data_dst->setSampleType($this->em->getRepository("AppBundle:SampleType")->findOneByCode($data_src['sample_type']));
				$data_dst->setQuantityUnit($this->em->getRepository("AppBundle:QuantityUnit")->findOneByCode($data_src['quantity_unit']));
				$data_dst->setNetwork($this->em->getRepository("AppBundle:Network")->findOneByCode($data_src['network']));
				$data_dst->setStation($this->em->getRepository("AppBundle:Station")->findOneByCode($data_src['station']));
				//$data_dst->setToremovenetwork();
				//$data_dst->setToremovestation();
				
				$this->em->persist($data_dst);
				
				$this->syncMeasurement($data_src['id'], $data_dst);
				
				$this->em->flush();
				$this->em->clear();
				$res['added']++;
			}
			$res['threated']++;
		}
		return $res;
	
	}
	
	
	public function syncMeasurement($sample_src, $sample_dst)
	{
		$result_src = $this->conn->query('SELECT * FROM measurement WHERE sid=' . $sample_src);
		while($data_src = $result_src->fetch()) {
			$data_dst = new Measurement();
			$data_dst->setSample($sample_dst);
			
			$referenceDate = $data_src['ref_date']!='' ?
				$referenceDate = \DateTime::createFromFormat('Y-m-d H:i:s', $data_src['ref_date']) : null;
			$data_dst->setReferencedate($referenceDate);
			
			$date = $data_src['datum']!='' ?
				$date = \DateTime::createFromFormat('Y-m-d H:i:s', $data_src['datum']) : null;
			$data_dst->setDate($date);
			
			$data_dst->setNumber($data_src['num']);
			$data_dst->setPreparation($data_src['preparation']);
			$data_dst->setQuantity($data_src['quantity']);
			$data_dst->setFreshDryRatio($data_src['fresh_dry_ratio']);
			$data_dst->setComments($data_src['comments']);
			if($data_src['results_fresh']=='Y') {
			    $data_dst->setResultsFresh(1);
			} else {
			    $data_dst->setResultsFresh(0);
			}
			
			$data_dst->setLaboratory($this->em->getRepository("AppBundle:Laboratory")->findOneByCode($data_src['labor']));
			$data_dst->setMethod($this->em->getRepository("AppBundle:Method")->findOneByCode($data_src['method']));
			$data_dst->setQuantityUnit($this->em->getRepository("AppBundle:QuantityUnit")->findOneByCode($data_src['quantity_unit']));
			$data_dst->setResultUnit($this->em->getRepository("AppBundle:ResultUnit")->findOneByCode($data_src['results_unit']));
			
			$this->em->persist($data_dst);
			$this->syncResult($data_src['id'], $data_dst);
		}
		
		return true;
	}
	
	public function syncResult($measurement_src, $measurement_dst)
	{
		$result_src = $this->conn->query('SELECT * FROM result WHERE mid=' . $measurement_src);
		while($data_src = $result_src->fetch()) {
			$data_dst = new Result();
			$data_dst->setMeasurement($measurement_dst);
			$data_dst->setNuclide($this->em->getRepository("AppBundle:Nuclide")->findOneByCode($data_src['nuclide']));
			$data_dst->setLimited($data_src['lim']==='Y');
			$data_dst->setValue($data_src['val']);
			$data_dst->setError($data_src['err']);
			
			$this->em->persist($data_dst);
		}
		return true;
	}

}