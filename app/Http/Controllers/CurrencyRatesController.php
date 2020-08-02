<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rate;
use App\Models\Currency;
use \DateTime;

/**
 * Class CurrencyRatesController
 *
 * Currency rates controller
 *
 * @package App\Http\Controllers
 */
class CurrencyRatesController extends Controller {

    /**
     * Get actual table rates
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     */
    public function getActualTableRate() {
        $date = new DateTime();
        $rates = Rate::with(['currency'])
            ->where('date', '=', $date->format('Y-m-d') .' 00:00:00')
            ->get();

        $currencyRates = [];
        foreach ($rates as $rate) {
            $currencyRates[] = [
                'currencyCode' => $rate->currency->code,
                'currencyName' => $rate->currency->name,
                'price' => round($rate->price, 2),
            ];
        }

        return response()->json([
            'status' => 'success',
            'data' => $currencyRates
        ], 200);
    }

    /**
     * Get historical single rates.
     *
     * @param Request $request
     * @param string $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHistoricalSingleRate(Request $request, $code) {
        /** @var Currency $currency */
        $currency = Currency::where('code', '=', $code)->first();
        if (is_null($currency)) {
            return response()->json([
                'status' => 'error',
                'message' => "Currency with code '" . $code . "' doesn't exists"], 404);
        }

        $params = $this->getRequestParameters($request);

        $currencies = $currency
            ->rates()
            ->ofSearch($currency->id, $params['search'])
            ->ofSort($params['sort'])
            ->paginate($params['limit']);

        $currencyRates = [];
        foreach ($currencies as $currency) {
            $currencyRates[] = [
                'date' => date('Y-m-d', strtotime($currency['date'])),
                'price' => $currency['price'],
                'number' => $currency['number']
            ];
        }

        return response()->json([
            'status' => 'success',
            'data' => $currencyRates,
            'currency' => $currency,
            'code' => $code
        ], 200);
    }

    /**
     * Get limit, search and sort params from the Request
     * Validation can be better, but it's only an example
     *
     * @param Request $request
     *
     * @return []
     */
    protected function getRequestParameters(Request $request) {
        $limit = 10;
        if (isset($request->limit) and is_int($request->limit)) {
            $limit = (int) $request->limit;
        }

        $search = null;
        if ($request->search) {
            $search = $request->search;
        }

        $columns = ['date', 'price', 'number'];
        $sorts = ['asc', 'desc'];

        $sort = [];
        if (isset($request->orderBy) and in_array($request->orderBy, $columns) and
            isset($request->sort) and in_array($request->sort, $sorts)) {
            $sort[$request->orderBy] = $request->sort;
        }

        return [
            'limit' => $limit,
            'search' => $search,
            'sort' => $sort,
        ];
    }
}