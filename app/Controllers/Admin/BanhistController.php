<?php

namespace App\Controllers\Admin;

use App\Classes\Validator;
use App\Models\Banhist;
use App\Models\User;
use Illuminate\Http\Request;

class BanhistController extends AdminController
{
    public function __construct()
    {
        parent::__construct();

        if (! isAdmin(User::MODER)) {
            abort('403', 'Доступ запрещен!');
        }
    }

    /**
     * Главная страница
     *
     * @return string
     */
    public function index(): string
    {
        $total = Banhist::query()->count();
        $page = paginate(setting('listbanhist'), $total);

        $records = Banhist::query()
            ->orderBy('created_at', 'desc')
            ->limit($page->limit)
            ->offset($page->offset)
            ->with('user', 'sendUser')
            ->get();

        return view('admin/banhists/index', compact('records', 'page'));
    }

    /**
     * История банов
     *
     * @param Request $request
     * @return string
     */
    public function view(Request $request): string
    {
        $login = check($request->input('user'));

        $user = User::query()->where('login', $login)->first();

        if (! $user) {
            abort(404, 'Пользователь не найден!');
        }

        $total = Banhist::query()->where('user_id', $user->id)->count();
        $page = paginate(setting('listbanhist'), $total);

        $banhist = Banhist::query()
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->offset($page->offset)
            ->limit($page->limit)
            ->with('user', 'sendUser')
            ->get();

        return view('admin/banhists/view', compact('user', 'banhist', 'page'));
    }

    /**
     * Удаление банов
     *
     * @param Request   $request
     * @param Validator $validator
     * @return void
     */
    public function delete(Request $request, Validator $validator): void
    {
        $page  = int($request->input('page', 1));
        $token = check($request->input('token'));
        $del   = intar($request->input('del'));
        $login = check($request->input('user'));

        $validator->equal($token, $_SESSION['token'], 'Неверный идентификатор сессии, повторите действие!')
            ->true($del, 'Отсутствуют выбранные записи для удаления!');

        if ($validator->isValid()) {
            Banhist::query()->whereIn('id', $del)->delete();

            setFlash('success', 'Выбранные записи успешно удалены!');
        } else {
            setFlash('danger', $validator->getErrors());
        }

        if ($login) {
            redirect('/admin/banhists/view?user=' . $login . '&page=' . $page);
        } else {
            redirect('/admin/banhists?page=' . $page);
        }
    }
}
