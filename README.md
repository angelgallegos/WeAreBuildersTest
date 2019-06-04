# We Are Builders Test

This repository contains the We Are Builders test assigned to Ángel Gallegos Andrade.

The following were the requirements of the assignment

 - Design and build a restful API based on the latest Symfony.

 - Set up an endpoint where profile data can be posted, a typical example for profile data is: first name, last name, e-mail, and birthdate. 

 - Set up another endpoint where one profile can follow or unfollow another profile. 

 - Store all data (profile and following) in a MySQL database using the Doctrine library. Utilize Symfony components like routing, forms, validation and try to show some testing experience using PHPUnit.

 - End with creating a command that allows you to create a single profile.

## Requirements
 - PHP 7.2 >=
 - Composer
 - MySQL 

## Usage 
Install the dependencies with:
```
composer install
```
Once the dependecies had been installed, update the next line:

DATABASE_URL=mysql://{user}:{password}@127.0.0.1:3306/{db}

in the .env file in the root with the credentials and name of the database that will be used.


Once the credentials are set, the schema can be generated by running:
```
php bin/console doctrine:schema:create
```
And after that some data fixtures can be load by running the next command:
```
php bin/console doctrine:fixtures:load
```
The API is secured with OAuth so you'll need to create a client, you can make one by running the following command:
```
php bin/console oauth:client:create --redirect-uri=http://www.notarealpage.com --grant-type=password --grant-type=refresh_token
```
And it should yield a message as the next:
`Added a new client with  public id PUBLIC_ID and secret SECRET`

Finally the embed Symfony server can be run with:
```
php bin/console server:start
```

### Tests configuation

Change the value `APP_ENV=dev` en el archivo .env and the database configuation in the file .env.test in order to prepare the project for testing.

Follow the instructions in usage to generate the schema and load the fixtures.

## The endpoints 
 
A user can be created with a curl request as such

```
curl --request POST \
  --url http://127.0.0.1:8000/user/register \
  --header 'content-type: application/json' \
  --data '{
	"name": "John",
	"last_name": "Doe",
	"email":"johndoe@gmail.com",
	"birthday": "1990-01-01",
	"username": "johndoe",
	"plain_password":{
            "first":"j0hnd0e123",
            "second":"j0hnd0e123"
        }
        }'
```
Once a user is created it can authenticate by using the new user info and the OAuth client credentials, like this:
```
curl --request POST \
  --url http://127.0.0.1:8000/oauth/v2/token \
  --header 'content-type: application/json' \
  --data '{
    "grant_type": "password",
    "client_id": "PUBLIC_ID",
    "client_secret": "SECRET",
    "username": "j0hnd0e123",
    "password": "j0hnd0e123"
   }'
```
The reponse contains the token used for authentication in the endpoints that are protected

The remaining endpoints are the ones in charge of creating the relationship(follow) and updating it.

To follow a user a request like this should be made:
```
curl --request POST \
  --url http://127.0.0.1:8000/api/follower/follow \
  --header 'authorization: Bearer AUTH_TOKEN' \
  --header 'content-type: application/json' \
  --data '{
	"user_two":3
    }'
```
The "user_two" key is the id corresponding to the user you want to follow.

To block a user a request like this is made:
```
curl --request PUT \
  --url http://127.0.0.1:8000/api/follower/block \
  --header 'authorization: Bearer AUTH_TOKEN' \
  --header 'content-type: application/json' \
  --data '{
	"user":3
    }'
```
To mute a user:
```
curl --request PUT \
  --url http://127.0.0.1:8000/api/follower/mute \
  --header 'authorization: Bearer AUTH_TOKEN' \
  --header 'content-type: application/json' \
  --data '{
	"user":3
    }'
```

## Test

Some unit and functional tests are included and it can be run with the following command:
```
./bin/phpunit
```