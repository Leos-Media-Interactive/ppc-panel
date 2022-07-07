<?php

namespace App\Http\Controllers;

use Google\Ads\GoogleAds\Lib\OAuth2TokenBuilder;
use Google\Ads\GoogleAds\Lib\V11\GoogleAdsClient;
use Google\Ads\GoogleAds\Lib\V11\GoogleAdsClientBuilder;
use Google\Ads\GoogleAds\Util\FieldMasks;
use Google\Ads\GoogleAds\Util\V11\ResourceNames;
use Google\Ads\GoogleAds\V11\Enums\CallTypeEnum\CallType;
use Google\Ads\GoogleAds\V11\Enums\CampaignStatusEnum\CampaignStatus;
use Google\Ads\GoogleAds\V11\Enums\GoogleVoiceCallStatusEnum\GoogleVoiceCallStatus;
use Google\Ads\GoogleAds\V11\Resources\Campaign;
use Google\Ads\GoogleAds\V11\Services\CampaignOperation;
use Google\Ads\GoogleAds\V11\Services\GoogleAdsRow;
use Google\Ads\GoogleAds\V11\Enums\KeywordMatchTypeEnum\KeywordMatchType;
use Google\Ads\GoogleAds\Lib\V11\GoogleAdsException;
use Google\Ads\GoogleAds\V11\Errors\GoogleAdsError;
use Google\ApiCore\ApiException;
use Google\Protobuf\Internal\GPBUtil;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GoogleAdsApi extends Controller
{

    private static array $_REPORT_TYPE = [
        'ACCOUNT_PERFORMANCE_REPORT' => ['campaign.id', 'campaign.name', 'customer.descriptive_name', 'metrics.impressions', 'metrics.clicks', 'metrics.ctr', 'metrics.average_cpc', 'metrics.conversions', 'metrics.conversions_from_interactions_rate', 'metrics.cost_per_conversion', 'metrics.cost_micros', 'customer.currency_code', 'metrics.conversions_value', 'segments.device'],
        'KEYWORDS_PERFORMANCE_REPORT' => ['campaign.id', 'campaign.name', 'ad_group.id', 'ad_group.name', 'metrics.impressions', 'metrics.clicks', 'metrics.ctr', 'metrics.average_cpc', 'metrics.conversions', 'metrics.conversions_from_interactions_rate', 'metrics.cost_per_conversion', 'metrics.cost_micros', 'metrics.conversions_value'],
        'CALL_METRICS_CALL_DETAILS_REPORT' => ['campaign.id', 'campaign.name', 'ad_group.id', 'ad_group.name', 'customer.currency_code', 'call_view.call_duration_seconds', 'call_view.caller_country_code', 'call_view.call_status', 'call_view.call_tracking_display_location', 'call_view.type', 'campaign.name', 'call_view.start_call_date_time'],
    ];


    private function createAdsClient()
    {
        $configFile = config_path('google_ads_php.ini');
        $oAuth2Credential = (new OAuth2TokenBuilder())->fromFile($configFile)->build();

        return (new GoogleAdsClientBuilder())->fromFile(config_path('google_ads_php.ini'))
            ->withOAuth2Credential($oAuth2Credential)
            ->build();

    }

    private function tryQuery($client, $adwords_id, $query){
        try{
            $response['response'] = $client->search($adwords_id, $query, ['pageSize' => 1000]);
            $response['status'] = 'success';
        }catch (GoogleAdsException $googleAdsException){

            $errors = [
                'type' => 'GoogleAdsException',
                'title' => "Request with ID ".$googleAdsException->getRequestId()." has failed.",
            ];

            foreach ($googleAdsException->getGoogleAdsFailure()->getErrors() as $error) {
                /** @var GoogleAdsError $error */
                $errors['details'][] = '#'.$error->getErrorCode()->getErrorCode() . 'Details: ' . $error->getMessage();
            }


            return [
                'response' => null,
                'status' => 'has_errors',
                'errors' => $errors
            ];

        }catch (ApiException $apiException) {

            $errors =[
                'type' => 'ApiException',
                'status' => $apiException->getStatus(),
                'title' => $apiException->getBasicMessage(),
                'meta' =>  $apiException->getMetadata()
            ];


            return [
                'response' => null,
                'status' => 'has_errors',
                'errors' => $errors
            ];
        }

        return $response;
    }

    private function buildQuery($reportType, $from, $range = 'TODAY'): string
    {



        if($reportType === 'CALL_METRICS_CALL_DETAILS_REPORT'){
            $range = " AND call_view.start_call_date_time DURING " . $range;
        }else{
            $range = " AND segments.date DURING " . $range;
        }

        return "SELECT "
            . implode(', ', self::$_REPORT_TYPE[$reportType])
            . " FROM " . $from
            . " WHERE campaign.status = 'ENABLED' "
            . $range;
    }


    public function ACCOUNT_PERFORMANCE_REPORT($adwords_id, $range): array
    {
        $client = $this->createAdsClient()->getGoogleAdsServiceClient();

        $q = $this->buildQuery('ACCOUNT_PERFORMANCE_REPORT', 'campaign', $range);

        $response = $this->tryQuery($client, $adwords_id, $q);


        if($response['status'] === 'has_errors'){
            return $response;
        }

        $data = [
            'status' => 'success',
            'response' => []
        ];
        $device_icon = [
            'DESKTOP' => 'fas-desktop',
            'MOBILE' => 'fas-mobile-alt',
            'TABLET' => 'fas-tablet-alt',
            'CONNECTED_TV' => 'fas-tv',
            'UNSPECIFIED' => 'fas-question',
            'UNKNOWN' => 'fas-question',
            'OTHER' => 'fas-question'
        ];

        foreach ($response['response']->iterateAllElements() as $googleAdsRow) {

            $metrics = $googleAdsRow->getMetrics();
            $segment = $googleAdsRow->getSegments();
            $device = new \Google\Ads\GoogleAds\V11\Enums\DeviceEnum\Device();


            $data['response']['ad_rows'][] = [
                'device' => $device_icon[$device->name($segment->getDevice())],
                'campaign' => [
                    'id' => $googleAdsRow->getCampaign()->getId(),
                    'name' => $googleAdsRow->getCampaign()->getName()
                ],
                'metrics' => [
                    'impressions' => $metrics->getImpressions(),
                    'clicks' => $metrics->getClicks(),
                    'conversions' => $metrics->getConversions(),
                    'ctr' => $metrics->getCtr(),
                    'average_cpc' => $metrics->getAverageCpc(),
                    'cost_micros' => $metrics->getCostMicros(),
                    'conversions_from_interactions_rate' => $metrics->getConversionsFromInteractionsRate(),
                    'conversions_value' => $metrics->getConversionsValue(),
                    'cost_per_conversion' => $metrics->getCostPerConversion()
                ]
            ];

        }

        return $data;

    }

    public function KEYWORDS_PERFORMANCE_REPORT($adwords_id = '8134724388', $range = 'TODAY'): array
    {
        $client = $this->createAdsClient()->getGoogleAdsServiceClient();

        $q = $this->buildQuery('KEYWORDS_PERFORMANCE_REPORT', 'ad_group', $range);

        $response = $client->search($adwords_id, $q, ['pageSize' => 1000]);
        $data = [
            'status' => 'success',
            'response' => []
        ];

        foreach ($response->iterateAllElements() as $googleAdsRow) {

            $metrics = $googleAdsRow->getMetrics();

            $data['response']['ad_rows'][] = [
                'campaign' => [
                    'id' => $googleAdsRow->getCampaign()->getId(),
                    'name' => $googleAdsRow->getCampaign()->getName()
                ],
                'ad_group' => [
                    'id' => $googleAdsRow->getAdGroup()->getId(),
                    'name' => $googleAdsRow->getAdGroup()->getName()
                ],
                'metrics' => [
                    'impressions' => $metrics->getImpressions(),
                    'clicks' => $metrics->getClicks(),
                    'ctr' => $metrics->getCtr(),
                    'average_cpc' => $metrics->getAverageCpc(),
                    'conversions' => $metrics->getConversions(),
                    'conversions_from_interactions_rate' => $metrics->getConversionsFromInteractionsRate(),
                    'cost_per_conversion' => $metrics->getCostPerConversion(),
                    'cost_micros' => $metrics->getCostMicros(),
                    'conversions_value' => $metrics->getConversionsValue()
                ]
            ];

        }

        return $data;

    }

    public function CALL_METRICS_CALL_DETAILS_REPORT($adwords_id, $range){
        $client = $this->createAdsClient()->getGoogleAdsServiceClient();


        $q = $this->buildQuery('CALL_METRICS_CALL_DETAILS_REPORT', 'call_view', $range);

        $response = $client->search($adwords_id, $q, ['pageSize' => 1000]);
        $data = [
            'status' => 'success',
            'response' => []
        ];

        $callType = [
            'HIGH_END_MOBILE_SEARCH' => 'emblem-search-2-circle-fill',
            'MANUALLY_DIALED ' => 'gmdi-phone-callback-o',
            'UNKNOWN' => 'far-window-minimize',
            'UNSPECIFIED' => 'far-window-minimize',
        ];

        $callStatus = [
            'UNSPECIFIED' => '<span class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-1 rounded dark:bg-blue-200 dark:text-blue-800">לא הוגדר</span>',
            'UNKNOWN' => '<div class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-1 rounded dark:bg-blue-200 dark:text-blue-800">לא ידוע</div>',
            'MISSED' => '<div class="bg-red-100 text-red-800 text-sm font-medium mr-2 p-1 rounded dark:bg-red-200 dark:text-red-900">הוחמצה</div>',
            'RECEIVED' => '<div class="bg-green-100 text-green-800 text-sm font-medium mr-2 p-1 rounded dark:bg-green-200 dark:text-green-900">התקבלה</div>',
        ];

        foreach ($response->iterateAllElements() as $googleAdsRow) {
            $campaign = $googleAdsRow->getCampaign();
            $callView = $googleAdsRow->getCallView();
            $adGroup = $googleAdsRow->getAdGroup();

            $data['response'] = [
                'campaign' => [
                    'id' => $campaign->getId(),
                    'name' => $campaign->getName()
                ],
                'ad_group' => [
                    'id' => $adGroup->getId(),
                    'name' => $adGroup->getName()
                ],
                'calls' => [
                    'call_duration_seconds' => $callView->getCallDurationSeconds(),
                    'caller_country_code' => $callView->getCallerCountryCode(),
                    'call_status' => $callStatus[GoogleVoiceCallStatus::name($callView->getCallStatus())],
                    'call_tracking_display_location' => $callView->getCallTrackingDisplayLocation(),
                    'type' => $callType[CallType::name($callView->getType())],
                    'start_call_date_time' => $callView->getStartCallDateTime()
                ]
            ];
        }

        return $data;
    }

}
