<?php 
// src/AppBudle/Admin/NetworkCategoryAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

class NetworkCategoryAdmin extends AbstractAdmin
{
	protected $translationDomain = 'AppBundle';
	
	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
		->addIdentifier('name', null, array('label' => 'label.name'))
		->add('hidden', 'boolean', array('editable' => true))
		;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
		->with('Category', array('class' => 'col-md-6'))
		->add('translations', TranslationsType::class)
		->add('hidden')
		->end()
		;
	}
}