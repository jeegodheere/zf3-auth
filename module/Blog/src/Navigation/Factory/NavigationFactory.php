<?php
/**
 * Created by PhpStorm.
 * User: Mid
 * Date: 13/10/2016
 * Time: 11:44
 */

namespace Blog\Navigation\Factory;


use Zend\Navigation\Service\DefaultNavigationFactory;

class NavigationFactory extends DefaultNavigationFactory
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'navigation-example';
    }

}