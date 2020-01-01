# EasyScoreboardAPI
[![GitHub license](https://img.shields.io/badge/license-UIUC/NCSA-blue)](https://github.com/Saisana299/EasyScoreboardAPI/blob/master/LICENSE)
[![GitHub license](https://img.shields.io/badge/release-v1.2.1-green)](https://github.com/Saisana299/EasyScoreboardAPI/releases/tag/v1.2.1)  
EasyScoreboardAPIは指定したプレイヤーにスコアボードを表示させることができるAPIです
  
### 対応状況
- [x] sidebar
- [x] list
- [ ] belowname `※1`

### ダウンロード
ダウンロードはこちら [Download](https://github.com/Saisana299/EasyScoreboardAPI/releases/tag/v1.2.1)  
  
### 使い方  
##### ・必須Use文
```php
use Saisana299\easyscoreboardapi\EasyScoreboardAPI;
```
___
##### ・スコアボードを作成しプレイヤーに送信
```php
EasyScoreboardAPI::getInstance()->sendScoreboard($player, $displaySlot, $displayName, $sortOrder);
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
EasyScoreboardAPI::getInstance()->setScore($player, $displaySlot, $message, $score, $scoreboardId);
```
|変数名|入れる値|説明|
|:--:|:--:|:--:|
|$player|Playerオブジェクト|スコアを表示するプレイヤー|
|$displaySlot|`"sidebar"` or `"list"`|スコアボードを表示した場所|
|$message|文字列|スコア名|
|$score|整数|スコア|
|$scoreboardId|整数|スコアのID (任意の数字) `※2`|
___
##### ・プレイヤーにプレイヤースコアを表示、プレイヤースコアの更新
　※listのみ表示できます(sidebarには表示できません)
```php
EasyScoreboardAPI::getInstance()->setPlayerScore($player, $player2, $score, $scoreboardId);
```
|変数名|入れる値|説明|
|:--:|:--:|:--:|
|$player|Playerオブジェクト|プレイヤースコアを表示するプレイヤー|
|$player2|Playerオブジェクト|スコア (プレイヤー)|
|$score|整数|スコア|
|$scoreboardId|整数|スコアのID (任意の数字) `※2`|
___
##### ・プレイヤーに表示したスコアを消去
```php
EasyScoreboardAPI::getInstance()->removeScore($player, $displaySlot, $scoreboardId);
```
|変数名|入れる値|説明|
|:--:|:--:|:--:|
|$player|Playerオブジェクト|表示したスコアを消去するプレイヤー|
|$displaySlot|`"sidebar"` or `"list"`|スコアボードを表示した場所|
|$scoreboardId|整数|スコアのID (任意の数字) `※2`|
___
##### ・プレイヤーに表示したスコアボードを消去
```php
EasyScoreboardAPI::getInstance()->deleteScoreboard($player, $displaySlot);
```
|変数名|入れる値|説明|
|:--:|:--:|:--:|
|$player|Playerオブジェクト|表示したスコアボードを消去するプレイヤー|
|$displaySlot|`"sidebar"` or `"list"`|スコアボードを表示した場所|
___
##### ・プレイヤーがスコアボードを表示しているか確認  
　返り値が true= 表示されている、false= 表示されていない。
```php
EasyScoreboardAPI::getInstance()->hasScoreboard($player, $displaySlot);
```
|変数名|入れる値|説明|
|:--:|:--:|:--:|
|$player|Playerオブジェクト|確認するプレイヤー|
|$displaySlot|`"sidebar"` or `"list"`|スコアボードの表示場所|
___
##### ・スコアボードを表示している全プレイヤーを取得
　配列を返します。
```php
EasyScoreboardAPI::getInstance()->getScoreboardPlayers($displaySlot);
```
|変数名|入れる値|説明|
|:--:|:--:|:--:|
|$displaySlot|`"sidebar"` or `"list"`|スコアボードの表示場所|
___
### 注釈
`※1` --- パケット名が不明なため保留中  
`※2` --- スコアのIDは好きな数字を入れてください  
```php
EasyScoreBoardAPI::getInstance()->setScore($player, "sidebar", "TEST", 1, 1);
EasyScoreBoardAPI::getInstance()->setScore($player, "sidebar", "TEST2", 1, 1);
```
この場合スコアIDが両方1なので、後からsetScoreしたものが表示されます(TEST2)  
スコア名が同じだった場合も一番最後にsetScoreしたものが表示されます。

※使えば分かると思います
___

### 使用例  
##### sidebarに表示
```php
//$playerはSaisana299
EasyScoreBoardAPI::getInstance()->sendScoreBoard($player, "sidebar", "TEST", false);
EasyScoreBoardAPI::getInstance()->setScore($player, "sidebar", "時間 ", 111, 1);
```
とすると...  
<img src="/assets/sidebar.png"> 
___

#### listに表示
```php
//$playerはSaisana299
EasyScoreBoardAPI::getInstance()->sendScoreBoard($player, "list", "TEST", false);
EasyScoreBoardAPI::getInstance()->setPlayerScore($player, $player, 1, 1);
EasyScoreBoardAPI::getInstance()->setScore($player,"list", "時間", 111, 2);
```
とすると...  
<img src="/assets/list.png">  
