<?php
App::view($config['themes'].'/index');

if (isset($_GET['act'])) {
    $act = check($_GET['act']);
} else {
    $act = 'index';
}
if (isset($_GET['start'])) {
    $start = abs(intval($_GET['start']));
} else {
    $start = 0;
}
if (isset($_GET['uz'])) {
    $uz = check($_GET['uz']);
} elseif (isset($_POST['uz'])) {
    $uz = check($_POST['uz']);
} else {
    $uz = "";
}

show_title('Рейтинг авторитетов');

switch ($act):
############################################################################################
##                                    Вывод пользователей                                 ##
############################################################################################
    case 'index':

        $total = DB::run() -> querySingle("SELECT count(*) FROM `users`;");

        if ($total > 0) {
            if ($start >= $total) {
                $start = 0;
            }

            $queryusers = DB::run() -> query("SELECT * FROM `users` ORDER BY `users_rating` DESC, `users_login` ASC LIMIT ".$start.", ".$config['avtorlist'].";");

            $i = 0;
            while ($data = $queryusers -> fetch()) {
                ++$i;

                echo '<div class="b">'.($start + $i).'. '.user_gender($data['users_login']);

                if ($uz == $data['users_login']) {
                    echo '<b><big>'.profile($data['users_login'], '#ff0000').'</big></b> (Авторитет: '.($data['users_rating']).')</div>';
                } else {
                    echo '<b>'.profile($data['users_login']).'</b> (Авторитет: '.($data['users_rating']).')</div>';
                }

                echo '<div>Плюсов: '.$data['users_posrating'].' / Минусов: '.$data['users_negrating'].'<br />';
                echo 'Дата регистрации: '.date_fixed($data['users_joined'], 'j F Y').'</div>';
            }

            page_strnavigation('/authoritylist?', $config['avtorlist'], $start, $total);

            echo '<div class="form">';
            echo '<b>Поиск пользователя:</b><br />';
            echo '<form action="/authoritylist?act=search&amp;start='.$start.'" method="post">';
            echo '<input type="text" name="uz" value="'.$log.'" />';
            echo '<input type="submit" value="Искать" /></form></div><br />';

            echo 'Всего пользователей: <b>'.$total.'</b><br /><br />';
        } else {
            show_error('Пользователей еще нет!');
        }
    break;

    ############################################################################################
    ##                                  Поиск пользователя                                    ##
    ############################################################################################
    case 'search':

        if (!empty($uz)) {
            $queryuser = DB::run() -> querySingle("SELECT `users_login` FROM `users` WHERE LOWER(`users_login`)=? OR LOWER(`users_nickname`)=? LIMIT 1;", array(strtolower($uz), utf_lower($uz)));

            if (!empty($queryuser)) {
                $queryrating = DB::run() -> query("SELECT `users_login` FROM `users` ORDER BY `users_rating` DESC, `users_login` ASC;");
                $ratusers = $queryrating -> fetchAll(PDO::FETCH_COLUMN);

                foreach ($ratusers as $key => $ratval) {
                    if ($queryuser == $ratval) {
                        $rat = $key + 1;
                    }
                }

                if (!empty($rat)) {
                    $page = floor(($rat - 1) / $config['avtorlist']) * $config['avtorlist'];

                    $_SESSION['note'] = 'Позиция в рейтинге: '.$rat;
                    redirect("/authoritylist?start=$page&uz=$queryuser");
                } else {
                    show_error('Пользователь с данным логином не найден!');
                }
            } else {
                show_error('Пользователь с данным логином не зарегистрирован!');
            }
        } else {
            show_error('Ошибка! Вы не ввели логин или ник пользователя');
        }

        echo '<i class="fa fa-arrow-circle-left"></i> <a href="/authoritylist?start='.$start.'">Вернуться</a><br />';
    break;

endswitch;

App::view($config['themes'].'/foot');