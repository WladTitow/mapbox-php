<?php
namespace Mapbox\Models;
use Yandex\Common\Model;
/**
 * Class Navigation
 *
 * @package Mapbox\Models
 */
class RetrieveDirections extends Model
{
    protected $code;
    protected $waypoints;
    protected $routes;
    protected $mappingClasses = [
        'waypoints' => Waypoints::class,
        'routes' => Routes::class
    ];
    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
    /**
     * @return array
     */
    public function getDurations()
    {
        return $this->durations;
    }
    /**
     * @return array
     */
    public function getDistances()
    {
        return $this->distances;
    }
    /**
     * @return Waypoints
     */
    public function getSources()
    {
        return $this->sources;
    }
    /**
     * @return Waypoints
     */
    public function getDestinations()
    {
        return $this->destinations;
    }    
}