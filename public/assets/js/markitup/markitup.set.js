
var InlineUpload = {
    dialog: null,
    options: {
        form_class: 'inline_upload_form', // class формы
        action: '/ajax/upload', // урл на который будет отправлен POST c загруженым файлом
        iframe: 'inline_upload_iframe' // имя iframe
    },
    display: function() { // метод, который принимает на себя клик по кнопке в markItUp
        var self = this;

        this.dialog = $(document).find(".inline_upload_container");

        if (!this.dialog.length) { // нашего скрытого div нету DOM'a, создаем
            // создаем форму с iframe внутри невидимого div и прикрепляем его к body
            this.dialog = $([
                '<div style="opacity:0;position:absolute;" class="inline_upload_container"><form class="',this.options.form_class,'" action="',this.options.action,'" target="',this.options.iframe,'" method="post" enctype="multipart/form-data">',
                '<input name="form[inlineUploadFile]" type="file" /></form>' +
                '<iframe id="',this.options.iframe,'" name="',this.options.iframe,'" class="',this.options.iframe,'" src="about:blank" width="0" height="0"></iframe></div>',
            ].join(''));
            this.dialog.appendTo(document.body);
        }

        // делаем клик по input[type=file] в скрытом div'e
        // чтобы показать системный диалог выборки файла
        $("input[name='form[inlineUploadFile]']").focus(); // хак для хрома и прочих
        $("input[name='form[inlineUploadFile]']").trigger('click');

        // после того, как файл был выбран, отправляем нашу скрытую форму на сервер
        $("input[name='form[inlineUploadFile]']").on('change', function(){
            if ($(this).val() != '') { // если файл небыл выбран, ничего страшного не произойдет
                $('.' + self.options.form_class).submit();
            }
        });

        // ответ будет отдан в скрытый iframe
        $('.' + this.options.iframe).bind('load', function() {
            var responseJSONStr = $(this).contents().find('body').html();

            console.log(responseJSONStr);

            if (responseJSONStr != '') { // сервер вернул нам ответ, будем его парсить
                var response = $.parseJSON(responseJSONStr);
                if (response.status == 'success') { // если все хорошо
                    var block = ['<img src="' + response.src + '" width="' + response.width + '" height="' + response.height + '" alt="" class=""/>'];
                    $.markItUp({replaceWith: block.join('')} ); // добавляем тег img в текст
                } else {
                    alert(response.msg); // сообщение об ошибке
                }
                self.cleanUp(); // cleanUp() убирает скрытый div с формой и iframe из DOM
            }
        });
    },
    cleanUp: function() {
        $("input[name='form[inlineUploadFile]']").off('change');
        this.dialog.remove();
    }
};



// ----------------------------------------------------------------------------
// markItUp bb-code setting!
// ----------------------------------------------------------------------------
mySettings = {
    previewParserPath:  '/ajax/bbcode', // path to your BBCode parser
    previewAutoRefresh: false,
    markupSet: [
        {title:'Жирный текст', name:'<i class="fa fa-bold"></i>', className:"bb-bold", key:'B', openWith:'[b]', closeWith:'[/b]'},
        {title:'Наклонный текст', name:'<i class="fa fa-italic"></i>', className:"bb-italic", key:'I', openWith:'[i]', closeWith:'[/i]'},
        {title:'Подчеркнутый текст', name:'<i class="fa fa-underline"></i>', className:"bb-underline", key:'U', openWith:'[u]', closeWith:'[/u]'},
        {title:'Зачеркнутый текст', name:'<i class="fa fa-strikethrough"></i>', className:"bb-strike", key:'S', openWith:'[s]', closeWith:'[/s]'},

        {separator:'---------------' },
        {title:'Ссылка', name:'<i class="fa fa-link"></i>', className:"bb-link", key:'L', openWith:'[url=[![Ссылка:!:http://]!]]', closeWith:'[/url]', placeHolder:'Текст ссылки...'},

        {title:'Изображение', name:'<i class="fa fa-image"></i>', className:"bb-image", openWith:'[img][![URL изображения:!:http://]!]', closeWith:'[/img]'},


        {
            name:'PictureUpload', key:'P', beforeInsert: function(markItUp) { InlineUpload.display(markItUp) }
        },

        {title:'Видео', name:'<i class="fab fa-youtube"></i>', className:"bb-youtube", openWith:'[youtube][![Ссылка на видео с youtube]!]', closeWith:'[/youtube]'},
        {title:'Цвет', name:'<i class="fa fa-th"></i>', className:"bb-color", openWith:'[color=[![Код цвета]!]]', closeWith:'[/color]',
        dropMenu: [
            {name:'Yellow',	openWith:'[color=#ffd700]', closeWith:'[/color]', className:"col1-1" },
            {name:'Orange',	openWith:'[color=#ffa500]', closeWith:'[/color]', className:"col1-2" },
            {name:'Red', openWith:'[color=#ff0000]', closeWith:'[/color]', className:"col1-3" },

            {name:'Blue', openWith:'[color=#0000ff]', closeWith:'[/color]', className:"col2-1" },
            {name:'Purple', openWith:'[color=#800080]', closeWith:'[/color]', className:"col2-2" },
            {name:'Green', openWith:'[color=#00cc00]', closeWith:'[/color]', className:"col2-3" },

            {name:'Magenta', openWith:'[color=#ff00ff]', closeWith:'[/color]', className:"col3-1" },
            {name:'Gray', openWith:'[color=#808080]', closeWith:'[/color]', className:"col3-2" },
            {name:'Cyan', openWith:'[color=#00ffff]', closeWith:'[/color]', className:"col3-3" }
        ]},

        {separator:'---------------' },
        {title:'Размер текста', name:'<i class="fa fa-font"></i>', className:"bb-size", openWith:'[size=[![Размер текста от 1 до 5]!]]', closeWith:'[/size]',
        dropMenu :[
            {name:'x-small', openWith:'[size=1]', closeWith:'[/size]' },
            {name:'small', openWith:'[size=2]', closeWith:'[/size]' },
            {name:'medium', openWith:'[size=3]', closeWith:'[/size]' },
            {name:'large', openWith:'[size=4]', closeWith:'[/size]' },
            {name:'x-large', openWith:'[size=5]', closeWith:'[/size]' }
        ]},

        {title:'По центру', name:'<i class="fa fa-align-center"></i>', className:"bb-center", openWith:'[center]', closeWith:'[/center]'},
        {title:'Спойлер', name:'<i class="fa fa-plus-square"></i>', className:"bb-spoiler", openWith:'[spoiler=[![Заголовок спойлера]!]]', closeWith:'[/spoiler]', placeHolder:'Текст спойлера...'},

        {separator:'---------------' },
        {title:'Скрытый контент', name:'<i class="fa fa-eye-slash"></i>', className:"bb-hide", openWith:'[hide]', closeWith:'[/hide]'},
        {title:'Цитата', name:'<i class="fa fa-quote-right"></i>', className:"bb-quote", openWith:'[quote]', closeWith:'[/quote]'},
        {title:'Исходный код', name:'<i class="fa fa-code"></i>', className:"bb-code", openWith:'[code]', closeWith:'[/code]'},

        {separator:'---------------' },
        {title:'Маркированный список', name:'<i class="fa fa-list-ul"></i>', className:"bb-unorderedlist", multiline:true, openBlockWith:'[list]\n', closeBlockWith:'\n[/list]', placeHolder:'Элемент списка'},
        {title:'Нумерованный список', name:'<i class="fa fa-list-ol"></i>', className:"bb-orderedlist", multiline:true, openBlockWith:'[list=1]\n', closeBlockWith:'\n[/list]', placeHolder:'Элемент списка'},

        {separator:'---------------' },
        {title:'Очистка BB-кода', name:'<i class="fa fa-eraser"></i>', className:"bb-clean", replaceWith:function(markitup) { return markitup.selection.replace(/\[(.*?)\]/g, "") } },
        {title:'Смайл', name:'<i class="fa fa-smile"></i>', className:"bb-smile", openWith:' :) ',
        dropMenu: [
            {name:':)', openWith:' :) ', className:"col1-1" },
            {name:':(', openWith:' :( ', className:"col1-2" },
            {name:':E', openWith:' :E ', className:"col1-3" },
            {name:':D', openWith:' :D ', className:"col1-4" },
            {name:':no', openWith:' :no ', className:"col1-5" },
            {name:':hello', openWith:' :hello ', className:"col2-1" },
            {name:':cry', openWith:' :cry ', className:"col2-2" },
            {name:':obana', openWith:' :obana ', className:"col2-3" },
            {name:':hi', openWith:' :hi ', className:"col2-4" },
            {name:':oy', openWith:' :oy ', className:"col2-5" },
            {name:':infat', openWith:' :infat ', className:"col3-1" },
            {name:':klass', openWith:' :klass ', className:"col3-2" },
            {name:':krut', openWith:' :krut ', className:"col3-3" },
            {name:':aaa', openWith:' :aaa ', className:"col3-4" },
            {name:':zlo', openWith:' :zlo ', className:"col3-5" },
            {name:':blum', openWith:' :blum ', className:"col4-1" },
            {name:':baby', openWith:' :baby ', className:"col4-2" },
            {name:':read', openWith:' :read ', className:"col4-3" },
            {name:':blin', openWith:' :blin ', className:"col4-4" },
            {name:':nyam', openWith:' :nyam ', className:"col4-5" },
            {name:':puls', openWith:' :puls ', className:"col5-1" },
            {name:':xaxa', openWith:' :xaxa ', className:"col5-2" },
            {name:':4moks', openWith:' :4moks ', className:"col5-3" },
            {name:':heart', openWith:' :heart ', className:"col5-4" },
            {name:':moder', openWith:' :moder ', className:"col5-5" }
        ]},
        {title:'Разделение страниц', name:'<i class="fa fa-exchange-alt"></i>', className:"bb-nextpage", openWith:'[nextpage]'},
        {title:'Обрезка страницы', name:'<i class="fa fa-cut"></i>', className:"bb-cutpage", openWith:'[cut]'},
        {title:'Просмотр', name:'<i class="fa fa-check-square"></i>', className:'bb-preview',  call:'preview'}
    ]
};

// ----------------------------------------------------------------------------
// markItUp Html setting!
// ----------------------------------------------------------------------------
myHtmlSettings = {
    onCtrlEnter:	{keepDefault:false, replaceWith:'<br />\r'},
    onShiftEnter:	{keepDefault:false, replaceWith:'<hr />\r'},
    onTab:			{keepDefault:false, openWith:'	'},
    markupSet: [
        {title:'Div', name:'<i class="fa fa-list-alt"></i>', className:"bb-div", openWith:'<div(!( class="[![Class]!]")!)>', closeWith:'</div>\n' },
        {title:'Span', name:'<i class="fa fa-columns"></i>', className:"bb-span", openWith:'<span(!( class="[![Class]!]")!)>', closeWith:'</span>\n' },
        {title:'Paragraph', name: '<i class="fa fa-paragraph"></i>', className:"bb-paragraph", openWith:'<p(!( class="[![Class]!]")!)>', closeWith:'</p>\n' },
        {title:'Paragraph', name: '<i class="fa fa-table"></i>', className:"bb-table", openWith:'<table(!( class="[![Class]!]")!)>\n	<tr>\n		<td>', closeWith:'</td>\n	</tr>\n</table>' },
        {separator:'---------------' },
        {title:'Heading 1', name:'<i class="fa fa-heading"></i>1', className:"bb-heading1", key:'1', openWith:'<h1(!( class="[![Class]!]")!)>', closeWith:'</h1>', placeHolder:'Введите название...' },
        {title:'Heading 2', name:'<i class="fa fa-heading"></i>2', className:"bb-heading2", key:'2', openWith:'<h2(!( class="[![Class]!]")!)>', closeWith:'</h2>', placeHolder:'Введите название...' },
        {title:'Heading 3', name:'<i class="fa fa-heading"></i>3', className:"bb-heading3", key:'3', openWith:'<h3(!( class="[![Class]!]")!)>', closeWith:'</h3>', placeHolder:'Введите название...' },
        {separator:'---------------' },
        {title:'Жирный текст', name:'<i class="fa fa-bold"></i>', className:"bb-bold", key:'B', openWith:'(!(<strong>|!|<b>)!)', closeWith:'(!(</strong>|!|</b>)!)' },
        {title:'Наклонный текст', name:'<i class="fa fa-italic"></i>', className:"bb-italic", key:'I', openWith:'(!(<em>|!|<i>)!)', closeWith:'(!(</em>|!|</i>)!)' },
        {title:'Подчеркнутый текст', name:'<i class="fa fa-underline"></i>', className:"bb-underline", key:'U', openWith:'<u>', closeWith:'</u>'},
        {title:'Зачеркнутый текст', name:'<i class="fa fa-strikethrough"></i>', className:"bb-strike", key:'S', openWith:'<del>', closeWith:'</del>' },
        {separator:'---------------' },
        {title:'Ul', name:'<i class="fa fa-list-ul"></i>', className:"bb-ul", openWith:'<ul>\n', closeWith:'</ul>\n' },
        {title:'Ol', name:'<i class="fa fa-list-ol"></i>', className:"bb-ol", openWith:'<ol>\n', closeWith:'</ol>\n' },
        {title:'Li', name:'<i class="fa fa-minus"></i>', className:"bb-li", openWith:'<li>', closeWith:'</li>' },
        {separator:'---------------' },
        {title:'Изображение', name:'<i class="fa fa-image"></i>', className:"bb-picture", key:'P', replaceWith:'<img src="[![Ссылка:!:http://]!]" alt="[![Альтернативный текст]!]" />' },
        {title:'Ссылка', name:'<i class="fa fa-link"></i>', className:"bb-link", key:'L', openWith:'<a href="[![Ссылка:!:http://]!]"(!( title="[![Title]!]")!)>', closeWith:'</a>', placeHolder:'Текст ссылки...' },
        {separator:'---------------' },
        {title:'Очистка BB-кода', name:'<i class="fa fa-eraser"></i>', className:'bb-clean', replaceWith:function(markitup) { return markitup.selection.replace(/<(.*?)>/g, "") } }
    ]
};
