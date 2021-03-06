<?php
$dbAutomatVars = Array(
	'0' => 'lang',
	'1' => 'orderFields',
);

$lang = Array(
	'choosefromlist' => ' - Выберите из списка -',
	'to_order' => 'Оформить заказ',
	'necessarys' => '<span style="color: red;">*</span>',
	'necessaryc' => '<span class="s_red">*</span>',
	'attention_asterisk' => 'Поля, отмеченные <span class="s_red">*</span> <strong>обязательные для заполнения</strong>',
	'order_info' => 'Информация о заказе',
	'contact_info' => 'Контактная информация',
	'error_thema' => 'Введите тему работы',
	'error_course' => 'Выберите предмет работы',
	'error_worktype' => 'Выберите тип работы',
	'error_client_srok' => 'Выберите срок выполнения работы',
	'error_fio' => 'Введите ФИО',
	'error_mphone' => 'Введите корректный номер мобильного телефона',
	'error_email' => 'Введите e-mail',
	'error_email_correct' => 'Введите верный e-mail',
	'error_captcha' => 'Введите защитный код',
	'error_login' => 'Введите логин',
	'error_pass' => 'Введите пароль',
	'error_mphone_correct' => 'Введите корректный номер телефона',
	'load_files' => 'Загрузить файл(ы)',
	'file_part' => 'Тип файла',
	'writein_addinfo_order' => 'Заполнить дополнительную информацию о заказе',
	'writein_addinfo_contact' => 'Показать дополнительные контактные данные',
	'writein_addinfo_order_small' => 'более полная информация поможет более четко выполнить заказ',
	'cnc' => 'Страна и город расположения вуза',
	'codc' => 'код страны',
	'codo' => 'код оператора',
	'num' => 'номер телефона',
	'cods' => 'код города',
	'thema' => 'Тема работы',
	'course' => 'Предмет работы',
	'worktype' => 'Тип работы',
	'client_srok' => 'Срок выполнения',
	'add_file' => 'Добавить ещё один файл',
	'file_comment' => 'Комментарии к файлу(ам)',
	'onemorefile' => 'Добавить ещё один файл',
	'schooltype' => 'Тип учебного заведения',
	'country' => 'Страна',
	'city' => 'Город',
	'vuz' => 'Название вуза',
	'volume' => 'Объем работы',
	'gost' => 'ГОСТ',
	'font' => 'Шрифт',
	'interval' => 'Интервал',
	'listsource' => 'К-во используемых источников',
	'addinfo' => 'Дополнительные требования',
	'precost' => 'Предполагаемый бюджет',
	'fio' => 'ФИО',
	'email' => 'E-mail',
	'mphone' => 'Мобильный телефон',
	'mphone_small' => 'на ваш номер будет поступать информация о номере заказа, статусе выполнения',
	'sphone' => 'Городской телефон',
	'icq' => 'ICQ',
	'contact' => 'Адрес',
	'web' => 'Веб-адрес',
	'other_contact' => 'Другие способы связи',
	'fromknow' => 'Откуда узнали о сайте',
	'specialization' => 'Специализация',
	'captcha' => 'Защитный код',
	'changecaptcha' => '[ Не вижу надпись ]',
	'button_order' => 'Оформить',
	'currency' => 'руб.',
	'fileUploadingError1' => 'файл не загружен',
	'fileUploadingError2' => 'файл загружен с ошибкой',
	'mandatoryFieldsDescription' => 'Поля, отмеченные <span>*</span> <strong>обязательные для заполнения</strong>',
	'detailsToEnter' => '<h4>Данные для входа в аккаунт</h4>',
	'mandatoryField' => '<span style="color: red;">*</span>',
	'login' => 'Логин',
	'pass' => 'Пароль',
	'skype' => 'Skype',
	'ownDataSaved' => 'Личные данные успешно сохранены!',
	'errors' => Array(
		'default' => 'Ошибка сервиса. Обратитесь к администратору.',
		'1.1' => 'Пожалуйста, укажите тему работы!',
		'1.2' => 'Пожалуйста, укажите предмет работы!',
		'1.3' => 'Пожалуйста, укажите тип работы!',
		'1.4' => 'Пожалуйста, укажите срок выполнения работы!',
		'1.5' => 'Пожалуйста, укажите Ваши ФИО!',
		'1.6' => 'Пожалуйста, укажите Ваш электронный адрес!',
		'1.7' => 'Пожалуйста, введите защитный код!',
		'1.8' => 'Пожалуйста, введите верный защитный код!',
		'1.9' => 'Пожалуйста, введите мобильный телефон!',
		'1.10' => 'Пожалуйста, введите пароль!',
		'1.11' => 'Пожалуйста, введите логин!',
		'1.12' => 'Пожалуйста, введите город расположения вуза!',
		'1.13' => 'Пожалуйста, введите название вуза!',
		'1.14' => 'Пожалуйста, введите объем работы!',
		'1.15' => 'Пожалуйста, введите ГОСТ!',
		'1.16' => 'Пожалуйста, введите шрифт!',
		'1.17' => 'Пожалуйста, введите интервал!',
		'1.18' => 'Не указано количество используемых источников!',
		'1.19' => 'Пожалуйста, введите дополнительные требования!',
		'1.20' => 'Пожалуйста, введите предполагаемую стоимость!',
		'1.21' => 'Пожалуйста, введите городской телефон!',
		'1.22' => 'Пожалуйста, введите icq!',
		'1.23' => 'Пожалуйста, введите адрес!',
		'1.24' => 'Заполните поле "Откуда вы узнали о нас!"',
		'1.25' => 'Пожалуйста, введите тип учебного заведения!',
		'1.26' => 'Пожалуйста, введите страну расположения вуза!',
		'1.27' => 'Пожалуйста, введите корректную дату рождения (формат ДД.ММ.ГГГГ)!',
		'2.1' => 'default',
		'2.2.1' => 'Ошибка! Введите корректную тему работы!',
		'2.2.2' => 'Ошибка! Не корректно заполнено поле: Дополнительные требования!',
		'2.2.3' => 'Ошибка! Не корректно заполнено поле: Адрес!',
		'2.2.4' => 'Срок выполнения заказа не может быть меньше текущей даты!',
		'2.3' => 'Пользователь с данным электронным адресом уже зарегистрирован! Если это Ваш электронный адрес - войдите сначала в свой аккаунт. Если забыли пароль - воспользуйтесь функцией восстановления пароля.',
		'2.4' => 'Ошибка! Возможно у Вас отключены cookies.',
		'2.6' => 'default',
		'2.7' => 'default',
		'2.8' => 'Пользователь с таким логином уже зарегистрирован! Если Вы забыли пароль - воспользуйтесь функцией восстановления пароля.<br />Если вы желаете зарегистрироваться в другого партнера системы учёта sverka1.ru, то введите другие регистрационные данные (логин, пароль и э-мейл)',
		'2.9' => 'Пользователя с логином <strong>{$v.login}</strong> не существует!',
		'2.10' => 'Пользователя с айди <strong>{$v.idu}</strong> не существует или аккаунт был удален! Для решения вопроса обратитесь к администрации сайта!',
		'2.11' => 'Пользователя под номером <strong>{$v.idu}</strong> не существует!',
		'2.12' => 'Неправильный пароль!',
		'2.13' => 'Извините, но пользователь <strong>{$v.login}</strong> не зарегистрирован на сайте!<br />Для входа в личный кабинет, Вам необходимо перейти на сайт: <a href="http://{$v.partner_site}">{$v.partner_site}</a>, где Вы проходили регистрацию или оформить заказ на этом сайте - при этом для Вас будет создан новый аккаунт.',
		'2.15' => 'Заказа №{$v.ido} не существует. Во всяком случае у вас. :)',
		'2.16' => 'Извините, но это не ваш файл! :)',
		'2.17' => 'Извините, но этот файл от другого заказа! :)',
		'2.18' => 'Вы не можете загрузить этот файл!',
		'2.19' => 'Вы не можете загрузить этот файл!',
		'2.22' => 'Ошибка! Пожалуйста, укажите кошелек Webmoney или Яндекс.Деньги на который необходимо проводить выплату.',
		'2.23' => 'Ошибка! Вы не можете заказать сумму большую, чем доступно к выплате!',
		'2.24' => 'Ошибка! Вы не указали сумму для выплаты!',
		'2.25' => 'Внимание! Партнерская программа отключена администрацией сайта. С вопросами обращайтесь по адресам указанным на сайте.',
		'2.26' => 'default',
		'2.27' => 'Пользователя с логином <strong>{$v.login}</strong> не существует!',
		'2.28' => 'Email <strong>{$v.email}</strong> не зарегестрирован на сайте.',
		'3.1' => 'default',
		'3.2' => 'default',
		'3.3' => 'default',
		'3.4' => 'default',
		'3.5' => 'default',
		'3.6' => 'default',
		'4.1' => 'У Вас возникла ошибка при загрузке файла на сервер. Пожалуйста, попробуйте загрузить ещё раз.',
		'4.2' => 'default',
		'4.3' => 'default',
		'5.1' => 'У Вас выключена онлайн оплата. Обратитесь к администратору.',
		'5.2' => 'Сумма платежа должна быть не менее {$v.min_sum}',
		'5.3' => 'Проверьте номер кошелька',
		'5.4' => 'default',
		'5.5' => 'default',
		'5.6' => 'default',
		'6.1' => 'default',
		'6.2' => 'default',
	),
);

$orderFields = Array(
	'thema' => Array(
		'enabled' => true,
		'mandatory' => true,
		'name' => 'o_thema',
	),
	'course' => Array(
		'enabled' => true,
		'mandatory' => true,
		'name' => 'o_course',
	),
	'worktype' => Array(
		'enabled' => true,
		'mandatory' => true,
		'name' => 'o_type',
	),
	'client_srok' => Array(
		'enabled' => true,
		'mandatory' => true,
		'name' => 'o_client_srok',
	),
	'file_part' => Array(
		'name' => 'f_part',
	),
	'file_arr' => Array(
		'name' => 'ofile',
	),
	'file_comment' => Array(
		'name' => 'f_comment',
	),
	'schooltype' => Array(
		'enabled' => true,
		'mandatory' => false,
		'name' => 'o_shcooltype',
	),
	'country' => Array(
		'enabled' => true,
		'mandatory' => false,
		'name' => 'o_cc1',
	),
	'city' => Array(
		'enabled' => true,
		'mandatory' => false,
		'name' => 'o_cc2',
	),
	'vuz' => Array(
		'enabled' => true,
		'mandatory' => false,
		'name' => 'o_vuz',
	),
	'volume' => Array(
		'enabled' => true,
		'mandatory' => false,
		'name' => 'o_volume',
	),
	'gost' => Array(
		'enabled' => true,
		'mandatory' => false,
		'name' => 'gost',
	),
	'font' => Array(
		'enabled' => true,
		'mandatory' => false,
		'name' => 'o_font',
	),
	'interval' => Array(
		'enabled' => true,
		'mandatory' => false,
		'name' => 'o_interval',
	),
	'listsource' => Array(
		'enabled' => true,
		'mandatory' => false,
		'name' => 'o_listsource',
	),
	'addinfo' => Array(
		'enabled' => true,
		'mandatory' => false,
		'name' => 'o_addinfo',
	),
	'precost' => Array(
		'enabled' => true,
		'mandatory' => false,
		'name' => 'o_precost',
	),
	'fio' => Array(
		'enabled' => true,
		'mandatory' => true,
		'name' => 'fio',
	),
	'email' => Array(
		'enabled' => true,
		'mandatory' => true,
		'name' => 'email',
	),
	'mphone' => Array(
		'enabled' => true,
		'mandatory' => false,
		'name' => Array(
			'0' => 'mphone1',
			'1' => 'mphone2',
			'2' => 'mphone3',
		),
	),
	'sphone' => Array(
		'enabled' => true,
		'mandatory' => false,
		'name' => Array(
			'0' => 'sphone1',
			'1' => 'sphone2',
			'2' => 'sphone3',
		),
	),
	'icq' => Array(
		'enabled' => true,
		'mandatory' => false,
		'name' => 'icq',
	),
	'contact' => Array(
		'enabled' => true,
		'mandatory' => false,
		'name' => 'contact',
	),
	'fromknow' => Array(
		'enabled' => true,
		'mandatory' => false,
		'name' => 'o_fromknow',
	),
	'captcha_code' => Array(
		'enabled' => false,
		'mandatory' => true,
		'name' => 'captcha_code',
	),
);

