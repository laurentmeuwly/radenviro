<?php 
// src/AppBudle/Admin/PredefinedNuclideListAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sonata\AdminBundle\Route\RouteCollection;

class PredefinedNuclideListNuclideAdmin extends AbstractAdmin
{	
	protected $datagridValues = array(
			'_sort_order' => 'ASC',
			'_sort_by' => 'position'
	);
	
	protected function configureRoutes(RouteCollection $collection)
	{
		$collection->add('move', $this->getRouterIdParameter().'/move/{position}');
	}
	
	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
		->add('nuclide')
		->add('_position', 'actions', array(
				'actions' => array(
				'move' => array(
						'template' => 'PixSortableBehaviorBundle:Default:_sort.html.twig'
						)
				)
		))
		;
	}
	
	protected function configureFormFields(FormMapper $formMapper)
	{
		
		$formMapper
		->add('nuclide', 'sonata_type_model_list', [
                   'required'      => true,
                   'btn_add'       => false,
                   'btn_list'      => 'name_of_list_button',
                   'btn_delete'    => false,     
                   'btn_catalogue' => 'admin', 
                   'label'         => 'name_of_your_label',
               ])
		;
		 
	}
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		
	}
	
}