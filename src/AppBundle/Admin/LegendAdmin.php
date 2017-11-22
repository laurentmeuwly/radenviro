<?php 
# src/AppBudle/Admin/LegendAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Xmon\ColorPickerTypeBundle\Form\Type\ColorPickerType;
use Sonata\AdminBundle\Route\RouteCollection;

class LegendAdmin extends AbstractAdmin
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
	
	/*
	// exemple pour n'afficher que les actifs dans la liste
	public function createQuery($context = 'list')
	{
		$query = parent::createQuery($context);
		$query->andWhere(
				$query->expr()->eq($query->getRootAliases()[0] . '.active', ':my_param')
				);
		$query->setParameter('my_param', '1');
		return $query;
	}
	*/
	
	
	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->addIdentifier('name', null, array('label' => 'admin.legend.name'))
			->add('totalStations', null, array('label' => 'admin.legend.total_stations',
            		'header_style' => 'text-align: center',
            		'row_align' => 'center')
				)
			->add('totalNuclides', null, array('label' => 'admin.legend.total_nuclides',
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
								'name'=> array('label' => 'admin.legend.name')
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
		->with('Stations', array('class' => 'col-md-6', 'label' => 'admin.label.stations'))
		/*->add('station', 'sonata_type_collection', array(
              'by_reference' => false), array('label' => 'admin.label.position'))*/
		->end()
		->with('Nuclides', array('class' => 'col-md-6', 'label' => 'admin.label.nuclides'))
		->end()

		//->add('station', 'sonata_type_model', array('multiple' => true, 'by_reference' => false))
		;
	}
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		
	}
	
}