<?php

// Import required libraries
require 'vendor/autoload.php';
// include_once('simple_html_dom.php');

use CBOR\StringStream;
use CBOR\Decoder;
use CBOR\ListObject; // List
use CBOR\IndefiniteLengthListObject; // Infinite List
use CBOR\TextStringObject;
use CBOR\UnsignedIntegerObject;
use CBOR\MapObject; // Map
use CBOR\IndefiniteLengthMapObject; // Infinite Map
use CBOR\ByteStringObject;
use CBOR\NegativeIntegerObject;
use CBOR\OtherObject\TrueObject;
use CBOR\OtherObject\NullObject;
use GuzzleHttp\Client;

function getHexAddress($wallet_address) {
    $hex_address = '01e1bc3d27cbf0258e014cb6abd72348cb9c5e393e3ac6a3b50244c781300eb28ee276fd4e36acdcc468f781bbffcebe62ab3914013d88f3a0';
   
    $url = "https://cardanoscan.io/address/" . $wallet_address;

    $httpClient = new \GuzzleHttp\Client();
    $response = $httpClient->get($url);
    $htmlString = (string) $response->getBody();
    //add this line to suppress any warnings
    libxml_use_internal_errors(true);
    $doc = new DOMDocument();
    $doc->loadHTML($htmlString);
    $xpath = new DOMXPath($doc);

    $titles = $xpath->evaluate('//span[@class="break-all"]');
   
    if(count($titles) > 0){
        $hex_address = $titles[0]->textContent;//.PHP_EOL;
        echo $hex_address;
    }
    
    return hex2bin($hex_address);
}

// testing scraping;
$cardanoAddress = 'addr1q8smc0f8e0cztrspfjm2h4erfr9ech3e8cavdga4qfzv0qfsp6egacnkl48rdtxuc3500qdmll8tuc4t8y2qz0vg7wsqgfqgmz';
$hex_address = getHexAddress($cardanoAddress);
var_dump($hex_address);

//full wallet addres sender
$wallet_sender = 'addr1qyzuvvmnewkpw8ywp64m8kz62sl2xsdxx778euvulzyu2rhzwrwl09qmj3lekd8nhzrrq8dja9hjakjtz0uqq9zlmaxshh5sch';
$hash = hex2bin("8c56a6d5df6823b13f1ee55473f44ded96ed841481d797e36b174c2267e48d96");//

//max transaction fee to pay (in lovelace)
$max_fee = 200000;

$ada_policyid = 'b24a29b9c16d349df16d9b5553b119e399e46ae19d6150c1a843ef61';
//full wallet addres receiver #1 addr1q8smc0f8e0cztrspfjm2h4erfr9ech3e8cavdga4qfzv0qfsp6egacnkl48rdtxuc3500qdmll8tuc4t8y2qz0vg7wsqgfqgmz
$wallet_receiver_1 = 'addr1q8smc0f8e0cztrspfjm2h4erfr9ech3e8cavdga4qfzv0qfsp6egacnkl48rdtxuc3500qdmll8tuc4t8y2qz0vg7wsqgfqgmz';
var_dump($wallet_receiver_1);

//amount ada to send (in lovelace) to receiver #1
$amount_ada_1 = 1500000;
//info about native token which also need to be send to receiver #1
$native_policyid_1 = 'afc910d7a306d20c12903979d4935ae4307241d03245743548e76783';
$native_assetname_1 = "4153484942";
//amount of native token that has to be send to receiver #1
$amount_native_1 = 250000;

//full wallet addres receiver #2
$wallet_receiver_2 = "addr1qyzuvvmnewkpw8ywp64m8kz62sl2xsdxx778euvulzyu2rhzwrwl09qmj3lekd8nhzrrq8dja9hjakjtz0uqq9zlmaxshh5sch";
$amount_ada_2 = 1500000;
//info about native token which also need to be send to receiver #2
$native_policyid_2 = 'c68307e7ca850513507f1498862a57c7f4fae7ba8e84b8bc074093a9';
$native_assetname_2 = "44494253";
//amount of native token that has to be send to receiver #2
$amount_native_2 = 253000;

try {

    $object = ListObject::create([
        MapObject::create()
            ->add(UnsignedIntegerObject::create(0), 
                ListObject::create([
                    ListObject::create([
                        ByteStringObject::create($hash),
                        UnsignedIntegerObject::create(0)
                    ])
                ])
                    
            )
            ->add(UnsignedIntegerObject::create(1), 
                ListObject::create([
                    ListObject::create([
                        ByteStringObject::create(getHexAddress($wallet_receiver_1)),
                        ListObject::create([
                            UnsignedIntegerObject::create($amount_ada_1),
                            MapObject::create()
                                ->add(ByteStringObject::create(hex2bin($native_policyid_2)),
                                    MapObject::create()
                                        ->add(ByteStringObject::create(hex2bin($native_assetname_1)),//'ASHIB'
                                        UnsignedIntegerObject::create($amount_native_1))    
                                )
                              
                        ])
                    ]),
                    ListObject::create([
                        ByteStringObject::create(getHexAddress($wallet_receiver_2)),
                        ListObject::create([
                            UnsignedIntegerObject::create($amount_ada_2),
                            MapObject::create()
                                ->add(ByteStringObject::create(hex2bin($native_policyid_2)),
                                    MapObject::create()
                                        ->add(ByteStringObject::create(hex2bin($native_assetname_2)),
                                        UnsignedIntegerObject::create($amount_native_2))    
                                )
                              
                        ])
                    ])

                ])
                                
            )
            ->add(UnsignedIntegerObject::create(2), 
                UnsignedIntegerObject::createFromHex($max_fee)
            )
            ->add(UnsignedIntegerObject::create(3), 
                UnsignedIntegerObject::createFromHex('07b8db1f')
            ),
        MapObject::create(),
        TrueObject::create(),
        NullObject::create()
    ]);
   
    // var_export($object);

    $tx = bin2hex((string)$object);
    // $tx = bin2hex(json_decode($object));
    $content = json_encode([
        'type' => "Tx MaryEra",
        'description' => "unsigned",
        'hash' => "2403c466054d9785c78d732d13ef5825de47280525ac05e3dfd52de7f4b1b690",
        "cborHex" => $tx
    ]);

    $filename = 'sendADA.json';
    file_put_contents($filename, $content);
    echo "File created: " . $filename;

    $data = hex2bin($tx);
    // String Stream
    $stream = StringStream::create($data);

    $decoder = Decoder::create();
    // Load the data
    $object = $decoder->decode($stream); // Return a CBOR\OtherObject\DoublePrecisionFloatObject class with normalized value ~0.3333 (1/3)
    
    var_export($object);

} catch (Exception $e) {
    // Error handling
    echo 'Error submitting transaction: ' . $e->getMessage();
}
?>
