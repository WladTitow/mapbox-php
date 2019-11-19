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
     * @return Waypoints
     */
    public function getWaypoints()
    {
        return $this->waypoints;
    }
    /**
     * @return Routes
     */
    public function getRoutes()
    {
        return $this->routes;
    } 
}