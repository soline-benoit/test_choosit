# Test Choosit
Test Symfony pour Choosit dont l'objectif est de développer une application contenant un catalogue de produits et une gestion de panier basique.

## Configurations
- PHP 7.4.4
- PDO-SQLite PHP extension activée
- [Composer](https://getcomposer.org/download/) pour gérer les dépendances
- [Node.js](https://nodejs.org/fr/download/) et [Yarn](https://yarnpkg.com/getting-started/install) pour gérer les assets
- [Exigences du framework Symfony 5](https://symfony.com/doc/current/setup.html)

## Utilisation
### Télécharger les dépendances
Installer [composer](https://getcomposer.org/download/)  si ce n'est déjà fait, puis lancer la commande suivante pour télécharger les dépendances du projet :
```
$ cd my_project/
$ composer install
```
---
### Compiler les assets
Installer [Node.js](https://nodejs.org/fr/download/) et [Yarn](https://yarnpkg.com/getting-started/install) si ce n'est déjà fait, puis lancer la commande suivante pour compiler les assets :
```
$ cd my_project/
$ yarn
```
---
### Créer la base de données
Exécuter ces commandes pour créer la base de données :
```
$ cd my_project/
$ php bin/console doctrine:database:create
$ php bin/console doctrine:migrations:migrate
```
---
### Charger les fixtures
Exécuter ces commandes pour charger les fixtures :
```
$ cd my_project/
$ php bin/console doctrine:fixtures:load
```
---
### Lancer le serveur
Il n'y a pas besoin de configuration spécifique pour lancer l'application. Si Symfony est déjà installé sur la machine, lancer la commande suivante et accéder à l'application sur le navigateur à l'adresse donnée (https://localhost:8000 par default)

```
$ cd my_project/
$ symfony server:start
```

Si le binaire Symfony n'est pas installé, lancer `php -S localhost:8000 -t public/` pour utiliser le serveur web PHP intégré ou bien configurer un serveur web comme Nginx ou Apache afin de lancer l'application.

## Tests
### Lancer les tests
Exécuter ces commandes pour lancer les tests :
```
$ cd my_project/
$ ./bin/phpunit
```
---
### Liste des tests disponibles :
#### Tests unitaires
- Test sur la quantité totale des produits contenus dans le panier après ajout d'un produit
- Test sur la quantité totale des produits contenus dans le panier après vidage du panier
- Test sur la quantité d'un produit spécifique contenu dans le panier
- Test sur le montant total du panier
#### Tests fonctionnels
- Test du code de réponse de la page d'accueil
- Test du code de réponse de la page "liste des produits"
- Test du nombre de produits affichés sur la page "liste des produits"

## Export des produits au format CSV
Exécuter ces commandes pour exporter tous les produits présents dans la base de données au format CSV :
```
$ cd my_project/
$ php bin/console export-all-products
```

## EasyAdmin
- Accès à l'espace admin : https://localhost:8000/admin
- Nom d'utilisateur : **admin**
- Mot de passe : **password**

