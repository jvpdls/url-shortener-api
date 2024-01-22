URL Shortener API
=================

This is a REST API for a URL shortener tool built with CodeIgniter 4.

Requirements
------------

*   PHP: 7.4 or above
*   CodeIgniter: 4.0 or above
*   MySQL client

Installation
------------

1.  Clone the repo: `git clone https://github.com/jvpdls/url-shortener-api.git`
2.  Run the script at `sql/createDatabase.sql` in your MySQL client
3.  Install dependencies: `composer install`
4.  Run locally: `php spark serve`
5.  Send requests via command-line or tools like Insomnia and Postman

Authentication
--------------

Except for GET requests, send the "API-Key" header for authentication. The API only accepts HTTPS requests. Configure the API secret in the .env file at the project's root, using the "API_KEY" variable. 

Refer to the project's filters (`app/Filters`) for details.

Routes
------

Below, you'll find the project's routes. All of them return JSON responses. Body params must be sent as JSON as well; URL params are sent via the request endpoint.

| Route              | Method | Params                                   | Description                    |
|--------------------|--------|------------------------------------------|--------------------------------|
| /get               | GET    | -                                        | Lists all short links          |
| /get/(:segment)    | GET    | $1(slug)                                 | List a specific short link     |
| /create            | POST   | slug, longUrl                            | Creates a new short link       |
| /update            | UPDATE | oldSlug, newSlug; oldLongUrl, newLongUrl | Updates an existing short link |
| /delete/(:segment) | DELETE | $1(slug)                                 | Deletes an existing short link |

Contributions
-------------

Contributions are welcome. Feel free to send a pull request with suggestions.