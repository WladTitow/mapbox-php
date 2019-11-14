<?php
namespace Mapbox\Clients\Navigation;
use Mapbox\Models\Response\GetRetrieveMatrixResponse;
use Mapbox\Models\Request\RetrieveMatrixRequest;
use Mapbox\Models\RetrieveMatrix;

class RetrieveMatrixClient extends Client
{
    /**
     * API domain
     *
     * @var string
     */
    protected $serviceDomain = 'api.mapbox.com/directions-matrix';
    /**
     * The Mapbox Matrix API returns travel times between many points.
     *
     * @see https://docs.mapbox.com/api/navigation/#matrix
     *
     * @param RetrieveMatrixRequest $request
     *
     * @return Stats
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Yandex\Common\Exception\ForbiddenException
     * @throws \Yandex\Common\Exception\UnauthorizedException
     * @throws \Mapbox\Exception\PartnerRequestException
     */
    public function getRetrieveMatrix(RetrieveMatrixRequest $request)
    {
        $resource = $request->buildQueryString();        
        $resource .= '&access_token='.$this->getAccessToken();
        return $this->getRetrieveMatrixResponse($resource);
    }
    /**
     * @param string $resource
     *
     * @return RetrieveMatrix
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Yandex\Common\Exception\ForbiddenException
     * @throws \Yandex\Common\Exception\UnauthorizedException
     * @throws \Mapbox\Exception\PartnerRequestException
     */
    private function getRetrieveMatrixResponse($resource)
    {
        $response = $this->sendRequest('GET', $this->getServiceUrl($resource));
        $decodedResponseBody = $this->getDecodedBody($response->getBody());
        return new RetrieveMatrix($decodedResponseBody);
    }
}