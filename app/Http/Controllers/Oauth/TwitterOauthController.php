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

    private $requestToken;

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

        $this->requestToken = $twitter->oauth('oauth/request_token', $params);
        $request->session()->put('request_token', $this->requestToken);

        return redirect('https://api.twitter.com/oauth/authorize?oauth_token=' . $this->requestToken["oauth_token"]);
    }

    public function callback(Request $request)
    {
        $requestParams = $request->all();
        if ($request->session()->has('request_token')) {
            return redirect()->route('oauth.twitter.login');
        }

        $this->requestToken = $request->session()->get('request_token');

        $twitter = new TwitterOAuth($this->key, $this->secret, $requestParams['oauth_token'], $this->requestToken['oauth_secret']);

        $params = [
            'oauth_verifier' => $requestParams['oauth_verifier'],
        ];
        $access_token = $twitter->oauth('oauth/access_token', $params);

        return array_merge($access_token, $request->all());
    }
}
