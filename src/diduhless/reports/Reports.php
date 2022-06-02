<?php

declare(strict_types=1);


namespace diduhless\reports;


use diduhless\reports\report\ReportListener;
use diduhless\reports\session\SessionListener;
use pocketmine\command\Command;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use pocketmine\command\CommandSender;
use diduhless\reports\report\form\ReportForm;
use diduhless\reports\report\form\ReportListForm;
use pocketmine\player\Player;

class Reports extends PluginBase {
    use SingletonTrait;

    public function onLoad(): void {
        self::setInstance($this);
        $this->saveDefaultConfig();
    }

    public function onEnable(): void {
        $this->registerEvents(new SessionListener());
        $this->registerEvents(new ReportListener());
    }

    private function registerEvents(Listener $listener): void {
        $this->getServer()->getPluginManager()->registerEvents($listener, $this);
    }
    
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
        switch($command->getName()){
            case "report":
                if($sender instanceof Player) {
                 $sender->sendForm(new ReportForm());
                } else {
                    $sender->sendMessage("command can extend in-game only");
                }
                 
            return true;
            case "reportlist":
                if($sender->hasPermission("reportlist.cmd")){
                    if(!$sender instanceof Player){
                        $sender->sendMessage("This Command Only Works for players! Please perform this command IN GAME!");
                    }else{
                        $sender->sendForm(new ReportListForm());
                    }
            return true;
    }
}

}

}