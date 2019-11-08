<?php
namespace Mapbox\Models;
use Yandex\Common\ObjectModel;
class Waypoints extends ObjectModel
{
    /**
     * @param array|object $waypoint
     *
     * @return Waypoints
     */
    public function add($waypoint)
    {
        if (is_array($waypoint)) {
            $this->collection[] = new Waypoint($waypoint);
        } elseif (is_object($waypoint) && $waypoint instanceof Waypoint) {
            $this->collection[] = $waypoint;
        }
        return $this;
    }
    /**
     * Get items
     *
     * @return Waypoint[]
     */
    public function getAll()
    {
        return $this->collection;
    }
    /**
     * @return Waypoint
     */
    public function current()
    {
        return parent::current();
    }
}