## About

Coding challenge as part of my application for a position as Senior PHP Developer (Laravel)

## Tools Used

-   Sanctum
-   Stripo
-   Mailtrap
-   Docker
-   Postman
-   Scribe
-   Redis
-   Horizon

## Prerequisites

Ensure you have the following installed on your machine:

-   Text Editor (Recommended: [VS Code](https://code.visualstudio.com/))
-   [Docker](https://www.docker.com/)
-   [Git](https://git-scm.com/)

## Getting Started

### 1. Clone the repository

```
git clone https://github.com/michaelisip/shakewell-coding-challenge.git
cd shakewell-coding-challenge
```

### 2. Set up environment file

```
cp .env.example .env
```

### 3. Start docker containers

```
sail up -d
```

## Run tests

```
sail artisan test
```

## API Documentation

```
http://localhost/docs
```

## Queues and Running Tasks

You can run the queue and scheduled jobs with the following command:

```
sail artisan queue:work

sail artisan schedule:work
```

Then monitor the queued jobs using Laravel Horizon

```
http://localhost/horizon
```

## Postman Collection

You can import the Postman collection generated on `public/docs` folder on API clients like [Postman](https://www.postman.com/) or [Insomia](https://insomnia.rest/)

## TODOs

-   [ ] add statistics; usage count, etc..
