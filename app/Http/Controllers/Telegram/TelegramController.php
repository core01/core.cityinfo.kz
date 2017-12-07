<?php
    /**
     * Created by PhpStorm.
     * User: Roman Sadoyan
     * Date: 27.09.17
     * Time: 11:09
     */

    namespace App\Http\Controllers\Telegram;

    use App\Http\Controllers\Controller;
    use App\Http\Controllers\Telegram\Commands\StartCommand;
    use App\Models\MODX\exchangeRate;
    use App\Models\MODX\exchCityName;
    use App\Models\TelegramBotChat;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;
    use Mockery\Exception;
    use Telegram\Bot\Api;
    use Telegram\Bot\Commands\Command;
    use Telegram\Bot\Laravel\Facades\Telegram;
    use Telegram\Bot\Objects\Update;

    class TelegramController extends Controller
    {
        public function __construct()
        {
            //$this->botan = new Botan(env('BOTAN_API_KEY'));
        }

        protected $aliases = [
            "Покупка\u{1F1FA}\u{1F1F8}" => 'buyUSD',
            "Продажа\u{1F1FA}\u{1F1F8}" => 'sellUSD',
            "Покупка\u{1F1EA}\u{1F1FA}" => 'buyEUR',
            "Продажа\u{1F1EA}\u{1F1FA}" => 'sellEUR',
            "Покупка\u{1F1F7}\u{1F1FA}" => 'buyRUB',
            "Продажа\u{1F1F7}\u{1F1FA}" => 'sellRUB',
            "Покупка\u{1F1E8}\u{1F1F3}" => 'buyCNY',
            "Продажа\u{1F1E8}\u{1F1F3}" => 'sellCNY',


        ];
        protected $flags = [
            'USD' => "\u{1F1FA}\u{1F1F8}",
            'EUR' => "\u{1F1EA}\u{1F1FA}",
            "RUB" => "\u{1F1F7}\u{1F1FA}",
            "CNY" => "\u{1F1E8}\u{1F1F3}"
        ];
        protected $botan;

        public function getRequest()
        {
            $response = Telegram::getMe();

            $botId = $response->getId();
            $firstName = $response->getFirstName();
            $username = $response->getUsername();

            return response()->json([
                'botId'     => $botId,
                'firstName' => $firstName,
                'userName'  => $username,
            ]);
        }

        public function postRequest(Request $request, $token)
        {
            /* @var $updates \Telegram\Bot\Objects\Update */
            $updates = Telegram::getWebhookUpdates();
            try {
                if ($token !== env('TELEGRAM_BOT_TOKEN')) {
                    throw new Exception('Invalid token');
                }
                $type = Telegram::detectMessageType($updates);
                $rawResponse = $updates->getMessage()->getRawResponse();
                if ($type === 'text') {
                    $text = $updates->getMessage()->getText();
                    switch ($text) {
                        case 'Выбор города':
                        case 'Начать сначала':
                            $text = 'Для просмотра курсов, выберите город';
                            $reply_markup = Telegram::replyKeyboardMarkup([
                                'keyboard'          => StartCommand::getKeyboard(),
                                'resize_keyboard'   => true,
                                'one_time_keyboard' => true
                            ]);

                            $response = Telegram::sendMessage([
                                'chat_id'      => $updates->getMessage()->getChat()->getId(),
                                'text'         => $text,
                                'reply_markup' => $reply_markup
                            ]);

                            $messageId = $response->getMessageId();
                            break;
                        case 'Усть-Каменогорск':
                        case 'Усть-Каменогорск ОПТ':
                        case 'Астана':
                        case 'Алматы':
                        case 'Павлодар':
                        case 'Риддер':
                            $this->attachChatToCity($text, $updates->getMessage()->getChat()->getId());

                            $keyboard = [
                                // USD
                                ["Продажа\u{1F1FA}\u{1F1F8}", "Покупка\u{1F1FA}\u{1F1F8}"],
                                // EUR
                                ["Продажа\u{1F1EA}\u{1F1FA}", "Покупка\u{1F1EA}\u{1F1FA}"],
                                // RUB
                                ["Продажа\u{1F1F7}\u{1F1FA}", "Покупка\u{1F1F7}\u{1F1FA}"],
                                // CNY
                                ["Продажа\u{1F1E8}\u{1F1F3}", "Покупка\u{1F1E8}\u{1F1F3}"],
                                ['Выбор города']
                            ];
                            $this->sendMessage($keyboard, $updates, 'Выберите валюту');
                            break;
                        // USD
                        case "Продажа\u{1F1FA}\u{1F1F8}":
                        case "Покупка\u{1F1FA}\u{1F1F8}":
                            // EUR
                        case "Продажа\u{1F1EA}\u{1F1FA}":
                        case "Покупка\u{1F1EA}\u{1F1FA}":
                            // RUB
                        case "Продажа\u{1F1F7}\u{1F1FA}":
                        case "Покупка\u{1F1F7}\u{1F1FA}":
                            // Продажа CNY
                        case "Продажа\u{1F1E8}\u{1F1F3}":
                        case "Покупка\u{1F1E8}\u{1F1F3}":
                            /* @var \App\Models\TelegramBotChat $telegramChat */
                            $telegramChat = TelegramBotChat::where('chat_id', '=',
                                $updates->getMessage()->getChat()->getId())->firstOrFail();

                            $userCityId = $telegramChat->city_id;
                            $field = $this->aliases[$text];
                            /*$this->botan->track($rawResponse,
                                $field . ' ' . exchCityName::where(['id' => $userCityId])->first()->name);*/
                            $rates = exchangeRate::where([
                                'city_id'   => $userCityId,
                                'hidden'    => 0,
                                'published' => 1,
                            ])
                                ->where('date_update', '>=', strtotime("-1 DAY"))
                                ->get([$field, 'name', 'date_update', 'info', 'phones']);
                            $arrbest = $this->getBestCoursesByText($text, $rates);
                            $responseText = "<b>Выгодные курсы</b> обмена валюты, по запросу \"<b>" . $text . "</b>\":\n\r";
                            $responseTextCourses = '';
                            foreach ($rates as $rate) {
                                if ($rate->$field === $arrbest[$field]) {
                                    $responseTextCourses .= "<b>" . html_entity_decode($rate->name) . "</b>\n\r" . $text .
                                        ' - <b>' . $rate->$field . " KZT</b>\n\r" . "<b>Время обновления: </b>" .
                                        date("d.m.y H:i", $rate->date_update) . "\n\r";
                                    if (!empty($rate->phones)) {
                                        $responseTextCourses .= "<b>Телефоны:</b> " . $rate->phones . "\n\r" .
                                            "<b>Адрес:</b> " . $rate->info . "\n\r";
                                    } else {
                                        $responseTextCourses .= "<b>Информация:</b> " . $rate->info . "\n\r";
                                    }
                                    $responseTextCourses .= "\n\r";
                                }
                            }
                            if (empty($responseTextCourses)) {
                                $responseText = 'Нет выгодных курсов по данной валюте.';

                                $reply_markup = Telegram::replyKeyboardMarkup([
                                    'inline_keyboard'   => [
                                        [
                                            [
                                                'text' => 'Более подробно на сайте',
                                                'url'  => 'https://cityinfo.kz/exchange/',
                                            ]
                                        ]
                                    ],
                                    'resize_keyboard'   => true,
                                    'one_time_keyboard' => true
                                ]);
                                Telegram::sendMessage([
                                    'chat_id'      => $updates->getMessage()->getChat()->getId(),
                                    'text'         => $responseText,
                                    'reply_markup' => $reply_markup
                                ]);
                            } else {
                                $this->sendMessage(false, $updates,
                                    $responseText . $responseTextCourses);
                            }
                            break;
                        default:
                            //Log:info($updates->getMessage()->getText());
                            break;
                    }
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                if ($updates->getMessage() !== null) {
                    $this->sendMessage(false, $updates,
                        'Сервис временно недоступен, пожалуйста свяжитесь с администрацией info@cityinfo.kz');
                }
                abort(400);
            }


            $update = Telegram::commandsHandler(true);
        }

        private function attachChatToCity($city, $chatId)
        {
            // Из таблицы new_exchCityNames
            $cities = [
                'Усть-Каменогорск'     => 4,
                'Усть-Каменогорск ОПТ' => 5,
                'Павлодар'             => 1,
                'Алматы'               => 2,
                'Астана'               => 3,
                'Риддер'               => 6
            ];
            if (in_array($city, array_keys($cities))) {
                TelegramBotChat::updateOrCreate(
                    ['chat_id' => $chatId],
                    ['city_id' => $cities[$city]]
                );
            } else {
                throw new Exception('City does not exists');
            }
        }

        private function getBestCoursesByText($text, $rates)
        {
            if (in_array($text, array_keys($this->aliases))) {
                $field = $this->aliases[$text];

                $arrbest = [
                    'buyUSD' => 0,
                    'buyEUR' => 0,
                    'buyRUB' => 0,
                    'buyCNY' => 0,

                    'sellUSD' => 10000,
                    'sellRUB' => 10000,
                    'sellEUR' => 10000,
                    'sellCNY' => 10000
                ];
                foreach ($rates as $rate) {
                    if (substr($field, 0, 3) == 'sel') {
                        if (($rate->$field <= $arrbest[$field]) && ((float)$rate->$field > 0)) {
                            $arrbest[$field] = (float)$rate->$field;
                        }
                    } else {
                        if ($rate->$field >= $arrbest[$field]) {
                            $arrbest[$field] = (float)$rate->$field;
                        }
                    }
                }
                return $arrbest;
            } else {
                throw new Exception('Invalid alias');
            }


        }

        private function sendMessage($keyboard, Update $updates, $text, $oneTime = false)
        {
            if ($keyboard) {
                $reply = [];
                $reply['keyboard'] = $keyboard;
                $reply['one_time_keyboard'] = $oneTime;
                $reply['resize_keyboard'] = true;
                $reply_markup = Telegram::replyKeyboardMarkup($reply);
                $response = Telegram::sendMessage([
                    'chat_id'      => $updates->getMessage()->getChat()->getId(),
                    'text'         => $text,
                    'reply_markup' => $reply_markup
                ]);
            } else {
                //Log::info($this->botan->shortenUrl('https://cityinfo.kz/exchange/', $updates->getMessage()->getFrom()->getId()));
                $reply_markup = Telegram::replyKeyboardMarkup([
                    'inline_keyboard'   => [
                        [
                            [
                                'text' => 'Более подробно на сайте',
                                'url'  => 'https://cityinfo.kz/exchange/',
                            ]
                        ]
                    ],
                    'resize_keyboard'   => true,
                    'one_time_keyboard' => true
                ]);
                $response = Telegram::sendMessage([
                    'chat_id'      => $updates->getMessage()->getChat()->getId(),
                    'text'         => $text,
                    'parse_mode'   => 'HTML',
                    'reply_markup' => $reply_markup
                ]);
            }


            $messageId = $response->getMessageId();
        }
    }