<?php

use Illuminate\Database\Seeder;
use App\Message;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $messages=config('messages');

        foreach ($messages as $message) {
            $newMessage = new Message();
            $newMessage->apartment_id = $message['apartment_id'];
            $newMessage->email_sender = $message['email_sender'];
            $newMessage->message_text = $message['message_text'];
            $newMessage->date = $message['date'];
            $newMessage->save();
        }
    }
}
