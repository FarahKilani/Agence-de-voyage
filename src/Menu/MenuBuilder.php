<?php

// src/AppBundle/Menu/Builder.php
namespace App\Menu;

use Knp\Menu\FactoryInterface;
// use Symfony\Component\DependencyInjection\ContainerAwareInterface;
// use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * MenuBuilder en tant que service (cf. http://symfony.com/doc/master/bundles/KnpMenuBundle/menu_builder_service.html)
 *
 */
class MenuBuilder
{
    private $factory;
    private $container;
    
    /**
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     */
    public function __construct(FactoryInterface $factory, Container $container)
    {
        $this->factory = $factory;
        $this->container = $container;
    }
    
    public function createMainMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        
        $menu->addChild('Home', array('route' => 'frontoffice_home'))
        ->setAttributes(array(
            'class' => 'nav-link',
            'icon' => 'fa fa-list'
        ));
        // ... add more children
        
        $menu->addChild('Circuits Programmes', array('route' => 'circuitsprogrammes'))
        ->setAttributes(array('class' => 'nav-link'));
        
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
        
            $menu->addChild('Circuits-admin', array('route' => 'admin_circuit_index'))
            ->setAttributes(array('class' => 'nav-link'));
        }
                
        if (!$this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            
            $menu->addChild('Login', array('route' => 'fos_user_security_login'))
            ->setAttributes(array('class' => 'nav-link'));
            
        } else {
            $menu->addChild('Logout', array('route' => 'fos_user_security_logout'))
            ->setAttributes(array('class' => 'nav-link'));
            
            
        }
       
        
       /* $menu->addChild('Likes', array('route' => 'front_like'))
        ->setAttributes(array('class' => 'nav-link'));*/
        
        return $menu;
    }
    
    public function createUserMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav  ml-auto');
        
        //if($this->container->get('security.context')->isGranted(array('ROLE_ADMIN', 'ROLE_USER'))) {} // Check if the visitor has any authenticated roles
        if($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            // Get username of the current logged in user
            $username = $this->container->get('security.token_storage')->getToken()->getUser()->getUsername();
            $label = 'Hi '. $username;
        }
        else
        {
            $label = 'Hi visitor';
        }
        $menu->addChild('User', array('label' => $label))
        ->setAttribute('dropdown', true)
        ->setAttribute('icon', 'fa fa-user');
        
        return $menu;
    }
    
}
