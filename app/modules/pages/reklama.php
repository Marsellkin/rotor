<?php
App::view($config['themes'].'/index');

$start = abs(intval(Request::input('start', 0)));

show_title('Реклама на сайте');

if (!empty($config['rekusershow'])) {
switch ($act):
############################################################################################
##                                    Главная страница                                    ##
############################################################################################

case 'index':

    $config['newtitle'] = 'Список всех ссылок';

    $total = DBM::run()->count('rekuser', array('rek_time' => array('>', SITETIME)));
    if ($total > 0) {
        if ($start >= $total) {
            $start = 0;
        }

        $reklama = DBM::run()->select('rekuser', array(
            'rek_time' => array('>', SITETIME),
        ), $config['rekuserpost'], $start, array('rek_time'=>'DESC'));

        foreach($reklama as $data) {
            echo '<div class="b">';
            echo '<i class="fa fa-check-circle"></i> ';
            echo '<b><a href="'.$data['rek_site'].'">'.$data['rek_name'].'</a></b> ('.profile($data['rek_user']).')</div>';

            echo 'Истекает: '.date_fixed($data['rek_time']).'<br />';

            if (! empty($data['rek_color'])) {
                echo 'Цвет: <span style="color:'.$data['rek_color'].'">'.$data['rek_color'].'</span>, ';
            } else {
                echo 'Цвет: нет, ';
            }

            if (! empty($data['rek_bold'])) {
                echo 'Жирность: есть<br />';
            } else {
                echo 'Жирность: нет<br />';
            }
        }

        page_strnavigation('/reklama?act=all&amp;', $config['rekuserpost'], $start, $total);

        echo 'Всего ссылок: <b>'.$total.'</b><br /><br />';
    } else {
        show_error('В данный момент рекламных ссылок еще нет!');
    }

    echo '<i class="fa fa-money"></i> <a href="/reklama/create">Купить рекламу</a><br />';
    break;

############################################################################################
##                                   Добавление ссылки                                    ##
############################################################################################
case 'create':

    if (is_user()) {
        if ($udata['point'] >= 50) {

            if (Request::isMethod('post')) {
                $uid = !empty($_GET['uid']) ? check($_GET['uid']) : 0;
                $site = isset($_POST['site']) ? check($_POST['site']) : '';
                $name = isset($_POST['name']) ? check($_POST['name']) : '';
                $color = isset($_POST['color']) ? check($_POST['color']) : '';
                $bold = (empty($_POST['bold'])) ? 0 : 1;
                $provkod = isset($_POST['provkod']) ? check(strtolower($_POST['provkod'])) : '';

                $validation = new Validation();

                $validation -> addRule('equal', array($uid, $_SESSION['token']), 'Неверный идентификатор сессии, повторите действие!')
                    -> addRule('max', array($udata['point'], 50), 'Для покупки рекламы вам необходимо набрать '.points(50).'!')
                    -> addRule('equal', array($provkod, $_SESSION['protect']), 'Проверочное число не совпало с данными на картинке!')
                    -> addRule('regex', array($site, '|^http://([а-яa-z0-9_\-\.])+(\.([а-яa-z0-9\/\-?_=#])+)+$|iu'), 'Недопустимый адрес сайта!. Разрешены символы [а-яa-z0-9_-.?=#/]!', true)
                    -> addRule('string', $site, 'Слишком длинный или короткий адрес ссылки!', true, 5, 50)
                    -> addRule('string', $name, 'Слишком длинное или короткое название ссылки!', true, 5, 35)
                    -> addRule('regex', array($color, '|^#+[A-f0-9]{6}$|'), 'Недопустимый формат цвета ссылки! (пример #ff0000)', false);

                if ($validation->run()) {

                    DBM::run()->delete('rekuser', array('rek_time' => array('<', SITETIME)));

                    $total = DBM::run()->count('rekuser', array('rek_time' => array('>', SITETIME)));

                    if ($total < $config['rekusertotal']) {

                        $rekuser = DBM::run()->selectFirst('rekuser', array('rek_user' => $log));

                        if (empty($rekuser)) {
                            $price = $config['rekuserprice'];

                            if (!empty($color)) {
                                $price = $price + $config['rekuseroptprice'];
                            }

                            if (!empty($bold)) {
                                $price = $price + $config['rekuseroptprice'];
                            }

                            if ($udata['money'] >= $price) {

                                $rek = DBM::run()->insert('rekuser', array(
                                    'rek_site'  => $site,
                                    'rek_name'  => $name,
                                    'rek_color' => $color,
                                    'rek_bold' => $bold,
                                    'rek_user' => $log,
                                    'rek_time' => SITETIME + ($config['rekusertime'] * 3600),
                                ));

                                $user = DBM::run()->update('users', array(
                                    'money' => array('-', $price),
                                ), array(
                                    'login' => $log
                                ));

                                save_advertuser();

                                notice('Рекламная ссылка успешно размещена (Cписано: '.moneys($price).')');
                                redirect("/reklama");

                            } else {
                                show_error('Ошибка! Для покупки рекламы у вас недостаточно денег!');
                            }
                        } else {
                            show_error('Ошибка! Вы уже разместили рекламу, запрещено добавлять несколько сайтов подряд!');
                        }
                    } else {
                        show_error('Ошибка! В данный момент нет свободных мест для размещения рекламы!');
                    }
                } else {
                    show_error($validation->getErrors());
                }
            }


            $total = DBM::run()->count('rekuser', array('rek_time' => array('>', SITETIME)));

            if ($total < $config['rekusertotal']) {

                $rekuser = DBM::run()->selectFirst('rekuser', array('rek_user' => $log, 'rek_time' => array('>', SITETIME)));

                if (empty($rekuser)) {
                    echo 'У вас в наличии: <b>'.moneys($udata['money']).'</b><br /><br />';

                    echo '<div class="form">';
                    echo '<form method="post" action="/reklama/create">';
                    echo '<input type="hidden" name="token" value="'.$_SESSION['token'].'">';

                    echo 'Адрес сайта:<br />';
                    echo '<input name="site" type="text" value="http://" maxlength="50" /><br />';

                    echo 'Название ссылки:<br />';
                    echo '<input name="name" type="text" maxlength="35" /><br />';

                    echo 'Код цвета:';

                    if (file_exists(BASEDIR.'/modules/services/colors.php')) {
                        echo ' <a href="/services/colors">(?)</a>';
                    }
                    echo '<br />';
                    echo '<input name="color" type="text" maxlength="7" /><br />';

                    echo 'Жирность: ';
                    echo '<input name="bold" type="checkbox" value="1" /><br />';

                    echo 'Проверочный код:<br />';
                    echo '<img src="/captcha" alt="" /><br />';
                    echo '<input name="provkod" size="6" maxlength="6" /><br />';

                    echo '<br /><input value="Купить" type="submit" /></form></div><br />';

                    echo 'Стоимость размещения ссылки '.moneys($config['rekuserprice']).' за '.$config['rekusertime'].' часов<br />';
                    echo 'Цвет и жирность опционально, стоимость каждой опции '.moneys($config['rekuseroptprice']).'<br />';
                    echo 'Ссылка прокручивается на всех страницах сайта с другими ссылками пользователей<br />';
                    echo 'В названии ссылки запрещено использовать любые ненормативные и матные слова<br />';
                    echo 'Адрес ссылки не должен направлять на прямое скачивание какого-либо контента<br />';
                    echo 'Запрещены ссылки на сайты с алярмами и порно<br />';
                    echo 'За нарушение правил предусмотрено наказание в виде строгого бана<br /><br />';

                } else {
                    show_error('Ошибка! Вы уже разместили рекламу, запрещено добавлять несколько сайтов подряд!');
                }
            } else {
                show_error('В данный момент нет свободных мест для размещения рекламы!');
            }
        } else {
            show_error('Ошибка! Для покупки рекламы вам необходимо набрать '.points(50).'!');
        }
    } else {
        show_login('Вы не авторизованы, для покупки рекламы, необходимо');
    }

    echo '<i class="fa fa-arrow-circle-left"></i> <a href="/reklama">Вернуться</a><br />';
break;

endswitch;

} else {
    show_error('Показ и размещение рекламы запрещено администрацией сайта!');
}

App::view($config['themes'].'/foot');
