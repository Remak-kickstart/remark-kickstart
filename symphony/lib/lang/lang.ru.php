<?php

	$about = array(
		'name' => 'Русский',
		'author' => array(
			'name' => 'Igor Bogdanov',
			'email' => 'i.bogdanov@ibcico.com',
		),
		'release-date' => '2009-11-27',
	);
	
	
	/*
	 * CORE: Symphony
	 * Localisation strings
	 */

	$dictionary = array(
	
		'\'%s\' is a required field.' => 
		'\'%s\' является обязательным полем.',

		'%1$s &ndash; %2$s' => 
		'%1$s &ndash; %2$s',

		'%1$s &ndash; %2$s &ndash; %3$s' => 
		'%1$s &ndash; %2$s &ndash; %3$s',

		'%s Redirect to 404 page when no results are found' => 
		'%s Переадресовывать на страницу 404, если ничего не было найдено.',

		'%s HTML-encode text' => 
		'%s Кодированный в HTML текст.',

		'%s Hide this section from the Publish menu' => 
		'%s Не показывать эту сущность в меню публикации.',

		'%s Pre-populate this field with today\'s date' => 
		'%s По умолчанию вставить в данное поле сегодняшнюю дату.',

		'%s Make this a required field' => 
		'%s Сделать обязательным полем.',

		'%s Allow selection of multiple authors' => 
		'%s Разрешить выбор нескольких авторов.',

		'%s Allow selection of multiple options' => 
		'%s Разрешить выбор нескольких опций.',

		'Filter %s by' => 
		'%s фильтровать по',

		'%s Show column' => 
		'%s Отображать данную колонку',

		'%s is not a valid object. Failed to append to XML.' => 
		'%s объект содержит ошибки. Невозможно присоединить к XML.',

		'%s Checked by default' => 
		'%s Выбрано по умолчанию.',

		'&larr; Previous' => 
		'&larr; Предыдущие',

		'</code> file after Symphony has installed successfully.' => 
		'</code> файл, после того как Симфони будет установлена.',

		'Failed to delete <code>%s</code>. Please check permissions.' => 
		'Невозможно удалить <code>%s</code>. Пожалуйста проверьте права управления.',

		'Failed to write Event to <code>%s</code>. Please check permissions.' => 
		'Невозможно записать <code>%s</code>. Пожалуйста проверьте права управления.',

		'[Symphony] A new entry was created on %s' => 
		'[Symphony] Была создана новая запись в %s ',

		'\'%s\' contains invalid data. Please check the contents.' => 
		'\'%s\' содержит неверный формат данных. Пожалуйста проверьте содержимое.',

		'Submit' => 
		'Отправить',

		'descending' => 
		'по убыванию',

		'Monkeys' => 
		'Обезьянки',

		'Enable' => 
		'Активировать',

		'Enabled' => 
		'Активирован',

		'All of these fields can be set dynamically using the exact field name of another field in the form as shown below in the example form:' => 
		'Все эти поля могут быть созданы динамически с использованием названия другого поля формы, как показано ниже в примере:',

		'General' => 
		'Основные',

		'Old Password' => 
		'Старый пароль',

		'No <code>/symphony</code> directory was found at this location. Please upload the contents of Symphony\'s install package here.' => 
		'В указанном расположении директория <code>/symphony</code> не найдена. Пожалуйста загрузите сюда содержимое установочного пакета.',

		'An existing <code>/workspace</code> directory was found at this location. Symphony will use this workspace.' => 
		'В указанном расположении была найдена уже созданная директория <code>/workspace</code>. Она и будет использована.',

		'Login Details' => 
		'Информация о входе в систему(!!!)',

		'Login' => 
		'Логин(!!!)',

		'Apply' => 
		'Применить',

		'ascending' => 
		'по возрастанию',

		'Output Options' => 
		'Опции вывода',

		'With Selected...' => 
		'С выбранными...',

		'Author' => 
		'Автор',

		'Create Author' => 
		'Создать Автора',

		'Author ID' => 
		'ID Автора',

		'Authors' => 
		'Авторы',

		'Filter Authors by' => 
		'Фильтровать Авторов по',

		'Save Changes' => 
		'Сохранить изменения',

		'Create Utility' => 
		'Создать Блок',

		'Utility could not be written to disk. Please check permissions on <code>/workspace/utilities</code>.' => 
		'Блок не может быть записан на диск. Пожалуйста проверьте права доступа для <code>/workspace/utilities</code>.',

		'Utilities' => 
		'Блоки',

		'Edit' => 
		'Редактировать',

		'There was an error while trying to upload the file <code>%1$s</code> to the target directory <code>%2$s</code>.' => 
		'При загрузке файла <code>%1$s</code> в директорию  <code>%2$s</code>  возникла ошибка.',

		'A database error occurred while attempting to reorder.' => 
		'При пересортировке в базеданных произошла ошибка.',

		'Entry encountered errors when saving.' => 
		'При сохранении записи возникли ошибки.',

		'There were some problems while attempting to save. Please check below for problem fields.' => 
		'При попытке сохранить возникли ошибки. Убедитесь в правильности кода, представленного ниже.',

		'Unknown errors where encountered when saving.' => 
		'При сохранении возникли неизвестные ошибки.',

		'Some errors were encountered while attempting to save.' => 
		'При попытке сохранить возникло несколько ошибок.',

		'Example Front-end Form Markup' => 
		'Пример кода формы для клиентской страницы',

		'Leave these fields unless you are sure they need to be changed.' => 
		'Не вносите изменения в данные поля, если вы не уверены, в том, что их следует изменить.',

		'Encumbered' => 
		'ENCUMBERED (!!!)',

		'Use an XPath expression to select which elements from the source XML to include.' => 
		'Используйте выражение XPath для выбора элементов из XML.',

		'Custom XML' => 
		'Внешний XML',

		'User Type' => 
		'Тип пользователя',

		'User type' => 
		'Тип пользователя',

		'User Information' => 
		'Информация о пользователе',

		'Username' => 
		'Имя пользователя',

		'Create a section' => 
		'Создать сущность',

		'Create Section' => 
		'Создать сущность',

		'Sections' => 
		'Sections',

		'Description' => 
		'Описание',

		'Please add the following personal details for this user.' => 
		'Пожалуйста добавьте следующие персональные данные пользователя.',

		'Please provide Symphony with access to a database.' => 
		'Пожалуйста укажите доступ к базе данных.',

		'The date specified in \'%s\' is invalid.' => 
		'Дата указанная в \'%s\' недействительна .',

		'Could not find Event <code>%s</code>. If the Event was provided by an Extensions, ensure that it is installed, and enabled.' => 
		'Не возможно наити событие <code>%s</code>. Если данное событие было создано одним из расширений, убедитесь, что оно установлено и активировано.',

		'Uploading \'%s\' failed. File upload stopped by extension.' => 
		'Загрузка \'%s\' не удалась. Файл имеет недействительное расширение',

		'Uploading \'%s\' failed. Could not write temporary file to disk.' => 
		'Загрузка \'%s\' не удалась. Временные файлы не могуть быть записаны на диск.',

		'Password is required' => 
		'Требуется пароль',

		'The password and confirmation did not match. Please retype your password.' => 
		'Пароли не совпадают. Пожалуйста введите пароль еще раз.',

		'Destination folder, <code>%s</code>, is not writable. Please check permissions.' => 
		'Папка назначения <code>%s</code> недоступна для записи. Пожалуйста проверьте права доступа.',

		'Can\'t open file %s' => 
		'Невозможно открыть файл %s',

		'Unable to remove file - %s' => 
		'Невозможно удалить файл %s',

		'Files' => 
		'Файлы',

		'Database' => 
		'База банных',

		'Database Error' => 
		'Ошибка базы данных',

		'Database Connection' => 
		'Соединение с базой даных',

		'Data Source' => 
		'Исходные данные',

		'Create Data Source' => 
		'Создать новые Исходные данные',

		'Failed to write Data source to <code>%s</code>. Please check permissions.' => 
		'Невозможно записать исходные данные в <code>%s</code>. Проверьте права управления.',

		'Data Sources' => 
		'Исходные данные',

		'Date and Time' => 
		'Дата и время',

		'Date Format' => 
		'Формат даты',

		'Disable' => 
		'Блокировать',

		'Uninstall' => 
		'Удалить',

		'Username is required' => 
		'Требуется имя пользователя',

		'Section is invalid' => 
		'Сущность недействительна',

		'The section associated with the data source <code>%s</code> could not be found.' => 
		'Не найдена сущность связанная с Исходными данными <code>%s</code>.',

		'Last name is required' => 
		'Фамилия является обязательным полем',

		'Body is a required field.' => 
		'Body является обязательным полем.(!!!)',

		'The table prefix <code><!-- TABLE-PREFIX --></code> is already in use. Please choose a different prefix to use with Symphony.' => 
		'Префикс таблиц <code><!-- TABLE-PREFIX --></code> уже используется. Пожалуйста выберите другой префикс для использования с Симфони.',

		'The Section you are looking, <code>%s</code> for could not be found.' => 
		'Сущность, которую вы ищете <code>%s</code> не может быть найдена.',

		'The Section you are looking for could not be found.' => 
		'Сущность, которую вы ищете не может быть найдена.',

		'The entry you are looking for could not be found.' => 
		'Запись, которую вы ищете не может быть найдена.',

		'First name is required' => 
		'Поле Имя является обязательным',

		'Big' => 
		'Большой',

		'The page you requested does not exist.' => 
		'Страница, которую вы ищете не существует.',

		'Could not find Data Source <code>%s</code>. If the Data Source was provided by an Extensions, ensure that it is installed, and enabled.' => 
		'Неозможно найти Исходные Данные <code>%s</code>. Если исходные данные были созданы одним из расширений, убедитесь, что оно установлено и активировано.',

		'E-mail address is required' => 
		'E-mail адрес является обязательным полем',

		'E-mail address entered is invalid' => 
		'Неверный E-mail адрес',

		'Could not find extension at location %s' => 
		'Невозможно обнаружить расширение в расположении %s.',

		'Entry limit specified was not a valid type. String or Integer expected.' => 
		'Неверный тип данных для обозначения лимита записей. Ожидается строка или целое число ',

		'Page could not be written to disk. Please check permissions on <code>/workspace/pages</code>.' => 
		'Страница не может быть записана на диск. Пожалуйста, проверьте права доступа для <code>/workspace/pages</code>.',

		'The page you requested to edit does not exist.' => 
		'Страница, которую Вы планируете редактировать не существует.',

		'The Symphony configuration file, <code>/manifest/config.php</code>, is not writable. You will not be able to save changes to preferences.' => 
		'Конфигурационный файл Симфони <code>/manifest/config.php</code> недоступен для чтения. Вы не сможете сохранить нстройки.',

		'This is an example of the form markup you can use on your frontend:' => 
		'Это пример кода формы, который вы можете использовать в клиентской части:',

		'This is a required field.' => 
		'Данное поле является обязательным.',

		'This is not a valid email address. You must provide an email address since you will need it if you forget your password.' => 
		'Был введен не правильный e-mail адрес. Вы должны предоставить верный e-mail адрес, поскольку н может понядобиться вам, сли вы забудете пароль',

		'Delete this data source' => 
		'Удалить эти исходные данные',

		'This is a courtesy email to notify you that an entry was created on the %1$s section. You can edit the entry by going to: %2$s' => 
		'Данное письмо информирует Вас о том, что в сущности %1$s была создана новая запись. Вы можете отредактировать её по следующему адресу: %2$s',

		'This page could not be rendered due to the following XSLT processing errors.' => 
		'Данная страница не может быть преобразована из-за следующих XSLT ощибок.',

		'Delete this page' => 
		'Удалить данную страницу',

		'Delete this author' => 
		'Удалить данного автора',

		'Delete this utility' => 
		'Удалить данный блок',

		'Delete this section' => 
		'Удалить данную сущность',

		'Delete this entry' => 
		'Удалить данную запись',

		'Username is already taken' => 
		'Данное имя пользователя уже используется',

		'This document is not well formed. The following error was returned: <code>%s</code>' => 
		'Данный документ был сформирован неправильно. Возникли следующие ошибки: <code>%s</code>',

		'Delete this event' => 
		'Удалить данное событие',

		'This event will not be processed if any of these rules return true.' => 
		'Данное событие не будет обработано если хотя бы одно из этих правил применимо (возвращает true).',

		'This is a required field' => 
		'Это обязательное поле.',

		'Dynamic Options' => 
		'Динамические опции',

		'Dynamic XML' => 
		'Динамический XML',

		'Email' => 
		'E-Mail',

		'Send Email' => 
		'Отправить E-Mail',

		'Email Address' => 
		'E-Mail адрес',

		'Send Email Filter' => 
		'Фильтр отправки E-Mail',

		'An Event with the name <code>%s</code> name already exists' => 
		'Событие с именем <code>%s</code> уже существует',

		'A field with that element name already exists. Please choose another.' => 
		'Поле с таким именем уже существует. Пожалуйста выберите другое имя.',

		'A new password has been requested for your account. Login using the following link, and change your password via the Authors area:' => 
		'Поступил запрос на создание нового пароля для вашего аккаунта. Войдите в систему используя данную ссылку, и измените свой пароль в разделе для Авторов:',

		'A file with the name %1$s already exists in %2$s. Please rename the file first, or choose another.' => 
		'Файл с именем %1$s уже существует в %2$s. Пожалуйста сначала переименуйте его или выберите другой.',

		'A Data source with the name <code>%s</code> name already exists' => 
		'Исходные данные с именем <code>%s</code> уже существуют',

		'An email containing a customised login link has been sent. It will expire in 2 hours.' => 
		'Письмо содержащее ссылку для входа было отправлено. Срок действия ссылки истекает через два часа.',

		'A result limit must be set' => 
		'Должно быть установлено конечное ограничение',

		'A page number must be set' => 
		'Должен быть установлен номер страницы',

		'Included Elements' => 
		'Подключенные элементы',

		'Preferences' => 
		'Свойства',

		'Entry [created | edited] successfully.' => 
		'Запись [создана | отредактирована] успешно.',

		'Entry edited successfully.' => 
		'Запись успешно отредактирована.',

		'Entry created successfully.' => 
		'Запись успешно создана.',

		'Create Entry' => 
		'Создать запись',

		'Entries' => 
		'Записи',

		'Recipient username was invalid' => 
		'Неверное имя получателя',

		'Developer' => 
		'Разработчик',

		'Aardvarks' => 
		'Трубкозубы',

		'Create Event' => 
		'Создать событие',

		'Events' => 
		'События',

		'Success and Failure XML Examples' => 
		'Примеры успешного и неудачного XML кода',

		'Filter Results' => 
		'Результаты фильтрации',

		'First' => 
		'Первый',

		'Advanced Configuration' => 
		'Дополнительные настройки',

		'Extensions' => 
		'Расширения',

		'A Utility with that name already exists. Please choose another.' => 
		'Блок с именем <code>%s</code> уже существует. Придумайте другое имя.',

		'A Section with the name <code>%s</code> name already exists' => 
		'Сущность с именем <code>%s</code> уже существует',

		'There is already a field of type <code>%s</code>. There can only be one per section.' => 
		'Поле типа <code>%s</code> уже существует. В сущности допустимо наличие только одного поля такого типа.',

		'A 403 type page already exists.' => 
		'Страница для ошибки 403 уже существует.',

		'A 404 type page already exists.' => 
		'Страница для ошибки 404 уже существует.',

		'An index type page already exists.' => 
		'Страница и типом index уже существует.',

		'A page with that handle already exists' => 
		'Сраница с таким обработчиком уже существует.',

		'A page with that title already exists' => 
		'Страница с таким названием уже существует.',

		'There was a problem locating your account. Please check that you are using the correct email address.' => 
		'Ваш профиль не найден. Пожалуйста, убедитесь в правильности введенного адреса email.',

		'An unknown database occurred while attempting to create the section.' => 
		'Во время создания сущности произошла неизвестная ошибка базы данных.',

		'No suitable XSLT processor was found.' => 
		'Не обнаружен подходящий XSLT процессор.',

		'No suitable engine object found' => 
		'Не найден подходящий объект engine.',

		'No valid recipients found. Check send-email[recipient] field.' => 
		'Подходящие адресаты не обнаружены. Проверьте поле send-email[recipient].',

		'There appears to be an existing <code>.htaccess</code> file in the <code>/symphony</code> directory.' => 
		'Судя по всему, в директории <code>/symphony</code> уже существует файл <code>.htaccess</code>.',

		'There appears to be an existing <code>.htaccess</code> file in the Symphony install location. To avoid name clashes, you will need to delete or rename this file.' => 
		'Судя по всему, в директории инсталляции Симфони уже существует файл <code>.htaccess</code>. Необходимо удалить или переименовать его, чтобы избежать возможных ошибок.',

		'It will expire in 2 hours. If you did not ask for a new password, please disregard this email.' => 
		'Срок действия - два часа. Если вы не запрашивали смену пароля просто проигнорируйте это письмо',

		'Existing Values' => 
		'Существующие значения',

		'Wrong password. Enter old one to change email address.' => 
		'Неправильный пароль. Введите старый пароль, чтобы изменить адрес e-mail',

		'Wrong password. Enter old password to change it.' => 
		'Неправильный пароль. Введите старый пароль, чтобы изменить его.',

		'Outstanding Requirements' => 
		'Привывшает требования',

		'Missing Requirements' => 
		'Не соответствует требованиям',

		'Fields' => 
		'Поля',

		'Filter Rules' => 
		'Правила фильтрации',

		'Women' => 
		'Женщины',

		'Large' => 
		'Большой',

		'Essentials' => 
		'Основное',

		'Group By' => 
		'Группировать по',

		'Hairy' => 
		'Волосатый(!!!!)',

		'Handle' => 
		'Обработать',

		'Hot' => 
		'Горячий',

		'Hi %s,' => 
		'Привет, %s,',

		'Host' => 
		'Хост',

		'Dogs' => 
		'Собаки',

		'ID' => 
		'ID',

		'The Symphony Team' => 
		'Команда разработчиков Симфони',

		'Installation Failure' => 
		'Ошибка установки',

		'Yes' => 
		'Да',

		'Cold' => 
		'Холодный',

		'Cats' => 
		'Кошки',

		'Bugs' => 
		'Жуки',

		'None' => 
		'Ничего',

		'No records found.' => 
		'Не найдено записей.',

		'None found.' => 
		'Ничего не найдено.',

		'Small' => 
		'Маленький',

		'Coconut' => 
		'Кокос',

		'list of comma author usernames.' => 
		'Список авторов через запятую.',

		'Components' => 
		'Компоненты',

		'Long Description <i>Optional</i>' => 
		'Полное описание <i>не обязательно</i>',

		'Last' => 
		'Последний',

		'Dear <!-- RECIPIENT NAME -->,' => 
		'Уважаемый(ая) <!-- RECIPIENT NAME -->,',

		'Delete' => 
		'Удалить',

		'Men' => 
		'Мужчины',

		'Allow Multiple' => 
		'Разрешить множественный выбор',

		'At least one source must be specified, dynamic or static.' => 
		'По крайней мере один динамический или статический источник даных должен быть определен.',

		'Best Regards,' => 
		'С уважением,',

		'Must be a valid number or parameter' => 
		'Должно быть числом или параметром',

		'Must be a valid number' => 
		'Должно быть числом',

		'Must be greater than zero' => 
		'Должно быть больше нуля',

		'When saved successfully, the following XML will be returned:' => 
		'При успешном сохранении будет возвращен следующий XML:',

		'The following is an example of what is returned if any filters fail:' => 
		'Это пример кода возвращаемого, если хотя бы один из фильтров не сработает:',

		'Last Name' => 
		'Фамилия',

		'Message' => 
		'Сообщение',

		'Name' => 
		'Имя',

		'Name is a required field.' => 
		'Имя - это обязательное поле.',

		'Namespace' => 
		'Пространство имен',

		'Namespace Declarations <i>Optional</i>' => 
		'Объявление пространств имен <i>не обязательно</i>',

		'Navigation' => 
		'Навигация',

		'Filter Navigation by' => 
		'Фильтровать навигацию по',

		'Next &rarr;' => 
		'Следующий &rarr;',

		'No' => 
		'Нет',

		'new' => 
		'новый',

		'Create New' => 
		'Создать новый',

		'Create a new data source' => 
		'Создать новые исходные данные',

		'Create a new page' => 
		'Создать новую страницу',

		'Create a new utility' => 
		'Создать новый блок',

		'Create a new entry' => 
		'Создать новую запись',

		'Create a new event' => 
		'Создать новое событие',

		'New Password' => 
		'Новый пароль',

		'New Symphony Account Password' => 
		'Новый пароль для профиля в симфони',

		'Confirm New Password' => 
		'Подтвердите новый пароль',

		'Admin Only' => 
		'Только для администратора',

		'Untitled' => 
		'Без названия',

		'Optional' => 
		'не обязательно',

		'Parameter Output' => 
		'Вывод параметров',

		'Password' => 
		'Пароль',

		'Confirm Password' => 
		'Подтвердите пароль',

		'Passwords did not match' => 
		'Пароли не совпадают',

		'Personal Information' => 
		'Личная информация',

		'Pirates' => 
		'Пираты',

		'Port' => 
		'Порт',

		'Lumpy' => 
		'Бугорчатый(!!!!)',

		'Source' => 
		'Источник',

		'Body' => 
		'Данные(!!!)',

		'Region' => 
		'Регион',

		'Round' => 
		'Круглый',

		'Pigs' => 
		'Свиньи',

		'Page %1$s of %2$s' => 
		'Страница %1$s из %2$s',

		'Create Page' => 
		'Создать страницу',

		'Page Not Found' => 
		'Страница не найдена',

		'Page not found' => 
		'Страница не найдена',

		'Pages' => 
		'Страницы',

		'Page ID' => 
		'ID страницы',

		'Page Type' => 
		'Тип страницы',

		'Set %s' => 
		'установить (!!!) %s',

		'You must enter a Password. This will be your Symphony login information.' => 
		'Вы должны ввести пароль. Вы будете использовать его для входа в Симфони.',

		'You must enter a Username. This will be your Symphony login information.' => 
		'Вы должны ввести Имя пользователя. Вы будете использовать его для входа в Симфони.',

		'You must enter your name.' => 
		'Вы должны ввести свое имя.',

		'You are not authorised to access this section.' => 
		'Вы не имеете прав для просмотра этой сущности',

		'You are not authorised to access this page.' => 
		'Вы не имеете прав для доступа к данной странице.',

		'You are already using the most recent version of Symphony. There is no need to run the installer, and can be safely deleted.' => 
		'Вы уже используете самую последнюю версию Симфони. Нет необходимости снова запускать инсталлятор, его можно удалить.',

		'You are not using the most recent version of Symphony. This update is only compatible with Symphony 2.' => 
		'Вы используете устаревшую версию симфони. Данное обновление совместимо только с версией 2.',

		'Once installed, you will be able to login to the Symphony admin with these user details.' => 
		'После установки используйте это имя пользователя и пароль для того, чтобы войти в административную часть Симфони.',

		'Sort by %1$s %2$s' => 
		'Сортировать по %1$s %2$s',

		'Sort By' => 
		'Сорировать по',

		'Sort Order' => 
		'Порядок сортировки',

		'Sorting and Limiting' => 
		'Сортировка и ограничения',

		'Default Section' => 
		'Сущность по умолчанию',

		'Static XML' => 
		'Статический XML',

		'Status' => 
		'Статус',

		'Make textarea %s rows tall' => 
		'Сделать текстовую область %s рядов в высоту.',

		'Make sure that you delete <code>' => 
		'Убедитесь что вы стираете <code>',

		'Symphony' => 
		'Симфони',

		'Update Symphony' => 
		'Обновить Симфони',

		'Symphony needs the following requirements satisfied before installation can proceed.' => 
		'Необходимо, чтобы были соблюдены следующие критерии, прежде чем установка может быть продолжена.',

		'Symphony needs permission to read and write both files and directories.' => 
		'Необходимо установить Симфони разрешение на чтение и запись для дерикторий и файлов.',

		'Symphony does not have write permission to the <code>/manifest</code> directory. Please modify permission settings on this directory and its contents to allow this, such as with a recursive <code>chmod -R</code> command.' => 
		'Симфони не имеет права на запись в директорию <code>/manifest</code>. Пожалуйста измените права доступа к дериктории и ее содержимому например командой <code>chmod -R</code>.',

		'Symphony does not have write permission to the <code>/symphony</code> directory. Please modify permission settings on this directory. This is necessary only during installation, and can be reverted once installation is complete.' => 
		'Симфони не имеет права на запись в директорию <code>/symphony</code>. Пожалуйста измените права доступа к дериктории и ее содержимому. Это необходимо только на время установки и может предыдущие значения могут быть восстановлены.',

		'Symphony does not have write permission to the existing <code>/workspace</code> directory. Please modify permission settings on this directory and its contents to allow this, such as with a recursive <code>chmod -R</code> command.' => 
		'Симфони не имеет права на запись в директорию  <code>/workspace</code>. Пожалуйста измените права доступа к дериктории и ее содержимомунапример командой <code>chmod -R</code>.',

		'Symphony does not have write permission to the temporary <code>htaccess</code> file. Please modify permission settings on this file so it can be written to, and renamed.' => 
		'Симфони не имеет права на запись во временный файл <code>.htaccess</code>. Пожалуйста измените права доступа к файлу, чтобы он был доступен для записи и переименования.',

		'Symphony does not have write permission to the root directory. Please modify permission settings on this directory. This is necessary only if you are not including a workspace, and can be reverted once installation is complete.' => 
		'Симфони не имеет права на запись в корневую директорию. Пожалуйста измените права доступа к директории. Это необходимо сделать только на время  установки. После инсталляции значения могут быть восстановлены.',

		'Install Symphony' => 
		'Инсталляция Симфони',

		'Symphony is ready to be installed at the following location.' => 
		'Симфони готова для установки в следующее размещение.',

		'Symphony normally specifies UTF-8 character encoding for database entries. With compatibility mode enabled, Symphony will instead use the default character encoding of your database.' => 
		'Обычно для базы данных Симфони использует кодировку UTF-8. В режиме совместимости Симфони будет использовать кодировку Вашей базы данных установленную по умолчанию.',

		'Symphony was unable to connect to the specified database. You may need to modify host or port settings.' => 
		'Симфони не смогла получить доступ к базе данных. Вам необходимо изменить название хоста или значение порта.',

		'Symphony Concierge' => 
		'Консьерж Симфони (!!!!)',

		'Symphony Database Error' => 
		'Ошибка базы данных Симфони',

		'System' => 
		'System',

		'System ID' => 
		'Системный ID ',

		'System Author' => 
		'Системный Автор',

		'System Date' => 
		'Системная дата',

		'Table Prefix' => 
		'Префикс таблиц',

		'Title' => 
		'Название',

		'Title is a required field' => 
		'Название явлется обязательным полем',

		'Type' => 
		'Тип',

		'To edit an existing entry, include the entry ID value of the entry in the form. This is best as a hidden field like so:' => 
		'Чтобы отредактировать существующую запись включите в форму ID записи. Лучше всего это сделать следующим образом:',

		'To redirect to a different location upon a successful save, include the redirect location in the form. This is best as a hidden field like so, where the value is the URL to redirect to:' => 
		'Для переадресации по новому адресу после успешного сохранения включите в форму ссылку на место переадресации. Лучше все это сделать при помощи скрытого поля, например таким образом, указав в качестве value URL:',

		'Environment Settings' => 
		'Установки среды',

		'Unknown Section' => 
		'Неизвестная сущность',

		'Unknown Entry' => 
		'Неизвестная запись',

		'URI' => 
		'URI',

		'URL' => 
		'URL',

		'URL Handle' => 
		'Обработчик URL',

		'URL Parameters' => 
		'Параметры URL',

		'Parent Page' => 
		'Родительская страница',

		'Validation Rule <i>Optional</i>' => 
		'Правило проверки <i>не обязательно</i>',

		'Forbidden' => 
		'Запрещено',

		'Required URL Parameter <i>Optional</i>' => 
		'Требуемыый параметр URL <i>не обязательно</i>',

		'Version' => 
		'Версия',

		'Version %s' => 
		'Версия %s',

		'Use compatibility mode' => 
		'Использовать режим совместимости',

		'Use <code>{$param}</code> syntax to specify dynamic portions of the URL.' => 
		'Используйте синтаксис <code>{$param}</code>, чтобы определить динамическую часть URL.',

		'Use <code>{$param}</code> syntax to limit by page parameters.' => 
		'Используйте синтаксис <code>{$param}</code>, чтобы лимитировать количество параметров страницы.',

		'Use <code>{$param}</code> syntax to filter by page parameters.' => 
		'Используйте синтаксис <code>{$param}</code>, чтобы фильтровать по параметрам страницы.',

		'Directories' => 
		'Директории',

		'First Name' => 
		'Имя',

		'Suggestion List' => 
		'Список предложений',

		'Birds' => 
		'Птицы',

		'Website Preferences' => 
		'Параметры Сайта',

		'Website Name' => 
		'Название Сайта',

		'When an error occurs during saving, due to either missing or invalid fields, the following XML will be returned' => 
		'Wenn beim Speichern ein Fehler auftritt, weil Felder fehlen oder ungültig sind, wird nachfolgendes XML ausgeben',

		'Value' => 
		'Значение',

		'Weasels' => 
		'Хорьки',

		'Root Path' => 
		'Путь к корневой директории',

		'Worms' => 
		'Червяки',

		'XML' => 
		'XML',

		'XML is invalid' => 
		'XML не валиден',

		'XML Output' => 
		'Вывод XML',

		'XSLT Processing Error' => 
		'Ошибка при обработке XSLT',

		'Viewing %1$s - %2$s of %3$s entries' => 
		'Показано %1$s - %2$s из %3$s записей',

		'Show a maximum of %s results' => 
		'Отображать максимально %s результатов',

		'Show page %s of results' => 
		'Показывать страницу %s результатов',

		'Line %s' => 
		'Строка %s',

		'Time Format' => 
		'Временной формат',

		'Destination Directory' => 
		'Директория назначения',

		'ZLib Compression Library' => 
		'Библиотека ZLib-Compression',

		'Use Field' => 
		'Использованное поле',

		'random' => 
		'случайным образом',

		'Access Denied' => 
		'Доступ закрыт',

		'Permission Settings' => 
		'Установки прав доступа',

		'XML returned is invalid.' => 
		'Возвращаемый XML  не валиден',

		'Two custom fields have the same element name. All element names must be unique.' => 
		'Два поля имеют одинаковое название элемента. Все имена элементов должны быть уникальны',

		'Could not find Field <code>%1$s</code> at <code>%2$s</code>. If the Field was provided by an Extension, ensure that it is installed, and enabled.' => 
		'Невозможно найти поле <code>%1$s</code> в <code>%2$s</code>. Если данное поле формировалось расширением, убедитесь что оно установлено и активировано.',

		'Could not find Text Formatter <code>%s</code>. If the Text Formatter was provided by an Extensions, ensure that it is installed, and enabled.' => 
		'Невозможно найти Text Formatter <code>%s</code>. Если Text Formatter был установлен расширением, убедитесь что оно установлено и активировано..',

		'Customise how Date and Time values are displayed throughout the Administration interface.' => 
		'Установите то, как будут выглядеть дата и время в административном интерфейсе.',

		'Data retrieved from the Symphony support server is decompressed with the ZLib compression library.' => 
		'Данные полученные с сервера поддержки Симфони распакованы при помощи библиотеки ZLib compression .',

		'Data source output grouping is not supported by the <code>%s</code> field' => 
		'Группировка исходных данных не поддерживается полем <code>%s</code>',

		'Enter your email address to be sent a remote login link with further instructions for logging in.' => 
		'Введите свой email адрес, куда будет выслана ссылка для продолжения регистрации.',

		'File chosen in \'%s\' does not match allowable file types for that field.' => 
		'Файл выбранный в \'%s\' не соответствует допустимому типу файлов для этого поля.',

		'File chosen in \'%s\' was only partially uploaded due to an error.' => 
		'Файл выбранный в \'%s\' был загружен частично в связи с ошибкой.',

		'Invalid element name. Must be valid QName.' => 
		'Неверное имя элемента. Имя должно соответствовать QName.',

		'Invalid Entry ID specified. Could not create Entry object.' => 
		'Было указано неверное ID. Невозможно создать объект Entry.',

		'Text Input' => 
		'Текстовая строка',

		'Textarea' => 
		'Текстовое поле',

		'Select Box' => 
		'Выпадающее меню',

		'Checkbox' => 
		'Выбор галочкой',

		'Date' => 
		'Дата',

		'File Upload' => 
		'Загрузка файла',

		'Tag List' => 
		'Список тэгов',

		'Last Seen' => 
		'Последнее посещение (!!!!)',

		'sections' => 
		'sections',

		'authors' => 
		'authors',

		'navigation' => 
		'navigation',

		'static_xml' => 
		'static_xml',

		'dynamic_xml' => 
		'dynamic_xml',

		'The supplied password was rejected. Make sure it is not empty and that password matches password confirmation.' => 
		'Данный пароль был отклонен. Убедитесь, что поле не пустое и пароли соответствуют друг другу.',

		'The Section you are looking for, <code>%s</code>, could not be found.' => 
		'Сущность, которую вы ищете, <code>%s</code>, не может быть найдена.',

		'Add a new author' => 
		'Дабавить нового Автора',

		'Could not %1$s %2$s, there was a problem loading the object. Check the driver class exists.' => 
		'Невозможно %1$s %2$s, возникли проблемы при загрузке объекта. Убедитесь в существовании управляющего класса.',

		'Static Options' => 
		'Статические опции',

		'Label' => 
		'Обозначение',

		'Placement' => 
		'Размещение',

		'Main content' => 
		'Основной контент',

		'Sidebar' => 
		'Боковая панель',

		'Formatting' => 
		'Форматирование',

		'An empty result will be returned when this parameter does not have a value. Do not wrap the parameter with curly-braces.' => 
		'Если данный параметр не имеет значения будет возвращен пустой результат. Не помещайте параметр в фигурные скбоки.',

		'Template' => 
		'Шаблон',

		'Page' => 
		'Страница',

		'Page Settings' => 
		'Установки страницы',

		'Page Resources' => 
		'Ресурсы страницы',

		'Page could not be deleted because it does not exist.' => 
		'Невозможно удалить страницу, поскольку она не существует.',

		'Page could not be deleted because it has children.' => 
		'Невозможно удалить страницу поскольку у нее есть дочерние элементы.',

		'One or more pages could not be deleted. Please check permissions on <code>/workspace/pages</code>.' => 
		'Одна или более страниц не могут быть удалены. Пожалуйста проверьте права для <code>/workspace/pages</code>.',

		'Navigation Group' => 
		'Группа навигации',

		'Delete Entries' => 
		'Удалить записи',

		'Add an Author' => 
		'Добавить Автора',

		'Leave password fields blank to keep the current password' => 
		'Оставьте поля для пароля пустыми, чтобы сохранить текущий пароль',

		'Preferences saved.' => 
		'Свойства сохранены.',

		'Logout' => 
		'Выйти',

		'name' => 
		'имя',

		'Utility' => 
		'Блок',

		'Symphony requires <code>MySQL 4.1</code> or greater to work. This requirement must be met before installation can proceed.' => 
		'Для Симфони необходима <code>MySQL 4.1</code> или новее. Без подходящей версии установка не может быть продолжена.',

		'Symphony requires <code>MySQL 4.1</code> or greater to work, however version <code>%s</code> was detected. This requirement must be met before installation can proceed.' => 
		'Для Симфони необходима <code>MySQL 4.1</code> или новее. Однако была обнаружена версия <code>%s</code>. Без подходящей версии установка не может быть продолжена.',

		'%s Select current user by default' => 
		'%s выбрать текущего пользователя по умолчанию',

		'The destination directory, <code>%s</code>, does not exists.' => 
		'Директория назначения <code>%s</code>  не существует.',

		'Directory <code>%s</code> does not exists.' => 
		'Директория <code>%s</code> не существует.',

		'Blueprints' => 
		'Шаблоны',

		'%1$s Allow remote login via <a href="%2$s">%2$s</a>' => 
		'%1$s Разрешить удаленный вход через <a href="%2$s">%2$s</a>',

		'An error occurred while processing this form. <a href="#error">See below for details.</a>' => 
		'Во время обработки формы произошла ошибка. <a href="#error">Детали ошибки.</a>',

		'Data source updated at %1$s. <a href="%2$s">Create another?</a> <a href="%2$s">View all Data sources</a>' => 
		'Исходные данные изменены в %1$s. <a href="%2$s">Создать еще одни?</a> <a href="%2$s">Просмотреть все исходные данные.</a>',

		'Data source created at %1$s. <a href="%2$s">Create another?</a> <a href="%3$s">View all Data source</a>' => 
		'Исходные данные созданы в %1$s. <a href="%2$s">Создать еще одни?</a> <a href="%2$s">Просмотреть все исходные данные.</a>',

		'The parameter <code id="output-param-name">$ds-%s</code> will be created with this field\'s value for XSLT or other data sources to use.' => 
		'Параметр <code id="output-param-name">$ds-%s</code> будет создан со следующим полем для использования в исходных данных или XSLT.',

		'Event updated at %1$s. <a href="%2$s">Create another?</a> <a href="%3$s">View all Events</a>' => 
		'Событие изменено в %1$s. <a href="%2$s">Создать еще одно?</a> <a href="%2$s">Просмотреть все события.</a>',

		'Event created at %1$s. <a href="%2$s">Create another?</a> <a href="%3$s">View all Events</a>' => 
		'Событие создано в %1$s. <a href="%2$s">Создать еще одно?</a> <a href="%2$s">Просмотреть все события.</a>',

		'Entry updated at %1$s. <a href="%2$s">Create another?</a> <a href="%3$s">View all Entries</a>' => 
		'Запись изменена в %1$s. <a href="%2$s">Создать еще одну?</a> <a href="%3$s">Просмотреть все записи.</a>',

		' (<b>Notice that it is possible to get mixtures of success and failure messages when using the "Allow Multiple" option</b>)' => 
		' (<b>Будте внимательны: при использовании "Множественного выбора" вы можете одновременно получить как сообщения об ошибках, так и сообщения об удачном завершении операции</b>)',

		'<acronym title="Universal Resource Locator">URL</acronym>' => 
		'<acronym title="Universal Resource Locator">URL</acronym>',

		'<acronym title="Universal Resource Locator">URL</acronym> Parameters' => 
		'<acronym title="Universal Resource Locator">URL-</acronym>Параметры',

		'%s %s at %s. <a href="%s">View all %s</a>' => 
		'%s %s um %s. <a href="%s">Просмотреть все %s.</a>',

		'%s %s at %s. <a href="%s">Create another?</a> <a href="%s">View all %s</a>' => 
		'%s %s um %s. <a href="%s">Создать еще?</a> <a href="%s">Просмотреть все %s.</a>',

		'Unknown errors occurred while attempting to save. Please check your <a href="%s">activity log</a>.' => 
		'При попытке сохранить возникли неизвестные ошибки. Пожалуйста проверьте <a href="%s">Activity log</a>.',

		'The supplied password was rejected. <a href="%s">Retrieve password?</a>' => 
		'Указанный пароль был отклонен. <a href="%s">Восстановить пароль?</a>',

		'It looks like your trying to create an entry. Perhaps you want fields first? <a href="%s">Click here to create some.</a>' => 
		'Похоже вы пытаетесь создать запись. Для начала вам нужно создать поля. <a href="%s">Для создания полей кликните сюда.</a>',

		'It looks like your trying to create an entry. Perhaps you want custom fields first? <a href="%s">Click here to create some.</a>' => 
		'Похоже вы пытаетесь создать запись. Для начала вам нужно создать поля. <a href="%s">Для создания полей кликните сюда.</a>',

		'Could not add directory "%s".' => 
		'Невозмодно добавить директорию "%s".',

		'Could not add file "%s".' => 
		'Невозможно добавить файл "%s".',

		'Please <a href="%s">login</a> to view this page.' => 
		'Пожалуйста  <a href="%s">войдите</a>, чтобы видеть данную страницу.',

		'MySQL Error (%1$s): %2$s in query "%3$s"' => 
		'Ошибка MySQL (%1$s): %2$s в записи "%3$s"',

		'<abbr title="PHP: Hypertext Pre-processor">PHP</abbr> 5.1 or above' => 
		'<abbr title="PHP: Hypertext Pre-processor">PHP</abbr> 5.1 или выше',

		'Symphony needs a recent version of <abbr title="PHP: Hypertext Pre-processor">PHP</abbr>.' => 
		'Для Симфони необходима последняя версия <abbr title="PHP: Hypertext Pre-processor">PHP</abbr>-Version.',

		'My<abbr title="Structured Query Language">SQL</abbr> 4.1 or above' => 
		'My<abbr title="Structured Query Language">SQL</abbr> 4.1 или выше',

		'Symphony needs a recent version of My<abbr title="Structured Query Language">SQL</abbr>.' => 
		'Для Симфони необходима последняя версия My<abbr title="Structured Query Language">SQL</abbr>-Version.',

		'<abbr title="eXtensible Stylesheet Language Transformation">XSLT</abbr> Processor' => 
		'<abbr title="eXtensible Stylesheet Language Transformation">XSLT</abbr>-Prozessor',

		'Symphony needs an XSLT processor such as Lib<abbr title="eXtensible Stylesheet Language Transformation">XSLT</abbr> or Sablotron to build pages.' => 
		'Для симфони необходим XSLT-процессор, такой как, например, Lib<abbr title="eXtensible Stylesheet Language Transformation">XSLT</abbr> или Sablotron для создания страниц.',

		'An error occurred during installation. You can view you log <a href="install-log.txt">here</a> for more details.' => 
		'Во время инсталляции произошла ошибка. Смотрите файлы журнала<a href="install-log.txt">Instalation-Log</a>для получения более детальной информации.',

		'Error creating field object with id %1$d, for filtering in data source "%2$s". Check this field exists.' => 
		'При создании объекта Field с id %1$d возникла ошибка при фильтрации в исходных данных "%2$s". Проверьте существование данного поля.',

		'"%1$s" contains invalid XML. The following error was returned: <code>%2$s</code>' => 
		'"%1$s" содержит невалидный XML. Было получено следующее сообщение об ошибке: <code>%2$s</code>',

		'File chosen in "%1$s" exceeds the maximum allowed upload size of %2$s specified by your host.' => 
		'Файл выбранный в "%1$s" привышает максимально разрешенный размер %2$s загружаемого файла определенный вашим хостом.',

		'File chosen in "%1$s" exceeds the maximum allowed upload size of %2$s, specified by Symphony.' => 
		'Файл выбранный в "%1$s" привышает максимально разрешенный размер %2$s загружаемого файла определенный Симфони.',

		'The send email filter, upon the event successfully saving the entry, takes input from the form and send an email to the desired recipient. <b>This filter currently does not work with the "Allow Multiple" option.</b> The following are the recognised fields:' => 
		'После создания записи в базе данных, фильтр отправки на электронную почту принимает введенные данные и отсылает письмо указанному адресату. <b>Этот фильтр в настоящее время не работает с опцией "Разрешить множественный выбор"</b> Следующие поля являются определенными(!!!):',

		'Section updated at %1$s. <a href="%2$s">Create another?</a> <a href="%3$s">View all Sections</a>' => 
		'Сущность была обновлена в %1$s. <a href="%2$s">Создать еще одну?</a> <a href="%3$s">Посмотреть все сущности.</a>',

		'Section created at %1$s. <a href="%2$s">Create another?</a> <a href="%3$s">View all Sections</a>' => 
		'Сущность была создана в %1$s. <a href="%2$s">Создать еще одну?</a> <a href="%3$s">Посмотреть все сущности.</a>',

		'Utility updated at %1$s. <a href="%2$s">Create another?</a> <a href="%3$s">View all Utilities</a>' => 
		'Блок был обновлен в %1$s. <a href="%2$s">Создать еще один?</a> <a href="%3$s">Посмотреть все блоки.</a>',

		'Utility created at %1$s. <a href="%2$s">Create another?</a> <a href="%3$s">View all Utilities</a>' => 
		'Блок был создан в %1$s. <a href="%2$s">Создать еще один?</a> <a href="%3$s">Посмотреть все блоки.</a>',

		'Entry created at %1$s. <a href="%2$s">Create another?</a> <a href="%3$s">View all Entries</a>' => 
		'Запись создана в %1$s. <a href="%2$s">Создать еще одну?</a> <a href="%3$s">Посмотреть все записи.</a>',

		'Author updated at %1$s. <a href="%2$s">Create another?</a> <a href="%3$s">View all Authors</a>' => 
		'Информация об авторе обновлена в %1$s. <a href="%2$s">Создать еще одного?</a> <a href="%3$s">Посмотреть всех авторов.</a>',

		'Author created at %1$s. <a href="%2$s">Create another?</a> <a href="%3$s">View all Authors</a>' => 
		'Автор был создан в %1$s. <a href="%2$s">Создать еще одного?</a> <a href="%3$s">Посмотреть всех авторов.</a>',

		'<a href="%s" title="Show debug view">Compile</a>' => 
		'<a href="%s" title="Показать режим отладки">Компилировать</a>',

		'<a href="%1$s" title="Show debug view for %2$s">Line %3$d</a>' => 
		'<a href="%1$s" title="Показать режим отладки для %2$s">Строки %3$d</a>',

	);
	
	
	/*
	 * CORE: Symphony
	 * Javascript strings
	 */

	$dictionary += array(
	
		'Untitled' => 
		'Без названия',

		'Password' => 
		'Пароль',

		'Add item' => 
		'Добавить элемент',

		'Remove selected items' => 
		'Удалить выбранные элементы',

		'Are you sure you want to {$action} {$name}?' => 
		'Уверены, что хотите {$action} {$name}?',

		'Are you sure you want to {$action} {$count} items?' => 
		'Уверены, что хотите {$action} {$count} элементов?',

		'Are you sure you want to {$action}?' => 
		'Уверены, что вы хотите {$action}?',

		'Reordering was unsuccessful.' => 
		'Пересортировка не удалась.',

		'Change Password' => 
		'Сменить пароль',

		'Remove File' => 
		'Удалить файл',

		'at' => 
		'в',

		'just now' => 
		'только что',

		'a minute ago' => 
		'минуту назад',

		'{$minutes} minutes ago' => 
		'{$minutes} минут назад',

		'about 1 hour ago' => 
		'около 1-го часа назад',

		'about {$hours} hours ago' => 
		'около {$hours} часов назад',

	);
	
	
	/*
	 * EXTENSION: Debug DevKit
	 * Localisation strings
	 */

	$dictionary += array(
	
		'XML' => 
		'XML',

		'Debug' => 
		'Отладка',

		'Params' => 
		'Параметры',

		'Result' => 
		'Результат',

	);
	
	
	/*
	 * EXTENSION: Export Ensemble
	 * Localisation strings
	 */

	$dictionary += array(
	
		'Existing Installation' => 
		'Существующая установка',

		'Install Symphony <em>Version %s</em>' => 
		'Установка Симфони, <em>Версия %s</em>',

		'It appears that Symphony has already been installed at this location.' => 
		'Судя по всему Симфони уже установлена в данном расположении.',

		'Export Ensemble' => 
		'Ensemble экспорт',

		'Create' => 
		'Создать',

		'Packages entire site as a <code>.zip</code> archive for download.' => 
		'Создать архив сайта в <code>Zip</code>-формате для скачивания.',

		'Export Ensemble cannot be installed, since the "<a href="http://php.net/manual/en/book.zip.php">ZipArchive</a>" class is not available. Ensure that PHP was compiled with the <code>--enable-zip</code> flag.' => 
		'Ensemble Экспорт не может быть установлен, поскольку класс "<a href="http://php.net/manual/en/book.zip.php">ZipArchive</a>" не доступен. Убедитесь, что PHP был скомпилирован с параметром <code>--enable-zip</code>.',

		'Warning: It appears you do not have the "ZipArchive" class available. Ensure that PHP was compiled with <code>--enable-zip</code>' => 
		'Предупреждение: Судя по всему у вас не доступен класс "ZipArchive". Убедитесь, что PHP был скомпилирован с параметром <code>--enable-zip</code>.',

	);
	
	
	/*
	 * EXTENSION: JIT Image Manipulation
	 * Localisation strings
	 */

	$dictionary += array(
	
		'Error reading external image <code>%s</code>. Please check the URI.' => 
		'Ошибка при чтении внешнего изображения <code>%s</code>. Проверьте правильность URI.',

		'Error writing to temporary file <code>%s</code>.' => 
		'Ошибка при записи во временный файл <code>%s</code>.',

		'Error loading image <code>%s</code>. Check it exists and is readable.' => 
		'Ошибка при загрузке изображения <code>%s</code>. Убедитесь, что файл существует и может быть прочитан.',

		'Cannot load CMYK JPG Images' => 
		'JPG-изображение в формате CMYK не может быть загружено',

		'Unsupported image type. Supported types: GIF, JPEG and PNG' => 
		'Неподдерживаемый тип изображения. Поддерживаемые типы: GIF, JPEG и PNG',

		'Invalid image resource supplied' => 
		'Недействительное изображение',

		'Error: Connecting to that external site is not permitted.' => 
		'Ошибка: Подключение к данному внешнему сайту запрещено.',

		'Image <code>%s</code> could not be found.' => 
		'Изобржение <code>%s</code> не найдено.',

		'Error generating image' => 
		'Ошибка при генерации изображения',

		'JIT Image Manipulation' => 
		'Обрабатывание изображений JIT',

		'Trusted Sites' => 
		'Доверенные сайты',

		'Leave empty to disable external linking. Single rule per line. Add * at end for wild card matching.' => 
		'Оставьте поле пустым, чтобы запретить внешние ссылки. Только одно правило в строке. Используйте * для замены любого символа.',

	);
	
	
	/*
	 * EXTENSION: Localisation Manager
	 * Localisation strings
	 */

	$dictionary += array(
	
		'%1$s &ndash; %2$s' => 
		'%1$s &ndash; %2$s',

		'Symphony' => 
		'Симфони',

		'Language Manager' => 
		'Менеджер языков',

		'Export Settings' => 
		'Установки экспорта',

		'Language' => 
		'Язык',

		'e. g. Deutsch, Français, Русский' => 
		'например Deutsch, Français, Русский',

		'Language Code' => 
		'Языковой Код',

		'e. g. de, fr, ru' => 
		'например de, fr, рус',

		'If you enter details of an already existing language, your download will contain all current strings highlighting missing ones. <br />If you leave all fields blank, a clean, untranslated language file will be returned.' => 
		'Если вы вводите информацию по уже существующему языку, все отсутствующие записи будут подсвечены. <br /> Если вы оставите все поля незаполненными, будет возвращен непереведенный языковой файл.',

		'Download Language File' => 
		'Загрузить языковой файл',

		'System Language' => 
		'Язык системы',

		'Authors can set up a differing language in their profiles.' => 
		'Авторы могут устанавливать в своих профилях различные языки.',

		'Custom Preferences' => 
		'Свойства',

		'System Standard' => 
		'Системный стандарт',

		'Localisation Manager' => 
		'Управление языками',

	);
	
	
	/*
	 * EXTENSION: Maintenance Mode
	 * Localisation strings
	 */

	$dictionary += array(
	
		'Maintenance Mode' => 
		'Режим обслуживания',

		'Enable maintenance mode' => 
		'Разрешить использование режима обслуживания',

		'Maintenance mode will redirect all visitors, other than developers, to the specified maintenance page.' => 
		'В режиме обслуживания все посетители сайта, за исключением разработчиков будут автоматически перенаправляться на специальную страницу обслуживания <code>maintenance</code>).',

		'This site is currently in maintenance mode. <a href="%s/symphony/system/preferences/?action=toggle-maintenance-mode&amp;redirect=%s">Restore?</a>' => 
		'Данный сайт сейчас находится в режиме обслуживания. <a href="%s/symphony/system/preferences/?action=toggle-maintenance-mode&amp;redirect=%s">Запустить?</a>',

		'Website Offline' => 
		'Сайт недоступен',

		'This site is currently in maintenance. Please check back at a later date.' => 
		'Данный сайт сейчас находится в режиме обслуживания. Пожалуйста обратитесь чуть позднее. Спасибо за понимание.',

	);
	
	
	/*
	 * EXTENSION: Profile DevKit
	 * Localisation strings
	 */

	$dictionary += array(
	
		'Profile' => 
		'Профиль',

		'General Details' => 
		'Общая информация',

		'Datasource Execution' => 
		'Создание исходных данных',

		'Event Execution' => 
		'Выполнение события',

		'Full Page Render Statistics' => 
		'Статистика обработки страницы',

		'Slow Query Details' => 
		'Информация о медленных запросах',

		'Total Database Queries' => 
		'Всего записей в базе данных',

		'Slow Queries (> 0.09s)' => 
		'Медленные запросы (> 0,09 Сек.)',

		'Total Time Spent on Queries' => 
		'Общее время затраченное на запросы записей из базы данных',

		'Time Triggering All Events' => 
		'Время запуска всех Событий',

		'Time Running All Data Sources' => 
		'Время запуска всех Исходных данных',

		'XML Generation Function' => 
		'Функция генерации XML',

		'XSLT Generation' => 
		'Генерация XSLT',

		'Output Creation Time' => 
		'Время создания вывода',

	);
	
	
	/*
	 * EXTENSION: Field: Select Box Link
	 * Localisation strings
	 */

	$dictionary += array(
	
		'Select Box Link' => 
		'Ссылка на сущность',

		'Options' => 
		'Опции',

		'Limit to the %s most recent entries' => 
		'Ограничение на %s последних записей.',

		'Allow selection of multiple options' => 
		'Разрешить выбор нескольких опций.',

	);
	
	
	/*
	 * CORE: Symphony
	 * Transliterations
	 */

	$transliterations = array(
	
		// Alphabetic
		
		'/À/' => 'A',		'/Á/' => 'A',		'/Â/' => 'A',		'/Ã/' => 'A',		'/Ä/' => 'Ae',
		'/Å/' => 'A',		'/Ā/' => 'A',		'/Ą/' => 'A',		'/Ă/' => 'A',		'/Æ/' => 'Ae',
		'/Ç/' => 'C',		'/Ć/' => 'C',		'/Č/' => 'C',		'/Ĉ/' => 'C',		'/Ċ/' => 'C',
		'/Ď/' => 'D',		'/Đ/' => 'D',		'/Ð/' => 'D',		'/È/' => 'E',		'/É/' => 'E',
		'/Ê/' => 'E',		'/Ē/' => 'E',		'/Ę/' => 'E',		'/Ě/' => 'E',
		'/Ĕ/' => 'E',		'/Ė/' => 'E',		'/Ĝ/' => 'G',		'/Ğ/' => 'G',		'/Ġ/' => 'G',
		'/Ģ/' => 'G',		'/Ĥ/' => 'H',		'/Ħ/' => 'H',		'/Ì/' => 'I',		'/Í/' => 'I',
		'/Î/' => 'I',		'/Ï/' => 'I',		'/Ī/' => 'I',		'/Ĩ/' => 'I',		'/Ĭ/' => 'I',
		'/Į/' => 'I',		'/İ/' => 'I',		'/Ĳ/' => 'Ij',		'/Ĵ/' => 'J',		'/Ķ/' => 'K',
		'/Ł/' => 'L',		'/Ľ/' => 'L',		'/Ĺ/' => 'L',		'/Ļ/' => 'L',		'/Ŀ/' => 'L',
		'/Ñ/' => 'N',		'/Ń/' => 'N',		'/Ň/' => 'N',		'/Ņ/' => 'N',		'/Ŋ/' => 'N',
		'/Ò/' => 'O',		'/Ó/' => 'O',		'/Ô/' => 'O',		'/Õ/' => 'O',		'/Ö/' => 'Oe',
		'/Ø/' => 'O',		'/Ō/' => 'O',		'/Ő/' => 'O',		'/Ŏ/' => 'O',		'/Œ/' => 'Oe',
		'/Ŕ/' => 'R',		'/Ř/' => 'R',		'/Ŗ/' => 'R',		'/Ś/' => 'S',		'/Š/' => 'S',
		'/Ş/' => 'S',		'/Ŝ/' => 'S',		'/Ș/' => 'S',		'/Ť/' => 'T',		'/Ţ/' => 'T',
		'/Ŧ/' => 'T',		'/Ț/' => 'T',		'/Ù/' => 'U',		'/Ú/' => 'U',		'/Û/' => 'U',
		'/Ü/' => 'Ue',		'/Ū/' => 'U',		'/Ů/' => 'U',		'/Ű/' => 'U',		'/Ŭ/' => 'U',
		'/Ũ/' => 'U',		'/Ų/' => 'U',		'/Ŵ/' => 'W',		'/Ý/' => 'Y',		'/Ŷ/' => 'Y',
		'/Ÿ/' => 'Y',		'/Y/' => 'Y',		'/Ź/' => 'Z',		'/Ž/' => 'Z',		'/Ż/' => 'Z',
		'/Þ/' => 'T',
		'/à/' => 'a',		'/á/' => 'a',		'/â/' => 'a',		'/ã/' => 'a',		'/ä/' => 'ae',
		'/å/' => 'a',		'/ā/' => 'a',		'/ą/' => 'a',		'/ă/' => 'a',		'/æ/' => 'ae',
		'/ç/' => 'c',		'/ć/' => 'c',		'/č/' => 'c',		'/ĉ/' => 'c',		'/ċ/' => 'c',
		'/ď/' => 'd',		'/đ/' => 'd',		'/ð/' => 'd',		'/è/' => 'e',		'/é/' => 'e',
		'/ê/' => 'e',		'/ë/' => 'e',		'/ē/' => 'e',		'/ę/' => 'e',		'/ě/' => 'e',
		'/ĕ/' => 'e',		'/ė/' => 'e',		'/ĝ/' => 'g',		'/ğ/' => 'g',		'/ġ/' => 'g',
		'/ģ/' => 'g',		'/ĥ/' => 'h',		'/ħ/' => 'h',		'/ì/' => 'i',		'/í/' => 'i',
		'/î/' => 'i',		'/ï/' => 'i',		'/ī/' => 'i',		'/ĩ/' => 'i',		'/ĭ/' => 'i',
		'/į/' => 'i',		'/ı/' => 'i',		'/ĳ/' => 'ij',		'/ĵ/' => 'j',		'/ķ/' => 'k',
		'/ł/' => 'l',		'/ľ/' => 'l',		'/ĺ/' => 'l',		'/ļ/' => 'l',		'/ŀ/' => 'l',
		'/ñ/' => 'n',		'/ń/' => 'n',		'/ň/' => 'n',		'/ņ/' => 'n',		'/ŋ/' => 'n',
		'/ò/' => 'o',		'/ó/' => 'o',		'/ô/' => 'o',		'/õ/' => 'o',		'/ö/' => 'oe',
		'/ø/' => 'o',		'/ō/' => 'o',		'/ő/' => 'o',		'/ŏ/' => 'o',		'/œ/' => 'oe',
		'/ŕ/' => 'r',		'/ř/' => 'r',		'/ŗ/' => 'r',		'/ś/' => 's',		'/š/' => 's',
		'/ş/' => 's',		'/ŝ/' => 's',		'/ș/' => 's',		'/ť/' => 't',		'/ţ/' => 't',
		'/ŧ/' => 't',		'/ț/' => 't',		'/ù/' => 'u',		'/ú/' => 'u',		'/û/' => 'u',
		'/ü/' => 'ue',		'/ū/' => 'u',		'/ů/' => 'u',		'/ű/' => 'u',		'/ŭ/' => 'u',
		'/ũ/' => 'u',		'/ų/' => 'u',		'/ŵ/' => 'w',		'/ý/' => 'y',		'/ŷ/' => 'y',
		'/ÿ/' => 'y',		'/y/' => 'y',		'/ź/' => 'z',		'/ž/' => 'z',		'/ż/' => 'z',
		'/þ/' => 't',		'/ß/' => 'ss',		'/ſ/' => 'ss',		'/ƒ/' => 'f',		
		'/ŉ/' => 'n',		
		
		'/А/' => 'A',
		'/а/' => 'a',
		'/Б/' => 'B',
		'/б/' => 'b',
		'/В/' => 'V',
		'/в/' => 'v',
		'/Г/' => 'G',
		'/г/' => 'g',
		'/Д/' => 'D',
		'/д/' => 'd',
		'/Е/' => 'E',
		'/е/' => 'e',
		'/Ё/' => 'E',
		'/ё/' => 'e',
		'/Ж/' => 'ZH',
		'/ж/' => 'zh',
		'/З/' => 'Z',
		'/з/' => 'z',
		'/И/' => 'I',
		'/и/' => 'i',
		'/Й/' => 'J',
		'/й/' => 'j',
		'/К/' => 'K',
		'/к/' => 'k',
		'/Л/' => 'L',
		'/л/' => 'l',
		'/М/' => 'M',
		'/м/' => 'm',
		'/Н/' => 'N',
		'/н/' => 'n',
		'/О/' => 'O',
		'/о/' => 'o',
		'/П/' => 'P',
		'/п/' => 'p',
		'/Р/' => 'R',
		'/р/' => 'r',
		'/С/' => 'S',
		'/с/' => 's',
		'/Т/' => 'T',
		'/т/' => 't',
		'/У/' => 'U',
		'/у/' => 'u',
		'/Ф/' => 'F',
		'/ф/' => 'f',
		'/Х/' => 'H',
		'/х/' => 'h',
		'/Ц/' => 'TS',
		'/ц/' => 'ts',
		'/Ч/' => 'CH',
		'/ч/' => 'ch',
		'/Ш/' => 'SH',
		'/ш/' => 'sh',
		'/Щ/' => 'SCH',
		'/щ/' => 'sch',
		'/Ъ/' => '',
		'/ъ/' => '',
		'/Ы/' => 'Y',
		'/ы/' => 'y',
		'/Ь/' => '',
		'/ь/' => '',
		'/Э/' => 'E',
		'/э/' => 'e',
		'/Ю/' => 'YU',
		'/ю/' => 'yu',
		'/Я/' => 'YA',
		'/я/' => 'ya',

		// Symbolic

		'/\(/' => null,		'/\)/' => null,		'/,/' => null,
		'/–/' => '-',		'/－/' => '-',		'/„/' => '"',
		'/“/' => '"',		'/”/' => '"',		'/—/' => '-',

		// Ampersands

		'/^&(?!&)$/' => 'и',
		'/^&(?!&)/' => 'и-',
		'/&(?!&)&/' => '-и',
		'/&(?!&)/' => '-и-',

	);
