<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;
use App\User;
use Illuminate\Support\Facades\Auth;
class AuthenticateController extends Controller
{

    /**
    *  @params Int   ->  id of client
     * @return String  -> the string of secret by client id
     */
    private function getSecret($id)
    {
        return DB::table('oauth_clients')->where('id', $id)->first()->secret;
    }

    /**
     * @DOC
     *  funzione che serve per fare un refresh del token
     *
     * @param request
     *  @return json response new token and new refresh_token expiration
     *
     */

    public function refreshToken(Request $request){


            $params = [
                'grant_type' => 'refresh_token',
                'refresh_token' =>request('refresh_token'),
                'scope' => '*',
            ];
            return $this->setParamsAndRequestForToken($request, $params);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * Questa è la funzione vera e propria del login, in pratica arriva in post username e password e con questi si va a fare l'autenticazione se le credenziali sono errate restituisce un 401
     */

    public function authenticate(Request $request)
    {
        $params = [
            'grant_type'=>'password',
            'username'=>request('username'),
            'password'=>request('password'),
            'scope'=>'*'
        ];
        return $this->setParamsAndRequestForToken($request, $params);
    }

    /**
      *  @params Request, array
     *   @return Route::dispatch
     *
     *  Function thant get Request and array params as arguments and return a redirection towards request token route
     */
    private function setParamsAndRequestForToken($request, $params){
        //per ora è statico web_app ma poi dovra essere una roba dinamica
        $params['client_id'] = $this->getClientIdFromRequestAndSetExpiration("web_app");
        $params['client_secret'] = $this->getSecret($params['client_id']);
        $request->request->add($params);

        $proxy = $this->createRequestToken();
        return Route::dispatch($proxy);
    }

    /** per adesso non serve potrebbe servire al momento che avviamo una app android o altro */
    private function getClientIdFromRequestAndSetExpiration($from){
        $refresh = Carbon::now();
        $expire = Carbon::now();
        switch ($from){
            case "web_app":
                $client = env("PASSPORT_CLIENT_ID_WEB_APP", null);
                Passport::refreshTokensExpireIn($refresh->addDays(15));
                Passport::tokensExpireIn($expire->addDays(15));
                break;
            case "desktop":
                $client = env("PASSPORT_CLIENT_ID_DESKTOP", null);
                Passport::refreshTokensExpireIn($refresh->addDays(30));
                Passport::tokensExpireIn($expire->addYear(2));
                break;
            default:
                $client = env("PASSPORT_CLIENT_ID_ANDROID", null);
                Passport::refreshTokensExpireIn($refresh->addDays(30));
                Passport::tokensExpireIn($expire->addYear(1));
                break;
        }
        return $client;
    }


    /**
     * @return Request
     *  function that return a POST request towards route for get token
     */
    private function createRequestToken(){
        return Request::create('oauth/token', 'POST');
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Funzione di logout, dove si va a invalidare il token, tramite il model User
     */
    public function logout(Request $request){
      $accessToken = Auth::user()->token();
      $refreshToken = DB::table('oauth_refresh_tokens')
          ->where('access_token_id', $accessToken->id)
          ->update([
              'revoked' => true
          ]);


      $accessToken->revoke();
      $accessToken->delete();
    }




}
