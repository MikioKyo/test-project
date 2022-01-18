# Это тестовое задание для работы
Была поставлена задача создать скрипт, который обрабатывал бы .csv файлы. Если строка в файле содержала недопустимые символы, то она не добавлялась бы в БД и в отчётном файле указывался бы символ из-за которого всё произошло.

Чтобы запустить "проект" нужно:
- docker-compose up --build -d
- В файлах index.php и post.php поменять значение переменных $db_host и $db_root_pass (если меняли название проекта в .env файле)

Хотелось бы заметить, пару проблем, которые хотелось бы исправить, если бы такой скрипт всё-таки был на "боевом сервере":
- Первое - изменить систему сохранения и скачивания файла. На данный момент файл сохраняется всего лишь один и чисто технически, может случиться такое, что до скачивания файла одним пользователем, его может поменять другой пользователь и на выходе первый пользователь получит то, чего не ожидал. Чтобы решить данную проблему нужно присваивать уникальные имена файлам каждый раз, а для того, чтобы место на диске с чрезвычайной скоростью не заканчивалось - с некой переодичностью подчищать папку с файлами (с помощью cron'а, например), но это мне показалось слишком для такого маленького проекта.
- Второе - хотелось бы, чтобы можно было просто написать docker-compose up и не менять ничего, поэтому нужно бы создать либо .htaccess либо .env файл, где бы хранились такие переменные как хост дб, пароль от пользователей и так далее (это уже прописано в .env файле для докера, например).