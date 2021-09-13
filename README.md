Pilot

The pilot project is created in symfony 5.3 version. For creating this project, Following steps should follow:-

1) Installing the standard edition of symfony via composer:-

    composer create-project symfony/website-skeleton my_project_name

2) Move to my_project_name directory and start the symfony server by using following command:-

    symfony server:start

3) Now configure the database but first you need to run following commands:-

    composer require symfony/orm-pack
    composer require --dev symfony/maker-bundle
    php bin/console doctrine:database:create

4) After creating database you need to define your database in .env file:-

    DATABASE_URL="mysql://DB_USERNAME:DB_PASSWORD@localhost:3306/DB_NAME"

5) Next you need to create/update entity by using following command:-

    php bin/console make:entity

6) Add your relevant fields and create migration by using following commands:-

    php bin/console make:migration
    php bin/console doctrine:migrations:migrate

7) If you need to add some property manually in entity then you need to run:-

    php bin/console make:entity --regenerate

8) For creating controller, You need to run following command:-

    php bin/console make:controller controler_name

9) To install security bundle, You need to run following command:-

    composer require symfony/security-bundle

10) For authentication, You need to run following commands:-

    php bin/console make:user
    php bin/console make:auth

11) You can also add dummy data in database by using following commands:-

    composer require --dev orm-fixtures
    php bin/console make:fixtures
    php bin/console doctrine:fixtures:load 

12) You can create forms by using following commands but first you need to install forms:-

    composer require symfony/form
    php bin console make:form form_name

13) For install the twig module, You need to run following command:-

    composer require twig
            or
    composer require symfony/twig-bundle

14) In symfony 5.3, there is no by default file for validation. You need to create file in "config/validator/validator.yaml". For validate the form, You need to run following command for validation:-

    composer require symfony/validator

15) For symfony mailer, You need to run following command:-

    composer require symfony/mailer

16) If you want to implement gmail mailer then you need to run:-

    composer require symfony/google-mailer

17) For front-end, You need to install encore bundle by using following commands:-

    composer require symfony/webpack-encore-bundle
    yarn install

18) To compile css/js files in web encore pack, Run following command:-

    yarn encore dev --watch

19) To check the security of symfony, Run following command:-

    symfony check:security

20) To update the version of symfony, Run following command:-

    symfony self:update

21) To add the bootstrap in your project, Run following command:-

    yarn add bootstrap --dev

22) To get the vendor folder in existing project, Run following command:-

    composer install
            or
    composer dump-autoload