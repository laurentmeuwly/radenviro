<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Datatables\SampleDatatable;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Source\Vector;
use AppBundle\Entity\Sample;
use AppBundle\Entity\Station;
use AppBundle\Entity\Network;
use AppBundle\Form\NetworkSearchType;
use AppBundle\Form\AdvancedSearchType;


class AdvancedController extends Controller
{    
	
	public function form1Action(Request $request)
	{
		
	}
	
}