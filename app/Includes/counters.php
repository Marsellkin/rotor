<?php
/*
$days = floor((gmmktime(0, 0, 0, date("m"), date("d"), date("Y")) - gmmktime(0, 0, 0, 1, 1, 1970)) / 86400);
$hours = floor((gmmktime(date("H"), 0, 0, date("m"), date("d"), date("Y")) - gmmktime((date("Z") / 3600), 0, 0, 1, 1, 1970)) / 3600);

DB::delete("DELETE FROM `online` WHERE `updated_at`<?;", [SITETIME - setting('timeonline')]);

$newhost = 0;

if (isUser()) {
    $queryonline = DB::run() -> querySingle("SELECT `id` FROM `online` WHERE `ip`=? OR `user_id`=? ORDER BY user_id=? desc LIMIT 1;", [getClientIp(), getUsername(), getUserId()]);
    if (empty($queryonline)) {
        DB::insert("INSERT INTO `online` (`ip`, `brow`, `updated_at`, `user_id`) VALUES (?, ?, ?, ?);", [getClientIp(), getUserAgent(), SITETIME, getUserId()]);
        $newhost = 1;
    } else {
        DB::update("UPDATE `online` SET `ip`=?, `brow`=?, `updated_at`=?, `user_id`=? WHERE `id`=? LIMIT 1;", [getClientIp(), getUserAgent(), SITETIME, getUserId(), $queryonline]);
    }
} else {
    $queryonline = DB::run() -> querySingle("SELECT `id` FROM `online` WHERE `ip`=? ORDER BY user_id IS NULL desc LIMIT 1;", [getClientIp()]);
    if (empty($queryonline)) {
        DB::insert("INSERT INTO `online` (`ip`, `brow`, `updated_at`) VALUES (?, ?, ?);", [getClientIp(), getUserAgent(), SITETIME]);
        $newhost = 1;
    } else {
        DB::update("UPDATE `online` SET `brow`=?, `updated_at`=?, user_id=? WHERE `id`=? LIMIT 1;", [getUserAgent(), SITETIME, null, $queryonline]);
    }
}
// -----------------------------------------------------------//
$counts = DB::run() -> queryFetch("SELECT * FROM `counter`;");

if ($counts['hours'] != $hours) {
    DB::run() -> query("INSERT IGNORE INTO `counter24` (`hour`, `hosts`, `hits`) VALUES (?, ?, ?);", [$hours, $counts['hosts24'], $counts['hits24']]);
    DB::update("UPDATE `counter` SET `hours`=?, `hosts24`=?, `hits24`=?;", [$hours, 0, 0]);
    DB::delete("DELETE FROM `counter24` WHERE `hour` < (SELECT MIN(`hour`) FROM (SELECT `hour` FROM `counter24` ORDER BY `hour` DESC LIMIT 24) AS del);");
}

if ($counts['days'] != $days) {
    DB::run() -> query("INSERT IGNORE INTO `counter31` (`days`, `hosts`, `hits`) VALUES (?, ?, ?);", [$days, $counts['dayhosts'], $counts['dayhits']]);
    DB::update("UPDATE `counter` SET `days`=?, `dayhosts`=?, `dayhits`=?;", [$days, 0, 0]);
    DB::delete("DELETE FROM `counter31` WHERE `days` < (SELECT MIN(`days`) FROM (SELECT `days` FROM `counter31` ORDER BY `days` DESC LIMIT 31) AS del);");
    // ---------------------------------------------------//
    $querycount = DB::select("SELECT `days`, `hosts` FROM `counter31` ORDER BY `days` DESC LIMIT 6;");
    $counts = $querycount -> fetchAssoc();

    $host_data = [];
    for ($i = 0, $tekdays = $days; $i < 6; $tekdays--, $i++) {
        array_unshift($host_data, (isset($counts[$tekdays])) ? $counts[$tekdays] : 0);
    }

    file_put_contents(STORAGE.'/temp/counter7.dat', serialize($host_data), LOCK_EX);
}
// -----------------------------------------------------------//
if (!empty($newhost)) {
    DB::update("UPDATE `counter` SET `allhosts`=`allhosts`+1, `allhits`=`allhits`+1, `dayhosts`=`dayhosts`+1, `dayhits`=`dayhits`+1, `hosts24`=`hosts24`+1, `hits24`=`hits24`+1;");
} else {
    DB::update("UPDATE `counter` SET `allhits`=`allhits`+1, `dayhits`=`dayhits`+1, `hits24`=`hits24`+1;");
}
*/
