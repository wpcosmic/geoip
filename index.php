<?php

require_once('vendor/autoload.php');

use GeoIp2\Database\Reader;

$result = [];

if (isset($_GET['ip']) && !empty(trim($_GET['ip']))) {
    $userIP = trim($_GET['ip']);

    try {
        $reader = new Reader('GeoLite2-Country.mmdb');
        $record = $reader->country($userIP);
    
        $result = [
            'IP' => $userIP,
            'countryISOCode' => $record->country->isoCode ?? 'XX',
            'country' => $record->country->name ?? 'XX',
            'continent' => $record->continent->names['en'] ?? 'XX',
        ];
    }
    catch (\Throwable $e) {
        $result = [
            'IP' => $userIP,
            'countryISOCode' => 'XX',
            'country' => 'XX',
            'continent' => 'XX',
        ];
    }
}
else {
    $result['msg'] = 'IP empty';
}

header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);