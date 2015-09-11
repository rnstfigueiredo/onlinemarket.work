<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        //laboratorio M3Ex1
        /* item 2
        In the onBootstrap() method, at the end, attach a listener with the following
        characteristics:
          • Listens For: the " MvcEvent::EVENT_DISPATCH " event
          • Context: current object ==> pode ser $this
          • Handler: onDispatch
          • Priority: 100
        */
        //http://framework.zend.com/manual/current/en/modules/zend.mvc.mvc-event.html
        //Name: dispatch ===>Constant: MvcEvent::EVENT_DISPATCH
        $eventManager->attach(MvcEvent::EVENT_DISPATCH,array($this, "onDispatch"), 100);
    }

    //laboratorio M3Ex1
    /* 3. Define method onDispatch(), which accepts an MvcEvent as an argument.
    */
    public function onDispatch(MvcEvent $mvce)
    {
       //M4Ex1
       // $sm == ServiceMeneger
       $sm = $mvce->getApplication()->getServiceManager(); 
       $categorias = $sm->get("categorias");


        //laboratorio M3Ex1
        /*5. In the onDispatch() method, use the setVariable() method of the view model
        * (Zend\View\Model\ViewModel) to assign a value of CATEGORY LIST to a variable
        * categories
        */
       //$ListaCategoria = "CATEGORY LIST"; M3Ex1
       $viewModel = $mvce->getViewModel();
       //$viewModel->setVariable('categoria', $ListaCategoria);  //M3Ex1
       
       $viewModel->setVariable("categorias", $categorias);  // versao lab M4Ex1


    }


    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
