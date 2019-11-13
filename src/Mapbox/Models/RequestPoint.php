<?php
namespace Mapbox\Models;
use Yandex\Common\Model;
class RequestPoint extends Model
{
    protected $longitude;
    protected $latitude;

    protected $approaches = null;
    protected $destinations = null;
    protected $sources = null;

    protected $propNameMap = array(
        'longitude',
        'latitude',
        'approaches',
        'destinations',
        'sources'
    );
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
     * @return string
     */
    public function getApproaches()
    {
        if(isset($this->approaches))
            return $this->approaches;
        return '';
    }
}