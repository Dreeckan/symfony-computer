<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class Builder
{
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Accueil', ['route' => 'default_index']);
        $menu->addChild('Computers', ['route' => 'computer_index']);
        $menu->addChild('Components', ['route' => 'component_index']);
        $menu->addChild('Devices', ['route' => 'device_index']);

        return $menu;
    }
}