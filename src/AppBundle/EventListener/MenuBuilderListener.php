<?php
// src/AppBundle/EventListener/MenuBuilderListener.php

namespace AppBundle\EventListener;

use Sonata\AdminBundle\Event\ConfigureMenuEvent;

class MenuBuilderListener
{
    public function addMenuItems(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();
        
        $child = $menu->addChild('reports', [
            'label' => 'Rapports quotidiens',
            //'route' => 'admin_dashboard',
        	//'route' => 'app_reports_index',
        ])->setExtras([
            'icon' => '<i class="fa fa-bar-chart"></i>',
        ]);
        
        $child = $menu['reports']->addChild('country', [
        		'label' => 'Pays',
        		'route' => 'admin_app_country_list',
        ]);
    }
}