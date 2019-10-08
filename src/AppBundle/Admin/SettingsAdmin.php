<?php 
# src/AppBudle/Admin/SettingsAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;


class SettingsAdmin extends AbstractAdmin
{	
	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
		->addIdentifier('id')
		->add('_action', 'actions', array(
				'actions' => array(
						'edit' => array(),
				)
			))
		;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
		->with('Informations', array('class' => 'col-md-9', 'label' => 'admin.label.informations'))
			->add('translations', TranslationsType::class, array(
					'label' => false,
					'fields' => array(
							'mobileMsg'=> array('field_type' => 'ckeditor', 'label' => 'admin.network.mobilemsg')
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
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		
	}
	
}