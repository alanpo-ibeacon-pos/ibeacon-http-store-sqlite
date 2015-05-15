<?php

if (count($_POST) == 0) {
    http_response_code(500);
    echo '
　　　　　　　　　 ／　.:.:.:.:.:／:.:.:.:＼:.:.:.:.:.:{:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:{　　 ヽ　　 　 ｝                    <br/>
　　　　　　--=彡 .:.:.:.:.:.／:.:.:.:.:.:.:.:.: ＼:.:.:., :.:.:.:.:.:.:.:.:.:.:.:.:.: { 　 ＼ ｀¨¨¨¨ヽ                    <br/>
　　　　　 　 ／.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:{　　　 ＼　 　 ﾉ      <br/>
　　　　　　　.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.ﾊ　　　　 ヽ　/     <br/>
　　　　　/ ｲ:.:.:.:.:.:/:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.|､:.:.:.:.:.:.:.:.:.:.:.:.:.ﾊ　　　　　ｲ          <br/>
　　　　　ﾘ ′ .:.:.:′:.:.:.:.:.:.:.:.:ハ:.:.:.:.:.:.:.:.:.:.:.:.|斗:ぃ.jﾄＶ:.:.:.:.:.:.:.＼___／:.: ＼                     <br/>
　　　　　　}/:.:.:.:j:.:.:.:.:.:.:.:.:.:.:/⌒!:.:.:.:.:ハ:.:.:.:jlﾆリﾆリﾆＶ:.:.:.:.:.:.:.:.:.:.:.、:.:.:.:.　:,           <br/>
　　　　　　|:.:.:.:.:.|:.:.:.:.:|:.:.:.:./ﾆﾆj八:.:j二∨:.j| .ィ示㍉,_ :.:.:.:.:.:.:.:.:.:.:. }＼:.:. : }ﾊ                  <br/>
　　　　　　|:.ﾊ :.:|:.:.:.:.:|:.:.{/ﾆﾆﾆﾆﾆリﾆ／ゞﾘ　{イh}::} ’∨:.:.:.:.リ:. : }　　v:. }:ﾊ                                  <br/>
　　　　　　リ.ｲ:.:ﾊ:八:|:.:.|=ﾆﾆﾆﾆニ／　 　′.乂いﾉ 　 }:.:.:.:.:.:{:.:.:.ﾘ　　 }:. } ﾘ                                      <br/>
　　　　　　 / {:.:.:.:.:.|:.:.Ｗ二ﾆﾆﾆ／ 　 ,　　 /::/::/::/::　/、:.:.:.:.:.:.:.:{　 　 }:. }                              <br/>
　　　 　 　 |　 〉 :.:.:|:.:.:.|､_｀¨¨¨´　　　　　　　　　　 　/ィ:.:}＼:.:.:.:.:}　　,ﾉイ                                   <br/>
　　　 　 　 |　{:.:.ﾊ:.:＼j|ﾊﾍ　　　　　　，､　　　　　　ｲﾊ:.(｀　 ヾ:.:.:j                                                  <br/>
.　　　　 　 　 乂{ ＼:.:{＼ ゞ＞　　　　　　　　　 ィf/ ﾘ 　＿_____}ノ                                                       <br/>
　　　　　　　　　　＿ヾ〉_　　　 r‐}＞　__　＜ｲハ____,／　　　　　＼                                                          <br/>
　　 　 　 　 　 ／　 　 　 ｀ヽ_/: : ＼,.. ＜´: : : :./ ／:i:i:i:i:i:i:i:i:i:i:i:i:　 ＼                                   <br/>
　　　　　　　 / : : : : : : : ／￣〉γ:ぃ ､ : : : : ｨ　/⌒ヽ:i:i:i:i:i:i:i:i:i:i:i:i:　　ゝ,，― ､                            <br/>
　　 　 　 　 / : : : : : : :./イ 　 ノ{:::::}.}　＼／:.|　j⌒!　}:i:i:i:i:i:i:i:i:i:i:i:i:i:i:i:／.....--..}               <br/>
.　 　 　 　 /: : : : : :{: :∧　　　　 ｰ彳 　　ヽ: :l　乂ﾉ .ﾉ:i:i:i:i:i:i:i:i:i:i:i:ｉ:／..／.........ﾉ                      <br/>


NONONO 㗎';
    die(1);
}

$db = null;

try {
    if (empty($_POST['jsonData'])) throw new Exception('jsonContent is empty()');

    $jsonObj = json_decode($_POST['jsonData']);

    $dir = dirname($_SERVER['DOCUMENT_ROOT']) . '/sqlite_db';
    if (!file_exists($dir)) {
        mkdir($dir, 0644, true);
    }
    $db = new SQLite3($dir . '/ibeacons.sqlite3');
    unset($dir);
    $db->enableExceptions(true);

    $db->exec('BEGIN TRANSACTION');

    $db->exec('CREATE TABLE IF NOT EXISTS `traces` (
                   `datetime` TEXT DEFAULT CURRENT_TIMESTAMP,
                   `selfMac` INTEGER NOT NULL,
                   `uuid` BLOB NOT NULL,
                   `major` INTEGER NOT NULL,
                   `minor` INTEGER NOT NULL,
                   `mac` INTEGER NOT NULL,
                   `txpower` INTEGER NOT NULL,
                   `rssi` INTEGER NOT NULL
               )');

    $stmt = $db->prepare("INSERT INTO traces(datetime, selfMac,`uuid`,major,minor,mac,txpower,rssi) VALUES(:datetime, :selfMac,:uuid,:major,:minor,:mac,:txpower,:rssi)");
    $stmt->bindParam(':datetime', $dateTime, SQLITE3_TEXT);
    $stmt->bindParam(':selfMac', $hexSelfMac, SQLITE3_INTEGER);
    $stmt->bindParam(':uuid', $binUuid, SQLITE3_BLOB);
    $stmt->bindParam(':major', $major, SQLITE3_INTEGER);
    $stmt->bindParam(':minor', $minor, SQLITE3_INTEGER);
    $stmt->bindParam(':mac', $hexMac, SQLITE3_INTEGER);
    $stmt->bindParam(':txpower', $txpower, SQLITE3_INTEGER);
    $stmt->bindParam(':rssi', $rssi, SQLITE3_INTEGER);
    foreach ($jsonObj as $el) {
        $dateTime = $el->datetime;
        $hexSelfMac = hexdec($el->selfMac);
        $binUuid = pack("H*", $el->uuid);
        $major = $el->major;
        $minor = $el->minor;
        $hexMac = hexdec($el->mac);
        $txpower = $el->txpower;
        $rssi = $el->rssi;
        $result = $stmt->execute();
    }

    $db->exec('COMMIT TRANSACTION');

    $db->close();

    echo 1;
} catch (Exception $e) {
    if (!is_null($db)) $db->close();
    http_response_code(500);
    echo $e;
    die(1);
}

