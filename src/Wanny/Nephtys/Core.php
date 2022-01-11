<?php
namespace Wanny\Nephtys;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use Wanny\Nephtys\Commands\Elo;
use Wanny\Nephtys\Commands\Setrank;
use Wanny\Nephtys\Commands\Stats;
use Wanny\Nephtys\Listener\NephysListener;
use Wanny\Nephtys\provider\ProviderInterface;
use Wanny\Nephtys\provider\providers\SQLiteProvider;
use Wanny\Nephtys\provider\providers\YamlProvider;
use Wanny\Nephtys\utils\EloSystem;

class Core extends PluginBase implements Listener{
    private $provider;
    private static $instance;
    public function onEnable()
    {
        self::$instance = $this;
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->setProvider();
        $this->initEvents();
        $this->initCommands();
        $this->getLogger()->info("§6NephtysElo ON - By Wanny");
    }

    public function initEvents() : void {
        $events = [new NephysListener($this)];
        foreach ($events as $event) $this->getServer()->getPluginManager()->registerEvents($event, $this);
    }

    public function initCommands() : void {
        $commandes = [new Setrank($this), new Elo($this), new Stats($this)];
        foreach ($commandes as $commande){
            $this->getServer()->getCommandMap()->register('Commandes', $commande);
        }
    }

    public function setProvider() : void {
        $providerName = $this->getConfig()->get("provider");
        $provider = null;
        switch(strtolower($providerName)){
            case "sqlite":
                $provider = new SQLiteProvider($this);
                break;
            case "yaml":
                $provider = new YamlProvider($this);
                break;
            default:
                $this->getLogger()->error("Selectionnez une base de donnés");
                $this->getServer()->getPluginManager()->disablePlugin($this);
                break;
        }

        if($provider instanceof ProviderInterface){
            $this->provider = $provider;
        }

        @mkdir($this->getDataFolder());
        @mkdir($this->getDataFolder() . "Nephtys/");
        $this->saveResource("config.yml");
        $this->saveResource("format.yml");
        $this->saveResource("elo.yml");
        $provider->prepare();
    }

    /**
     * @return ProviderInterface
     */
    public function getProvider() : ProviderInterface
    {
        return $this->provider;
    }

    /**
     * @return Core
     */
    public static function getInstance() : Core
    {
        return self::$instance;
    }

}
