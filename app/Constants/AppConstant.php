<?php

namespace App\Constants;

class AppConstant
{
    public static function getGateways(): array
    {
        return [
            'nagad' => [
                'key' => 'nagad',
                'name' => 'Nagad',
                'logo' => '',
                'description' => 'Nagad is a mobile financial service in Bangladesh operating under the authority of Bangladesh Bank as a subsidiary of the Bangladesh Post Office.',
                'url' => asset('assets/gateways/nagad.png'), // Using asset() helper
            ],
            'bkash' => [
                'name' => 'Bkash',
                'logo' => 'assets/gateways/bkash.png',
                'description' => 'bKash is a mobile financial service in Bangladesh operating under the authority of Bangladesh Bank as a subsidiary of the Bangladesh Post Office.',
                'url' => asset('assets/gateways/bkash.png'),
            ],
        ];
    }
}
