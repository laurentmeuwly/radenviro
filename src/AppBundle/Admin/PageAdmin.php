<?php 
# src/AppBudle/Admin/PageAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

class PageAdmin extends AbstractAdmin
{
	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
		->addIdentifier('code', null, array('label' => 'admin.page.code'))
		->add('title', null, array('label' => 'admin.page.title'))
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
		->with('General', array('class' => 'col-md-3', 'label' => 'admin.label.general'))
		->add('code')
		->end()
		->with('Informations', array('class' => 'col-md-6', 'label' => 'admin.label.informations'))
		->add('translations', TranslationsType::class, array(
				'label' => false,
				'fields' => array(
						'title'=> array('label' => 'admin.page.title'),
						'content'=> array('label' => 'admin.page.content')
				)
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