<?php
/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 02.01.2017
 * Time: 11:50
 */

namespace RT\Client;

use RT\Client\Genratable\Script;

class Codebase implements Generatable
{
    /**
     * @var $generatables Generatable[]
     */
    private $generatables = [];
    private $socketEndpoint;
    private $socketName;

    public function __construct(array $config)
    {
        $this->socketEndpoint = $config["endpoint"];
        $this->socketName = $config["socketName"];

        $this->add($this->getInitScript(), Placement::PRE_BODY());
    }

    public function getInitScript()
    {
        $configScript = <<<JS
        
    io.sails.url = "{$this->socketEndpoint}";
    io.sails.transports = ['websocket', 'polling'];
    io.sails.autoConnect = false;
    io.sails.useCORSRouteToGetCookie = false; // TODO

    var {$this->socketName} = io.sails.connect();
    var {$this->socketName}_id = "";

JS;

        $this->add(new Script(<<<JS

    {$this->socketName}.get("/app/init", function(res){
        if(res)
            {$this->socketName}_id = res.id;
    });
JS
        ), Placement::RE_CONNECT_CALLBACK());

        return new Script($configScript);
    }

    public function add(Generatable $gen, Placement $placement = null)
    {
        if (!$placement) {
            $placement = Placement::POST_BODY();
        }
        $this->generatables[(string)$placement][] = $gen;
    }

    public function generate(Placement $placement = null)
    {

        $output = "";

        if (!$placement) {

            foreach ($this->generatables as $placement => $generatables) {
                $placementScript = $this->generatePlacementScript($placement);

                if ($placement == (string)Placement::CONNECT_CALLBACK()) {
                    $placementScript = <<<JS
    {$this->socketName}.on('reconnect', function(res){
    {$placementScript}
    });
JS;
                }

                $output .= $placementScript;
            }
        } else {
            $placementScript = $this->generatePlacementScript($placement);

            /* place connect callback post body */
            if ($placement == Placement::POST_BODY()) {
                $placementScript = <<<JS
                
var handleReconnect = function(){
    {$this->generatePlacementScript(Placement::RE_CONNECT_CALLBACK())}
}
                
{$this->socketName}.on('connect', function(res){
    {$this->generatePlacementScript(Placement::CONNECT_CALLBACK())}
});
         
{$this->socketName}.on('reconnect', handleReconnect);

handleReconnect();

JS;
            }
            $output .= $placementScript;
        }

        return $output;
    }

    protected function generatePlacementScript(Placement $placement)
    {
        $placementScript = "";
        if ($generatables = $this->generatables[(string)$placement]) {
            foreach ($generatables as $generatable) {
                $placementScript .= $generatable->generate();
            }
        }
        return $placementScript;
    }

    public function __toString()
    {
        return $this->generate();
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param string $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @return string
     */
    public function getSocketName()
    {
        return $this->socketName;
    }

    /**
     * @param string $socketName
     */
    public function setSocketName($socketName)
    {
        $this->socketName = $socketName;
    }


}