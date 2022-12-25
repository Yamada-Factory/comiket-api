<?php

namespace App\Http\Controllers\Oauth;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TwitterOauthController extends Controller
{
    private $OAUTH_SECRET = '';

    private $callbackUrl = '';

    private $key;

    private $secret;


    public function __construct()
    {
        $this->callbackUrl = config('services.twitter.callback_url');
        $this->key = config('services.twitter.key');
        $this->secret = config('services.twitter.secret');
    }

    public function login(Request $request)
    {
        //TwitterOAuthの仕様準備
        $twitter = new TwitterOAuth($this->key, $this->secret);
        $params = [
            "oauth_callback" => $this->callbackUrl,
            "x_auth_access_type" => "read"
        ];

        $requestToken = $twitter->oauth('oauth/request_token', $params);
        session()->flash('request_token', $requestToken);
        session()->reflash();

        return redirect('https://api.twitter.com/oauth/authorize?oauth_token=' . $requestToken['oauth_token']);
    }

    public function callback(Request $request)
    {
        $requestParams = $request->all();
        if (session()->has('request_token')) {
            return redirect()->route('oauth.twitter.login');
        }

        $requestToken = session()->get('request_token');

        $twitter = new TwitterOAuth($this->key, $this->secret, $requestParams['oauth_token'], $requestToken['oauth_secret']);

        $params = [
            'oauth_verifier' => $requestParams['oauth_verifier'],
        ];
        $access_token = $twitter->oauth('oauth/access_token', $params);

        return array_merge($access_token, $request->all());
    }
}
