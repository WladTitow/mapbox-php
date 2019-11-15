<?php
namespace Mapbox\Models;
use Yandex\Common\Model;
class Route extends Model
{
    /**
     * A float indicating the estimated travel time through the waypoints in seconds.
     */
    protected $duration;
    /**
     * A float indicating the distance traveled through the waypoints in meters.
     */
    protected $distance;
    /**
     * A float indicating the distance traveled through the waypoints in meters.
     */    
    protected $legs;
    /*protected $mappingClasses = [
        'legs' => RouteLegs::class,
    ];*/
    /**
     * A string indicating which weight was used. 
     */        
    protected $weightName = 'routability';
    protected $propNameMap = [
        'weight_name' => 'weightName'
    ];
    /**
     * A float indicating the weight in units described by weightName.
     */    
    protected $weight;

    protected $geometry;
    protected $voiceLocale;

    /**
     * @return double
     */
    public function getDuration()
    {
        return $this->duration;
    }
        /**
     * @return double
     */
    public function getDistance()
    {
        return $this->distance;
    }


}