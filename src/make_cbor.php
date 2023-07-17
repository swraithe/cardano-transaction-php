<?php

// Import required libraries
require 'vendor/autoload.php';

use Blockfrost\Service;
use CBOR\StringStream;
use CBOR\Decoder;
use CBOR\ListObject; // List
use CBOR\IndefiniteLengthListObject; // Infinite List
use CBOR\TextStringObject;
use CBOR\UnsignedIntegerObject;
// use CBOR\OtherObject;
// use CBOR\Tag;
// use CBOR\MapObject;
// use CBOR\OtherObject\UndefinedObject;
// use CBOR\TextStringObject;
// use CBOR\ListObject;
// use CBOR\NegativeIntegerObject;
// use CBOR\UnsignedIntegerObject;
// use CBOR\OtherObject\TrueObject;
// use CBOR\OtherObject\FalseObject;
// use CBOR\OtherObject\NullObject;
// use CBOR\Tag\DecimalFractionTag;
// use CBOR\Tag\TimestampTag;

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
    // $cbor_str = json_encode($cbor_arr);
    // print_r("\r\nCBOR String: \n");
    // print_r($cbor_str);

    // $cbor = Service::streamFromString($cbor_str);
    // print_r(" \r\nCBOR stream:\r\n");
    // print_r($cbor);
  
    //creating object
 // Create a List with a single item
    $object = ListObject::create()
    ->add(TextStringObject::create('(｡◕‿◕｡)⚡'));


    // var_dump($object);

    $hex_str = "84a400828258206581b1a1706fa649630094912e4e66d61eaaeec50a9d5574dfc730f0afbd2b72008258208c56a6d5df6823b13f1ee55473f44ded96ed841481d797e36b174c2267e48d9600018282583901e1bc3d27cbf0258e014cb6abd72348cb9c5e393e3ac6a3b50244c781300eb28ee276fd4e36acdcc468f781bbffcebe62ab3914013d88f3a0821a00115cb0a1581cc68307e7ca850513507f1498862a57c7f4fae7ba8e84b8bc074093a9a14444494253118258390183c5aa6240b877227867fe16afa9dc0ae6fe5b3b4d1f027071d04b77e270ddf7941b947f9b34f3b886301db2e96f2eda4b13f800145fdf4d821a002658dea3581cafc910d7a306d20c12903979d4935ae4307241d03245743548e76783a14541534849421a3b9aca00581cb24a29b9c16d349df16d9b5553b119e399e46ae19d6150c1a843ef61a1466469646974731a000186a0581cc68307e7ca850513507f1498862a57c7f4fae7ba8e84b8bc074093a9a144444942531903d7021a0002c565031a07b8db1fa0f5f6";
    // $hex_str = "fb3fd5555555555555";
    // CBOR object (in hex for the example)
    $data = hex2bin($hex_str);
    // var_dump($data);
    // String Stream
    $stream = StringStream::create($data);

    $decoder = Decoder::create();
    // Load the data
    $object = $decoder->decode($stream); // Return a CBOR\OtherObject\DoublePrecisionFloatObject class with normalized value ~0.3333 (1/3)
    
    // var_dump($object);
    var_export($object);

    $file = 'file.txt';
    $data = serialize($object);
    file_put_contents($file, $data);
    
    // $fp = fopen('vardump.txt', 'w');
    // fwrite($fp, serialize($object));
    // fclose($fp);

} catch (Exception $e) {
    // Error handling
    echo 'Error submitting transaction: ' . $e->getMessage();
}
?>
