<?php

namespace DigipolisGent\SockAPIBundle\Service;

use DigipolisGent\SockAPIBundle\JsonModel\ArrayMappable;
use DigipolisGent\SockAPIBundle\JsonModel\Event;
use Psr\Log\LoggerInterface;

abstract class SockAPIService
{
    /**
     * @var string
     */
    protected $userToken;

    /**
     * @var string
     */
    protected $clientToken;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $scheme = 'https';

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string|bool
     */
    protected $modelClass = false;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param string $host
     * @param string $userToken
     * @param string $clientToken
     */
    public function __construct($host, $userToken, $clientToken)
    {
        $this->host = $host;
        $this->userToken = $userToken;
        $this->clientToken = $clientToken;
    }

    /**
     * @return string
     */
    public function getUserToken()
    {
        return $this->userToken;
    }

    /**
     * @param string $userToken
     *
     * @return $this
     */
    public function setUserToken($userToken)
    {
        $this->userToken = $userToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getClientToken()
    {
        return $this->clientToken;
    }

    /**
     * @param string $clientToken
     *
     * @return $this
     */
    public function setClientToken($clientToken)
    {
        $this->clientToken = $clientToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     *
     * @return $this
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param LoggerInterface $logger
     *
     * @return $this
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * @param string $scheme
     *
     * @return $this
     */
    public function setScheme($scheme)
    {
        $this->scheme = $scheme;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     *
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * @param null|int $id
     *
     * @return string
     */
    protected function constructUrl($id = null)
    {
        $url = $this->scheme.'://'.$this->host.$this->prefix.$this->path;

        if ($id) {
            $url = $url.'/'.$id;
        }

        return $url;
    }

    /**
     * @param string $method
     * @param string $url
     * @param array  $data
     *
     * @return mixed
     */
    protected function doRequest($method, $url, array $data = array())
    {
        $curl = curl_init();

        $data['user_token'] = $this->userToken;
        $data['client_token'] = $this->clientToken;
        $query = $this->removeArrayKeys(http_build_query($data));

        switch (strtoupper($method)) {
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, 1);
                // Set the query parameters as the POST body.
                curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
                break;
            case 'DELETE':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
            // No break; here. The URL must include the query parameters for all
            // methods except POST.
            default:
                $url = sprintf('%s?%s', $url, $query);
                break;
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $json = curl_exec($curl);


        $info = curl_getinfo($curl);
        curl_close($curl);

        $statusCode = $info['http_code'];
        $result = json_decode($json);

        if ($this->getLogger()) {
            $this->getLogger()->info(sprintf('call to sock API: %s %s responded with %s', strtoupper($method), $url, $statusCode));
            // only log if json is smaller than 1 MB
            $size = strlen($json);
            if ($size < 1000000) {
                $this->getLogger()->debug(sprintf('Sock API response (%s)[%d bytes]: %s', $statusCode, $size, $json));
            } else {
                $this->getLogger()->debug(sprintf('Sock API response (%s): too large %d', $statusCode, $size));
            }
        }

        if ($result === null || $statusCode < 200 || $statusCode > 299) {
            $msg = 'call to sock API failed: '.$statusCode;
            if ($statusCode === 422 && $result && isset($result->errors)) {
                $msg .= ': '.json_encode($result->errors);
            }
            throw new \RuntimeException($msg);
        }

        return $result;
    }

    /**
     * @param array $data
     *
     * @return array|ArrayMappable[]
     */
    public function index(array $data = array())
    {
        $data = $this->doRequest('GET', $this->constructUrl(), $data);
        return $this->assertModels($data);
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function show($id)
    {
        $data = $this->doRequest('GET', $this->constructUrl($id));

        return $this->assertModel($data);
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->doRequest('DELETE', $this->constructUrl($id));
    }

    /**
     * @param ArrayMappable $data
     *
     * @return ArrayMappable
     */
    public function create(ArrayMappable $data)
    {
        $data = $this->doRequest('POST', $this->constructUrl(), $data->toArray());

        return $this->assertModel($data);
    }

    /**
     * @param ArrayMappable $data
     *
     * @return ArrayMappable
     */
    public function update(ArrayMappable $data)
    {
        $data = $this->doRequest('POST', $this->constructUrl(), $data->toArray());

        return $this->assertModel($data);
    }

    /**
     * @param int $id
     *
     * @return array|Event[]
     */
    public function events($id)
    {
        return [];
    }

    public function assertModels($data, $class = null)
    {
        $models = array();
        foreach ($data as $d) {
            $models[] = $this->assertModel($d, $class);
        }

        return $models;
    }

    public function assertModel($data, $class = null)
    {
        /** @var string|ArrayMappable $class */
        $class = $class ?: $this->modelClass;
        if (!$class) {
            return $data;
        }

        $data = $this->object2array($data);
        $object = $class::fromArray($data);
        return $object;
    }

    protected function removeArrayKeys($queryString)
    {
        // replace [0] by [], also works if the bracket have been url encoded
        // ie: %5B0%5D will become %5B%5D
        return preg_replace('/((\[)|(\%5B))(\d+)((\])|(\%5D))/', '$1$5', $queryString);
    }

    protected function object2array($object)
    {
      return json_decode(json_encode($object), true);
    }
}
