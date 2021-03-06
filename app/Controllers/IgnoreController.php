<?php

namespace App\Controllers;

use App\Classes\Validator;
use App\Models\Ignore;
use App\Models\User;
use Illuminate\Http\Request;

class IgnoreController extends BaseController
{
    /**
     * Конструктор
     */
    public function __construct()
    {
        parent::__construct();

        if (! getUser()) {
            abort(403, 'Для просмотра игнор-листа необходимо авторизоваться!');
        }
    }

    /**
     * Главная страница
     *
     * @param Request   $request
     * @param Validator $validator
     * @return string
     */
    public function index(Request $request, Validator $validator): string
    {
        if ($request->isMethod('post')) {
            $page  = int($request->input('page', 1));
            $token = check($request->input('token'));
            $login = check($request->input('user'));

            $validator->equal($token, $_SESSION['token'], 'Неверный идентификатор сессии, повторите действие!');

            $user = User::query()->where('login', $login)->first();
            $validator->notEmpty($user, ['user' => 'Данного пользователя не существует!']);

            if ($user) {
                $validator->notEqual($user->login, getUser('login'), ['user' => 'Запрещено добавлять свой логин!']);

                $totalIgnore = Ignore::query()->where('user_id', getUser('id'))->count();
                $validator->lte($totalIgnore, setting('limitignore'), 'Ошибка! Игнор-лист переполнен (Максимум ' . setting('limitignore') . ' пользователей!)');

                $validator->false(getUser()->isIgnore($user), ['user' => 'Данный пользователь уже есть в игнор-листе!']);
                $validator->notIn($user->level, User::ADMIN_GROUPS, ['user' => 'Запрещено добавлять в игнор администрацию сайта']);
            }

            if ($validator->isValid()) {

                Ignore::query()->create([
                    'user_id'    => getUser('id'),
                    'ignore_id'  => $user->id,
                    'created_at' => SITETIME,
                ]);

                if (! $user->isIgnore(getUser())) {
                    $message = 'Пользователь [b]' . getUser('login') . '[/b] добавил вас в свой игнор-лист!';
                    $user->sendMessage(getUser(), $message);
                }

                setFlash('success', 'Пользователь успешно добавлен в игнор-лист!');
                redirect('/ignores?page=' . $page);
            } else {
                setInput($request->all());
                setFlash('danger', $validator->getErrors());
            }
        }

        $total = Ignore::query()->where('user_id', getUser('id'))->count();
        $page = paginate(setting('ignorlist'), $total);

        $ignores = Ignore::query()
            ->where('user_id', getUser('id'))
            ->orderBy('created_at', 'desc')
            ->offset($page->offset)
            ->limit($page->limit)
            ->with('ignoring')
            ->get();

        return view('ignores/index', compact('ignores', 'page'));
    }

    /**
     * Заметка для пользователя
     *
     * @param int       $id
     * @param Request   $request
     * @param Validator $validator
     * @return string
     */
    public function note(int $id, Request $request, Validator $validator): string
    {
        $ignore = Ignore::query()
            ->where('user_id', getUser('id'))
            ->where('id', $id)
            ->first();

        if (! $ignore) {
            abort(404, 'Запись не найдена');
        }

        if ($request->isMethod('post')) {

            $token = check($request->input('token'));
            $msg   = check($request->input('msg'));

            $validator->equal($token, $_SESSION['token'], ['msg' => 'Неверный идентификатор сессии, повторите действие!'])
                ->length($msg, 0, 1000, ['msg' => 'Слишком большая заметка, не более 1000 символов!']);

            if ($validator->isValid()) {

                $ignore->update([
                    'text' => $msg,
                ]);

                setFlash('success', 'Заметка успешно отредактирована!');
                redirect('/ignores');
            } else {
                setInput($request->all());
                setFlash('danger', $validator->getErrors());
            }
        }

        return view('ignores/note', compact('ignore'));
    }

    /**
     * Удаление контактов
     *
     * @param Request   $request
     * @param Validator $validator
     */
    public function delete(Request $request, Validator $validator): void
    {
        $page  = int($request->input('page', 1));
        $token = check($request->input('token'));
        $del   = intar($request->input('del'));

        $validator->equal($token, $_SESSION['token'], 'Неверный идентификатор сессии, повторите действие!')
            ->true($del, 'Отсутствуют выбранные пользователи для удаления!');

        if ($validator->isValid()) {

            Ignore::query()
                ->where('user_id', getUser('id'))
                ->whereIn('id', $del)
                ->delete();

            setFlash('success', 'Выбранные пользователи успешно удалены!');
        } else {
            setFlash('danger', $validator->getErrors());
        }

        redirect('/ignores?page=' . $page);
    }
}
