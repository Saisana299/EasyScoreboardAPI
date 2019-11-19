<?php

declare(strict_types = 1);

namespace Saisana299\easyscoreboardapi;

use pocketmine\plugin\PluginBase;
use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\Player;
use pocketmine\Server;

class EasyScoreboardAPI extends PluginBase{

	/** @var array */
	private static $sidebar = [];
	/** @var array */
	private static $list = [];
	/** @var null */
	private static $instance = null;

	public static function getInstance(){
		return self::$instance;
	}

    public function onEnable(){
		$this->getLogger()->info("§eEasy§aScore§bBoard§cAPI§fを読み込みました");
        if (!file_exists($this->getDataFolder())) mkdir($this->getDataFolder(), 0744, true);
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        self::$instance = $this;
    }

    public function allremove(string $name){
		if(isset(self::$sidebar[$name])){
			unset(self::$sidebar[$name]);
		}
		if(isset(self::$list[$name])){
			unset(self::$list[$name]);
		}
    }

	//以下API
	
	/**
	 * スコアボードを作成し、プレイヤーに表示します
	 * 
	 * @param  Player   $player           
	 * @param  string   $displaySlot    [スコアボードの表示場所 (sidebar, list)]
	 * @param  string   $displayName    [スコアボードの表示名]
	 * @param  boolean  $sortOrder      [並び順 (true = スコアが多い順 | false = スコアが少ない順)]
	 */
	public function sendScoreboard(Player $player, string $displaySlot, string $displayName, bool $sortOrder): void{

		if($displaySlot !== "sidebar" && $displaySlot !== "list"){
			return;
		}

		if($displaySlot === "sidebar"){
			if(isset(self::$sidebar[$player->getName()])){
				self::deleteScoreboard($player,$displaySlot);
			}
		}elseif($displaySlot === "list"){
			if(isset(self::$list[$player->getName()])){
				self::deleteScoreboard($player,$displaySlot);
			}
		}

		if($sortOrder === true){
			$sortOrder = 1;
		}else{
			$sortOrder = 0;
		}
		
		$pk = new SetDisplayObjectivePacket();
		$pk->displaySlot = $displaySlot;
		$pk->objectiveName = $displaySlot;
		$pk->displayName = $displayName;
		$pk->criteriaName = "dummy";
		$pk->sortOrder = $sortOrder;
		$player->sendDataPacket($pk);

		if($displaySlot === "sidebar"){
			self::$sidebar[$player->getName()] = true;
		}elseif($displaySlot === "list"){
			self::$list[$player->getName()] = true;
		}
	}
	
	/**
	 * プレイヤーに表示されているスコアボードを消去します
	 * 
	 * @param  Player $player       
	 * @param  string $displaySlot  [スコアボードの表示場所 (sidebar, list)]
	 */
	public function deleteScoreboard(Player $player, string $displaySlot): void{

		if($displaySlot !== "sidebar" && $displaySlot !== "list"){
			return;
		}

		$pk = new RemoveObjectivePacket();
		$pk->objectiveName = $displaySlot;
		$player->sendDataPacket($pk);

		if($displaySlot === "sidebar"){
			if(isset(self::$sidebar[$player->getName()])){
				unset(self::$sidebar[$player->getName()]);
			}
		}elseif($displaySlot === "list"){
			if(isset(self::$list[$player->getName()])){
				unset(self::$list[$player->getName()]);
			}
		}
	}
	
	/**
	 * プレイヤーのスコアボードにスコアを追加・更新します
	 * 
	 * @param Player  $player          
	 * @param string  $displaySlot   [スコアボードの表示場所 (sidebar, list)]
	 * @param string  $message       [スコアの名前]
	 * @param int     $score         [スコア]
	 * @param int     $scoreboardId  [スコアのID (任意の数字)]
	 */
	public function setScore(Player $player, string $displaySlot, string $message, int $score, int $scoreboardId): void{

		if($displaySlot !== "sidebar" && $displaySlot !== "list"){
			return;
		}

		if($displaySlot === "sidebar"){
			if(!isset(self::$sidebar[$player->getName()])){
			return;
			}
		}elseif($displaySlot === "list"){
			if(!isset(self::$list[$player->getName()])){
			return;
			}
		}
		
		$entry = new ScorePacketEntry();
		$entry->objectiveName = $displaySlot;
		$entry->type = $entry::TYPE_FAKE_PLAYER;
		$entry->customName = $message;
		$entry->score = $score;
		$entry->scoreboardId = $scoreboardId;
		
		$pk = new SetScorePacket();
		$pk->type = $pk::TYPE_CHANGE;
		$pk->entries[] = $entry;
		$player->sendDataPacket($pk);
	}

	/**
	 * プレイヤーのスコアボードにプレイヤースコアを追加・更新します
	 * 
	 * @param Player  $player        
	 * @param Player  $player2       [プレイヤースコア]
	 * @param int     $score         [スコア]
	 * @param int     $scoreboardId  [スコアのID (任意の数字)]
	 */
	public function setPlayerScore(Player $player, Player $player2, int $score, int $scoreboardId): void{

		if(!isset(self::$list[$player->getName()])){
			return;
		}
		
		$entry = new ScorePacketEntry();
		$entry->objectiveName = "list";
		$entry->type = $entry::TYPE_PLAYER;
		$entry->entityUniqueId = $player2->getId();
		$entry->score = $score;
		$entry->scoreboardId = $scoreboardId;
		
		$pk = new SetScorePacket();
		$pk->type = $pk::TYPE_CHANGE;
		$pk->entries[] = $entry;
		$player->sendDataPacket($pk);
	}

	/**
	 * プレイヤーのスコアボードのスコアを消去します
	 * 
	 * @param  Player $player         
	 * @param  string $displaySlot   [スコアボードの表示場所 (sidebar, list)]
	 * @param  int    $scoreboardId  [スコアのID] 
	 */
	public function removeScore(Player $player, string $displaySlot, int $scoreboardId): void{

		if($displaySlot !== "sidebar" && $displaySlot !== "list"){
			return;
		}

		if($displaySlot === "sidebar"){
			if(!isset(self::$sidebar[$player->getName()])){
			return;
			}
		}elseif($displaySlot === "list"){
			if(!isset(self::$list[$player->getName()])){
			return;
			}
		}

		$entry = new ScorePacketEntry();
		$entry->objectiveName = $displaySlot;
		$entry->scoreboardId = $scoreboardId;

		$pk = new SetScorePacket();
		$pk->type = $pk::TYPE_REMOVE;
		$pk->entries[] = $entry;
		$player->sendDataPacket($pk);
	}

	/**
	 * プレイヤーがスコアボードを表示しているかを確認します
	 * 
	 * @param  Player  $player       
	 * @param  string  $displaySlot [スコアボードの表示場所 (sidebar, list)]
	 */
	public function hasScoreboard(Player $player, string $displaySlot): bool{
		if($displaySlot === "sidebar"){
			return (isset(self::$sidebar[$player->getName()])) ? true : false;
		}elseif($displaySlot === "list"){
			return (isset(self::$list[$player->getName()])) ? true : false;
		}
		return false;
	}

	/**
	 * スコアボードを表示している全プレイヤーを取得
	 * 
	 * @param  string  $displaySlot [スコアボードの表示場所 (sidebar, list)]
	 */
	public function getScoreboardPlayers(string $displaySlot): array{
		if($displaySlot === "sidebar"){
			return self::$sidebar;
		}elseif($displaySlot === "list"){
			return self::$list;
		}
		return false;
	}
	
}
