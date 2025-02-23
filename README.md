## À propos de mon application

Cette application est conçue pour simplifier et automatiser la gestion quotidienne des rendez-vous, des factures, des clients, et plus encore. Développée avec le framework Laravel, elle utilise une syntaxe élégante et expressive, facilitant ainsi le développement et la maintenance.
### Instruction
1) Configuration de fichier .env afin de correspondre à votre environnement de développement
2) php artisan migrate ( initialisation de la db)
3) php artisan db:seed ( insertion des données dans la db )
4) Lancer votre serveur local afin de tester les fonctionnalitées


### Fonctionnalités Principales

- **Gestion des rendez-vous** : Créez, modifiez et supprimez des rendez-vous facilement.
- **Gestion des clients** : Suivez les informations de vos clients et gérez leurs rendez-vous.
- **Gestion des factures** : Automatisez la création et l'envoi des factures avec des calculs de montants totaux.
- **Gestion groupes** : 
- Admin ( accès à toute l'application)
- Staff ( Membres du secrétaria -> accès à toutes les fonctionnalité en lecture/ecriture)
- employee ( accès limité à l'application )

### Technologies Utilisées

- **Laravel** : Framework PHP pour le développement d'applications web.
- **Bootstrap** : Framework CSS pour un design responsive et moderne.
- **Carbon** : Une bibliothèque PHP pour la gestion des dates et des heures.
