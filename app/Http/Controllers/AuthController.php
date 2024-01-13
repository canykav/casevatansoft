<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
* @OA\Post(
     *     path="/api/auth/login",
     *     summary="Get token for login",
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="User email",
     *         required=true,
     *         @OA\Schema(type="string",format="email")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="User password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
 *     @OA\Response(
 *          response="200",
 *          description="An example resource",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(
 *                  type="string",
 *                  default="",
 *                  description="access_token",
 *                  property="access_token"
 *              ),
 *  *              @OA\Property(
 *                  type="string",
 *                  default="bearer",
 *                  description="token_type",
 *                  property="token_type"
 *              ), 
 *  *              @OA\Property(
 *                  type="integer",
 *                  default="3060",
 *                  description="expires_in",
 *                  property="expires_in"
 *              ),
 *          )
 *     ),     * )
     */
    public function login(Request $req)
    {
        // dd($req->all());
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
        /**
* @OA\GET(
     *     path="/api/auth/me",
     *     summary="Get logged in user information",
     *         *      security={{"bearer_token":{}}},

 *     @OA\Response(
 *          response="200",
 *          description=""
 *     ),     * )
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
         /**
* @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Logout from current user",
     *         *      security={{"bearer_token":{}}},
 *     @OA\Response(
 *          response="200",
 *          description="An example resource",
 *          @OA\JsonContent(
 *              type="object",
 *  *              @OA\Property(
 *                  type="string",
 *                  default="Successfully logged out",
 *                  description="message",
 *                  property="message"
 *              ),
 *          )
 *     ),     * )
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    // /**
    //  * Refresh a token.
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function refresh()
    // {
    //     return $this->respondWithToken(auth()->refresh());
    // }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            // 'expires_in' => auth()->factory()->getTTL() * 60
            'expires_in' => auth('api')->factory()->getTTL() * 60

        ]);
    }
}