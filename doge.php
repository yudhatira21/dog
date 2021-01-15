<?php  
error_reporting(0);
include 'function.php';

echo 'Reff : ';
$reff = trim(fgets(STDIN));

echo 'Address : ';
$address = trim(fgets(STDIN));

while (true) {
	$fake_name = get('https://fakenametool.net/generator/random/id_ID/indonesia');
	preg_match_all('/<td>(.*?)<\/td>/s', $fake_name, $result);

	$name = $result[1][0];
	$user = explode(' ', $name);
	$alamat = $result[1][2];
	$ex_al = explode(', ', $alamat);
	$base = ['0878', '0813', '0838', '0851', '0853'];
	$rand_base = array_rand($base);
	$number = $base[$rand_base].number(8);
	$domain = ['gmail.com', 'hotmail.com', 'yahoo.com'];
	$rand = array_rand($domain);
	$email = str_replace(' ', '', strtolower($name)).'@'.$domain[$rand];
	$username = explode('@', $email);
	$password = random(8);


	$referral_page = get('https://dogeminer.fun/?r='.$reff);
	$cookies = getcookies($referral_page);


	$headers = array();
	$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:84.0) Gecko/20100101 Firefox/84.0';
	$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8';
	$headers[] = 'Accept-Language: id,en-US;q=0.7,en;q=0.3';
	$headers[] = 'Connection: keep-alive';
	$headers[] = 'Cookie: wolven_core_session='.$cookies['wolven_core_session'].'; referral='.$cookies['referral'];
	$headers[] = 'Upgrade-Insecure-Requests: 1';
	$headers[] = 'Te: Trailers';


	$register = post('https://dogeminer.fun/account/register', 'user_name='.$username[0].'&email='.$email.'&email_repeat='.$email.'&password='.$password.'&password_repeat='.$password.'&address='.$address.'&tos_agree=1&register=Register Securely', $headers);

	if (stripos($register, 'Your account was successfully created.')) {
		$login = post('https://dogeminer.fun/account/login', 'user_name='.$username[0].'&password='.$password.'&login=Login Securely', $headers);
		$cookies = getcookies($login);

		$page_dash = get('https://dogeminer.fun/page/dashboard', $headers);
		$post = post('https://dogeminer.fun/page/dashboard', 'claim=Start+Auto+Faucet', $headers);
	$next = fetch_value($post, 'location: https://dogeminer.fun/page/dashboard/','
content-type');
		$claim = get('https://dogeminer.fun/page/dashboard/'.$next, $headers);

		if (stripos($claim, 'Your faucet claim')) {
			echo "Success Claim | 0.00001000 Doge\n";
		} else {
			echo "Failed Claim | 0.00001000 Doge\n";
		}

	} else {
		echo "Failed to register\n";
	}
}





?>