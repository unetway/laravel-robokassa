<?php

return [
    'login' => env('ROBOKASSA_LOGIN'),

    'password1' => env('ROBOKASSA_PASSWORD1'),

    'password2' => env('ROBOKASSA_PASSWORD2'),

    'is_test' => env('ROBOKASSA_IS_TEST', false),

    'test_password1' => env('ROBOKASSA_TEST_PASSWORD1'),

    'test_password2' => => env('ROBOKASSA_TEST_PASSWORD2'),

	'hashType' => env('ROBOKASSA_HASH_TYPE', 'md5'),
];