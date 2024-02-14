1 - Crée une base de donnée "test_technique" que l'on va connecter au CRUD pour stocker les admins et les events (Pouvoir migrer les schémas de base de données)

2 - À l'intérieur du fichier "../inertia-vue>" lancer les commandes pour installer les dépendances : 

- composer install

- npm install 

3 - Lancer les commandes pour migrer les schémas de bases de donnés et les identifiants de connexion de l'admin :

- php artisan migrate --seed

(On préférera php artisan migrate:refresh --seed , effectuer un rollback puis une migration)

4 - Dans deux invites de commandes (ou terminal), lancer les commandes dans chaque terminal :

-  php artisan serv

- npm run dev

5 - Se rendre sur l'url : http://127.0.0.1:8000/

6 - Se connecter (Log in) avec les identifiant suivants :

username : test@example.com
mdp : root



/////////


Refaire le datepicker
Reregarder formrequest pour ne pas faire redondant
Enlever les sleeep
