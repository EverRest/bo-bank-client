<?php
declare(strict_types=1);

namespace App\Services\Convert;

use App\Models\Currency;
use App\Services\Http\HttpClient;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Config;

class ConvertService
{
    /**
     * @param $amount
     * @param Currency $fromCurrency
     * @param Currency $toCurrency
     *
     * @return float|int|null
     * @throws GuzzleException
     * @throws Exception
     */
    public static function convert($amount, Currency $fromCurrency, Currency $toCurrency): float|int|null
    {
        try {
            $response = HttpClient::get("http://api.exchangeratesapi.io/latest?base=$fromCurrency->code&symbols=$toCurrency->code&access_key=" . Config::get('admin.exchange_rates_api'));
            $data = json_decode($response, true);
            $currencyCode = $toCurrency->code;
            if (isset($data['rates'][$currencyCode])) {
                return floatval($data['rates'][$currencyCode]) * $amount;
            }

            return null;
        } catch (Exception $e) {
            throw new Exception("ExchangeRatesApi is not responding. Error: {$e->getMessage()}");
        }
    }
}
