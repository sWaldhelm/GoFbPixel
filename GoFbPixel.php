<?php
namespace GoFbPixel;

use Shopware\Components\Plugin;
//use Shopware\Components\Plugin\Context\InstallContext;
//use Shopware\Components\Plugin\Context\UninstallContext;

class GoFbPixel extends \Shopware\Components\Plugin
{
    public static function getSubscribedEvents()
    {
        return [
                'Enlight_Controller_Action_PreDispatch_Frontend' => 'preparePlugin',
        ];
    }
    
    public function preparePlugin()
    {
        $this->container->get('Template')->addTemplateDir(
            $this->getPath() . '/Resources/views/'
        );
    }

}
?>