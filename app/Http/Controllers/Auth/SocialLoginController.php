<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Passport\Client as OClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class SocialLoginController extends Controller
{
    //
    public function redirectToProvider(string $provider) : RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }
    public function handleProviderCallback(string $provider){

        $user =  Socialite::driver($provider)->stateless()->user();
        dd($user);

    }


    public function socialLogin(Request $request){
        $validated = $request->validate([
            'email' => 'required',
            'provider_id' => 'required',
            'provider_type' => 'required',
            'token' => 'required',
        ]);
        
        $user=User::where('provider',$request->provider_type)->where('provider_id',$request->provider_id)->first();
        if($user){
            $accessToken = $this->getTokenAndRefreshTokenForSocial($request->provider_type, $request->token)->getData();
            return (new UserResource($user))->additional(['data' => ['access_token' => $accessToken]]);
        }else{
            $user=new User();
            $user->email=$request->email;
            $user->provider_id=$request->provider_id;
            $user->provider=$request->provider_type;
            $user->profile_pic=$request->profile_picture;
            $user->first_name=$request->full_name;
            $user->last_name='';
            $user->is_social=1;
            $user->created_at=Carbon::now();
            $user->updated_at=Carbon::now();
            $user->save();
            
            $accessToken = $this->getTokenAndRefreshTokenForSocial($request->provider_type, $request->token)->getData();
            
            return (new UserResource($user))->additional(['data' => ['access_token' => $accessToken]]);
        }

    }



    public function getTokenAndRefreshTokenForSocial($provider, $providertoken) {


//         $oClient = OClient::where('password_client', 1)->first();
// $http = new Client;

// $response = $http->post(env('APP_URL') . '/oauth/token', [
//     RequestOptions::FORM_PARAMS => [
//         'grant_type' => 'social', // static 'social' value
//         'client_id' => $oClient->id, // client id
//         'client_secret' => $oClient->secret, // client secret
//         'provider' => $provider, // name of provider (e.g., 'facebook', 'google' etc.)
//         'access_token' => $providertoken, // access token issued by specified provider
//     ],
//     RequestOptions::HTTP_ERRORS => false,
// ]);
// $data = json_decode($response->getBody()->getContents(), true);
// dd($response->getStatusCode());
// if ($response->getStatusCode() === Response::HTTP_OK) {
//     $accessToken = Arr::get($data, 'access_token');
//     $expiresIn = Arr::get($data, 'expires_in');
//     $refreshToken = Arr::get($data, 'refresh_token');

//     // success logic
// } else {
//     $message = Arr::get($data, 'message');
//     $hint = Arr::get($data, 'hint');

//     // error logic
// }

        $oClient = OClient::where('password_client', 1)->orderBy('id','desc')->first();
        // dd($providertoken);
        $http = new Client;
        $url = env('APP_URL').'/oauth/token';
        try{
            $response = $http->request('POST', $url, [
                'form_params' => [
                    'grant_type' => 'social',
                    'client_id' => $oClient->id,
                    'client_secret' => $oClient->secret,
                    'provider' => $provider,
                    'access_token' => $providertoken,
                ],
            ]);
            $result = json_decode((string) $response->getBody(), true);
            return response()->json($result, 200);
        }catch (GuzzleException $exception) {
            if ($exception->getCode() === 400) {
                throw new UnauthorizedHttpException('', 'Incorrect email or password');
            }
        }

    }
}
