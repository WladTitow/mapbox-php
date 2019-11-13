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
     * @return double 
     */
    public function getLongitude()
    {
        return $this->location[0];
    }
    /**
     * @return double
     */
    public function getLatitude()
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