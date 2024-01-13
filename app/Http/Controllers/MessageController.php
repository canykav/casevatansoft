<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\MessageReport;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
* @OA\Post(
     *     path="/api/messages",
     *     summary="Send a new message",
     *         *      security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="Message title",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="content",
     *         in="query",
     *         description="Message Content",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
 *     @OA\Response(
 *          response="200",
 *          description="An example resource",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(
 *                  type="boolean",
 *                  default="success",
 *                  description="status",
 *                  property="status"
 *              ),
 *  *              @OA\Property(
 *                  type="string",
 *                  default="SMS gönderim talebi işleme alındı.",
 *                  description="message",
 *                  property="message"
 *              ),
 *          )
 *     ),     * )
     */
    public function store(Request $req)
    {
        $messages = json_decode($req->messages) ?? [];

        foreach($messages as $index => $message) {
            $data = [
                'title' => $message->title,
                'content' =>  $message->content,
                'user_id' => auth()->user()->id,
                'status' => 0
            ];
            # Mesajı bekliyor durumunda oluşturur.
            $message = Message::create($data);

            #İlk 500 sms'i anlık gönderir.
            if($index<500) {
                $apiResponse = [
                    'number' =>rand(10000,99999),
                    'title' => $message->title,
                    'content' => $message->content,
                    'status' => 'success'
                ];
                
                $status = $apiResponse['status'] == 'success' ? '1' : '-1';

                # Gönderilen smslerin raporunu kaydeder.
                MessageReport::create([
                    "message_id" => $message->id,
                    "number" => $apiResponse['number'], # SMS'in API'dan gelen numarası. API olmadığı için random
                    "api_response" => $apiResponse,
                    "send_time" => date('Y-m-d H:i:s')
                ]);
                # Gönderilen smslerin durumunu değiştirir
                Message::where('id', $message->id)->update(['status', $status]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'SMS gönderim talebi işleme alındı.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
