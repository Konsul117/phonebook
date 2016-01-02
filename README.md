# phonebook
Телефонный справочник (тестовое задание)

Данный проект представляет собой тестовое задание по фреймворку yii2. Задача заключается в реализации простого приложения, основываясь на фреймворке yii2 (base). 
Функционал:
* Добавление, редактирование контактов телефонного справочника (CRUD).
* Возможность регистрации, а так же ведение собственного справочника для каждого пользователя.
* Устанвка и инициализация проекта (загрузка справочников из внешнего источника).

Цель задания:
* Продемонстрировать базовые знания и навыки разработки на основе MVC (HMVC) фреймворка.
* Использование менеджеров пакетов (composer, bower).
* Создание компонентов, расширение функционала фреймворка.

В данном задании были задействованы следующие технологии:
* Миграции БД, автоматическое развёртывание структуры БД, загрузка справочников из внешнего источника и импорт в БД.
* Реализация Access Control List (ACL) - системы распределения прав на основе компонента RBAC.
* Стандартные CRUD-операции над моделями.
* Клиент-серверное взаимодействие посредством ajax.
* Самописные и вендорские jquery-плагины.
* Механизм назначения событий их обработки.
* Консольные операции и интерактивный режим взаимодействия с пользователем.
* ФИАС (классификатор адресообразующих элементов) для получения городов и улиц, используемых в приложении.

# Установка
1. Клонируйте к себе проект
2. Выполните из командной строки (корневой директории клонированного проекта) установку компонентов bower:

        $ bower install
3. Выполните установку компоентов composer:

        $ composer install

4. Выдайте права на запись для каталогов:

        $ chmod -R 777 ./runtime
        $ chmod -R 777 ./web/assets

5. Настройте БД в файле конфигурации config/db.php. База данных должна быть пустая.

        'dsn' => 'mysql:host=localhost;dbname=test', //вместо test - имя БД
        'username' => '',//имя пользователя
        'password' => '',//пароль

6. Произведите инициализацию:

        $ ./yii init/install

7. Создайте пользователя с правами администратора:

        $ ./yii init/create-admin

8. Установите базу ФИАС:

        $ ./yii init/fias

Следуйте выводимым сообщениям. Данный процесс очень долгий, т.к. размер таблицы составляет порядка 140 Мб
