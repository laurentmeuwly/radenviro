<?php 

# src/AppBudle/Admin/AutomaticNetworkStationAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class AutomaticNetworkStationAdmin extends AbstractAdmin
{
	public $last_position = 0;
	
	private $positionService;
	
	protected $datagridValues = array(
			'_page' => 1,
			'_sort_order' => 'ASC',
			'_sort_by' => 'sorting',
	);
	
	public function setPositionService(PositionHandler $positionHandler)
	{
		$this->positionService = $positionHandler;
	}
	
	protected function configureRoutes(RouteCollection $collection)
	{
		// ...
		$collection->add('move', $this->getRouterIdParameter().'/move/{position}');
	}
	
	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
		->addIdentifier('name')
		->add('automaticNetwork.name')
		->add('sorting')
		->add('hidden', 'boolean', array('editable' => true))
		->add('_action', null, array(
				'actions' => array(
						'move' => array(
								'template' => 'PixSortableBehaviorBundle:Default:_sort.html.twig'
						),
				)
		)
				)
		;
	}
	
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
			->add('name_de', 'text')
			->add('description_de', 'text')
			->add('name_fr', 'text')
			->add('description_fr', 'text')
			->add('name_it', 'text')
			->add('description_it', 'text')
			->add('name_en', 'text')
			->add('description_en', 'text')
			->add('latitude', 'text')
			->add('longitude', 'text')
		;
	}
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		//$datagridMapper->add('name_fr');
	}
}