<?php 
// src/AppBudle/Admin/SiteAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Sonata\AdminBundle\Route\RouteCollection;

class SiteAdmin extends AbstractAdmin
{	
	protected $datagridValues = array(
			'_sort_order' => 'ASC',
			'_sort_by' => 'position'
	);
	
	protected function configureRoutes(RouteCollection $collection)
	{
		$collection->add('move', $this->getRouterIdParameter().'/move/{position}');
	}
	
	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
		->addIdentifier('name', null, array('label' => 'admin.site.name'))
		->add('siteType.name', 		null, array('label' => 'admin.site_type.name'))
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
		;
	}
	
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
		->with('General', array('class' => 'col-md-6', 'label' => 'admin.label.general'))
		->add('translations', TranslationsType::class, [
				'label' => false,
				'fields' => [
						'name'=> [
								'label' => 'admin.site.name',
						],
						'description' => [
								'field_type' => 'ckeditor',
								'label' => 'admin.label.description',
						]		
				]
				
			])
		->end()
		
		->with('Attributs', array('class' => 'col-md-3', 'label' => 'admin.label.attributs'))
		->add('siteType', 	null, [ 'label' => 'admin.site_type.name' ])
		->add('latitude', 	null, [ 'label' => 'admin.label.latitude' ])
		->add('longitude', 	null, [ 'label' => 'admin.label.longitude' ])
		->add('zoom', 		null, [ 'label' => 'admin.label.zoom' ])
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
		
		->with('Map', array('class' => 'col-md-3', 'label' => 'admin.label.map'))
		->end()
		
		->with('Stations', array('class' => 'col-md-6', 'label' => 'admin.site.stations'))
		//->add('stations', null, array('multiple'=>true, 'expanded'=>true, 'mapped'=>false))
		->add('stations', null, array('multiple'=>true, 'expanded'=>true, 'mapped'=>true))
		//->add('stations', CollectionType::class, array('by_reference' => false))
		/*->add('stations', CollectionType::class, array(
				'class'        => 'AppBundle:Station',
				'choice_label' => 'name',
				'multiple'     => true,
				'required'     => false))*/
		->end()
		;
		 
	}
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		
	}
	
}