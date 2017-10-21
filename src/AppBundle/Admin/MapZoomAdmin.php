<?php 
# src/AppBudle/Admin/MapZoomAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class MapZoomAdmin extends AbstractAdmin
{
	protected $datagridValues = array(
			'_sort_order' => 'ASC',
			'_sort_by' => 'name'
	);
	
	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
		->addIdentifier('name', null, array('label' => 'admin.zoom.name'))
		->add('_latitude', null, array('label' => 'admin.label.latitude'))
		->add('_longitude', null, array('label' => 'admin.label.longitude'))
		->add('_zoom', null, array('label' => 'admin.zoom.zoom',
				'header_style' => 'text-align: center',
				'row_align' => 'center')
				)
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
	
	}
	
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
		->with('General', array('class' => 'col-md-5', 'label' => 'admin.label.general'))
		->add('name', null, array('label' => 'admin.zoom.name'))
		->add('latitude', null, array('label' => 'admin.label.latitude'))
		->add('longitude', null, array('label' => 'admin.label.longitude'))
		->add('zoom', null, array('label' => 'admin.zoom.zoom'))
		->end()
		->with('Additional', array('class' => 'col-md-4', 'label' => 'admin.zoom.additional'))
		->add('nlatitude', null, array('label' => 'admin.label.nlatitude',
				'attr' => array('readonly' => true)
			))
		->add('slatitude', null, array('label' => 'admin.label.slatitude',
				'attr' => array('readonly' => true)
			))
		->add('elongitude', null, array('label' => 'admin.label.elongitude',
				'attr' => array('readonly' => true)
			))
		->add('wlongitude', null, array('label' => 'admin.label.wlongitude',
				'attr' => array('readonly' => true)
			))
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

}