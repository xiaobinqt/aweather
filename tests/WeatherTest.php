<?php
/**
 * Created by PhpStorm.
 * User: BinWei
 * Date: 2019/6/25
 * Time: 21:17
 */


namespace Xiaobinqt\Weather\Tests;


use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Mockery\Matcher\AnyArgs;
use PHPUnit\Framework\TestCase;
use Xiaobinqt\Weather\Exceptions\HttpException;
use Xiaobinqt\Weather\Exceptions\InvalidArgumentException;
use Xiaobinqt\Weather\Weather;

class WeatherTest extends TestCase
{
    /**
     * @description 检查 type 参数
     * @throws InvalidArgumentException
     * @throws \Xiaobinqt\Weather\Exceptions\HttpException
     */
    public function testGetWeatherWithInvalidType()
    {
        $w = new Weather('mock-key');
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type value(base/all): foo');
        $w->getWeather('深圳', 'foo');
        // 如果没有抛出异常,则会运行到这里,标记当前测试没有成功
        $this->fail('Failed to assert getWeather throw exception with invalid argument.');
    }


    /**
     * @description 检查 format 参数
     * @throws InvalidArgumentException
     * @throws \Xiaobinqt\Weather\Exceptions\HttpException
     */
    public function testGetWeatherWithInvalidFormat()
    {
        $w = new Weather('mock-key');
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid response format: array');
        $w->getWeather('深圳', 'base', 'array');
        // 如果没有抛出异常,则会运行到这里,标记当前测试没有成功
        $this->fail('Failed to assert getWeather throw exception with invalid argument.');
    }


    public function testGetWeather()
    {
        // json
        $response = new Response(200, [], '{"success": true}');
        $client = \Mockery::mock(Client::class);
        $client->allows()->get('https://restapi.amap.com/v3/weather/weatherInfo', [
            'query' => [
                'key'        => 'mock-key',
                'city'       => '深圳',
                'output'     => 'json',
                'extensions' => 'base',
            ],
        ])->andReturn($response);

        $w = \Mockery::mock(Weather::class, ['mock-key'])->makePartial();
        $w->allows()->getHttpClient()->andReturn($client);

        $this->assertSame(['success' => true], $w->getWeather('深圳'));

        // xml
        $response = new Response(200, [], '<hello>content</hello>');
        $client = \Mockery::mock(Client::class);
        $client->allows()->get('https://restapi.amap.com/v3/weather/weatherInfo', [
            'query' => [
                'key'        => 'mock-key',
                'city'       => '深圳',
                'extensions' => 'all',
                'output'     => 'xml',
            ],
        ])->andReturn($response);

        $w = \Mockery::mock(Weather::class, ['mock-key'])->makePartial();
        $w->allows()->getHttpClient()->andReturn($client);

        $this->assertSame('<hello>content</hello>', $w->getWeather('深圳', 'all', 'xml'));
    }

    public function testGetWeatherWithGuzzleRuntimeException()
    {
        $client = \Mockery::mock(Client::class);
        $client->allows()
            ->get(new AnyArgs())
            ->andThrow(new \Exception('request timeout'));

        $w = \Mockery::mock(Weather::class, ['mock-key'])->makePartial();
        $w->allows()->getHttpClient()->andReturn($client);

        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('request timeout');

        $w->getWeather('深圳');
    }

    public function testGetHttpClient()
    {
        $w = new Weather('mock-key');

        // 断言返回结果为 GuzzleHttp\ClientInterface 实例
        $this->assertInstanceOf(ClientInterface::class, $w->getHttpClient());
    }

    public function testSetGuzzleOptions()
    {
        $w = new Weather('mock-key');

        // 设置参数前，timeout 为 null
        $this->assertNull($w->getHttpClient()->getConfig('timeout'));

        // 设置参数
        $w->setGuzzleOptions(['timeout' => 5000]);

        // 设置参数后，timeout 为 5000
        $this->assertSame(5000, $w->getHttpClient()->getConfig('timeout'));
    }

}