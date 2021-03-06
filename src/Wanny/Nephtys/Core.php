<?php
namespace Wanny\Nephtys;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use TheNote\core\invmenu\InvMenuHandler;
use Wanny\Nephtys\Commands\Boutique;
use Wanny\Nephtys\Commands\Clear;
use Wanny\Nephtys\Commands\Ec;
use Wanny\Nephtys\Commands\Elo;
use Wanny\Nephtys\Commands\Freeze;
use Wanny\Nephtys\Commands\Kit;
use Wanny\Nephtys\Commands\MoneyCmd\Money;
use Wanny\Nephtys\Commands\MoneyCmd\Pay;
use Wanny\Nephtys\Commands\MoneyCmd\Setmoney;
use Wanny\Nephtys\Commands\Setrank;
use Wanny\Nephtys\Commands\Stats;
use Wanny\Nephtys\Commands\Teleportation\Tpaccept;
use Wanny\Nephtys\Commands\Teleportation\Tpahere;
use Wanny\Nephtys\Commands\Teleportation\Tpdeny;
use Wanny\Nephtys\Listener\EcListener;
use Wanny\Nephtys\Listener\NephysListener;
use Wanny\Nephtys\provider\ProviderInterface;
use Wanny\Nephtys\provider\providers\SQLiteProvider;
use Wanny\Nephtys\provider\providers\YamlProvider;
use Wanny\Nephtys\utils\Utils;

class Core extends PluginBase implements Listener{
    private $provider;
    private static $instance;
    public function onEnable() : void
    {
        self::$instance = $this;
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->setProvider();
        $this->initEvents();
        $this->initCommands();
        $this->getLogger()->info("§6NephtysElo ON - By Wanny");
        if (!InvMenuHandler::isRegistered()) {
            InvMenuHandler::register($this);
        }
    }

    public function initEvents() : void {
        $events = [new NephysListener($this), new EcListener($this)];
        foreach ($events as $event) $this->getServer()->getPluginManager()->registerEvents($event, $this);
    }

    public function initCommands() : void {
        $commandes = [new Setrank($this), new Elo($this), new Stats($this), new Money($this), new Setmoney($this), new Pay($this), new Kit($this),
            new Ec($this), new Tpahere($this), new Tpaccept($this), new Tpdeny($this), new Clear($this), new Freeze($this), new Boutique($this),
            new Clear($this)];
        //Utils::savePermissions();
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
        @mkdir($this->getDataFolder() . "Kits/");
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