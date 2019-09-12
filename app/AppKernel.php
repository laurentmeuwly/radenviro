<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
        	
        	new AppBundle\AppBundle(),
        	
        	// Symfony standard edition
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
        	new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
        	new Symfony\Bundle\AsseticBundle\AsseticBundle(),
        	
        	// Doctrine
        	new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
                    	
        	// KNP Helper
        	new Knp\Bundle\MenuBundle\KnpMenuBundle(),
        	new Knp\Bundle\MarkdownBundle\KnpMarkdownBundle(),
        	// new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
        	new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
        	new Knp\DoctrineBehaviors\Bundle\DoctrineBehaviorsBundle(),
        	
        	// Sonata feature
        	new FOS\UserBundle\FOSUserBundle(),
        	new Sonata\UserBundle\SonataUserBundle('FOSUserBundle'),
        	new Application\Sonata\UserBundle\ApplicationSonataUserBundle(),
        	new Application\Sonata\MediaBundle\ApplicationSonataMediaBundle(),
        	// new Sonata\PageBundle\SonataPageBundle(),
        	// new Sonata\NewsBundle\SonataNewsBundle(),
        	new Sonata\MediaBundle\SonataMediaBundle(),
        	new Sonata\TranslationBundle\SonataTranslationBundle(),
        		     
        	new CoopTilleuls\Bundle\CKEditorSonataMediaBundle\CoopTilleulsCKEditorSonataMediaBundle(),
            new FOS\CKEditorBundle\FOSCKEditorBundle(),
            
        	new Sonata\AdminBundle\SonataAdminBundle(),
        	new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
        	
        	
            // Sonata foundation
        	new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
        	new Sonata\CoreBundle\SonataCoreBundle(),
        	// new Sonata\IntlBundle\SonataIntlBundle(),
        	new Sonata\FormatterBundle\SonataFormatterBundle(),
        	// new Sonata\CacheBundle\SonataCacheBundle(),
        	new Sonata\BlockBundle\SonataBlockBundle(),
        	// new Sonata\SeoBundle\SonataSeoBundle(),
        	// new Sonata\ClassificationBundle\SonataClassificationBundle(),
        	// new Sonata\NotificationBundle\SonataNotificationBundle(),
        	// new Sonata\DatagridBundle\SonataDatagridBundle(),
        		
        		
        	//new A2lix\AutoFormBundle\A2lixAutoFormBundle(),
        	new A2lix\TranslationFormBundle\A2lixTranslationFormBundle(),
        		
        	new Pix\SortableBehaviorBundle\PixSortableBehaviorBundle(),
        	new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),	
        	//new Braincrafted\Bundle\BootstrapBundle\BraincraftedBootstrapBundle(),
        	new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
        	
        	new APY\DataGridBundle\APYDataGridBundle(),
        	new Sg\DatatablesBundle\SgDatatablesBundle(),
        	new Waldo\DatatableBundle\WaldoDatatableBundle(),
        		
        	new Xmon\ColorPickerTypeBundle\XmonColorPickerTypeBundle(),
        		
        	new Ivory\GoogleMapBundle\IvoryGoogleMapBundle(),
        		
			new Shapecode\Bundle\CronBundle\ShapecodeCronBundle(),

			new Omines\DataTablesBundle\DataTablesBundle(),	

			new SunCat\MobileDetectBundle\MobileDetectBundle(),
        	
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
			$bundles[] = new Symfony\Bundle\WebServerBundle\WebServerBundle();
			//$bundles[] = new Sidus\DoctrineDebugBundle\SidusDoctrineDebugBundle();
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
