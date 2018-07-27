<?php

namespace duooincc\CPEParticle\command\subcommands;

use duooincc\CPEParticle\command\{
	PoolCommand, SubCommand
};
use duooincc\CPEParticle\util\Translation;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class RemoveSubCommand extends SubCommand{
	public function __construct(PoolCommand $owner){
		parent::__construct($owner, 'remove');
	}

	/**
	 * @param CommandSender $sender
	 * @param String[]      $args
	 *
	 * @return bool
	 */
	public function onCommand(CommandSender $sender, array $args) : bool{
		if(isset($args[0])){
			$config = $this->plugin->getConfig();
			if($args[0] === '*' && $sender instanceof Player){
				$playerName = $sender->getLowerCaseName();
			}else{
				if(!$config->exists($args[0], true)){
					$sender->sendMessage(Translation::translate('command-generic-failure@invalid-player', $args[0]));
					return true;
				}
				$playerName = strtolower($args[0]);
			}
			$config->remove($playerName);
			$sender->sendMessage($this->translate('success', $playerName));
			return true;
		}
		return false;
	}
}
