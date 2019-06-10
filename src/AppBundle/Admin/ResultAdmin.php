<?php 
// src/AppBudle/Admin/ResultAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Sonata\CoreBundle\Form\Type\DateTimeRangePickerType;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

class ResultAdmin extends AbstractAdmin
{
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        unset($this->listModes['mosaic']);
         
        
    }
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        
    }
}