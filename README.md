# onboardingSimpleApp
CRUD app with mongodb/mysql connection wrapper

# onboardingComposer


Steps to run the app:
- In application root folder run the following command:
    composer install
- Run PHP built-in server with following command:
    php -S localhost:1991 -t public/
- Send requests from Postman to localhost:1991

Supported routes:
GET /store/chair         -  get all chairs
GET /store/chair/{id}    -  gets a specific chair
POST /store/chair        -  creates a new chair
PUT /store/chair/{id}    -  updates a specific chair
DELETE /store/chair/{id} -  deletes a specific chair
