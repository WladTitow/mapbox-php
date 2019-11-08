<?php
namespace Mapbox\Models;
use Yandex\Common\Model;
class Waypoint extends Model
{
    protected $name;
    protected $location;
    protected $distance;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @return array
     */
    public function getLocation()
    {
        return $this->location;
    }
    /**
     * longitude
     * @return double 
     */
    public function getLocationX()
    {
        return $this->location[0];
    }
    /**
     * latitude
     * @return double
     */
    public function getLocationY()
    {
        return $this->location[1];
    }
    /**
     * @return double
     */
    public function getDistance()
    {
        return $this->distance;
    }
}