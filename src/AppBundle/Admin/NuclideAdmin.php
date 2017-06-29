<?php 
// src/AppBudle/Admin/NuclideAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

class NuclideAdmin extends AbstractAdmin
{
	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
		->addIdentifier('code')
		->add('name')
		->add('hidden', 'boolean', array('editable' => true))
		/*->add('_action', null, array(
				'actions' => array(
						'show' => array(),
						'edit' => array(),
						'delete' => array(),
				)
		))*/
		;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
		->with('Nuclide', array('class' => 'col-md-6'))
		->add('code')
		->add('translations', TranslationsType::class)
		->add('hidden')
		->end()
		;
	}
}