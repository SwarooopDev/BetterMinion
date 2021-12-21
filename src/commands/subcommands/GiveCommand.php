<?php

declare(strict_types=1);

namespace Mcbeany\BetterMinion\commands\subcommands;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use Mcbeany\BetterMinion\commands\arguments\TypeArgument;
use Mcbeany\BetterMinion\minions\MinionType;
use Mcbeany\BetterMinion\utils\Language;
use Mcbeany\BetterMinion\utils\Utils;
use pocketmine\block\BlockLegacyIds;
use pocketmine\command\CommandSender;
use pocketmine\item\LegacyStringToItemParserException;
use pocketmine\player\Player;

class GiveCommand extends BaseSubCommand{


    public function __construct(string $name, string $description = "", array $aliases = []){
        parent::__construct($name, $description, $aliases);
        $this->usageMessage = "/minion <type> <target> <player>";
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args) : void{
        if (count($args) < 2) {
            $this->sendUsage();
            return;
        }
        $type = MinionType::fromString($args["type"]);
        if ($type === null) {
            $sender->sendMessage(Language::getInstance()->type_not_found($args["type"]));
            return;
        }
        try {
            $target = Utils::parseItem($args["target"])->getBlock();
            if ($target->getId() !== BlockLegacyIds::AIR) {
                $player = $sender;
                if (!$sender instanceof Player) {
                    if (!isset($args["player"])) {
                        $sender->sendMessage(Language::getInstance()->no_selected_player());
                        return;
                    }
                    $player = $sender->getServer()->getPlayerByPrefix($args["player"]);
                }
                if ($player === null) {
                    $sender->sendMessage(Language::getInstance()->player_not_found($args["player"]));
                    return;
                }
                // TODO: Give player's a minion spawner
            }
            return;
        } catch (LegacyStringToItemParserException) {
        }

        $sender->sendMessage(Language::getInstance()->target_not_found($args["target"]));
    }

    /**
     * @throws ArgumentOrderException
     */
	protected function prepare() : void{
        $this->setPermission("betterminion.commands.give");
		$this->registerArgument(0, new TypeArgument("type", true));
        $this->registerArgument(1, new RawStringArgument("target", true));
        $this->registerArgument(2, new RawStringArgument("player", true));
	}
}