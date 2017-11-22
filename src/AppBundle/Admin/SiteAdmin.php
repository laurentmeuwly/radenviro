<?php 
// src/AppBudle/Admin/SiteAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

class SiteAdmin extends AbstractAdmin
{	
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
		->add('position', 		null, array('label' => 'admin.label.sorting'))
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
								'field_type' => 'textarea',
								'label' => 'admin.label.description',
								'attr' => ['class' => 'ckeditor']
						]		
				]
				
			])
		->end()
		
		->with('Attributs', array('class' => 'col-md-3', 'label' => 'admin.label.attributs'))
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
		;
		 
	}
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		
	}
	
}