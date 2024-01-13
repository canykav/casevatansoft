<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\MessageReport;
use Illuminate\Http\Request;

class MessageReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    * @OA\GET(
        *     path="/api/message-reports",
        *     summary="Get Message Reports",
     *      security={{"bearer_token":{}}},
        *     @OA\Parameter(
        *         name="date",
        *         in="query",
        *         description="date of reports",
        *         required=false,
        *         @OA\Schema(type="date")
        *     ),
    *     @OA\Response(
    *          response="200",
    *          description="An example resource",
    *          @OA\JsonContent(
    *              type="object",
    * @OA\Property(
    *      type="array",
    *      description="data",
    *      property="data",
    *      @OA\Items(
    *          type="array",
    *          @OA\Items()
    *      ),
    * ),
    *  *              @OA\Property(
    *                  type="string",
    *                  default="success",
    *                  description="status",
    *                  property="status"
    *              ),
    *          )
    *     ),     * )
        */
    public function index(Request $req)
    {
        $where = [
            ['user_id', auth()->user()->id]
        ];

        if($req->date){
            $where[]= ['send_time' => $req->date];
        }

        $reports = MessageReport::leftJoin('messages', 'message_reports.message_id', '=', 'messages.id')
        ->select('messages.*','message_reports.number', 'message_reports.send_time')
        ->where($where)
        ->get();

        return response()->json([
            'data' => $reports,
            'status' => 'success'
        ]);
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
    public function store(Request $req)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     
    * @OA\GET(
        *     path="/api/message-reports/{number}",
        *     summary="Get detail of report",
        *      security={{"bearer_token":{}}},
    *     @OA\Response(
    *          response="200",
    *          description="An example resource",
    *          @OA\JsonContent(
    *              type="object",
    * @OA\Property(
    *      type="array",
    *      description="data",
    *      property="data",
    *      @OA\Items(
    *          type="array",
    *          @OA\Items()
    *      ),
    * ),
    *  *              @OA\Property(
    *                  type="string",
    *                  default="success",
    *                  description="status",
    *                  property="status"
    *              ),
    *          )
    *     ),     * )
        */
    public function show($number)
    {
        $where = [
            ['number', $number]
        ];

        $report = MessageReport::leftJoin('messages', 'message_reports.message_id', '=', 'messages.id')
        ->where($where)
        ->first();

        return response()->json([
            'data' => $report,
            'status' => 'success'
        ]);
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
