<?php namespace Acme\Libraries;

use CurrencyConverter\CurrencyConverter;

class UserCurrency {

    public $currency;

    public $defaultCurrency = 'KWD';

    public function __construct()
    {
//        $currency = new Currency(new OpenExchangeRates(Config::get('app.currency_api')), new Runtime());
        $this->currency = new CurrencyConverter;
//        dd($this->currency->currencies());
//        $value =  $currency->convert('KWD', 'INR',1);
//        dd($value);
    }

    public function convert($to = 'KWD', $amount )
    {
        return $this->currency->convert($this->defaultCurrency,$to,$amount);
    }
} 