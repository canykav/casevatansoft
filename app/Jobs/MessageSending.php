<?php

namespace App\Jobs;

use App\Models\Message;
use App\Models\MessageReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MessageSending implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        # Bekleyen mesajlar
        $messages = Message::where('status','0')->orderBy('id')->limit(10000)->get();
        
        # Mesajların SMS API'ına iletilmesi
        foreach($messages as $message) {

            $apiResponse = true;

            if($apiResponse == true ) {
                #Mesajı başarılı işaretle
                Message::where('id', $message->id)->update(['status' => '1']);

                # Mesaj raporu oluştur
                MessageReport::create([
                    "message_id" => $message->id,
                    "number" => rand(10000,99999), # SMS'in API'dan gelen numarası. API olmadığı için random
                    "api_response" => json_encode([
                        'title' => $message->title,
                        'content' => $message->content
                    ]),
                    "send_time" => date('Y-m-d H:i:s')
                ]);                
            }

        }
    }
}
