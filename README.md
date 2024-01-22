# URL Shortener API

This project showcases a REST API for a URL shortener tool, developed using CodeIgniter 4.

## Requirements

  - PHP: 7.4 or above;
  - Codeigniter: 4.0 or above;
  - MySQL client.

## Installation

1. Clone this repo: `git clone https://github.com/jvpdls/url-shortener-api.git`;
2. Run the script at `sql/createDatabase.sql` onto your MySQL client;
3. Install the project's dependencies: `composer install`;
4. Run it locally: `php spark serve`;
5. Send requests through the command-line or using tools such as Insomnia and Postman.

### Environment variables

Please set up your own .env file at the project's root. Configure an API secret using the "API_KEY" variable.

## Routes

Below, you'll find the project's routes. All of them return JSON responses. Body params must be sent as JSON as well; URL params are sent via the request endpoint.

| Route              | Method | Params                                   | Description                    | "API-Key" Header required? |
|--------------------|--------|------------------------------------------|--------------------------------|----------------------------|
| /get               | GET    | -                                        | Lists all short links          | N                          |
| /get/(:segment)    | GET    | $1(slug)                                 | List a specific short link     | N                          |
| /create            | POST   | slug, longUrl                            | Creates a new short link       | Y                          |
| /update            | UPDATE | oldSlug, newSlug; oldLongUrl, newLongUrl | Updates an existing short link | Y                          |
| /delete/(:segment) | DELETE | $1(slug)                                 | Deletes an existing short link | Y                          |

## Contributions

Contributions are welcome. Feel free to send a pull request in case you have any suggestions.
