<?php
namespace lotto;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use onebone\economyapi\EconomyAPI;
use pocketmine\utils\TextFormat as color;
use pocketmine\level\sound\AnvilFallSound;

class Main extends PluginBase{
    public function onEnable() {
       
    }
    public function onCommand(CommandSender $sender, Command $command, $label, array $args) {
        switch ($command){
            case 'lottery':
                if(count($args) == 1 && $sender instanceof Player){
                if(($money = (int) $args[0]) <= 10000){ // 10000 is the money
                  //  $Smoney = EconomyAPI::getInstance()->reduceMoney($sender->getName(), $args[0]);
                    $smoney = EconomyAPI::getInstance()->myMoney($sender->getName()); // economy api
                 if($smoney < $args[0]){// economy api
                     $sender->sendMessage(color::RED."you dont have enough money!");
                     return;
                 }   
                 $r = rand(1, 100);
                   $group = $this->getServer()->getPluginManager()->getPlugin("PurePerms")->getUserDataMgr()->getGroup($sender);// pure perms api

        $groupname = $group->getName();
	$chance = 35;
	switch($groupname){
		case "RANKNAME1":
		$chance = 35;
		break;
		case "RANKNAME2":
		$chance = 37;
		break;
		case "RANKNAME3":
		$chance = 50;
		break;
	}
                 if($r <= $chance){
                     EconomyAPI::getInstance()->addMoney($sender->getName(), $args[0]);
                     $sender->sendMessage(color::GREEN."Congrats! you won §a$".$args[0]);
                     $sender->getLevel()->addSound(new AnvilFallSound($sender), [$sender]);
                    // EconomyAPI::getInstance()->reduceMoney($sender->getName(), $args[0]);
                 }  else {
                     $sender->sendMessage(color::RED."you lost $".$args[0]."! better luck next time.");
                     EconomyAPI::getInstance()->reduceMoney($sender->getName(), $args[0]);
                 }
                }  else {
                 $sender->sendMessage(color::RED."the Max is 10000!");   
                }
                }  else {
                $sender->sendMessage(color::RED."usage: /lottery (money) *note that the max is 500 and you must have the money you inputted");    
                }
                break;
        }
    }
}
