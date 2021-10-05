<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $successStatus = 200;
    protected $createdStatus = 201;
    protected $requestFailed = 404;
    protected $responseFailed = 500;
    protected $forbiddenStatus = 403;
    /**
     * Store a newly created resource in storage.
     *
     * @api 'v1/register'
     * @param  UserRequest  $request
     * @return JsonResponse
     */
    public function register(UserRequest $request): JsonResponse
    {
        /*Hash the password*/
        $request['password'] = Hash::make($request['password']);

        try
        {
            /* Create a new User $user */
            $user = User::create($request->all());

            /* Check user count */
            if ($user)
            {
                /* Grant a token to user */
                $token = $user->createToken('auth-token')->plainTextToken;

                /* Return successful response*/
                return response()->json([
                    'data'      => $user,
                    'count'     => 1,
                    'success'   => true,
                    'msg'       => 'User registered',
                    'token'     => $token
                ], $this->createdStatus);
            }
            else
            {
                /* Return failure response*/
                return response()->json([
                    'data'      => [],
                    'success'   => false,
                    'msg'       => 'User could not be registered'
                ], $this->requestFailed);
            }
        }
        catch (Exception $ex)
        {
            /* Return exception gracefully */
            return response()->json([
                'data'      => [],
                'success'   => false,
                'msg'       => $ex->getMessage() . ' on ' . $ex->getLine()
            ], $this->responseFailed);
        }
    }

    /**
     * login
     * Login a user and provide a token.
     *
     * @api 'v1/login'
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try
        {
            /* Find the user from credentials*/
            $user = User::where('email', $request['credentials'])->orWhere('name', $request['credentials'])->first();

            /* Check if the user exists*/
            if ($user)
            {
                /* Validate the password */
                $passwordValidation = Hash::check($request['password'], $user->password);

                if ($passwordValidation)
                {
                    /* Grant user the token */
                    $token = $user->createToken('auth-token')->plainTextToken;

                    /* Return successful response*/
                    return response()->json([
                      'data'      => $user,
                      'count'     => 1,
                      'success'   => true,
                      'msg'       => 'User logged in',
                      'token'     => $token
                    ], $this->successStatus);
                }
                else
                {
                    /* Passwords do not match */
                    return response()->json([
                      'data'      => [],
                      'success'   => false,
                      'msg'       => 'Passwords do not match ',
                    ], $this->requestFailed);
                }
            }
            else
            {
                /* No such user found */
                return response()->json([
                  'data'      => [],
                  'success'   => false,
                  'msg'       => 'No such user exists ',
                ], $this->requestFailed);
            }
        }
        catch (Exception $ex)
        {
            /* Return exception gracefully */
            return response()->json([
              'data'      => [],
              'success'   => false,
              'msg'       => $ex->getMessage() . ' on ' . $ex->getLine()
            ], $this->responseFailed);
        }
    }
}
