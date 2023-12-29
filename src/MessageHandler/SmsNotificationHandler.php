<?php 
namespace App\MessageHandler;

use App\Message\SmsNotification;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SmsNotificationHandler
{
    public function __invoke(SmsNotification $message)
    {
        for ($i = 1; $i <= 1000000000; $i++) {

            if($i == 1000000000){
                $smsContent = $message->getContent();
            }
        }

        echo $smsContent;
    }
}