## EasyScoreboardAPI
[![GitHub license](https://img.shields.io/badge/license-MIT%20License-blue)](https://github.com/Saisana299/EasyScoreboardAPI/blob/master/LICENSE)  
EasyScoreboardAPIは指定したプレイヤーにスコアボードを表示させることができるAPIです
  
  
### 使い方  
##### ・必須Use文
```php
use Saisana299\easyscoreboardapi\EasyScoreboardAPI;
```
___
##### ・プレイヤーにスコアボードを送信
```php
EasyScoreboardAPI::createScoreboard($player, $displaySlot, $displayName, $sortOrder);
```
|変数名|入れる値|説明|
|:--:|:--:|:--:|
|$player|Playerオブジェクト|スコアボードを表示するプレイヤー|
|$displaySlot|`"sidebar"` or `"list"`|スコアボードを表示する場所|
|$displayName|文字列|スコアボードに表示する文字|
|$sortOrder|`true` or `false`|スコアの並び順です (true=降順、false=昇順)|
___
##### ・プレイヤーにスコアを表示、スコアの更新
```php
EasyScoreboardAPI::setScoreboardLine($player, $displaySlot, $message, $score, $scoreboardId);
```
|変数名|入れる値|説明|
|:--:|:--:|:--:|
|$player|Playerオブジェクト|スコアを表示するプレイヤー|
|$displaySlot|`"sidebar"` or `"list"`|スコアボードを表示した場所|
|$message|文字列|スコア名|
|$score|整数|スコア|
|$scoreboardId|整数|スコアのID (任意の数字)|
___
##### ・プレイヤーにプレイヤーのスコアを表示、スコアの更新
```php
EasyScoreboardAPI::setScoreboardPlayerLine($player, $player2, $score, $scoreboardId);
```
|変数名|入れる値|説明|
|:--:|:--:|:--:|
|$player|Playerオブジェクト|スコアを表示するプレイヤー|
|$player2|Playerオブジェクト|スコア (プレイヤー)|
|$score|整数|スコア|
|$scoreboardId|整数|スコアのID (任意の数字)|
___
##### ・プレイヤーに表示したスコアを消去
```php
EasyScoreboardAPI::removeScoreboardLine($player, $displaySlot, $scoreboardId);
```
|変数名|入れる値|説明|
|:--:|:--:|:--:|
|$player|Playerオブジェクト|表示したスコアを消去するプレイヤー|
|$displaySlot|`"sidebar"` or `"list"`|スコアボードを表示した場所|
|$scoreboardId|整数|スコアのID (任意の数字)|
___
##### ・プレイヤーに表示したスコアボードを消去
```php
EasyScoreboardAPI::removeScoreboard($player, $displaySlot);
```
|変数名|入れる値|説明|
|:--:|:--:|:--:|
|$player|Playerオブジェクト|表示したスコアボードを消去するプレイヤー|
|$displaySlot|`"sidebar"` or `"list"`|スコアボードを表示した場所|
___
##### ・プレイヤーがスコアボードを表示しているか確認  
　返り値が true= 表示されている、false= 表示されていない。
```php
EasyScoreboardAPI::hasScoreboard($player, $displaySlot);
```
|変数名|入れる値|説明|
|:--:|:--:|:--:|
|$player|Playerオブジェクト|表示したスコアボードを消去するプレイヤー|
|$displaySlot|`"sidebar"` or `"list"`|スコアボードの表示場所|
___
##### ・スコアボードを表示している全プレイヤーを取得
　配列を返します。
```php
EasyScoreboardAPI::getScoreboardPlayers($displaySlot);
```
|変数名|入れる値|説明|
|:--:|:--:|:--:|
|$displaySlot|`"sidebar"` or `"list"`|スコアボードの表示場所|
___

### 使用例  
##### sidebarに表示
```php
EasyScoreBoardAPI::createScoreBoard($player, "sidebar", "TEST", false);
EasyScoreBoardAPI::setScoreBoardLine($player, "sidebar", "時間 ", 111, 1);
EasyScoreBoardAPI::setScoreBoardLine($player, "sidebar", "時間2", 121, 2);
```
とすると...  

#### listに表示
```php
EasyScoreBoardAPI::createScoreBoard($player, "list", "TEST", false);
EasyScoreBoardAPI::setScoreBoardPlayerLine($player, $player, 1, 1);
EasyScoreBoardAPI::setScoreBoardLine($player,"list", "時間", 111, 2);
```
とすると...  
