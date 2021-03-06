<?php

namespace App\Controllers\Admin;

use App\Models\Transfer;
use Illuminate\Http\Request;

class TransferController extends AdminController
{
    /**
     * Главная страница
     *
     * @return string
     */
    public function index(): string
    {
        $total = Transfer::query()->count();
        $page = paginate(setting('listtransfers'), $total);

        $transfers = Transfer::query()
            ->orderBy('created_at', 'desc')
            ->limit($page->limit)
            ->offset($page->offset)
            ->with('user', 'recipientUser')
            ->get();

        return view('admin/transfers/index', compact('transfers', 'page'));
    }

    /**
     * Просмотр всех переводов
     *
     * @param Request $request
     * @return string
     */
    public function view(Request $request): string
    {
        $login = check($request->input('user'));

        if (! $user = getUserByLogin($login)) {
            abort(404, 'Пользователь с данным логином не найден!');
        }

        $total = Transfer::query()->where('user_id', $user->id)->count();
        $page = paginate(setting('listtransfers'), $total);

        $transfers = Transfer::query()
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit($page->limit)
            ->offset($page->offset)
            ->with('user', 'recipientUser')
            ->get();

        return view('admin/transfers/view', compact('transfers', 'page', 'user'));
    }
}
