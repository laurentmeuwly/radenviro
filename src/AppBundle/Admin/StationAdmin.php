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
			->add('_active', 'boolean', array('label' => 'admin.label.active',
					'editable' => true,
					'header_style' => 'text-align: center',
					'row_align' => 'center')
					)
			->add('name', null, array('label' => 'admin.station.name'))
			->add('network.name', null, array('label' => 'admin.station.network'))
			->add('stationType.code', null, array('label' => 'admin.station_type.name'))
			->add('_action', 'actions', array(
					'actions' => array(
							'edit' => array(),
							'delete' => array(),
					)
			))
		;
	}
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
		->add('active', null, ['operator_type' => 'sonata_type_boolean', 'label' => 'admin.label.active'])
		->add('code')
		->add('translations.name', null, ['label' => 'admin.station.name'])
		->add('network', null, ['label' => 'admin.network.name'], 'entity', [
					'class' => 'AppBundle\Entity\Network',
					'choice_label' => 'code',
			])
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
			->add('active', 	null, [ 'label' => 'admin.label.active' ])
			->add('network', null, [ 'label' => 'admin.station.network' ])
			->add('stationType', null, [ 'label' => 'admin.station_type.name' ])
		->end()
		->with('Attributs', array('class' => 'col-md-3', 'label' => 'admin.label.attributs'))
		->add('latitude', 	null, [ 'label' => 'admin.label.latitude' ])
		->add('longitude', 	null, [ 'label' => 'admin.label.longitude' ])
		->add('zoom', 		null, [ 'label' => 'admin.label.zoom' ])
		->add('defaultZoom',null, [ 'label' => 'admin.label.default_zoom' ])
		->add('graph_scale', 'choice', array('label' => 'admin.label.graph_scale',
			'choices' => [
				'1 month' => '1m',
				'1 year' => '1y',
				'All' => 'all'
			]))
		
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
						'description'=> array('field_type' => 'ckeditor', 'label' => 'admin.label.description')
				)
			))
		->end()
		
		;
	}
	
}