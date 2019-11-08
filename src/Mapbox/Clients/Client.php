<?php
namespace Mapbox\Clients;
use GuzzleHttp\Exception\ClientException;
use Yandex\Common\AbstractServiceClient;
use Yandex\Common\Exception\ForbiddenException;
use Yandex\Common\Exception\UnauthorizedException;
use Mapbox\Exception\PartnerRequestException;

class Client extends AbstractServiceClient
{
    /**
     * API domain
     *
     * @var string
     */
    protected $serviceDomain = 'api.mapbox.com';
    /**
     * Requested version of API
     *
     * @var string
     */
    private $version = 'v1';
    /**
     * Application ID
     *
     * @var string
     */
    private $clientId;
    /**
     * @param string $token access token
     */
    /**
     * @var string
     */
    protected $libraryName = 'mapbox-php-library';

    public function __construct($clientId = '', $token = '')
    {
        $this->setAccessToken($token);
        $this->setClientId($clientId);
    }
    /**
     * @param array|null $headers
     * @return ClientInterface
     */
    protected function getClient($headers = null)
    {
        if ($this->client === null) {
            $defaultOptions = [
                'base_uri' => $this->getServiceUrl(),
                'headers' => [                    
                    'Host' => $this->getServiceDomain(),
                    'User-Agent' => $this->getUserAgent(),
                    'Accept' => '*/*',
                ],
            ];
            if ($headers && is_array($headers)) {
                $defaultOptions["headers"] += $headers;
            }
            if ($this->getProxy()) {
                $defaultOptions['proxy'] = $this->getProxy();
            }
            if ($this->getDebug()) {
                $defaultOptions['debug'] = $this->getDebug();
            }
            $this->client = new Client($defaultOptions);
        }
        return $this->client;
    }
    /**
     * Get url to service resource with parameters
     *
     * @param string $resource
     *
     * @return string
     */
    public function getServiceUrl($resource = '')
    {
        return $this->serviceScheme . '://' . $this->serviceDomain . '/' . $this->version . '/' . $resource;        
    }
    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }
    /**
     * @param string $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }
    /**
     * Sends a request
     *
     * @param string $method  HTTP method
     * @param string $uri     URI object or string.
     * @param array  $options Request options to apply.
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws ForbiddenException
     * @throws UnauthorizedException
     * @throws PartnerRequestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function sendRequest($method, $uri, array $options = [])
    {
        try {
            $response = $this->getClient()->request($method, $uri, $options);
        } catch (ClientException $ex) {
            $result = $ex->getResponse();
            $code = $result->getStatusCode();
            $message = $result->getReasonPhrase();
            $body = $result->getBody();
            if ($body) {
                $jsonBody = json_decode($body);
                if ($jsonBody && isset($jsonBody->error) && isset($jsonBody->error->message)) {
                    $message = $jsonBody->error->message;
                }
            }
            if ($code === 403) {
                throw new ForbiddenException($message);
            }
            if ($code === 401) {
                throw new UnauthorizedException($message);
            }
            throw new PartnerRequestException(
                'Service responded with error code: "' . $code . '" and message: "' . $message . '"',
                $code
            );
        }
        return $response;
    }
}