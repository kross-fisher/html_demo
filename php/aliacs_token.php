<?php
define ('OPENAPI_SDK', '../../aliyun-openapi/');
define ('REGION_ID', 'cn-shanghai');
define ('ENDPOINT', 'sts.cn-shanghai.aliyuncs.com');
include_once OPENAPI_SDK . 'aliyun-php-sdk-core/Config.php';
use Sts\Request\V20150401 as Sts;

$accessKey = 'LTAoFfgyUoSxKE21OLxzn';
$accessSec = 'qD9EIgkrcFP0abH3MegFTbKvd';
$roleArn = 'acs:ram::1790082332282535:role/aliyunosstokengeneratorrole';

DefaultProfile::addEndpoint(REGION_ID, REGION_ID, 'Sts', ENDPOINT);
$profile = DefaultProfile::getProfile(REGION_ID, $accessKey, $accessSec);
$client = new DefaultAcsClient($profile);

$request = new Sts\AssumeRoleRequest();
$request->setRoleSessionName('upload-netcam-video');
$request->setRoleArn($roleArn);

try {
    $resp = $client->getAcsResponse($request);
    echo json_encode($resp->Credentials);
} catch (ServerException $e) {
    echo json_encode(['Server Error' => $e->getMessage()]);
} catch (ClientException $e) {
    echo json_encode(['Client Error' => $e->getMessage()]);
}
?>