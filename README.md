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

## TODOs

-   [ ] voucher expiration and percentage type
-   [ ] run jobs for updating expired vouchers
