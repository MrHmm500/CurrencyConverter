<?php

namespace App\Http\Controllers;

use App\Jobs\ImportConversionRates;
use App\Models\ConversionBase;
use App\Models\ConversionRate;
use Illuminate\Http\Request;

class ConversionController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function conversionListForBase(
        Request $request,
    )
    {
        $from = $request->get('from', 'EUR');
        $to = $request->get('to', 'AWG');
        // todo: omschrijven naar classes?
        return $this->getDatabaseValue($from, $to) ?? $this->getFixerValue($from, $to) ?? $this->getXigniteValue($from, $to);
    }

    private function getDatabaseValue(string $from, string $to)
    {
        // try to find today's data in the database, if it's already there, we don't have to do a query and can just return the cached data
        $databaseConversion = ConversionBase::query()->where('base', '=', $from)->where('date', '=', date('Y-m-d'))->first();
        if (null === $databaseConversion) {
            return null;
        }

        return ($databaseConversion->conversionRates->reject(function (ConversionRate $conversionRate) use ($to) {
            return $conversionRate->currency !== $to;
        }))->first()?->rate;
    }

    private function getFixerValue(string $from, string $to)
    {
        // if it doesn't exist, do a call again, return the data that's needed, and create a job that inserts the database value
        try {
            $options = stream_context_create(array('http'=>
                array(
                    'timeout' => 10 //10 seconds
                )
            ));
            $conversions = json_decode(file_get_contents('http://data.fixer.io/api/latest?base='.$from.'&access_key=' . getenv('FIXER_API_KEY'), false, $options), true);
            if (empty($conversions['success']) || empty($conversions['base']) || empty($conversions['date']) || count($conversions['rates']) < 1)  {
                throw new \Exception('bad response');
            }

            dispatch(new ImportConversionRates($conversions));
            return $conversions['rates'][$to];
        } catch(\Exception $ed) {
            return null;
        }
    }

    private function getXigniteValue(string $from, string $to)
    {
        $conversions = json_decode(file_get_contents('https://globalcurrencies.xignite.com/xGlobalCurrencies.json/GetRealTimeRateTable?Symbols=AED,AFN,ALL,AMD,ANG,AOA,ARS,AUD,AWG,AZN,BAM,BBD,BDT,BGN,BHD,BIF,BMD,BND,BOB,BRL,BSD,BTC,BTN,BWP,BYN,BYR,BZD,CAD,CDF,CHF,CLF,CLP,CNY,COP,CRC,CUC,CUP,CVE,CZK,DJF,DKK,DOP,DZD,EGP,ERN,ETB,EUR,FJD,FKP,GBP,GEL,GGP,GHS,GIP,GMD,GNF,GTQ,GYD,HKD,HNL,HRK,HTG,HUF,IDR,ILS,IMP,INR,IQD,IRR,ISK,JEP,JMD,JOD,JPY,KES,KGS,KHR,KMF,KPW,KRW,KWD,KYD,KZT,LAK,LBP,LKR,LRD,LSL,LTL,LVL,LYD,MAD,MDL,MGA,MKD,MMK,MNT,MOP,MRO,MUR,MVR,MWK,MXN,MYR,MZN,NAD,NGN,NIO,NOK,NPR,NZD,OMR,PAB,PEN,PGK,PHP,PKR,PLN,PYG,QAR,RON,RSD,RUB,RWF,SAR,SBD,SCR,SDG,SEK,SGD,SHP,SLE,SLL,SOS,SSP,SRD,STD,SYP,SZL,THB,TJS,TMT,TND,TOP,TRY,TTD,TWD,TZS,UAH,UGX,USD,UYU,UZS,VEF,VES,VND,VUV,WST,XAF,XCD,XDR,XOF,XPF,YER,ZAR,ZMK,ZMW,ZWL&PriceType=Mid&_token=' . getenv('XIGNITE_API_TOKEN')), true);
        $finalConversions = [];
        foreach ($conversions['Lines'] as $line) {
            $finalConversions[$line['BaseCurrency']] = [
                'date' => date('Y-m-d'),
                'base' => $line['BaseCurrency'],
                'rates' => [],
            ];
            foreach ($line['Columns'] as $column) {
                $finalConversions[$line['BaseCurrency']]['rates'][$column['QuoteCurrency']] = $column['Rate'];
            }
        }

        foreach ($finalConversions as $dailyConversion) {
            dispatch(new ImportConversionRates($dailyConversion));
        }
        return $finalConversions[$from]['rates'][$to];
    }
}
