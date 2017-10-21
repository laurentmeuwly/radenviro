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
		->addIdentifier('name', null, array('label' => 'label.name'))
		->add('siteType.name', 		null, array('label' => 'label.site_type'))
		->add('sorting', 		null, array('label' => 'label.sorting'))
		;
	}
	
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
		->with('General', array('class' => 'col-md-6'))
		->add('translations', TranslationsType::class, [
				'fields' => [
						'name'=> [
								'label' => 'label.name',
						],
						'description' => [
								'field_type' => 'textarea',
								'label' => 'label.description',
								'attr' => ['class' => 'ckeditor']
						]		
				]
				
			])
		->add('hidden', 	null, [ 'label' => 'label.hidden' ])
		->add('sorting', 	null, [ 'label' => 'label.sorting' ])
		->add('latitude', 	null, [ 'label' => 'label.latitude' ])
		->add('longitude', 	null, [ 'label' => 'label.longitude' ])
		->add('zoom', 		null, [ 'label' => 'label.zoom' ])
		->end()
		;
		 
	}
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		
	}
	
}