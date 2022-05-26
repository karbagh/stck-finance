<?php

return [
    'success' => [
        'destroyed' => ':item deleted successfully.'
    ],
    'fail' => [
        'stock' => [
            'buy' => 'Failed to buy the stock for client, please try again later!',
            'sell' => 'Failed to sell the stock for client, please try again later!',
            'budget' => [
                'less' => 'Failed to buy the stock for client, budget is not enough!'
            ],
            'volume' => [
                'less' => 'Failed to buy the stock for client, volume is not enough!'
            ],
        ],
    ],
];
