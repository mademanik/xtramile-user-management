# Xtramile User Management

A multi-service architecture consisting of a React Frontend, PHP/Laravel Backend, MySQL Database, Go Scheduler, and a Python Analytics Service.

## Architecture Overview
1.  **Frontend (React/Vite)**: User registration interface running on **Port 4135**.
2.  **PHP API**: Backend service that stores user data in MySQL, running on **Port 8080**.
3.  **Go Scheduler**: Scans the PHP API every 30 seconds, saves data to JSON files, and forwards "David" entries to the Python service.
4.  **Python Service**: Receives and logs filtered user data, running on **Port 5000**.
5.  **MySQL**: Central database storage, accessible on **Port 3306**.

---

## Prerequisites

Each project has its own `docker-compose.yml`. To allow communication between containers across different Compose files, you **must** create a shared external network first:

```
docker network create xtramile-network
```

## Getting Started

Follow this specific order to ensure the database is ready and migrations are completed before dependent services start:

1.PHP API & Database
```
cd php-api
docker-compose up -d --build
```
Note: Wait approximately 20-30 seconds for the MySQL container to fully initialize and migrations to finish.

2.Python Analytics Service
```
cd python-api
docker-compose up -d --build
```

3.Go Scheduler Service
```
cd go-scheduler-service
docker-compose up -d --build
```

4.React Frontend
```
cd frontend
docker-compose up -d --build
```

## Service Endpoints

1. Frontend
```
http://localhost:4135
```

2. Backend API
```
http://localhost:8080/api/users
```

3. Python API
```
http://localhost:5000/receive
```

4. MySQL DB
```
localhost:3306
```
