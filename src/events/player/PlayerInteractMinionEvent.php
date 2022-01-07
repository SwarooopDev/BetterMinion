<?php
declare(strict_types=1);

namespace Mcbeany\BetterMinion\events\player;

use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;

class PlayerInteractMinionEvent extends PlayerMinionEvent implements Cancellable{
	use CancellableTrait;
}