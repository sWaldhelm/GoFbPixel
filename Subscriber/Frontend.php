<?php
namespace GoFbPixel\Subscriber;

use Enlight\Event\SubscriberInterface;

class Frontend implements SubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return  [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Index' => 'onPostDispatchIndex',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Listing' => 'onPostDispatchListing',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Detail' => 'onPostDispatchDetail',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Checkout' => 'onPostDispatchCheckout',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Account' => 'onPostDispatchAccount',
        ];
    }
    
     public function onPostDispatchIndex(\Enlight_Event_EventArgs $args)
    {
         /** @var \Shopware_Controllers_Frontend_Detail $detailController */
        $indexController = $args->getSubject();
        $view = $indexController->View();

        $view->assign('fbBaseCode' , $this->getPageViewTrack());
    }
    
    public function onPostDispatchListing(\Enlight_Event_EventArgs $args)
    {
        $listingController = $args->getSubject();
        $view = $listingController->View();

        $view->assign('fbBaseCode' , $this->getPageViewTrack());
    }
    
    public function onPostDispatchDetail(\Enlight_Event_EventArgs $args)
    {
       $detailController = $args->getSubject();
       $sArticle = $detailController->View()->getAssign('sArticle');
       
       $view = $detailController->View();

       $view->assign('fbBaseCode' , $this->getPageViewTrack());
       $view->assign('fbEventCode', "fbq('track', 'ViewContent', { content_type: 'product', content_ids: ['".$sArticle['ordernumber']."']});");
    }
    
     public function onPostDispatchCheckout(\Enlight_Event_EventArgs $args)
    {
        $checkoutController = $args->getSubject();
        $view = $checkoutController->View();

        $checkoutAction = $this->getAction($checkoutController);

        switch ($action) {
            case cart:
              $fbEventCode = "fbq('track', 'AddToCart', {content_type: 'product', content_ids: ['".$this->getBasketArticles($controller)."']})";
              break;
            case finish:
               $fbEventCode = "fbq('track', 'Purchase', {value: ".$controller->View()->sBasket['sAmount'].", currency: 'EUR'})";
                break;
            default:
                echo "something other";
                echo "<br /><br /><br />";
        }

        $view->assign('fbEventCode' , $fbEventCode);
    }
    
    
    public function onPostDispatchAccount(\Enlight_Event_EventArgs $args)
    {
       // $this->admin = Shopware()->Modules()->Admin();
               
        $accountController = $args->getSubject();
        $view = $accountController->View();
        
        $accountAction = $this->getAction($accountController);
        
        switch ($accountAction) {
            case payment:
                $fbEventCode = "fbq('track', 'AddPaymentInfo')";
        }
        
        $view->assign('fbEventCode' , $fbEventCode);
    }
    
    private function getPageViewTrack()
    {
        return "fbq('track', 'PageView');";
    }
    
    private function getAction($controller)
    {
        return $controller->Request()->getActionName();
    }
    
        private function getBasketArticles($controller)
    {
         $basket = $controller->View()->sBasket;

        $ordernumbers = '';
        foreach ($basket['content'] as $basketItem)
        {
            if(isset($basketItem['ordernumber'])) {
                $ordernumbers .= $basketItem['ordernumber']. ',';
            }
        }
        return $ordernumbers;
    }
    
}