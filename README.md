## Установка

- git clone https://github.com/endone777/xml-parse.git
- cd xml-parse
- cp .env.example .env
- composer install
- php artisan key:generate
- php artisan:migrate

Так же необходимо прописать данные для БД в файле **.env**
Переместить дефолтный файл XML в **storage\app**

## Запуск парсера

- php artisan xml:parse 
> Запускает парсер "по умолчанию", берет файл *storage/app/data.xml*

- php artisan xml:parse --file="C:\dummy\data.xml"
> Запускает парсер, берет файл который мы указали
