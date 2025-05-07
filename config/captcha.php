<?php

return [
    // 'characters' => '1234567890', // Use only numbers
    'characters' => ['2', '3', '4', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'j', 'm', 'n', 'p', 'q', 'r', 't', 'u', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'M', 'N', 'P', 'Q', 'R', 'T', 'U', 'X', 'Y', 'Z'],
    'default'   => [
        'length'    => 5,
        'width'     => 120,
        'height'    => 36,
        'quality'   => 90,
        'math'      => false, // Disable math CAPTCHA
        'bgImage'   => true,
        'bgColor'   => '#ffffff',
        'fontColors'=> ['#000000'],
        'contrast'  => -5,
    ],
    'math'      => [
        'length'    => 5,
        'width'     => 120,
        'height'    => 36,
        'quality'   => 90,
        'math'      => true, // Enable math CAPTCHA
        'bgImage'   => false,
        'bgColor'   => '#ffffff',
        'fontColors'=> ['#000000'],
        'contrast'  => -5,
    ],

    // Add more configurations as needed...
];
