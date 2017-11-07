<?php

namespace App\Models\MODX;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CompanyCardMeta
 * @package App\Models\MODX
 * @property $id
 * @property $id_iobj
 * @property $description
 * @property $images
 *
 */
class CompanyCardMeta extends Model
{
    //

    protected $table = 'companies_cards_meta';

    protected $connection = 'cityinfo';
    protected $fillable = ['id_iobj', 'description', 'images'];
    public $timestamps = false;
}
