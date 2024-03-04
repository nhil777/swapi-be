# SWAPI-BE: StarWars API Backend

This repository contains a backend integration of the StarWars API. For the corresponding frontend, please visit [here](https://github.com/nhil777/swapi-fe).

It is built with Laravel v10, utilizing the StarWars API Service located at [`app/services/SWAPIService`](https://github.com/nhil777/swapi-be/blob/main/app/Services/SWAPIService.php).

In the background, using Redis, a job runs every five minutes to compute some useful statistics that can be accessed through the API endpoint. You can see the code [here](https://github.com/nhil777/swapi-be/blob/main/app/Jobs/ComputeStatistics.php).

## Initial Setup

1. Copy `.env.example` to a new file `.env`

2. Create a Docker network:
    ```bash
    docker network create kool_global
    ```

3. Launch the application:
    ```bash
    docker-compose up -d
    ```

4. Access the application container:
    ```bash
    docker exec -it swapi-be_app_1 bash
    ```

5. Install dependencies:
    ```bash
    composer install
    ```

6. Generate application key:
    ```bash
    php artisan key:generate
    ```

7. Start `schedule:work`
    ```bash
    php artisan schedule:work
    ```

8. On a new terminal, start `queue:work`
    ```bash
    php artisan queue:work
    ```

Now, you can access the API at `http://localhost`.

### Endpoints
- Search for a person:
    ```
    http://localhost/api/search/people?query=Yoda
    ```

- Fetch details about a specific person:
    ```
    http://localhost/api/details/people/20
    ```

- Search for a movie:
    ```
    http://localhost/api/search/movies?query=Attack
    ```

- Fetch details about a specific movie:
    ```
    http://localhost/api/details/movies/2
    ```

- Query statistics:
    ```
    http://localhost/api/statistics
    ```

## Running Tests

1. Access the application container:
    ```bash
    docker exec -it swapi-be_app_1 bash
    ```

2. Execute tests:
    ```bash
    php artisan test
    ```

## Suggested Improvements

- [ ] Enhance error handling
- [ ] Remove unnecessary default Laravel files
- [ ] Refactor the SWAPIService for better modularity and maintainability
- [ ] Move App\Loggers\QueryLog up the chain
