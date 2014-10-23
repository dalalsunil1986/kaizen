<?php namespace Acme\Libraries;

use Config;
use Moltin\Currency\Currency;
use Moltin\Currency\Exchange\OpenExchangeRates;
use Moltin\Currency\Format\Runtime;

class UserCurrency {

    public $currency;

    public $defaultCurrency = 'KD';

    public function __construct()
    {
        $currency = new Currency(new OpenExchangeRates(Config::get('app.currency_api')), new Runtime());
//        dd($this->currency->currencies());
        $value = $currency->convert(9.33)->from('GBP')->to('KWD')->format();
        dd($value);
    }

} 