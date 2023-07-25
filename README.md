# Easy Réunion

## États des éléments

Liste des états à utiliser pour les agenda_elements :

- option_request : demande de devis (uniquement généré par le formulaire de demande de devis)
- option : lorsqu'un devis a été créé mais pas encore signé. Peut être ajouté uniquement par un admin
- confirmation : lorsqu'un devis a été signé
- partner_option : lorsqu'un partenaire va potentiellement avoir besoin d'une date
- partner_confirmation : date bloquée par un partenaire
- cancelled : réservation annulée (uniquement venant d'une confirmation : les autres sont supprimées)

## Legacy

Les offres sont actuellement seulement dissimulées, on pourrait les faire réapparaître.

# Installation

## Télécharger le site

Le site est stocké sur Github et peut être récupérer via un clonage du répertoire à partir de la commande suivante :

```bash
git clone <url>
```

Pour obtenir les URL, il faudra cliquer sur le bouton clone présent sur
la [page d'accueil du répertoire](https://github.com/Easy-Reunion/easy-reunion) (cf capture d'écran suivant).

| ![Bouton cloner sur Github]() |
|---|
| Capture d'écran de la page d'accueil du site officiel de Composer |

Autrement voici les différents URL possible pour la récupération du répertoire :
| Nom | URL |
|---|---|
| HTTPS | https://github.com/Easy-Reunion/easy-reunion.git |
| SSH | git@github.com:Easy-Reunion/easy-reunion.git |

## Installation du site

Une fois le répertoire récupéré et prêt à être manipulé, dirigez-vous à l'intérieur de ce dernier et commencer l'
installation du site consistant à faire - dans l'ordre - l'installation des dépendances, de la configuration, la
migration des données, pour finir sur la construction des feuilles de styles et des scripts. Il est impératif que le
processus soit fait sous cette ordre.
Le site est fait sous Laravel 8, qui utilise Composer pour la gestion des dépendances pour la partie "backend" et NPM
pour la gestion des dépendances pour la partie "frontend".

### Composer

[Composer](https://getcomposer.org/) est le gestionnaire de paquets (autrement dit, les dépendances) PHP utilisé par
notre "framework", Laravel. Il est utilisé par ce dernier, ainsi que par les tests unitaires et le signalement des
erreurs.

Pour le télécharger et l'installer, il vous faudra aller sur le [site officiel de Composer](https://getcomposer.org/)
dans la section "Download".

| ![Page d'accueil de getcomposer.org]() |
|---|
| Capture d'écran de la page d'accueil du site officiel de Composer |

Une fois Composer installé, démarrer une nouvelle session dans votre invite de commande et executer la commande suivante
pour voir si Composer est bien présent sur votre ordinateur. Si tout se passe correctement, vous devez obtenir la
version de Composer.

```bash
composer --version
```

Si Composer est bien reconnu comme étant une commande, l'installation des dépendances peut dorénavant commencer via
cette commande :

```bash
composer install
```

### NPM

[NPM](https://www.npmjs.com/) est le gestionnaire de paquets [NodeJS](https://nodejs.org/) - une plateforme de
logicielles libres conçus en Javascript - utilisé par Laravel, en complément de Composer vu au préalable. Il est utilisé
pour la mise en place des feuilles de styles et des outils - ainsi que les libraries - facilitant le travail.
Pour l'installer, il faudra vous rendre sur le [site officiel de NodeJS](https://nodejs.org/), des boutons de
téléchargement seront présents directement sur la page d'accueil. Pour le bon fonctionnement du site, on utilise la
version "LTS" ("Latest stable", ou "dernière version stable" en français), actuellement à la version 16.8.0.
L'installation de NodeJS permettra l'installation de son gestionnaire de paquet - NPM - en parallèle.

Une fois l'installation finie, executer les commandes suivantes permettant respectivement de voir la version de NodeJS
et de NPM :

```bash
node --version
npm --version
```

Si les deux commandes sont bien reconnues, l'installation des dépendances peut démarrer avec la commande suivante :

```bash
npm install
```

## Configuration

Laravel utilise le fichier `.env` pour la configuration du site : cela peut inclure l'URL du site qui sera utilisé par
l'utilisateur ou les identifiants permettant la connexion à la base de données. Si ce fichier n'est pas présent dans le
répertoire racine du site, il faudra copier le
fichier [.env.example](https://github.com/Easy-Reunion/easy-reunion/blob/master/.env.example) dans un nouveau
fichier `.env`
au même emplacement.

### Application

Les variables commençant par `APP_` sont nécessaires pour faire fonctionner le site - en particulier l'URL qui définira
l'adresse utilisée pour récupérer des ressources ou générer des routes, ainsi que la clé de l'application permettant la
migration des données.
Les adresses URL comme "easy-reunion.local" peut être créer par le biais des hôtes virtuels (ou "virtual hosts" en
anglais). En ce qui concerne la clé de l'application, elle peut être créée via la commande suivante :

```bash
php artisan key:generate
php artisan storage:link # symlink de /public/storage vers /storage/app/public
```

### Base de données

Les variables commençant par `DB_` permettent la connexion à la base de données. Normalement, seules les variables
définissant le nom de la base de données (`DB_DATABASE`) et les identifiants sont à modifier.
Il est à noter que c'est à utilisateur de créer la base de données qui sera utilisée par le site.

## Migration des données

Une fois la clé de l'application et la base de données créées, la migration des données peut commencer à partir de la
commande suivante :

```bash
php artisan migrate:fresh --seed
```

## Construction des feuilles de styles et des scripts

L'ensemble des feuilles de styles et des scripts peuvent être créés à partir de ces commandes :

```bash
# Construit les fichiers, les optimise et les minifie (le code source est difficilement compréhensible par un humain)
npm run prod

# Construit les fichiers et les optimise (le code source reste en revanche visible)
npm run dev

# Execute la commande `npm run dev` à chaque modification d'un fichier
npm run watch

# Alternative à `npm run watch`
npm run watch-poll
```
