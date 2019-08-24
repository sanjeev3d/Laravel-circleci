---
title: API Reference

language_tabs:
- bash
- javascript
- php

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)

<!-- END_INFO -->

#Register or Login
<!-- START_e37495e5da5e4623f4c207bddbe39fa1 -->
## api/authenticate/register
> Example request:

```bash
curl -X POST "http://localhost/api/authenticate/register" \
    -H "Content-Type: application/json" \
    -d '{"username":"ratione","email":"eos","password":"et","first_name":"excepturi","last_name":"voluptatem","activation_code":"sint","external_id":"nisi","metadata":"pariatur","timezone":"saepe"}'

```

```javascript
const url = new URL("http://localhost/api/authenticate/register");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "username": "ratione",
    "email": "eos",
    "password": "et",
    "first_name": "excepturi",
    "last_name": "voluptatem",
    "activation_code": "sint",
    "external_id": "nisi",
    "metadata": "pariatur",
    "timezone": "saepe"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post("http://localhost/api/authenticate/register", [
    'headers' => [
            "Content-Type" => "application/json",
        ],
    'json' => [
            "username" => "ratione",
            "email" => "eos",
            "password" => "et",
            "first_name" => "excepturi",
            "last_name" => "voluptatem",
            "activation_code" => "sint",
            "external_id" => "nisi",
            "metadata" => "pariatur",
            "timezone" => "saepe",
        ],
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



> Example response (200):

```json
{
    "status": "success",
    "message": "User Registered Successfully! An email activation link have been sent at your email address",
    "data": {
        "token_type": "Bearer",
        "expires_in": 31622400,
        "access_token": "string",
        "refresh_token": "string"
    }
}
```
> Example response (422):

```json
{
    "status": "error",
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The Email field is required."
        ],
        "username": [
            "The Username field is required."
        ],
        "first_name": [
            "The First Name field is required."
        ],
        "last_name": [
            "The Last Name field is required."
        ],
        "password": [
            "The Password field is required."
        ]
    }
}
```
> Example response (404):

```json
{
    "status": "error",
    "message": "404 Not Found"
}
```

### HTTP Request
`POST api/authenticate/register`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    username | string |  required  | User Unique UserName
    email | string |  required  | User Email
    password | string |  required  | User Password
    first_name | string |  required  | User First Name
    last_name | string |  required  | User Last Name
    activation_code | string |  optional  | User Activation Code
    external_id | string |  optional  | User External Id
    metadata | json |  optional  | User Meta data [{"title":"Tapas"}, {"url" : "https://www.yahoo.com/"}]
    timezone | string |  optional  | User timezone

<!-- END_e37495e5da5e4623f4c207bddbe39fa1 -->

<!-- START_284e564368f7dba0bfacf4e06fdbf384 -->
## api/authenticate/login
> Example request:

```bash
curl -X POST "http://localhost/api/authenticate/login" \
    -H "Content-Type: application/json" \
    -d '{"email":"sit","password":"labore"}'

```

```javascript
const url = new URL("http://localhost/api/authenticate/login");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "email": "sit",
    "password": "labore"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post("http://localhost/api/authenticate/login", [
    'headers' => [
            "Content-Type" => "application/json",
        ],
    'json' => [
            "email" => "sit",
            "password" => "labore",
        ],
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



> Example response (200):

```json
{
    "status": "success",
    "message": "User Login Successfully!",
    "data": {
        "user": {
            "id": 1,
            "name": "string",
            "email": "string",
            "username": "string",
            "first_name": "string",
            "last_name": "string",
            "timezone": "string",
            "phone": "string",
            "dob": "string",
            "activation_code": "string",
            "external_id": "string",
            "metadata": "string",
            "email_verified_at": "string",
            "status": "integer",
            "created_at": "datetime",
            "updated_at": "datetime"
        },
        "auth": {
            "token_type": "Bearer",
            "expires_in": "timestamp",
            "access_token": "string",
            "refresh_token": "string"
        }
    }
}
```
> Example response (404):

```json
{
    "status": "error",
    "message": "404 Not Found"
}
```
> Example response (422):

```json
{
    "status": "error",
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The Email field is required."
        ],
        "password": [
            "The Password field is required."
        ]
    }
}
```

### HTTP Request
`POST api/authenticate/login`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    email | string |  required  | User Email
    password | string |  required  | User Password

<!-- END_284e564368f7dba0bfacf4e06fdbf384 -->

<!-- START_d151945492f7b400adecdb178895dc24 -->
## api/adminuser
> Example request:

```bash
curl -X GET -G "http://localhost/api/adminuser" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL("http://localhost/api/adminuser");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get("http://localhost/api/adminuser", [
    'headers' => [
            "Authorization" => "Bearer {token}",
        ],
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



> Example response (200):

```json
{
    "status": "success",
    "message": "string",
    "data": {
        "id": "integer",
        "name": "string",
        "email": "string",
        "email_verified_at": "string",
        "created_at": "string [date-time]",
        "updated_at": "string [date-time]"
    }
}
```
> Example response (404):

```json
{
    "status": "error",
    "message": "404 Not Found"
}
```
> Example response (422):

```json
{
    "status": "error",
    "message": "Unauthenticated"
}
```

### HTTP Request
`GET api/adminuser`


<!-- END_d151945492f7b400adecdb178895dc24 -->

<!-- START_2b6e5a4b188cb183c7e59558cce36cb6 -->
## api/user
> Example request:

```bash
curl -X GET -G "http://localhost/api/user" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL("http://localhost/api/user");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get("http://localhost/api/user", [
    'headers' => [
            "Authorization" => "Bearer {token}",
        ],
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



> Example response (422):

```json
{
    "status": "error",
    "message": "Unauthenticated"
}
```

### HTTP Request
`GET api/user`


<!-- END_2b6e5a4b188cb183c7e59558cce36cb6 -->

<!-- START_b4f4625b609a18310a50b1dddf752a55 -->
## api/resetPassword
> Example request:

```bash
curl -X POST "http://localhost/api/resetPassword" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL("http://localhost/api/resetPassword");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post("http://localhost/api/resetPassword", [
    'headers' => [
            "Authorization" => "Bearer {token}",
        ],
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



> Example response (422):

```json
{
    "status": "error",
    "message": "Unauthenticated"
}
```

### HTTP Request
`POST api/resetPassword`


<!-- END_b4f4625b609a18310a50b1dddf752a55 -->

<!-- START_406e4552819a456070d1f6c93688188d -->
## api/refreshToken
> Example request:

```bash
curl -X POST "http://localhost/api/refreshToken" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"refresh_token":"facilis"}'

```

```javascript
const url = new URL("http://localhost/api/refreshToken");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "refresh_token": "facilis"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post("http://localhost/api/refreshToken", [
    'headers' => [
            "Authorization" => "Bearer {token}",
            "Content-Type" => "application/json",
        ],
    'json' => [
            "refresh_token" => "facilis",
        ],
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



> Example response (200):

```json
{
    "status": "success",
    "message": "Auth Token Refreshed Successfully!",
    "data": {
        "auth": {
            "token_type": "Bearer",
            "expires_in": "timestamp",
            "access_token": "string",
            "refresh_token": "string"
        }
    }
}
```
> Example response (200):

```json
{
    "status": "error",
    "message": "The refresh token is invalid."
}
```
> Example response (401):

```json
{
    "status": "error",
    "message": "Unauthenticated"
}
```
> Example response (404):

```json
{
    "status": "error",
    "message": "404 Not Found"
}
```

### HTTP Request
`POST api/refreshToken`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    refresh_token | string |  required  | Provide refresh token

<!-- END_406e4552819a456070d1f6c93688188d -->

<!-- START_61739f3220a224b34228600649230ad1 -->
## api/logout
> Example request:

```bash
curl -X POST "http://localhost/api/logout" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL("http://localhost/api/logout");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post("http://localhost/api/logout", [
    'headers' => [
            "Authorization" => "Bearer {token}",
        ],
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



> Example response (401):

```json
{
    "status": "error",
    "message": "Unauthenticated"
}
```
> Example response (404):

```json
{
    "status": "error",
    "message": "404 Not Found"
}
```
> Example response (200):

```json
{
    "status": "success",
    "message": "Logout Successfully"
}
```

### HTTP Request
`POST api/logout`


<!-- END_61739f3220a224b34228600649230ad1 -->

<!-- START_c1aa27515bf03f12d5698af59e31585a -->
## test
> Example request:

```bash
curl -X GET -G "http://localhost/test" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL("http://localhost/test");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get("http://localhost/test", [
    'headers' => [
            "Authorization" => "Bearer {token}",
        ],
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



> Example response (200):

```json
null
```

### HTTP Request
`GET test`


<!-- END_c1aa27515bf03f12d5698af59e31585a -->

<!-- START_fa745d6b77c91410642b30e7e1129271 -->
## user/verify/{token}
> Example request:

```bash
curl -X GET -G "http://localhost/user/verify/1" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL("http://localhost/user/verify/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get("http://localhost/user/verify/1", [
    'headers' => [
            "Authorization" => "Bearer {token}",
        ],
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



> Example response (200):

```json
null
```

### HTTP Request
`GET user/verify/{token}`


<!-- END_fa745d6b77c91410642b30e7e1129271 -->


