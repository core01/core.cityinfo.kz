<?php
    /**
     * Created by PhpStorm.
     * User: Roman Sadoyan
     * Date: 27.09.17
     * Time: 11:09
     */

    namespace App\Http\Controllers\Telegram;

    use App\Http\Controllers\Controller;
    use Telegram\Bot\Laravel\Facades\Telegram;

    Class TelegramController extends Controller
    {
        public function getRequest()
        {
            $response = Telegram::getMe();

            $botId = $response->getId();
            $firstName = $response->getFirstName();
            $username = $response->getUsername();

            return response()->json([
                'botId' => $botId,
                'firstName' => $firstName,
                'userName' => $username,
            ]);
        }
    }