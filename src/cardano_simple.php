<?php 

use Blockfrost\Block\BlockService;
use Blockfrost\Service;

require __DIR__.'/vendor/autoload.php';

$projectId = "mainnetUDnbDwWOmDkgbipZiRlT63FqZg8ELo50";

$blockService = new BlockService(Service::$NETWORK_CARDANO_MAINNET, $projectId);

try
{
    $res = $blockService->getLatestBlock();

    echo $res->hash;
}

catch(Exception $err)
{
    echo $err->getMessage();
}


?>