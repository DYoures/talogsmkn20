<?php

require __DIR__ . '/vendor/autoload.php';

$jar = new \GuzzleHttp\Cookie\CookieJar();
$client = new GuzzleHttp\Client(['cookies' => $jar]);

$res = $client->get('http://127.0.0.1:8000/login');
preg_match('/name="_token" value="([^"]+)"/', (string)$res->getBody(), $matches);
$token = $matches[1];

$loginRes = $client->post('http://127.0.0.1:8000/login', [
    'form_params' => [
        '_token' => $token,
        'email' => 'admin@talogsmkn20.local',
        'password' => 'password123',
    ],
    'allow_redirects' => true,
]);

echo "Final URL: " . $loginRes->getHeaderLine('X-Guzzle-Redirect-History') . "\n";
$body = (string)$loginRes->getBody();
if (str_contains($body, 'These credentials do not match our records.')) {
    echo "Error: Credentials do not match!\n";
}
if (str_contains($body, 'Dashboard')) {
    echo "Success: Reached Dashboard!\n";
}
if (str_contains($body, 'Manajemen Pengguna') || str_contains($body, 'Total Pengguna')) {
    echo "Success: Dashboard contains Pengguna stats!\n";
}

$usersRes = $client->get('http://127.0.0.1:8000/admin/users');
$usersBody = (string)$usersRes->getBody();
echo "Users Page Length: " . strlen($usersBody) . "\n";
echo "Users Page contains 'Manajemen Pengguna': " . (str_contains($usersBody, 'Manajemen Pengguna') ? 'YES' : 'NO') . "\n";
echo "Users Page contains 'admin@talogsmkn20.local': " . (str_contains($usersBody, 'admin@talogsmkn20.local') ? 'YES' : 'NO') . "\n";
