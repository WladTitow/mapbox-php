<?php
namespace Mapbox\Clients\Navigation;
use Mapbox\Models\Response\GetRetrieveMatrixResponse;
use Mapbox\Models\Request\RetrieveDirectionsRequest;
use Mapbox\Models\RetrieveDirections;

class RetrieveDirectionsClient extends Client
{
    /**
     * API domain
     *
     * @var string
     */
    protected $serviceDomain = 'api.mapbox.com/directions';
    /**
     * Requested version of API
     *
     * @var string
     */
    private $version = 'v5';
    /**
     * Retrieve directions between waypoints. 
     * Directions requests must specify at least two waypoints as starting and ending points.
     *
     * @see https://docs.mapbox.com/api/navigation/#directions
     *
     * @param RetrieveDirectionsRequest $request
     *
     * @return Stats
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Yandex\Common\Exception\ForbiddenException
     * @throws \Yandex\Common\Exception\UnauthorizedException
     * @throws \Mapbox\Exception\PartnerRequestException
     */
    public function getRetrieveDirections(RetrieveDirectionsRequest $request)
    {
        $resource = $request->buildQueryString();        
        $resource .= '&access_token='.$this->getAccessToken();
        return $this->getRetrieveDirectionsResponse($resource);
    }
    /**
     * @param string $resource
     *
     * @return RetrieveDirections
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Yandex\Common\Exception\ForbiddenException
     * @throws \Yandex\Common\Exception\UnauthorizedException
     * @throws \Mapbox\Exception\PartnerRequestException
     */
    private function getRetrieveDirectionsResponse($resource)
    {
        $response = $this->sendRequest('GET', $this->getServiceUrl($resource));
        $decodedResponseBody = $this->getDecodedBody($response->getBody());
        return new RetrieveDirections($decodedResponseBody);
    }
}