<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Tentative d'authentification avec les identifiants
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Retourne le token et l'utilisateur authentifié
        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => auth('api')->user(),
        ]);
    }
    public function allusers(){
        $users=USER::where('role','user')->get();
        return response()->json($users);
    }


    /**
     * Register a User.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'role' => 'required|string|in:admin,user',
            'avatar' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)],
            ['isActive' => false]
        ));

        $verificationUrl = route('verify.email', ['email' => $user->email]);
        Mail::send([], [], function ($message) use ($user, $verificationUrl) {
            $message->to($user->email)
                ->subject('Verify Your Email')
                ->html("<h2>{$user->name}, thank you for registering!</h2>
                        <p>Please verify your email to continue:</p>
                        <a href='{$verificationUrl}'>Click here</a>");
        });

        return response()->json([
            'message' => 'User successfully registered. Please verify your email.',
            'user' => $user
        ], Response::HTTP_CREATED);
    }

    /**
     * Verify Email.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyEmail(Request $request)
    {
        $user = User::where('email', $request->query('email'))->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], Response::HTTP_NOT_FOUND);
        }

        if ($user->isActive) {
            return response()->json([
                'success' => true,
                'message' => 'Account already activated'
            ]);
        }

        $user->isActive = true;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Account activated successfully'
        ]);
    }

    /**
     * Logout the user (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */


     public function logout()
     {
         auth('api')->logout();  // Invalide le token actuel

         return response()->json([
             'status' => 'success',
             'message' => 'Logged out successfully.'
         ], Response::HTTP_OK);
     }


    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        // Refresh the token using JWTAuth
        $newToken = JWTAuth::refresh(JWTAuth::getToken());

        return $this->createNewToken($newToken);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,  // Get the TTL from the factory
            'user' => auth('api')->user()
        ]);
    }

}
