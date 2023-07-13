<?php

// Import required libraries
require 'vendor/autoload.php';

use Blockfrost\Service;

// Set your wallet sender and receiver addresses
$wallet_sender = 'SENDER_WALLET_ADDRESS';
$wallet_receiver1 = 'RECEIVER_WALLET_ADDRESS1';
$wallet_receiver2 = 'RECEIVER_WALLET_ADDRESS2';

// Set the amount of ADA to send
$amount_ada = 10; // Example: sending 10 ADA

// Set native token information
$policy_id_native_token_1 = 'POLICY_ID_NATIVE_TOKEN_1';
$amount_native_token_1 = 100; // Example: sending 100 tokens

$policy_id_native_token_2 = 'POLICY_ID_NATIVE_TOKEN_2';
$amount_native_token_2 = 200; // Example: sending 200 tokens

try {

    $cbor_arr = array(
        'sender' => $wallet_sender,
        'amount' => [
            [
                'unit' => 'lovelace',
                'quantity' => $amount_ada * 1000000, // Convert ADA to Lovelace
            ],
            [
                'unit' => $policy_id_native_token_1,
                'quantity' => $amount_native_token_1,
            ],
            [
                'unit' => $policy_id_native_token_2,
                'quantity' => $amount_native_token_2,
            ],
        ],
        'receiver' => array(
            $wallet_receiver1,
            $wallet_receiver2
            /* etc. */
        ),
    );
    $cbor_str = json_encode($cbor_arr);
    print_r("\r\nCBOR String: \n");
    print_r($cbor_str);

    $cbor = Service::streamFromString($cbor_str);
    print_r(" \r\nCBOR stream:\r\n");
    print_r($cbor);
  
} catch (Exception $e) {
    // Error handling
    echo 'Error submitting transaction: ' . $e->getMessage();
}
?>
