<?php
namespace Mapbox\Models;
use Yandex\Common\ObjectModel;
class Routes extends ObjectModel
{
    /**
     * @param array|object $route
     *
     * @return Routes
     */
    public function add($route)
    {
        if (is_array($route)) {
            $this->collection[] = new Route($route);
        } elseif (is_object($route) && $route instanceof Route) {
            $this->collection[] = $route;
        }
        return $this;
    }
    /**
     * Get items
     *
     * @return Route[]
     */
    public function getAll()
    {
        return $this->collection;
    }
    /**
     * @return Route
     */
    public function current()
    {
        return parent::current();
    }
}