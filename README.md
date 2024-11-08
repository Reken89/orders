Решения по БД:
Для решения заданий, создал 5 таблиц
* orders - таблица с заказами (использовал связь один ко многим к таблице tickets)
* tickets - таблица с билетами

* events - таблица с событиями (использовал связь один ко многим к таблице event_prices и event_schedules)
* event_prices - таблица с типами и ценами билетов на событие
* event_schedules - таблица с датами на событие

Вид таблиц:
orders:
* id - int(10) инкрементальный порядковый номер
* event_id - int(11) уникальный ид события
* event_date - varchar(10) дата и время на которое были куплены билеты
* equal_price - int(11) общая сумма заказа
* created - datetime дата создания заказа

tickets:
* id - int(10) инкрементальный порядковый номер
* order_id - int(11) уникальный ид заказа
* type - varchar(120) тип билета (взрослый, детский, льготный и т.д.)
* price - int(11) цена билета на момент покупки
* barcode - varchar(120) уникальный штрих код заказа

events:
* id - int(10) инкрементальный порядковый номер
* title - varchar(120) название события
* description - text описание события

event_prices:
* id - int(10) инкрементальный порядковый номер
* title - varchar(120) название билета
* event_id - int(11) уникальный ид события
* type - varchar(120) тип билета на событие (взрослый, детский, льготный и т.д.)
* price - int(11) цена билета

event_schedules:
* id - int(10) инкрементальный порядковый номер
* event_id - int(11) уникальный ид события
* event_date - datetime дата события

Такая структура таблиц позволяет, добавлять новые типы билетов на события не меняя структуры БД
Так же структура таблиц позволяет закрепить за заказом неограниченное количество билетов

////////////////////////////////////////////////////////////////////////////////

Решения по структуре кода:
Для решения заданий использовал следующую структуру кода:
* Controllers - Класс управления, координирования, контроля
* Models - Бизнес логика и модели таблиц БД
* Views - Работа с front частью приложения
* tests - Тесты PHPUNIT для проверки работы приложения

Методика решения:
* При решении задания придерживался MVC и ООП
* В работе использовал autoloader и phpunit от composer

Алгоритм приложения
* Класс контроллера принимает значения
* Выполнение действий бизнес логики
- Генерация barcode
- Обращение к API (В роли API используется класс модели, возвращающий рандомные ответы-сообщения)
- Запись в БД
- Возвращение результата выполненных действий (информация собрана в массив)