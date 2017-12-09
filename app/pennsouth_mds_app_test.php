<?php
require('../vendor/AWeber-API-PHP-Library-master/aweber_api/aweber_api.php');

# replace XXX with your real keys and secrets
$consumerKey = 'Akz4bgpT5FO6EJZm3M0hkYSu';
$consumerSecret = 'WyKB0vnarrzLlzNxpilQfyTzTUzhhOQDLnfhJ3rF';

# create new instance of AWeberAPI
$application = new AWeberAPI($consumerKey, $consumerSecret);

# get a request token using oob as the callback URL
list($requestToken, $tokenSecret) = $application->getRequestToken('oob');

# prompt user to go to authorization URL
echo "Go to this url in your browser: {$application->getAuthorizeUrl()}\n";

# get the verifier code
echo 'Type code here: ';
$code = trim(fgets(STDIN));

# turn on debug mode for more information
$application->adapter->debug = true;

# exchange request token + verifier code for an access token
$application->user->requestToken = $requestToken;
$application->user->tokenSecret = $tokenSecret;
$application->user->verifier = $code;
list($accessToken, $accessSecret) = $application->getAccessToken();

# show your access token
print "\n$accessToken\n$accessSecret\n";
// token: AgcyvMSHQhivDVsJFl4a7nc1
// secret: jJDWGNsFvPD14MAknnykXSAbsmSZxsXqXJrawg6N

//print "$accessSecret\n";
//print "$accessToken\n";

// https://auth.aweber.com/1.0/oauth/authorize?oauth_token=AgcyvMSHQhivDVsJFl4a7nc1

?>