<?php

namespace App\Models\MODX;

use Illuminate\Database\Eloquent\Model;

/**
 * Class exchCityNames
 * @package App\Models\MODX
 * @property $name
 */
class exchCityName extends Model
{
    //
    protected $table = 'new_exchCityNames';

    protected $connection = 'cityinfo';

    public $timestamps = false;
}
