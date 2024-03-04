# StarWars API Backend Integration

This repository contains a backend integration of the StarWars API. For the corresponding frontend, please visit [here](https://github.com/nhil777/swapi-fe).

It is built with Laravel v10, utilizing the StarWars API Service located at [`app/services/SWAPIService`](https://github.com/nhil777/swapi-be/blob/main/app/Services/SWAPIService.php).

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
