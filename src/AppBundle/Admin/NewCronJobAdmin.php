<?php

namespace AppBundle\Admin;

//use Sonata\AdminBundle\Admin\AbstractAdmin;
use Shapecode\Bundle\CronBundle\Admin\CronjobAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
/**
 * Class NewCronjobAdmin
 *
 * @package Shapecode\Bundle\CronBundle\Admin
 * @author  Nikita Loges
 */
class NewCronJobAdmin extends CronjobAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('create');
        $collection->remove('edit');
        $collection->remove('delete');
    }
}