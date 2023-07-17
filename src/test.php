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
use CBOR\MapObject; // Map
use CBOR\IndefiniteLengthMapObject; // Infinite Map
use CBOR\ByteStringObject;
// use CBOR\TextStringObject;
// use CBOR\UnsignedIntegerObject;
use CBOR\NegativeIntegerObject;
use CBOR\OtherObject\TrueObject;
use CBOR\OtherObject\NullObject;

$wallet_sender = ("addr1qyzuvvmnewkpw8ywp64m8kz62sl2xsdxx778euvulzyu2rhzwrwl09qmj3lekd8nhzrrq8dja9hjakjtz0uqq9zlmaxshh5sch");//addr1qyzuvvmnewkpw8ywp64m8kz62sl2xsdxx778euvulzyu2rhzwrwl09qmj3lekd8nhzrrq8dja9hjakjtz0uqq9zlmaxshh5sch
// $wallet_receiver = hex2bin("addr1qyzuvvmnewkpw8ywp64m8kz62sl2xsdxx778euvulzyu2rhzwrwl09qmj3lekd8nhzrrq8dja9hjakjtz0uqq9zlmaxshh5sch");
// $wallet_receiver = hex2bin("3F5562403F772278673F3F3F3F3F3F5B3B4D70713F4B773F703F3F3F3F343F303F3F6F2E3F4B3F27202E20225C3022202E20275F3F4D000000");// contract of ADA
$wallet_receiver = hex2bin("01e1bc3d27cbf0258e014cb6abd72348cb9c5e393e3ac6a3b50244c781300eb28ee276fd4e36acdcc468f781bbffcebe62ab3914013d88f3a0");

var_dump($wallet_receiver);

$hash = hex2bin("6581b1a1706fa649630094912e4e66d61eaaeec50a9d5574dfc730f0afbd2b72");//"6581b1a1706fa649630094912e4e66d6";//6581b1a1706fa649630094912e4e66d6
// var_dump($hash);
$hash1 = hex2bin('3F563F3F3F68233F3F3F54733F4D3F3F3F3F3F6B4C22673F000000000000000');

$output_amount = 0xff;
try {

    $object = ListObject::create([
        MapObject::create()
            ->add(UnsignedIntegerObject::create(0), 
                ListObject::create([
                    ListObject::create([
                        ByteStringObject::create($hash),
                        UnsignedIntegerObject::create(0)
                    ]),
                    ListObject::create([
                        ByteStringObject::create($hash),
                        UnsignedIntegerObject::create(0)
                    ])
                ])
                    
            )
            ->add(UnsignedIntegerObject::create(1), 
                ListObject::create([
                    ListObject::create([
                        ByteStringObject::create($wallet_receiver),
                        ListObject::create([
                            UnsignedIntegerObject::create($output_amount),
                            MapObject::create()
                                ->add(ByteStringObject::create(hex2bin('afc910d7a306d20c12903979d4935ae4307241d03245743548e76783')),
                                    MapObject::create()
                                        ->add(ByteStringObject::create('ASHIB'),
                                        UnsignedIntegerObject::create(16))    
                                )
                                ->add(ByteStringObject::create(hex2bin('b24a29b9c16d349df16d9b5553b119e399e46ae19d6150c1a843ef61')),
                                    MapObject::create()
                                        ->add(ByteStringObject::create('didits'),
                                        UnsignedIntegerObject::create(16))    
                                )
                                ->add(ByteStringObject::create(hex2bin('c68307e7ca850513507f1498862a57c7f4fae7ba8e84b8bc074093a9')),
                                    MapObject::create()
                                        ->add(ByteStringObject::create('DIBS'),
                                        UnsignedIntegerObject::create(16))    
                                )
                              
                        ])
                    ]),
                    ListObject::create([
                        ByteStringObject::create($wallet_receiver),
                        ListObject::create([
                            UnsignedIntegerObject::create($output_amount),
                            MapObject::create()
                                ->add(ByteStringObject::create(hex2bin('afc910d7a306d20c12903979d4935ae4307241d03245743548e76783')),
                                    MapObject::create()
                                        ->add(ByteStringObject::create('ASHIB'),
                                        UnsignedIntegerObject::create(16))    
                                )
                                ->add(ByteStringObject::create(hex2bin('b24a29b9c16d349df16d9b5553b119e399e46ae19d6150c1a843ef61')),
                                    MapObject::create()
                                        ->add(ByteStringObject::create('didits'),
                                        UnsignedIntegerObject::create(16))    
                                )
                                ->add(ByteStringObject::create(hex2bin('c68307e7ca850513507f1498862a57c7f4fae7ba8e84b8bc074093a9')),
                                    MapObject::create()
                                        ->add(ByteStringObject::create('DIBS'),
                                        UnsignedIntegerObject::create(16))    
                                )
                              
                        ])
                    ])

                ])
                                
            )
            ->add(UnsignedIntegerObject::create(2), 
                UnsignedIntegerObject::createFromHex('0')
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


    $file = 'tx.txt';
    file_put_contents($file, $tx);

    $data = hex2bin($tx);
    // var_dump($data);
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
