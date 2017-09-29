<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    /**
     * Class TelegramBotChat
     * @package App\Models
     *
     * @property $city_id
     * @property $chat_id
     */
    class TelegramBotChat extends Model
    {
        //
        protected $fillable = [
            'city_id', 'chat_id'
        ];
    }
