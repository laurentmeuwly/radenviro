<?php 
# src/AppBudle/Admin/StationAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

class StationAdmin extends AbstractAdmin
{
	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->addIdentifier('code', null, array('label' => 'admin.station.code'))
			->add('name', null, array('label' => 'admin.station.name'))
			->add('network.name', null, array('label' => 'admin.station.network'))
			->add('stationType.code', null, array('label' => 'admin.station_type.name'))
		;
	}
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
			->add('code')
			->add('network', null, array(), 'entity', array(
					'class' => 'AppBundle\Entity\Network',
					'choice_label' => 'code',
			))
		;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
		->with('General', array('class' => 'col-md-6', 'label' => 'admin.label.general'))
			->add('code', null, [ 'label' => 'admin.station.code' ])
			->add('network', null, [ 'label' => 'admin.station.network' ])
			->add('stationType', null, [ 'label' => 'admin.station_type.name' ])
		->end()
		->with('Attributs', array('class' => 'col-md-3', 'label' => 'admin.label.attributs'))
		->add('latitude', 	null, [ 'label' => 'admin.label.latitude' ])
		->add('longitude', 	null, [ 'label' => 'admin.label.longitude' ])
		->add('hidden', 	null, [ 'label' => 'admin.label.hidden' ])
		->add('zoom', 		null, [ 'label' => 'admin.label.zoom' ])
		->add('defaultZoom',null, [ 'label' => 'admin.label.default_zoom' ])
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
		->with('Informations', array('class' => 'col-md-6', 'label' => 'admin.label.informations'))
			->add('translations', TranslationsType::class, array(
				'label' => false,
				'fields' => array(
						'name'=> array('label' => 'admin.station.name'),
						'description'=> array('label' => 'admin.label.description')
				)
			))
		->end()
		
		;
	}
	
}