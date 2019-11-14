<?php
namespace Mapbox\Models\Request;
use Mapbox\Models\RetrieveDirections;
use Mapbox\Models\RequestPoint;
use Yandex\Common\Model;
use Mapbox\Exception\PartnerRequestException;
class RetrieveDirectionsRequest extends Model
{
    /**
     * Request constants
     */
    const ENCTYPE = PHP_QUERY_RFC3986;   
    const DRIVING = 'mapbox/driving';
    const WALKING = 'mapbox/walking';
    const CYCLING = 'mapbox/cycling';
    const TRAFFIC = 'mapbox/driving-traffic';
  
    protected $profile = self::DRIVING;

    protected $alternatives = false;
    protected $continue_straight = false;
    //duration, distance, speed, and congestion
    protected $annotations;


    const DURATION = 'duration';
    const DISTANCE = 'distance';
    const BOTHANNOTATIONS = 'duration,distance';
    protected $requestPoints = null;

    protected $fallbackSpeed = null;

    protected $mappingOptionals = array(
        'alternatives'
    );

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
    public function getRequestPoints()
    {
        return $this->requestPoints;
    }
    /**
     * @return string
     */
    public function getAnnotations()
    {
        return $this->annotations;
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
     * @param string $annotations
     *
     * @return RetrieveMatrixRequest
     */
    public function setAnnotations($annotations)
    {
        switch ($annotations) {
            case self::DURATION:
                $this->annotations = self::DURATION;
            case self::DISTANCE:
                $this->annotations = self::DISTANCE;
            case self::BOTHANNOTATIONS:
                $this->annotations = self::BOTHANNOTATIONS;
            default:
                throw new PartnerRequestException('Annotations value not valid');
        }
        return $this;
    }

    /**
     * @param RequestPoint $requestPoint
     *
     * @return RetrieveMatrixRequest
     */
    public function addRequestPoint($requestPoint)
    {
        $this->requestPoints[] = $requestPoint;
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
        $queryData = null;
        $coordinatesList = array();
        foreach ($this->requestPoints as $point) {
            $coordinatesList[] = $point->getLongitude().','.$point->getLatitude();
        }
        $queryString = $this->profile.'/'.implode(';', $coordinatesList);
        $approaches = array_filter(
            $this->requestPoints,
            function ($e) { return isset($e->approaches);}
        );
        if(count($approaches) > 0) {
            $approaches = array_map(
                function ($e) { return $e->getApproaches();},
                $this->requestPoints
            );
            $queryData['approaches'] = implode(';', $approaches);
        }
        $destinations = array_filter(
            $this->requestPoints,
            function ($e) { return isset($e->destinations);}
        );
        if(count($destinations) > 0)
            $queryData['destinations'] = implode(';', array_keys($destinations));
        
        $sources = array_filter(
            $this->requestPoints,
            function ($e) { return isset($e->sources);}
        );
        if(count($sources) > 0)
            $queryData['sources'] = implode(';', array_keys($sources));

        foreach ($this->mappingOptionals as $key => $propertyName) {
            if(isset($this->{$propertyName})) {
                if (is_scalar($this->{$propertyName})) {
                    $queryData[$propertyName] = $this->{$propertyName};
                } else {
                    $queryData[$propertyName] = implode(',', $this->{$propertyName});
                }
            }
        }
        $queryString .= '?';
        if(isset($queryData))
            $queryString .= http_build_query($queryData, $prefix, $argSeparator, $self::ENCTYPE);
        return $queryString;
    }
}