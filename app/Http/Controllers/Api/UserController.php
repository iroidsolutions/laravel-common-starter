<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Laravel\Passport\Client as OClient;

class UserController extends Controller
{
    //

    public function getUserProfile(){
        $id = Auth::user()->id;
        return new UserResource(Auth::user());
        return Auth::user();
    }
    public function updateUserProfile(UpdateUserRequest $request){

        $data = User::whereId(Auth::user()->id)->first();
        $img='';
        $time_zone = is_null($request->time_zone)?"UTC":$request->time_zone;
        if($request->has('profile_pic')){
            $name = $request->file('profile_pic')->getClientOriginalName();
            $path = $request->file('profile_pic')->store('public/images');
            $img = $path;

        }
        $data->first_name=$request->first_name;
        $data->last_name=$request->last_name;
        $data->profile_pic=$img;
        $data->time_zone=$time_zone;
        $data->save();
        return response()->json(['success' => 'Profile Updated successfully'], 200);

    }


    public function refreshToken(Request $request)
    {
        $request->validate([
            'refresh_token' => 'required|string'
        ]);

        $tokens = $this->refreshAuthToken($request->refresh_token);

        return [ 'data' => $tokens ];
    }


    public function refreshAuthToken(string $refreshToken)
    {
        $http = new \GuzzleHttp\Client;
        $oClient = OClient::where('password_client', 1)->first();

        try {
            $response = $http->post(url('oauth/token'), [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refreshToken,
                    'client_id' => $oClient->id,
                    'client_secret' => $oClient->secret,
                ],
            ]);

            return json_decode((string) $response->getBody(), true);
        } catch (GuzzleException $e) {
            if ($e->getCode() === 401) {
                throw new HttpException($e->getCode(), 'Either refresh token is expired or revoked');
            }
        }
    }

}
