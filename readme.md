# BounceTrap API Client

A simple package to consume BounceTrap's API.

-----------------------


## Installation

`composer require optimail\bouncetrap-client`

-----------------------


## Usage

Create an instance of `Optimail\BounceTrap\Client`:

```
new Client;
```

-----------------------


## Response class

`$response = $client->response($email);`

### toArray()

Use `$response->toArray();` to get all of the data returned in the response

### toJson()

Use `$response->toJson();` to get all of the data in the response return as json

### errors()

Use `$response->errors();` to get all the errors returned in the response

### hasErrors()

Use `$response->hasErrors();` to check if the response contains any errors

-----------------------


## Other responses

### Raw guzzle response

`$client->raw($email);`

### Json

`$client->json($email);`
