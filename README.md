Тестове завдання
Для виконання завдання було використано фреймворк Laravel 11.37

Встановлення
Клонування з репозиторію https://github.com/vitkonovaluck/test_telegram_trello.git
Запестити composer в директорія проекту composer install
Створити .env файл : cp .env.example .env 
Зареєструвати бота у Telegram та внести його токен у .env файл під дерективою TELEGRAM_BOT_TOKEN
Створити групу у телеграм Telegram, за допомогою @UserInfoToBot визначити її id та внести у .env файл під дерективою TELEGRAM_CHAT_ID
Створити дошку на Trello на додати та внести її id та внести у .env файл під дерективою TRELLO_BOARD_ID
Згенерувати Trello створити ключ API, та внести у .env файл під дерективою TRELLO_API_KEY 
Згенерувати Trello створити токен API, та внести у .env файл під дерективою TRELLO_API_TOKEN
Для реєстрації webhook у Telegram та Trello та створення колонок “InProgress” та “Done” на дошці Trello необхідно виконати команду php artisan app:setup
Створити базу та виконати міграцію php artisan migrate

