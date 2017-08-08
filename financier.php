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

// Financier ASCII logo; made by patorjk with figlet.js (github.com/patorjk/figlet.js)
$logo = <<<HEREDOC
______  _                        _
|  ____(_)                      (_)
| |__   _ _ __   __ _ _ __   ___ _  ___ _ __
|  __| | | '_ \ / _` | '_ \ / __| |/ _ \ '__|
| |    | | | | | (_| | | | | (__| |  __/ |
|_|    |_|_| |_|\__,_|_| |_|\___|_|\___|_|
HEREDOC;

// define financier.php version
define('VERSION', '0.1.0');

// define script banner
$banner = $logo . ' v' . VERSION . "\n\n";

// web request URL link as a constant
define('REQ_URL', 'https://api.coinmarketcap.com/v1/global/');

// define `clear screen' function for readability
function clear_screen() { echo exec('clear'); }

// define function to obtain and display cryptocurrency market, `global' data
function get_global_data() {
    // init curl session
    $ch = curl_init();
    // set the file for transfer
    curl_setopt($ch, CURLOPT_URL, REQ_URL);
    //return the file as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // set up the encoded-string for output
    $encoded_json = curl_exec($ch);
    // close curl resource to free up server resources
    curl_close($ch);

    // decode JSON output from line 49, and assign it to a new variable
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
    // make the script sleep for 1 minute, then make a new `get_global_data()' call
    sleep(60);

}
