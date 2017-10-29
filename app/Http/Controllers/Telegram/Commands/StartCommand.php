<?php

    namespace App\Http\Controllers\Telegram\Commands;

    use Telegram\Bot\Commands\Command;
    use Telegram\Bot\Laravel\Facades\Telegram;

    Class StartCommand extends Command
    {
        protected $name = 'start';

        protected $description = 'Выбор города';

        public static function getKeyboard()
        {
            return $keyboard = [
                [
                    'Астана',
                    'Алматы',
                    'Павлодар',
                    'Риддер',
                ],
                ['Усть-Каменогорск', 'Усть-Каменогорск ОПТ']
            ];
        }

        public function handle($arguments)
        {
            $chat = $this->update->getMessage()->getChat();


            $text = 'Привет, ' . $chat->getFirstName() . ', для просмотра курса валют в обменных пунктах нужно выбрать город.';


            $reply_markup = Telegram::replyKeyboardMarkup([
                'keyboard'          => self::getKeyboard(),
                'resize_keyboard'   => true,
                'one_time_keyboard' => true
            ]);


            $response = Telegram::sendMessage([
                'chat_id'      => $chat->getId(),
                'text'         => $text,
                'reply_markup' => $reply_markup
            ]);

            $messageId = $response->getMessageId();

            //$this->replyWithMessage(compact('text'));
        }
    }