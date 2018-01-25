<?php 
// src/AppBudle/Admin/PredefinedNuclideListAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Form\Type\ModelListType;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sonata\AdminBundle\Route\RouteCollection;

class PredefinedNuclideListAdmin extends AbstractAdmin
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
		->addIdentifier('name', null, array('label' => 'admin.predefinednuclidelist.name'))
		->add('_active', 'boolean', array('label' => 'admin.label.active',
				'editable' => true,
				'header_style' => 'text-align: center',
				'row_align' => 'center')
				)
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
		// NEXT_MAJOR: Keep FQCN when bumping Symfony requirement to 2.8+.
		/*$collectionType = method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')
		? 'Sonata\CoreBundle\Form\Type\CollectionType'
				: 'sonata_type_collection';*/
				
				
		$formMapper
		->with('General', array('class' => 'col-md-6', 'label' => 'admin.label.general'))
		->add('name', 	null, [ 'label' => 'admin.predefinednuclidelist.name' ])
		->end()
		
		->with('Attributs', array('class' => 'col-md-3', 'label' => 'admin.label.attributs'))
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
		
		->with('Nuclides', array('class' => 'col-md-6', 'label' => 'admin.predefinednuclidelist.nuclides'))
		//->add('nuclides', null, array('multiple'=>true, 'expanded'=>true, 'mapped'=>true))
		//->add('nuclides', null, array('label' => 'nuclides', 'expanded' => true, 'by_reference' => true, 'multiple' => true))
		
		/*->add('nuclides', ModelListType::class, array(
				'class'    => 'AppBundle\Entity\PredefinedNuclideListNuclide',
		))*/
		//->add('nuclides',null,array('required'=>false,'mapped'=>false))//Custom fields
		
		/*->add('nuclides', ModelType::class, array(
				'multiple' => true,   // Multiple selection allowed
				'expanded' => true,   // Render as checkboxes
				//'property' => 'name', // Assuming that the entity has a "name" property
				'class'    => 'AppBundle\Entity\Nuclide',
		))*/
		
				
		// ok n'affiche que les éléments de la liste concernée. Mais édition pas exploitable
		->add('nuclides', CollectionType::class, [], [
				'edit' => 'inline',
				'inline' => 'table',
				'sortable' => 'position',
				//'link_parameters' => ['context' => $context],
				//'admin_code' => 'sonata.media.admin.gallery_has_media',
				//'admin_code' => 'appbundle.admin.predefinednuclidelistnuclideadmin',
		])
		->end()
		;
		 
	}
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		
	}
	
}