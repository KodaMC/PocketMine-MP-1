<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
 */

declare(strict_types=1);

namespace pocketmine\entity\animation;

use pocketmine\entity\Human;
use pocketmine\item\Item;
use pocketmine\network\mcpe\convert\ItemTranslator;
use pocketmine\network\mcpe\protocol\ActorEventPacket;
use pocketmine\network\mcpe\protocol\types\ActorEvent;

final class ConsumingItemAnimation extends DictionaryAnimation{

	public function __construct(
		private Human $human, //TODO: maybe this can be expanded to more than just player entities?
		private Item $item
	){}

	public function encode() : array{
		[$netId, $netData] = ItemTranslator::getInstance()->toNetworkId($this->dictionaryProtocol, $this->item->getId(), $this->item->getMeta());
		return [
			//TODO: need to check the data values
			ActorEventPacket::create($this->human->getId(), ActorEvent::EATING_ITEM, ($netId << 16) | $netData)
		];
	}
}
