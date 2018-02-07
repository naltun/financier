#!/usr/bin/env php
<?php

/*
** Financier is a PHP script for delivering real-time, up-to-date Cryptocurrency market data
**
** INTENDED USE:
** I intend to run this in a separate terminal tile, so I can glance over whilst using tmux. Use your imagination, and have fun accordingly.
**
** This script may grow in functionality as is seen fit, or may not
**
** Licensed proudly under the the GNU General Public License Version 2
** For information regarding Free/Libre software, please read more at en.wikipedia.org/wiki/Free_software
** Happy coding
**
** Developed by Noah Altunian (github.com/naltun)
*/

// Financier ASCII logo; made with figlet.js (github.com/patorjk/figlet.js)
$logo = <<<HEREDOC
_______ _                        _
|  ____(_)                      (_)
| |__   _ _ __   __ _ _ __   ___ _  ___ _ __
|  __| | | '_ \ / _` | '_ \ / __| |/ _ \ '__|
| |    | | | | | (_| | | | | (__| |  __/ |
|_|    |_|_| |_|\__,_|_| |_|\___|_|\___|_|
HEREDOC;

// define financier.php version
define('VERSION', '0.2.3');

// define script banner
$banner = $logo . ' v' . VERSION . "\n\n";

// web request URL link as a constant
// for the get_global_data() function
define('GLOBAL_DATA__URL', 'https://api.coinmarketcap.com/v1/global/');

// define function to clear screen before each get_global_data() update for readability
function clear_screen() { echo exec('clear'); }

// define function to display a list of currencies and accompanying data if the user supplies an argument to the script
// NOTE: There is a maximum number of currencies that can be displayed. A possible work-around for this
// is to allow a curses-like scroll functionality. Financier currently supports a ticker limit of 7
if ( isset( $argv[1] ) and is_numeric( $argv[1] )) {
    // set ticker limit as a variable
    ( $argv[1] <= 7 ) ? $ticker_limit = $argv[1] : $ticker_limit = 7;

    // web request URL link as a constant for retrieve_currency_data() function
    define('TICKER_URL', 'https://api.coinmarketcap.com/v1/ticker/?limit=' . $ticker_limit);

    function get_currency_data() {
        // init curl session
        $ch = curl_init();
        // set the file for transfer
        curl_setopt($ch, CURLOPT_URL, TICKER_URL);
        // return the file as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // set the encoded string for output
        $encoded_json = curl_exec($ch);
        // close curl resource to free up server resources
        curl_close($ch);

        // decode JSON output and asssign to a new variable
        $decoded_json  = json_decode($encoded_json, true);
        $currency_data = $decoded_json;

        foreach( $currency_data as $key => $value )
        {
          echo 'Currency:     '  . $value['name']      . "\n";
          echo 'Symbol:       '  . $value['symbol']    . "\n";
          echo 'Rank:         '  . $value['rank']      . "\n";
          echo 'Price (USD):  $' . number_format($value['price_usd'], 4) . "\n\n";
        }
    }
}

// define function to obtain and display cryptocurrency market, `global' data
function get_global_data() {
    // init curl session
    $ch = curl_init();
    // set the file for transfer
    curl_setopt($ch, CURLOPT_URL, GLOBAL_DATA__URL);
    // return the file as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // set the encoded-string for output
    $encoded_json = curl_exec($ch);
    // close curl resource to free up server resources
    curl_close($ch);

    // decode JSON output and assign it to a new variable
    $decoded_json = json_decode($encoded_json, true);
    $global_data  = $decoded_json;

    // assign updated data to variables
    $total_market_cap  = number_format($global_data['total_market_cap_usd']);
    $bitcoin_dominance = $global_data['bitcoin_percentage_of_market_cap'];
    $active_currencies = $global_data['active_currencies'];

    echo "Total Market Cap:        $$total_market_cap\n";
    echo "Bitcoin Dominance:       $bitcoin_dominance%\n";
    echo "Total Active Currencies: $active_currencies\n\n";

}

// loop forever until the script is stopped
// display data in the mean time
while(TRUE) {

    clear_screen();
    echo $banner;
    get_global_data();
    if ( function_exists( 'get_currency_data' ) ) {
        echo "Displaying Top $ticker_limit currencies\n\n";
        get_currency_data();
    }
    // make the script sleep for 1 minute, then make a new `get_global_data()' call
    sleep(60);

}
