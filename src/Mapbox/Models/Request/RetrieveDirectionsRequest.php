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
    protected $requestPoints = null;
    /**
     * Whether to try to return alternative routes (true) or not (false, default)
     */
    protected $alternatives = false;

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
     * @return bool
     */
    public function getAlternatives()
    {
        return $this->alternatives;
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