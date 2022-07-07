<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AdsData extends Controller
{


    public function account($range = 'TODAY')
    {

        $userAdwordsId = auth()->user()->adwords_id;
        if(auth()->user()->role === 'super_admin' || auth()->user()->role === 'manager'){
            return view('adsdata.account', [
                'account_performance' => [
                    'ad_rows' => []
                ],
                'selected_range' => $range,
                'user_role' => 'manager'
            ]);
        }
        $ads = new GoogleAdsApi();
        $data = $ads->ACCOUNT_PERFORMANCE_REPORT($userAdwordsId, $range);


        if ($data['status'] === 'has_errors') {
            return view('errors', [
                'errors' => $data['errors'],
            ]);
        } else {
            return view('adsdata.account', [
                'account_performance' => $data['response'],
                'selected_range' => $range,
            ]);
        }
    }

    public function keywords($range = 'TODAY')
    {

        $userAdwordsId = auth()->user()->adwords_id;
        $ads = new GoogleAdsApi();
        $data = $ads->KEYWORDS_PERFORMANCE_REPORT($userAdwordsId, $range);

        if ($data['status'] === 'has_errors') {
            return view('errors', [
                'errors' => $data['errors'],
            ]);
        } else {
            return view('adsdata.keywords', [
                'account_performance' => $data['response'],
                'selected_range' => $range
            ]);
        }

    }

    public function calls($range = 'TODAY')
    {

        $userAdwordsId = auth()->user()->adwords_id;
        $ads = new GoogleAdsApi();
        $data = $ads->CALL_METRICS_CALL_DETAILS_REPORT($userAdwordsId, $range);

        if ($data['status'] === 'has_errors') {
            return view('errors', [
                'errors' => $data['errors'],
            ]);
        } else {
            return view('adsdata.calls', [
                'account_performance' => $data['response'],
                'selected_range' => $range
            ]);
        }
    }

}
