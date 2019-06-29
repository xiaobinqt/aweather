<h1 align="center"> weather </h1>

<p align="center"> A Weather SDK.</p>


## 安装

```shell
$ composer require xiaobinqt/weather -vvv
```

## 使用

```php
use Xiaobinqt\Weather\Weather;

// 高德开放平台应用 API Key
$key = 'xxx';
$w = new Weather($key);
```

## 获取天气
```php
$response = $w->getWeather('深圳');
```

## 示例
```
{
    "status": "1",
    "count": "1",
    "info": "OK",
    "infocode": "10000",
    "lives": [
        {
            "province": "广东",
            "city": "深圳市",
            "adcode": "440300",
            "weather": "阴",
            "temperature": "32",
            "winddirection": "西南",
            "windpower": "≤3",
            "humidity": "68",
            "reporttime": "2019-06-29 15:15:36"
        }
    ]
}
```

## 获取近期天气预报
```
{
    "status": "1",
    "count": "1",
    "info": "OK",
    "infocode": "10000",
    "forecasts": [
        {
            "city": "深圳市",
            "adcode": "440300",
            "province": "广东",
            "reporttime": "2019-06-29 15:15:36",
            "casts": [
                {
                    "date": "2019-06-29",
                    "week": "6",
                    "dayweather": "阵雨",
                    "nightweather": "多云",
                    "daytemp": "33",
                    "nighttemp": "28",
                    "daywind": "无风向",
                    "nightwind": "无风向",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                },
                {
                    "date": "2019-06-30",
                    "week": "7",
                    "dayweather": "大雨",
                    "nightweather": "大雨",
                    "daytemp": "32",
                    "nighttemp": "28",
                    "daywind": "无风向",
                    "nightwind": "无风向",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                },
                {
                    "date": "2019-07-01",
                    "week": "1",
                    "dayweather": "大雨",
                    "nightweather": "大雨",
                    "daytemp": "31",
                    "nighttemp": "27",
                    "daywind": "无风向",
                    "nightwind": "无风向",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                },
                {
                    "date": "2019-07-02",
                    "week": "2",
                    "dayweather": "大雨-暴雨",
                    "nightweather": "大雨-暴雨",
                    "daytemp": "31",
                    "nighttemp": "26",
                    "daywind": "东南",
                    "nightwind": "东南",
                    "daypower": "4",
                    "nightpower": "4"
                }
            ]
        }
    ]
}
```

## 获取 XML 格式返回值
#### 第三个参数为返回值类型,默认为 `json`,可选 `xml`和`json`

```
<?xml version="1.0" encoding="UTF-8"?>
<response>
    <status>1</status>
    <count>1</count>
    <info>OK</info>
    <infocode>10000</infocode>
    <lives type="list">
        <live>
            <province>广东</province>
            <city>深圳市</city>
            <adcode>440300</adcode>
            <weather>阴</weather>
            <temperature>32</temperature>
            <winddirection>西南</winddirection>
            <windpower>≤3</windpower>
            <humidity>68</humidity>
            <reporttime>2019-06-29 15:15:36</reporttime>
        </live>
    </lives>
</response>
```

## 参考
> [高德开放平台天气接口](https://lbs.amap.com/api/webservice/guide/api/weatherinfo/)

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/xiaobinqt/aweather/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/xiaobinqt/aweather/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT