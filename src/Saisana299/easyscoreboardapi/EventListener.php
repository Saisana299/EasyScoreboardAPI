<?php

declare(strict_types = 1);

namespace Saisana299\easyscoreboardapi;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;

class EventListener implements Listener{
	
    private $EasyScoreboardAPI;
		
    public function __construct(EasyScoreboardAPI $EasyScoreboardAPI)
    {
        $this->EasyScoreboardAPI = $EasyScoreboardAPI;
    }

    public function onQuit(PlayerQuitEvent $event){
    	$name = $event->getPlayer()->getName();
    	$this->EasyScoreboardAPI->allremove($name);
    }
}
