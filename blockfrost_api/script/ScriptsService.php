<?php 

namespace Blockfrost\Script;

use Blockfrost\Service;
use Blockfrost\Page;

class ScriptsService extends Service 
{
    public function __construct($network, $projectId)
    {
        parent::__construct($network, $projectId);
    }
    
    public function getScripts(Page $page = null):array //<ScriptsInner>
    {
        $resp = $this->get("/scripts", $page);
        
        return $this->resp_from_json($resp, ['array', '\Blockfrost\Script\Script'] );
    }
    
    public function getScript(string $script_hash):ScriptInformation
    {
        $resp = $this->get("/scripts/{$script_hash}");
        
        return $this->resp_from_json($resp, '\Blockfrost\Script\ScriptInformation' );
    }
    
    public function getScriptAsJSON(string $script_hash):ScriptJSON
    {
        $resp = $this->get("/scripts/{$script_hash}/json");
        
        return $this->resp_from_json($resp, '\Blockfrost\Script\ScriptJSON' );
    }
    
    public function getScriptAsCBOR(string $script_hash):ScriptCBOR
    {
        $resp = $this->get("/scripts/{$script_hash}/cbor");
        
        return $this->resp_from_json($resp, '\Blockfrost\Script\ScriptCBOR' );
    }
    
    public function getScriptRedeemers(string $script_hash, Page $page = null):array
    {
        $resp = $this->get("/scripts/{$script_hash}/redeemers", $page);
        
        return $this->resp_from_json($resp, ['array', '\Blockfrost\Script\ScriptRedeemer' ]);
    }
    
    public function getDatumAsJSON(string $datum_hash):ScriptDatum
    {
        $resp = $this->get("/scripts/datum/{$datum_hash}");
        
        return $this->resp_from_json($resp, '\Blockfrost\Script\ScriptDatum' );
    }
  
}








?>