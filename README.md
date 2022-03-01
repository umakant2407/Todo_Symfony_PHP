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
    
And enjoy :)
   
