<?php

namespace App\Http\Controllers\Oauth;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

        return redirect('https://api.twitter.com/oauth/authorize?oauth_token=' . $requestToken['oauth_token'] . '&oauth_secret=' . $requestToken['oauth_token_secret']);
    }

    public function callback(Request $request)
    {
        $requestParams = $request->all();

        $oauthSecret = $requestParams['oauth_secret'];

        $twitter = new TwitterOAuth($this->key, $this->secret, $requestParams['oauth_token'], $oauthSecret);

        $params = [
            'oauth_verifier' => $requestParams['oauth_verifier'],
        ];
        $access_token = $twitter->oauth('oauth/access_token', $params);
        $userConnection = new TwitterOAuth($this->key, $this->secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);

        $userInfo = $userConnection->get('account/verify_credentials');
        $friendsList = $userConnection->get('friends/list');
        $friendsListArray = json_decode(json_encode($friendsList), true);
        $friendsScreenNameList = [];
        foreach ($friendsListArray['users'] as $friend) {
            $friendsScreenNameList[] = $friend['screen_name'];
        }

        return $friendsScreenNameList;
    }
}
