<?php

namespace Keet\Mvc\Controller;

use Zend\Mvc\Controller\AbstractActionController as ZendAbstractActionController;

abstract class AbstractActionController extends ZendAbstractActionController
{
    /**
     * Redirect to a route, or pass the url to the view for a javascript redirect
     *
     * @return mixed|\Zend\Http\Response
     */
    public function redirectToRoute()
    {
        if ($this->getRequest()
                 ->isXmlHttpRequest()) {
            return [
                'redirect' => call_user_func_array(
                    [
                        $this->url(),
                        'fromRoute',
                    ],
                    func_get_args()
                ),
            ];
        }

        return call_user_func_array(
            [
                $this->redirect(),
                'toRoute',
            ],
            func_get_args()
        );
    }

    /**
     * Gets all Trait's used by class and parent classes, see comments @link http://php.net/class_uses
     *
     * @param      $class
     * @param bool $autoload
     *
     * @return array
     */
    protected function givenClassAndParentTraits($class, $autoload = true)
    {
        $traits = [];

        // Get traits of all parent classes
        while ($class = get_parent_class($class)) {
            $traits = array_merge(class_uses($class, $autoload), $traits);
        };

        // Get traits of all parent traits
        $traitsToSearch = $traits;
        while ( ! empty($traitsToSearch)) {
            $newTraits = class_uses(array_pop($traitsToSearch), $autoload);
            $traits = array_merge($newTraits, $traits);
            $traitsToSearch = array_merge($newTraits, $traitsToSearch);
        };

        foreach ($traits as $trait => $same) {
            $traits = array_merge(class_uses($trait, $autoload), $traits);
        }

        return array_unique($traits);
    }
}