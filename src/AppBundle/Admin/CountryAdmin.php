<?php 
# src/AppBudle/Admin/BagCodeAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

class CountryAdmin extends AbstractAdmin
{
	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->addIdentifier('code')
			->add('name')
			
		;
	}
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
			->add('code')
			
		;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
		->with('Country', array('class' => 'col-md-6'))
		->add('code')
		->add('translations', TranslationsType::class)
		->end()
		;
	}
	
}