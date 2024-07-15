# Тестовое задание
Есть веб-api, принимающее события (ограничимся 10000 событий) для группы аккаунтов (1000 аккаунтов) и складывающее их в очередь.  
Каждое событие связано с определенным аккаунтом и важно, чтобы события аккаунта обрабатывались  
в том же порядке, в котором поступили в очередь. Обработка события занимает 1 секунду (эмулировать с помощью sleep).  

Сделать обработку очереди событий максимально быстрой на данной конкретной машине.  

Код писать на PHP. Можно использовать фреймворки и инструменты такие как RabbitMQ, Redis, MySQL и т. д.

## Инструкция по локальному запуску
1. Задаем переменные окружения
2. Запускаем `docker-compose up`
3. Заходим в контейнер application
4. Запускаем `composer install`
5. Запускаем команду для отправки событий `bin/console test:publishGeneratedMessagesGroupEvent 100`. Можно задать любое количество сообщений.

## Проверка обработки
Зайти в var/log/dev.log и убедиться, что события аккаунта обрабатываются в том же порядке, в котором поступили в очередь

## Увелечение скорости обработки
Для увелечения скорости обработки нужно увеличивать количество консьюмеров "account_event_X".
