# onboardingSimpleApp
CRUD app with mongodb/mysql connection wrapper

# onboardingComposer


Steps to run the app:
- In application root folder run the following command:
    composer install
- Run PHP built-in server with following command:
    php -S localhost:1991 -t public/
- Open localhost:1991 in your browser.

Supported routes:
/ and /index
/store/chair
/store/chair/{id}
/store/sofa
/store/sofa/{id}