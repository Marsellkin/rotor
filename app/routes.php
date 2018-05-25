<?php

$router = new AltoRouter();

$router->addMatchTypes(['user' => '[0-9A-Za-z-_]++']);
$router->addMatchTypes(['letter'=> '[0-9a-z]']);

$routes = [
    ['GET',      '/', 'Controllers\HomeController@index', 'home'],
    ['GET',      '/captcha', 'Controllers\HomeController@captcha', 'captcha'],
    ['GET',      '/closed', 'Controllers\HomeController@closed'],
    ['GET|POST', '/banip', 'Controllers\HomeController@banip'],

    ['GET',      '/guestbooks', 'Controllers\GuestbookController@index', 'book'],
    ['POST',     '/guestbooks/add', 'Controllers\GuestbookController@add'],
    ['GET|POST', '/guestbooks/edit/[i:id]', 'Controllers\GuestbookController@edit'],

    ['GET',      '/sitemap.xml', 'Controllers\SitemapController@index'],
    ['GET',      '/sitemap/[a:action].xml', 'Controllers\SitemapController'],

    ['GET',      '/blogs', 'Controllers\BlogController@index', 'blogs'],
    ['GET',      '/blogs/[i:id]', 'Controllers\BlogController@blog'],
    ['GET',      '/blogs/tags/[*:tag]?', 'Controllers\BlogController@tags'],
    ['GET|POST', '/blogs/create', 'Controllers\BlogController@create'],
    ['GET',      '/blogs/authors', 'Controllers\BlogController@authors'],
    ['GET',      '/blogs/active/articles', 'Controllers\BlogController@userArticles'],
    ['GET',      '/blogs/active/comments', 'Controllers\BlogController@userComments'],
    ['GET',      '/blogs/top', 'Controllers\BlogController@top'],
    ['GET',      '/blogs/rss', 'Controllers\BlogController@rss'],
    ['GET|POST', '/blogs/search', 'Controllers\BlogController@search'],
    ['GET',      '/articles', 'Controllers\BlogController@newArticles'],
    ['GET',      '/articles/[i:id]', 'Controllers\BlogController@view'],
    ['GET|POST', '/articles/edit/[i:id]', 'Controllers\BlogController@edit'],
    ['GET',      '/articles/print/[i:id]', 'Controllers\BlogController@print'],
    ['GET',      '/articles/rss/[i:id]', 'Controllers\BlogController@rssComments'],
    ['GET',      '/articles/comments', 'Controllers\BlogController@newComments'],
    ['GET|POST', '/articles/comments/[i:id]', 'Controllers\BlogController@comments'],
    ['GET|POST', '/articles/edit/[i:id]/[i:cid]', 'Controllers\BlogController@editComment'],
    ['GET',      '/articles/end/[i:id]', 'Controllers\BlogController@end'],
    ['GET',      '/articles/comment/[i:id]/[i:cid]', 'Controllers\BlogController@viewComment'],

    ['GET',      '/news', 'Controllers\NewsController@index', 'news'],
    ['GET',      '/news/[i:id]', 'Controllers\NewsController@view'],
    ['GET|POST', '/news/comments/[i:id]', 'Controllers\NewsController@comments'],
    ['GET',      '/news/end/[i:id]', 'Controllers\NewsController@end'],
    ['GET',      '/news/rss', 'Controllers\NewsController@rss', 'news_rss'],
    ['GET|POST', '/news/edit/[i:id]/[i:cid]', 'Controllers\NewsController@editComment'],
    ['GET',      '/news/allcomments', 'Controllers\NewsController@allComments'],
    ['GET',      '/news/comment/[i:id]/[i:cid]', 'Controllers\NewsController@viewComment'],

    ['GET',      '/photos', 'Controllers\PhotoController@index', 'photos'],
    ['GET',      '/photos/[i:id]', 'Controllers\PhotoController@view'],
    ['GET',      '/photos/delete/[i:id]', 'Controllers\PhotoController@delete'],
    ['GET',      '/photos/end/[i:id]', 'Controllers\PhotoController@end'],
    ['GET|POST', '/photos/comments/[i:id]', 'Controllers\PhotoController@comments'],
    ['GET|POST', '/photos/create', 'Controllers\PhotoController@create'],
    ['GET|POST', '/photos/edit/[i:id]', 'Controllers\PhotoController@edit'],
    ['GET|POST', '/photos/edit/[i:id]/[i:cid]', 'Controllers\PhotoController@editComment'],
    ['GET',      '/photos/albums', 'Controllers\PhotoController@albums'],
    ['GET',      '/photos/albums/[user:login]', 'Controllers\PhotoController@album'],
    ['GET',      '/photos/comments', 'Controllers\PhotoController@allComments'],
    ['GET',      '/photos/comments/[user:login]', 'Controllers\PhotoController@userComments'],
    ['GET',      '/photos/comment/[i:id]/[i:cid]', 'Controllers\PhotoController@viewComment'],
    ['GET|POST', '/photos/top', 'Controllers\PhotoController@top'],

    ['GET',      '/forums', 'Controllers\Forum\ForumController@index', 'forum'],
    ['GET',      '/forums/[i:id]', 'Controllers\Forum\ForumController@forum'],
    ['GET|POST', '/forums/create', 'Controllers\Controllers\Forum\ForumController@create'],
    ['GET',      '/forums/search', 'Forum\ForumController@search'],
    ['GET',      '/forums/active/[posts|topics:action]', 'Controllers\Forum\ActiveController'],
    ['POST',     '/forums/active/delete', 'Controllers\Forum\ActiveController@delete'],
    ['GET',      '/forums/top/posts', 'Controllers\Forum\ForumController@topPosts'],
    ['GET',      '/forums/top/topics', 'Controllers\Forum\ForumController@topTopics'],
    ['GET',      '/forums/rss', 'Controllers\Forum\ForumController@rss'],
    ['GET',      '/forums/bookmarks', 'Controllers\BookmarkController@index'],
    ['POST',     '/forums/bookmarks/[delete|perform:action]', 'Controllers\BookmarkController'],
    ['GET',      '/topics', 'Controllers\Forum\NewController@topics'],
    ['GET',      '/posts', 'Controllers\Forum\NewController@posts'],
    ['GET',      '/topics/[i:id]', 'Controllers\Forum\TopicController@index'],
    ['GET',      '/topics/[i:id]/[i:pid]', 'Controllers\Forum\TopicController@viewpost'],
    ['POST',     '/topics/votes/[i:id]', 'Controllers\Forum\TopicController@vote'],
    ['GET',      '/topics/end/[i:id]', 'Controllers\Forum\TopicController@end'],
    ['GET',      '/topics/close/[i:id]', 'Controllers\Forum\TopicController@close'],
    ['POST',     '/topics/create/[i:id]', 'Controllers\Forum\TopicController@create'],
    ['POST',     '/topics/delete/[i:id]', 'Controllers\Forum\TopicController@delete'],
    ['GET|POST', '/topics/edit/[i:id]', 'Controllers\Forum\TopicController@edit'],
    ['GET',      '/topics/print/[i:id]', 'Controllers\Forum\TopicController@print'],
    ['GET',      '/topics/rss/[i:id]', 'Controllers\Forum\ForumController@rssPosts'],
    ['GET|POST', '/posts/edit/[i:id]', 'Controllers\Forum\TopicController@editPost'],

    ['GET',      '/users/[user:login]', 'Controllers\User\UserController@index'],
    ['GET|POST', '/users/[user:login]/note', 'Controllers\User\UserController@note', 'note'],
    ['GET|POST', '/login', 'Controllers\User\UserController@login', 'login'],
    ['GET',      '/logout', 'Controllers\User\UserController@logout', 'logout'],
    ['GET|POST', '/register', 'Controllers\User\UserController@register', 'register'],
    ['GET|POST', '/profile', 'Controllers\User\UserController@profile'],
    ['GET',      '/key', 'Controllers\User\UserController@key'],
    ['GET|POST', '/settings', 'Controllers\User\UserController@setting'],
    ['GET',      '/accounts', 'Controllers\User\UserController@account'],
    ['POST',     '/accounts/changemail', 'Controllers\User\UserController@changeMail'],
    ['GET',      '/accounts/editmail', 'Controllers\User\UserController@editMail'],
    ['POST',     '/accounts/editstatus', 'Controllers\User\UserController@editStatus'],
    ['POST',     '/accounts/editpassword', 'Controllers\User\UserController@editPassword'],
    ['POST',     '/accounts/apikey', 'Controllers\User\UserController@apikey'],

    ['GET',      '/searchusers', 'User\SearchController@index'],
    ['GET',      '/searchusers/[letter:letter]', 'User\SearchController@sort'],
    ['GET|POST', '/searchusers/search', 'User\SearchController@search'],

    ['GET',      '/ratings/[user:login]/[received|gave:action]?', 'RatingController@received'],
    ['POST',     '/ratings/delete', 'RatingController@delete'],
    ['GET|POST', '/users/[user:login]/rating', 'RatingController@index'],

    ['GET|POST', '/mails', 'MailController@index', 'mails'],
    ['GET|POST', '/recovery', 'MailController@recovery', 'recovery'],
    ['GET',      '/recovery/restore', 'MailController@restore'],
    ['GET|POST', '/unsubscribe', 'MailController@unsubscribe', 'unsubscribe'],

    ['GET',      '/menu', 'PageController@menu'],
    ['GET',      '/pages/[a:action]?', 'PageController@index'],
    ['GET',      '/tags', 'PageController@tags', 'tags'],
    ['GET',      '/rules', 'PageController@rules', 'rules'],
    ['GET',      '/smiles', 'PageController@smiles', 'smiles'],
    ['GET',      '/online/[all:action]?', 'OnlineController@index', 'online'],

    ['POST',     '/ajax/bbcode', 'AjaxController@bbCode'],
    ['POST',     '/ajax/delcomment', 'AjaxController@delComment'],
    ['POST',     '/ajax/rating', 'AjaxController@rating'],
    ['POST',     '/ajax/vote', 'AjaxController@vote'],
    ['POST',     '/ajax/complaint', 'AjaxController@complaint'],

    ['GET',      '/walls/[user:login]', 'WallController@index', 'walls'],
    ['POST',     '/walls/[user:login]/create', 'WallController@create'],
    ['POST',     '/walls/[user:login]/delete', 'WallController@delete'],

    ['GET',      '/messages/[outbox|history|clear:action]?', 'MessageController@index'],
    ['POST',     '/messages/delete', 'MessageController@delete'],
    ['GET|POST', '/messages/send', 'MessageController@send'],

    ['GET',      '/votes', 'VoteController@index'],
    ['GET|POST', '/votes/[i:id]', 'VoteController@view'],
    ['GET',      '/votes/voters/[i:id]', 'VoteController@voters'],
    ['GET',      '/votes/history', 'VoteController@history'],
    ['GET',      '/votes/history/[i:id]', 'VoteController@viewHistory'],
    ['GET|POST', '/votes/create', 'VoteController@create'],

    ['GET|POST', '/ignores', 'IgnoreController@index'],
    ['GET|POST', '/ignores/note/[i:id]', 'IgnoreController@note'],
    ['POST',     '/ignores/delete', 'IgnoreController@delete'],

    ['GET|POST', '/contacts', 'ContactController@index'],
    ['GET|POST', '/contacts/note/[i:id]', 'ContactController@note'],
    ['POST',     '/contacts/delete', 'ContactController@delete'],
    ['GET',      '/counters/[day|month:action]?', 'CounterController@index'],

    ['GET',      '/transfers', 'TransferController@index'],
    ['POST',     '/transfers/send', 'TransferController@send'],

    ['GET',      '/notebooks', 'NotebookController@index'],
    ['GET|POST', '/notebooks/edit', 'NotebookController@edit'],

    ['GET',      '/reklama', 'RekUserController@index'],
    ['GET|POST', '/reklama/create', 'RekUserController@create'],

    ['GET',      '/authlogs', 'LoginController@index'],

    ['GET|POST', '/users', 'User\ListController@userlist'],
    ['GET',      '/administrators', 'User\ListController@adminlist'],
    ['GET|POST', '/authoritylists', 'User\ListController@authoritylist'],
    ['GET|POST', '/ratinglists', 'User\ListController@ratinglist'],
    ['GET|POST', '/ban', 'User\BanController@ban'],
    ['GET|POST', '/who', 'User\UserController@who'],

    ['GET',      '/faq', 'PageController@faq'],
    ['GET',      '/statusfaq', 'PageController@statusfaq'],
    ['GET',      '/surprise', 'PageController@surprise'],

    ['GET',      '/offers/[offer|issue:type]?', 'OfferController@index'],
    ['GET',      '/offers/[i:id]', 'OfferController@view'],
    ['GET|POST', '/offers/create', 'OfferController@create'],
    ['GET|POST', '/offers/edit/[i:id]', 'OfferController@edit'],
    ['GET|POST', '/offers/comments/[i:id]', 'OfferController@comments'],
    ['GET',      '/offers/end/[i:id]', 'OfferController@end'],
    ['GET|POST', '/offers/edit/[i:id]/[i:cid]', 'OfferController@editComment'],
    ['GET',      '/offers/comment/[i:id]/[i:cid]', 'OfferController@viewComment'],

    ['GET|POST', '/pictures', 'PictureController@index'],
    ['GET',      '/pictures/delete', 'PictureController@delete'],

    ['GET|POST', '/files/[*:action]?', 'FileController@index', 'files'],

    ['GET',      '/loads', 'Load\LoadController@index'],
    ['GET',      '/loads/rss', 'Load\LoadController@rss'],
    ['GET',      '/loads/[i:id]', 'Load\LoadController@load'],
    ['GET',      '/loads/top', 'Load\TopController@index'],
    ['GET',      '/loads/search', 'Load\SearchController@index'],
    ['GET',      '/downs/[i:id]', 'Load\DownController@index'],
    ['GET|POST', '/downs/edit/[i:id]', 'Load\DownController@edit'],
    ['GET',      '/downs/delete/[i:id]/[i:fid]', 'Load\DownController@deleteFile'],
    ['GET|POST', '/downs/create', 'Load\DownController@create'],
    ['POST',     '/downs/votes/[i:id]', 'Load\DownController@vote'],
    ['GET|POST', '/downs/download/[i:id]', 'Load\DownController@download'],
    ['GET|POST', '/downs/comments/[i:id]', 'Load\DownController@comments'],
    ['GET',      '/downs/comment/[i:id]/[i:cid]', 'Load\DownController@viewComment'],
    ['GET',      '/downs/end/[i:id]', 'Load\DownController@end'],
    ['GET|POST', '/downs/edit/[i:id]/[i:cid]', 'Load\DownController@editComment'],
    ['GET',      '/downs/rss/[i:id]', 'Load\DownController@rss'],
    ['GET',      '/downs/zip/[i:id]', 'Load\DownController@zip'],
    ['GET',      '/downs/zip/[i:id]/[i:fid]', 'Load\DownController@zipView'],
    ['GET',      '/downs', 'Load\NewController@files'],
    ['GET',      '/downs/comments', 'Load\NewController@comments'],
    ['GET',      '/downs/active/files', 'Load\ActiveController@files'],
    ['GET',      '/downs/active/comments', 'Load\ActiveController@comments'],

    ['GET',      '/admin/loads', 'Admin\LoadController@index'],
    ['POST',     '/admin/loads/create', 'Admin\LoadController@create'],
    ['GET|POST', '/admin/loads/edit/[i:id]', 'Admin\LoadController@edit'],
    ['GET',      '/admin/loads/delete/[i:id]', 'Admin\LoadController@delete'],
    ['GET',      '/admin/loads/restatement', 'Admin\LoadController@restatement'],
    ['GET',      '/admin/loads/[i:id]', 'Admin\LoadController@load'],
    ['GET|POST', '/admin/downs/edit/[i:id]', 'Admin\LoadController@editDown'],
    ['GET|POST', '/admin/downs/delete/[i:id]', 'Admin\LoadController@deleteDown'],
    ['GET',      '/admin/downs/delete/[i:id]/[i:fid]', 'Admin\LoadController@deleteFile'],
    ['GET',      '/admin/downs/new', 'Admin\LoadController@new'],
    ['GET',      '/admin/downs/publish/[i:id]', 'Admin\LoadController@publish'],

    ['GET',      '/api', 'ApiController@index'],
    ['GET',      '/api/users', 'ApiController@users'],
    ['GET',      '/api/forums', 'ApiController@forums'],
    ['GET',      '/api/messages', 'ApiController@messages'],

    ['GET',      '/admin', 'Admin\AdminController@index', 'admin'],
    ['GET',      '/admin/spam', 'Admin\SpamController@index'],
    ['POST',     '/admin/spam/delete', 'Admin\SpamController@delete'],
    ['GET',      '/admin/errors', 'Admin\ErrorController@index'],
    ['GET',      '/admin/errors/clear', 'Admin\ErrorController@clear'],
    ['GET|POST', '/admin/antimat', 'Admin\AntimatController@index'],
    ['GET',      '/admin/antimat/[delete|clear:action]', 'Admin\AntimatController'],
    ['GET',      '/admin/status', 'Admin\StatusController@index'],
    ['GET|POST', '/admin/status/[create|edit:action]', 'Admin\StatusController'],
    ['GET',      '/admin/status/delete', 'Admin\StatusController@delete'],

    ['GET',      '/admin/rules', 'Admin\RuleController@index'],
    ['GET|POST', '/admin/rules/edit', 'Admin\RuleController@edit'],

    ['GET',      '/admin/upgrade', 'Admin\AdminController@upgrade'],
    ['GET',      '/admin/phpinfo', 'Admin\AdminController@phpinfo'],

    ['GET|POST', '/admin/settings', 'Admin\SettingController@index'],
    ['GET',      '/admin/caches', 'Admin\CacheController@index'],
    ['POST',     '/admin/caches/clear', 'Admin\CacheController@clear'],

    ['GET',      '/admin/backups', 'Admin\BackupController@index'],
    ['GET|POST', '/admin/backups/create', 'Admin\BackupController@create'],
    ['GET',      '/admin/backups/delete', 'Admin\BackupController@delete'],

    ['GET|POST', '/admin/checkers', 'Admin\CheckerController@index'],
    ['GET|POST', '/admin/checkers/scan', 'Admin\CheckerController@scan'],

    ['GET|POST', '/admin/delivery', 'Admin\DeliveryController@index'],

    ['GET',      '/admin/logs', 'Admin\LogController@index'],
    ['GET',      '/admin/logs/clear', 'Admin\LogController@clear'],

    ['GET',      '/admin/notices', 'Admin\NoticeController@index'],
    ['GET|POST', '/admin/notices/create', 'Admin\NoticeController@create'],
    ['GET|POST', '/admin/notices/edit/[i:id]', 'Admin\NoticeController@edit'],
    ['GET',      '/admin/notices/delete/[i:id]', 'Admin\NoticeController@delete'],

    ['GET|POST', '/admin/delusers', 'Admin\DelUserController@index'],
    ['POST',     '/admin/delusers/clear', 'Admin\DelUserController@clear'],

    ['GET',      '/admin/files', 'Admin\FilesController@index'],
    ['GET|POST', '/admin/files/edit', 'Admin\FilesController@edit'],
    ['GET|POST', '/admin/files/create', 'Admin\FilesController@create'],
    ['GET',      '/admin/files/delete', 'Admin\FilesController@delete'],

    ['GET',      '/admin/smiles', 'Admin\SmileController@index'],
    ['GET|POST', '/admin/smiles/create', 'Admin\SmileController@create'],
    ['GET|POST', '/admin/smiles/edit/[i:id]', 'Admin\SmileController@edit'],
    ['POST',     '/admin/smiles/delete', 'Admin\SmileController@delete'],

    ['GET|POST', '/admin/ipbans', 'Admin\IpBanController@index'],
    ['POST',     '/admin/ipbans/delete', 'Admin\IpBanController@delete'],
    ['GET',      '/admin/ipbans/clear', 'Admin\IpBanController@clear'],

    ['GET|POST', '/admin/blacklists', 'Admin\BlacklistController@index'],
    ['POST',     '/admin/blacklists/delete', 'Admin\BlacklistController@delete'],

    ['GET',      '/admin/news', 'Admin\NewsController@index'],
    ['GET|POST', '/admin/news/edit/[i:id]', 'Admin\NewsController@edit'],
    ['GET|POST', '/admin/news/create', 'Admin\NewsController@create'],
    ['GET',      '/admin/news/restatement', 'Admin\NewsController@restatement'],
    ['POST',     '/admin/news/delete', 'Admin\NewsController@delete'],

    ['GET',      '/admin/guestbooks', 'Admin\GuestbookController@index'],
    ['GET|POST', '/admin/guestbooks/edit/[i:id]', 'Admin\GuestbookController@edit'],
    ['GET|POST', '/admin/guestbooks/reply/[i:id]', 'Admin\GuestbookController@reply'],
    ['POST',     '/admin/guestbooks/delete', 'Admin\GuestbookController@delete'],
    ['GET',      '/admin/guestbooks/clear', 'Admin\GuestbookController@clear'],

    ['GET',      '/admin/transfers', 'Admin\TransferController@index'],
    ['GET',      '/admin/transfers/view', 'Admin\TransferController@view'],

    ['GET',      '/admin/users', 'Admin\UserController@index'],
    ['GET',      '/admin/users/search', 'Admin\UserController@search'],
    ['GET|POST', '/admin/users/edit', 'Admin\UserController@edit'],
    ['GET|POST', '/admin/users/delete', 'Admin\UserController@delete'],

    ['GET',      '/admin/administrators', 'Admin\AdminlistController@index'],

    ['GET',      '/admin/invitations', 'Admin\InvitationController@index'],
    ['GET|POST', '/admin/invitations/create', 'Admin\InvitationController@create'],
    ['GET',      '/admin/invitations/keys', 'Admin\InvitationController@keys'],
    ['POST',     '/admin/invitations/send', 'Admin\InvitationController@send'],
    ['POST',     '/admin/invitations/mail', 'Admin\InvitationController@mail'],
    ['POST',     '/admin/invitations/delete', 'Admin\InvitationController@delete'],

    ['GET|POST', '/admin/reglists', 'Admin\ReglistController@index'],

    ['GET|POST', '/admin/chats', 'Admin\ChatController@index'],
    ['GET|POST', '/admin/chats/edit/[i:id]', 'Admin\ChatController@edit'],
    ['GET',      '/admin/chats/clear', 'Admin\ChatController@clear'],

    ['GET',      '/admin/banlists', 'Admin\BanlistController@index'],

    ['GET',      '/admin/bans', 'Admin\BanController@index'],
    ['GET|POST', '/admin/bans/edit', 'Admin\BanController@edit'],
    ['GET|POST', '/admin/bans/change', 'Admin\BanController@change'],
    ['GET',      '/admin/bans/unban', 'Admin\BanController@unban'],

    ['GET',      '/admin/banhists', 'Admin\BanhistController@index'],
    ['GET',      '/admin/banhists/view', 'Admin\BanhistController@view'],
    ['POST',     '/admin/banhists/delete', 'Admin\BanhistController@delete'],

    ['GET',      '/admin/votes', 'Admin\VoteController@index'],
    ['GET',      '/admin/votes/history', 'Admin\VoteController@history'],
    ['GET|POST', '/admin/votes/edit/[i:id]', 'Admin\VoteController@edit'],
    ['GET',      '/admin/votes/close/[i:id]', 'Admin\VoteController@close'],
    ['GET',      '/admin/votes/delete/[i:id]', 'Admin\VoteController@delete'],
    ['GET',      '/admin/votes/close/[i:id]', 'Admin\VoteController@change'],
    ['GET',      '/admin/votes/restatement', 'Admin\VoteController@restatement'],

    ['GET',      '/admin/offers/[offer|issue:type]?', 'Admin\OfferController@index'],
    ['GET',      '/admin/offers/[i:id]', 'Admin\OfferController@view'],
    ['GET|POST', '/admin/offers/edit/[i:id]', 'Admin\OfferController@edit'],
    ['GET|POST', '/admin/offers/reply/[i:id]', 'Admin\OfferController@reply'],
    ['GET',      '/admin/offers/restatement', 'Admin\OfferController@restatement'],
    ['GET|POST', '/admin/offers/delete', 'Admin\OfferController@delete'],

    ['GET',      '/admin/photos', 'Admin\PhotoController@index'],
    ['GET|POST', '/admin/photos/edit/[i:id]', 'Admin\PhotoController@edit'],
    ['GET',      '/admin/photos/restatement', 'Admin\PhotoController@restatement'],
    ['POST',     '/admin/photos/delete', 'Admin\PhotoController@delete'],

    ['GET',      '/admin/reklama', 'Admin\RekUserController@index'],
    ['GET|POST', '/admin/reklama/edit/[i:id]', 'Admin\RekUserController@edit'],
    ['POST',     '/admin/reklama/delete', 'Admin\RekUserController@delete'],

    ['GET',      '/admin/forums', 'Admin\ForumController@index'],
    ['POST',     '/admin/forums/create', 'Admin\ForumController@create'],
    ['GET|POST', '/admin/forums/edit/[i:id]', 'Admin\ForumController@edit'],
    ['GET',      '/admin/forums/delete/[i:id]', 'Admin\ForumController@delete'],
    ['GET',      '/admin/forums/restatement', 'Admin\ForumController@restatement'],
    ['GET',      '/admin/forums/[i:id]', 'Admin\ForumController@forum'],
    ['GET|POST', '/admin/topics/edit/[i:id]', 'Admin\ForumController@editTopic'],
    ['GET|POST', '/admin/topics/move/[i:id]', 'Admin\ForumController@moveTopic'],
    ['GET',      '/admin/topics/action/[i:id]', 'Admin\ForumController@actionTopic'],
    ['GET',      '/admin/topics/delete/[i:id]', 'Admin\ForumController@deleteTopic'],
    ['GET',      '/admin/topics/[i:id]', 'Admin\ForumController@topic'],
    ['GET|POST', '/admin/posts/edit/[i:id]', 'Admin\ForumController@editPost'],
    ['POST',     '/admin/posts/delete', 'Admin\ForumController@deletePosts'],
    ['GET',      '/admin/topics/end/[i:id]', 'Admin\ForumController@end'],

    ['GET',      '/admin/blogs', 'Admin\BlogController@index'],
    ['POST',     '/admin/blogs/create', 'Admin\BlogController@create'],
    ['GET',      '/admin/blogs/restatement', 'Admin\BlogController@restatement'],
    ['GET|POST', '/admin/blogs/edit/[i:id]', 'Admin\BlogController@edit'],
    ['GET',      '/admin/blogs/delete/[i:id]', 'Admin\BlogController@delete'],
    ['GET',      '/admin/blogs/[i:id]', 'Admin\BlogController@blog'],
    ['GET|POST', '/admin/articles/edit/[i:id]', 'Admin\BlogController@editBlog'],
    ['GET|POST', '/admin/articles/move/[i:id]', 'Admin\BlogController@moveBlog'],
    ['GET',      '/admin/articles/delete/[i:id]', 'Admin\BlogController@deleteBlog'],

    ['GET', '/search', function() {
        return view('search/index');
    }],
];

$pluginRoutes = require APP . '/Plugins/Test/routes.php';

$routes = array_merge($routes, $pluginRoutes);

$router->addRoutes($routes);

App\Classes\Registry::set('router', $router);
