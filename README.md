## Prerequisites

-   PHP
-   Composer
-   Laravel 11 or newer
-   Local database
-   Git
-   Node.js

## Setting Up The Project

-   Clone the project
-   Run below commands:

```
composer i
npm i
```

-   Duplicate .env.example and rename to .env:

```
cp .env.example .env
```

-   Run command:

```
php artisan key:generate
```

-   Fill the database:

```
php artisan migrate --seed
```

## Running The Project

-   Run command:

```
composer run dev
```

-   Open http://localhost:8000
-   Login credentials for admin: admin@admin.com - admin
-   Register a user to see the learner side
