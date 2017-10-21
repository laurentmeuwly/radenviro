<?php 
# src/AppBudle/Admin/AutomaticNetworkAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Xmon\ColorPickerTypeBundle\Form\Type\ColorPickerType;
use Sonata\AdminBundle\Route\RouteCollection;

class AutomaticNetworkAdmin extends AbstractAdmin
{
	protected $datagridValues = array(
			'_sort_order' => 'ASC',
			'_sort_by' => 'position'
	);
	
	protected function configureRoutes(RouteCollection $collection)
	{
		$collection->add('move', $this->getRouterIdParameter().'/move/{position}');
	}
	
	public function configure() {
		$this->setTemplate('edit', 'AppBundle:SpecialAdmin:edit.html.twig');
	}
	
	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
		->addIdentifier('name', null, array('label' => 'admin.automatic_network.name'))
		->add('totalStations', null, array('label' => 'admin.automatic_network.total_stations',
				'header_style' => 'text-align: center',
				'row_align' => 'center')
				)
		->add('_color', null, array( 'label' => 'admin.label.color',
				'header_style' => 'text-align: center',
				'row_align' => 'center')
				)
		->add('_active', 'boolean', array('label' => 'admin.label.active',
				'editable' => true,
				'header_style' => 'text-align: center',
				'row_align' => 'center')
				)
		->add('_position', 'actions', array(
				'actions' => array(
						'move' => array(
								'template' => 'PixSortableBehaviorBundle:Default:_sort.html.twig'
						)
				)
		))
		->add('_action', 'actions', array(
				'actions' => array(
						'edit' => array(),
						'delete' => array(),
				)
		))
		;
	}
	
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
		->with('General', array('class' => 'col-md-6', 'label' => 'admin.label.general'))
		->add('translations', TranslationsType::class, array(
				'label' => false,
				'fields' => array(
						'name'=> array('label' => 'admin.automatic_network.name'),
						'url'=> array('label' => 'admin.automatic_network.url')
				)
		))
		->end()
		->with('Attributs', array('class' => 'col-md-3', 'label' => 'admin.label.attributs'))
		->add('color', ColorPickerType::class,  array('label' => 'admin.label.color'))
		->add('active', null, array('label' => 'admin.label.active'))
		->add('position', null, array('label' => 'admin.label.position'))
		->end()
		->with('History', array('class' => 'col-md-3', 'label' => 'admin.label.history'))
		->add('createdAt', 'sonata_type_datetime_picker',  array('label' => 'admin.label.created_at',
				'attr' => array(
						'readonly' => true
				)
		))
		->add('updatedAt', 'sonata_type_datetime_picker', array('label' => 'admin.label.updated_at',
				'attr' => array(
						'readonly' => true
				)
		))
		->end()
		;
	}
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
	
	}
}