<?php
namespace Mapbox\Models\Request;
use Mapbox\Models\RetrieveMatrix;
use Yandex\Common\Model;
use Mapbox\Exception\PartnerRequestException;
class RetrieveMatrixRequest extends Model
{
    /**
     * Request constants
     */
    const DRIVING = 'mapbox/driving';
    const WALKING = 'mapbox/walking';
    const CYCLING = 'mapbox/cycling';
    const TRAFFIC = 'mapbox/driving-traffic';
    
    protected $profile = self::DRIVING;
    protected $coordinates;

    protected $annotations;
    protected $approaches;
    protected $destinations;
    protected $fallback_speed;
    protected $sources;    

    /**
     * @return string
     */
    public function getProfile()
    {
        return $this->profile;
    }
    /**
     * @return array
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * @param string $profile
     *
     * @return RetrieveMatrixRequest
     */
    public function setProfile($profile)
    {
        switch ($profile) {
            case self::WALKING:
                $this->profile = self::WALKING;
            case self::CYCLING:
                $this->profile = self::CYCLING;
            case self::TRAFFIC:
                $this->profile = self::TRAFFIC;
            case self::DRIVING:
                $this->profile = self::DRIVING;
            default:
                throw new PartnerRequestException('Profile value not valid');
        }
        return $this;
    }
    /**
     * @param double $longitude
     * @param double $latitude
     *
     * @return RetrieveMatrixRequest
     */
    public function addCoordinates($longitude, $latitude)
    {
        $this->coordinates[] = array($longitude, $latitude);
        return $this;
    }    

    /**
     * Returns URL-encoded query string
     *
     * @param string $prefix
     * @param string $argSeparator
     *
     * @return string $queryString
     */
    public function buildQueryString($prefix = '', $argSeparator = '&')
    {
        /*$encType = PHP_QUERY_RFC3986;
        foreach ($queryData as $key => &$value) {
            if (!is_scalar($value)) {
                $value = implode(',', $value);
            }
        }
        $queryString = http_build_query($queryData, $prefix, $argSeparator, $encType);*/        
        $coordinatesList = array();
        foreach ($this->coordinates as $value) {
            $coordinatesList[] = implode(',', $value);
        }        
        $queryString = $this->profile.'/'.implode(';', $coordinatesList);
        return $queryString;
    }

    public function optionalEmpty()
    {
        return true;
    }
}