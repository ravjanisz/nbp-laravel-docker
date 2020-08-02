## Instalacja

Pobieramy repozytorium
```bash
https://github.com/ravjanisz/nbp-laravel-docker.git
```

Wykonujemy po pobraniu repozytorium
```bash
mkdir docker/dbdata
```

Tworzymy kontenery
```bash
docker-compose build
docker-compose up
```

## Konfiguracja
Przed wykonaniem migracji należy uzupełnić IP do bazy danych.

Wykonujemy
```bash
docker ps
```
Kopiujemy nazwę kontenera aplikacji 
```bash
docker inspect NAZWA | grep "IPAddress"
```
IP które otrzymaliśmy dodajemy do pliku .env i klucza: DB_HOST

Uruchamiamy powłokę kontenera
```bash
docker exec -it NAZWA bash
```

W kontenerze wykonujemy następujące komendy
```bash
composer install
php artisan key:generate
php artisan migrate
```

Wykonanie migracji inicjalizacyjnej
```bash
php artisan rav:initial-currency-rates-import
```

Wykonujemy testy
```bash
php artisan test
```

Uzupełniamy crontab

```bash
crotab -e
```

I dodajemy linię
```bash
* * * * * cd /var/www && php artisan schedule:run >> /dev/null 2>&1
```





