## About

Coding challenge as part of my application for Senior PHP Developer (Laravel) for Shakewell Agency

## Tools Used

-   Sanctum
-   Stripo
-   Mailtrap
-   Docker
-   Postman
-   Scribe

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

## Postman Collection

You can import the Postman collection generated on `public/docs` folder on API clients like [Postman](https://www.postman.com/) or [Insomia](https://insomnia.rest/)

## TODOs

-   [ ] voucher type; fixed or percentage
-   [ ] add voucher expiration and limit to vouchers
-   [ ] schedule jobs to set expired vouchers
-   [ ] add statistics; usage count, etc..
