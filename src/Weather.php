<?php
/**
 * Created by PhpStorm.
 * User: BinWei
 * Date: 2019/6/25
 * Time: 17:40
 */


namespace Xiaobinqt\Aweather;


use GuzzleHttp\Client;
use Xiaobinqt\Aweather\Exceptions\HttpException;
use Xiaobinqt\Aweather\Exceptions\InvalidArgumentException;

class Weather
{
    protected $key;
    protected $guzzleOptions = array();

    /**
     * Weather constructor.
     * @param $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }


    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    public function setGuzzleOptions($options)
    {
        $this->guzzleOptions = $options;
    }


    public function getWeather($city, $type = 'base', $format = 'json')
    {
        $url = "https://restapi.amap.com/v3/weather/weatherInfo";
        if (!in_array(strtolower($format), array(
            "json",
            'xml'
        ))) {
            throw  new InvalidArgumentException('Invalid response format: ' . $format);
        }

        if (!in_array(strtolower($type), array(
            "base",
            'all'
        ))) {
            throw new InvalidArgumentException("Invalid type value(base/all): " . $type);
        }

        $query = array_filter(array(
            'key'        => $this->key,
            'city'       => $city,
            'extensions' => $type,
            'output'     => $format
        ));

        try {
            $response = $this->getHttpClient()->get($url, array(
                'query' => $query
            ))->getBody()->getContents();

            return 'json' === $format ? json_decode($response, true) : $response;
        } catch (\Exception $exception) {
            throw new HttpException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }


}