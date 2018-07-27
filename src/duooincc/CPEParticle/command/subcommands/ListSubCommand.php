<?php

namespace duooincc\CPEParticle\command\subcommands;

use duooincc\CPEParticle\command\{
	PoolCommand, SubCommand
};
use duooincc\CPEParticle\util\{
	Translation, Utils
};
use pocketmine\command\CommandSender;
use pocketmine\Server;

class ListSubCommand extends SubCommand{
	public function __construct(PoolCommand $owner){
		parent::__construct($owner, 'list');
	}

	/**
	 * @param CommandSender $sender
	 * @param String[]      $args
	 *
	 * @return bool
	 */
	public function onCommand(CommandSender $sender, array $args) : bool{
		$list = [];
		foreach($this->plugin->getConfig()->getAll() as $key => $value){
			if(($player = Server::getInstance()->getPlayerExact($key)) !== null){
				$key = $player->getName();
			}
			$list[] = [
				$key,
				$value[0],
				Translation::translate($value[1] == 1 ? 'modename@head' : 'modename@foot'),
				$value[2],
			];
		}

		$max = ceil(count($list) / 5);
		$page = min($max, (isset($args[0]) ? Utils::toInt($args[0], 1, function(int $i){
				return $i > 0 ? 1 : -1;
			}) : 1) - 1);
		$sender->sendMessage($this->translate('head', $page + 1, $max));
		for($i = $page * 5; $i < ($page + 1) * 5 && $i < count($list); $i++){
			$sender->sendMessage($this->translate('item', ...$list[$i]));
		}

		return true;
	}
}
