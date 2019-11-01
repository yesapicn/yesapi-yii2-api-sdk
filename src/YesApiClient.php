<?php
namespace YesApiCn\Yii2ApiSDK;

/**
 * 小白接口-Yii2-SDK包
 *
 * @author dogstar 20191101
 */
class YesApiClient {

	protected static $api_host;
	protected static $app_key;
	protected static $app_secrect;
	protected static $debug = false;

	public static function init($api_host, $app_key, $app_secrect, $debug = false) {
		self::$app_key = $app_key;
		self::$app_secrect = $app_secrect;
		self::$api_host = $api_host;
		self::$debug = $debug;
	}

	public static function initConfig($config) {
		if (isset($config['api_host'])) {
			self::$api_host = $config['api_host'];
		}
		if (isset($config['app_key'])) {
			self::$app_key = $config['app_key'];
		}
		if (isset($config['app_secrect'])) {
			self::$app_secrect = $config['app_secrect'];
		}
		if (isset($config['debug'])) {
			self::$debug = $config['debug'];
		}
	}

    /**
     * 发起小白接口请求
     *
     * @param string    $service 小白接口服务名称
     * @param array     $params 请求参数
     * @param int       $timeoutMs 超时时间，单位为毫秒
     * @return array/FALSE
     */
    public static function request($service, $params, $timeoutMs = 3000) {
        $ak = self::$app_key;
        $appSecrect = self::$app_secrect;
        $apiHost = self::$api_host;

        $url = rtrim($apiHost, '/') . '/?s=' . $service;

        // 生成签名
        unset($params['sign']);
        $params['s'] = $service;
        $params['app_key'] = $ak;
        $params['sign'] = self::encryptAppKey($params, $appSecrect);

        self::$debug && \Yii::info('YesApi request: ' . $url . '&' . http_build_query($params));

        // 请求小白接口
        $rs = self::doRequest($url, $params, $timeoutMs);
        // 重试一次
        if ($rs === false) {
            $rs = self::doRequest($url, $params, $timeoutMs);
        }

        // 处理返回结果
        self::$debug && \Yii::info('YesApi result: ' . $rs);
        $rsArr = json_decode($rs, true);

        return $rsArr;
    }

    protected static function doRequest($url, $data, $timeoutMs = 3000)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $timeoutMs);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.\Yii::$app->request->userIP, 'CLIENT-IP:'.\Yii::$app->request->userIP));
        curl_setopt($ch, CURLOPT_USERAGENT, \Yii::$app->request->userAgent);

        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        $rs = curl_exec($ch);

        curl_close($ch);

        return $rs;
    }

    protected static function encryptAppKey($params, $appSecrect) {
        ksort($params);

        $paramsStrExceptSign = '';
        foreach ($params as $val) {
            $paramsStrExceptSign .= $val;
        }

        return strtoupper(md5($paramsStrExceptSign . $appSecrect));
    }
}
