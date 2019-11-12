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
    const ENCTYPE = PHP_QUERY_RFC3986;   
    const DRIVING = 'mapbox/driving';
    const WALKING = 'mapbox/walking';
    const CYCLING = 'mapbox/cycling';
    const TRAFFIC = 'mapbox/driving-traffic';

    const DURATION = 'duration';
    const DISTANCE = 'distance';
    const BOTHANNOTATIONS = 'duration,distance';

    
    protected $profile = self::DRIVING;
    protected $coordinates;

    protected $annotations = self::DURATION;
    protected $approaches;
    protected $destinations;
    protected $fallback_speed;
    protected $sources;    

    protected $mappingOptionals = array(
        'annotations'
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
    public function getCoordinates()
    {
        return $this->coordinates;
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
        $coordinatesList = array();
        foreach ($this->coordinates as $value) {
            $coordinatesList[] = implode(',', $value);
        }        
        $queryString = $this->profile.'/'.implode(';', $coordinatesList);

        $queryData = array();
        foreach ($this->mappingOptionals as $key => $propertyName) {
            if (is_scalar($this->{$propertyName})) {
                $queryData[$propertyName] = $this->{$propertyName};
            } else {
                $queryData[$propertyName] = implode(',', $this->{$propertyName});
            }
        }
        $queryString .= '?'.http_build_query($queryData, $prefix, $argSeparator, $self::ENCTYPE);
        return $queryString;
    }
}