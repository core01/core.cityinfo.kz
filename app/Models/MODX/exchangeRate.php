<?php

namespace App\Models\MODX;

use Illuminate\Database\Eloquent\Model;

/**
 * Class exchangeRate
 * @package App\Models\MODX
 * @property
 *
 * @property $date_update
 * @property $buyUSD
 * @property $sellUSD
 * @property $buyEUR
 * @property $sellEUR
 * @property $buyRUB
 * @property $sellRUB
 * @property $buyCNY
 * @property $sellCNY
 * @property $city_id
 * @property $day_and_night
 * @property $company_id
 * @property $published
 * @property $hidden
 * @property $info
 * @property $phones
 * @property $name
 */
class exchangeRate extends Model
{
    //
    protected $table = 'new_exchange_rates';

    protected $connection = 'cityinfo';
}
