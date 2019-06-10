<?php
// src/AppBundle/EventListener/MenuBuilderListener.php

namespace AppBundle\EventListener;

use Sonata\AdminBundle\Event\ConfigureMenuEvent;

class MenuBuilderListener
{
    public function addMenuItems(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();
        
        $child = $menu->addChild('sync', [
            'label' => 'menu.synchronisation',
            //'route' => 'admin_dashboard',
        	//'route' => 'app_reports_index',
        ])->setExtras([
            'icon' => '<i class="fa fa-bar-chart"></i>',
        ]);
        
        /*$child = $menu['sync']->addChild('trad', [
            'label' => 'Traductions',
            'route' => 'translation_index',
        ]);*/
        
        $child = $menu['sync']->addChild('clean', [
        		'label' => 'Supprimer données',
        		//'route' => 'clean_measurements',
        		'route' => 'admin_app_sample_list',
        ]);
        
       /* $child = $menu['sync']->addChild('envira', [
        		'label' => 'Envira',
        		'route' => 'syncenvira',
        ]);*/

        $child = $menu['sync']->addChild('cron', [
            'label' => 'cronJob',
            'route' => 'admin_shapecode_cron_cronjob_list',
        ]);
    }
}