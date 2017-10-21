<?php 
// src/AppBudle/Admin/SiteTypeAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

class SiteTypeAdmin extends AbstractAdmin
{
	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
		->addIdentifier('name')
		->add('color')
		->add('hidden')
		;
	}
	
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
		->with('General', array('class' => 'col-md-6'))
		->add('translations', TranslationsType::class)
		->add('hidden')
		->add('sorting')
		->add('color')
		->end()
		;
	}
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
	
	}
	
}