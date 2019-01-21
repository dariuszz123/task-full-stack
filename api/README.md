# CRUD test app API service

## Main stack

* Symfony 4
* friendsofsymfony/rest-bundle

### User resource example

```json
{
    "id":1,
    "name":"Leanne Graham",
    "username":"Bret",
    "email":"Sincere@april.biz",
    "address":{
        "street":"Kulas Light",
        "suite":"Apt. 556",
        "city":"Gwenborough",
        "zipCode":"92998-3874",
        "geo":{"lat":"-37.31590000","lng":"81.14960000"}
    },
    "phone":"1-770-736-8031 x56442",
    "website":"hildegard.org",
    "company":{
        "name":"Romaguera-Crona",
        "catchPhrase":"Multi-layered client-server neural-net",
        "bs":"harness real-time e-markets",
    }
}
```

### Endpoints

#### User create

Method: `POST`  
Path: `/api/users`  
Request body: `User resource` without id  

Response: `User resource`  
Success response code: `201`  


#### User get

Method: `GET`  
Path: `/api/users/:id`  

Response: `User resource`  
Success response code: `200`  

#### Users list get

Method: `GET` 
Path: `/api/users`  
Query params: `limit=(int)` and `offset=(int)`  

Response: List of `User resource`  
Success response code: `200`  
Response example:
```json
{
   "users": [],
   "currentPage": 1,
   "prevUri": null,
   "nextUri": "/api/users?limit=2&offset=2"
}
```

#### User update

Method: `PATCH`  
Path: `/api/users/:id`  
Request body: `User resource` (can be partial) without id  

Response: `User resource`  
Success response code: `200`  

#### User delete

Method: `DELETE`  
Path: `/api/users/:id`  

Success response code: `204`  

## Testing

Phpunit `./bin/phpunit`
