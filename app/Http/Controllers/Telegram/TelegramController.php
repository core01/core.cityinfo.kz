<?php
    /**
     * Created by PhpStorm.
     * User: Roman Sadoyan
     * Date: 27.09.17
     * Time: 11:09
     */

    namespace App\Http\Controllers\Telegram;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;
    use Telegram\Bot\Laravel\Facades\Telegram;

    Class TelegramController extends Controller
    {
        public function getRequest()
        {
            Log::info('bil request');
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
        public function postRequest(Request $request){
            Log::info('bil post request' . print_r($request->toArray(),1));
        }
    }