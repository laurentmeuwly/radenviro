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
			->addIdentifier('code')
			->add('name')
			->add('network.name')
			->add('stationType.code')
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
		->with('General', array('class' => 'col-md-6'))
			->add('code')
		->end()
		->with('Descriptions', array('class' => 'col-md-12'))
			->add('translations', TranslationsType::class)
		->end()
		;
	}
	
}