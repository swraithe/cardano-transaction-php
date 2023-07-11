<?php

// Import required libraries
require 'vendor/autoload.php';

use GuzzleHttp\Client;

// Set your Blockfrost API key
$blockfrostApiKey = 'mainnetUDnbDwWOmDkgbipZiRlT63FqZg8ELo50';

// Set your wallet sender and receiver addresses
$wallet_sender = 'SENDER_WALLET_ADDRESS';
$wallet_receiver = 'RECEIVER_WALLET_ADDRESS';

// Set the amount of ADA to send
$amount_ada = 10; // Example: sending 10 ADA

// Set native token information
$policy_id_native_token_1 = 'POLICY_ID_NATIVE_TOKEN_1';
$amount_native_token_1 = 100; // Example: sending 100 tokens

$policy_id_native_token_2 = 'POLICY_ID_NATIVE_TOKEN_2';
$amount_native_token_2 = 200; // Example: sending 200 tokens

// Create payload for the transaction
$payload = [
    'payments' => [
        [
            'address' => $wallet_receiver,
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
        ],
    ],
];

// Serialize the payload
$serializedPayload = json_encode($payload);

// Construct the HTTP client
$client = new Client([
    'base_uri' => 'https://cardano-mainnet.blockfrost.io/api/v0/',
    'headers' => [
        'project_id' => $blockfrostApiKey,
        "Content-Type" => "application/cbor"
    ],
]);

try {
    // Submit transaction to Blockfrost
    $response = $client->post('txs/submit', [
        'body' => $serializedPayload,
    ]);

    // Get the transaction ID
    $transactionId = json_decode($response->getBody()->getContents(), true)['tx_hash'];

    // Success message
    echo 'Transaction submitted successfully! Transaction ID: ' . $transactionId;
} catch (Exception $e) {
    // Error handling
    echo 'Error submitting transaction: ' . $e->getMessage();
}
?>
