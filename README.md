ToDoList
========

Welcome on the ToDoList GitHub. A Symfony 2.8 project.

Prerequisite
------------

- PHP 7
- MySQL
- Composer for Symfony 2.8 and bundles installations

Add-ons
-------

- Bootstrap

ORM
---

- Doctrine

Bundles
-------

- Twig
- PhpUnit

Installation
------------

1. Symfony 2.8 and bundles installations Open bash in folder and type:

    composer install
    
2. Database creation Type:

    php app/console doctrine:database:create
    
   Then
   
    php app/console doctrine:schema:update --force
    
3.Start Symfony Server

    php app/console server:run
    
4.Run Your Test

    1.All at Once
        
         bin/phpunit -c app/
    
    2.For Individual File.. as -BaseControllerTest
    
        bin/phpunit -c app src/AppBundle/Tests/Controller/BaseControllerTest.php
        
    Screenshot:-

        ![Screenshot from 2022-03-01 18-40-14](https://user-images.githubusercontent.com/62796358/156175154-533f81de-28de-43e0-a8a5-3433a5257e46.png)

And enjoy :)
   
