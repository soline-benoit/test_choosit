# Test Choosit
Test Symfony pour Choosit dont l'objectif est de développer une application contenant un catalogue de produits et une gestion de panier basique.

## Configurations
- PHP 7.4.3
- PDO-SQLite PHP extension activée
- [Exigences du framework Symfony 5](https://symfony.com/doc/current/setup.html)

## Utilisation
Il n'y a pas besoin de configuration spécifique pour lancer l'application. Si Symfony est déjà installé sur la machine, lancer la commande suivante et accéder à l'application sur le navigateur à l'adresse donnée (https://localhost:8000 par default)

```
$ cd my_project/
$ symfony serve
```

Si le binaire Symfony n'est pas installé, lancer `php -S localhost:8000 -t public/` pour utiliser le serveur web PHP intégré ou bien configurer un serveur web comme Nginx ou Apache afin de lancer l'application.

## Tests
Exécuter ces commandes pour lancer les tests :
```
$ cd my_project/
$ ./bin/phpunit
```
