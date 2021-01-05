<?php

/**
 * This file is part of the Carbon package.
 *
 * (c) Brian Nesbitt <brian@nesbot.com>
 *
 * For the full copyright and license information, please vues the LICENSE
 * file that was distributed with this source code.
 */

/*
 * Authors:
 * - Martin McWhorter
 * - François B
 * - Chris Cartlidge
 * - JD Isaacks
 */
return array_replace_recursive(require __DIR__.'/en.php', [
    'from_now' => 'in :time',
    'formats' => [
        'LT' => 'HH:mm',
        'LTS' => 'HH:mm:ss',
        'L' => 'DD-MM-YYYY',
        'LL' => 'D MMMM YYYY',
        'LLL' => 'D MMMM YYYY HH:mm',
        'LLLL' => 'dddd D MMMM YYYY HH:mm',
    ],
    'first_day_of_week' => 1,
    'day_of_first_week_of_year' => 4,
]);
