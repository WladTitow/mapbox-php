<?php
namespace Mapbox\Models;
use Yandex\Common\Model;
class RequestPoint extends Model
{
    const CURB = 'curb';

    protected $longitude;
    protected $latitude;

    protected $approaches = '';
    protected $destinations = false;
    protected $sources = false;

    /**
     * @return double 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
    /**
     * @return double
     */
    public function getLatitude()
    {
        return $this->latitude;
    }
    /**
     * @return double
     */
    public function getDestinations()
    {
        return $this->destinations;
    }
    /**
     * @return double
     */
    public function getSources()
    {
        return $this->sources;
    }
    /**
     * @return string
     */
    public function getApproaches()
    {
        if(isset($this->approaches))
            return $this->approaches;
        return '';
    }
}