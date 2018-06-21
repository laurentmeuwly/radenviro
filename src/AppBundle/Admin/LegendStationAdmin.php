<?php 
// src/AppBudle/Admin/LegendStationAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

class LegendStationAdmin extends AbstractAdmin
{
	protected $parentAssociationMapping = 'legend'; // This does the trick..
	
	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
		->add('station')
		->add('position')
		;
		
		/*if (!$this->isChild()) {
			$formMapper->add('legend'); // Just add the legend dropdown, if you are NOT in legend-context
		}*/
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
		//->add('legend', 'sonata_type_model', ['required' => false])
		->add('station', 'sonata_type_model_list', ['btn_add'       => false, 'required' => false], [])
		//->add('station')
		//->add('station', null, array('multiple'=>true, 'expanded'=>true, 'mapped'=>true))
		//->add('position')
		->add('position', 'hidden')
		;
	}
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
		->add('legend', null, ['label' => 'admin.legend.name'], 'entity', [
				'class' => 'AppBundle\Entity\Legend'
		])
		;
	}
}