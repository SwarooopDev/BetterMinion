<?php

declare(strict_types=1);

namespace Mcbeany\BetterMinion\events\minions;

use Mcbeany\BetterMinion\minions\entities\BaseMinion;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\item\Item;

class MinionCollectResourcesEvent extends MinionEvent implements Cancellable{
	use CancellableTrait;

	public function __construct(
		BaseMinion $minion,
		private Item $resources
	) {
		parent::__construct($minion);
	}

	public function getResource() : Item{
		return $this->resource;
	}
}
