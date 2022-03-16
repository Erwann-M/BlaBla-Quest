# Projet BlaBlaQuest: Journal d'équipe

> Répartission des rôles:
>
>- Project Owner: Jennifer (Symfony)
>- Scrum Master: Brice (Symfony)
>- Git Master: Erwann (React)
>- Lead Dev: Khaled (React)
>- Technical Lead: Cédric (React)

## 26/11/2021 - Sprint 0

> Début du projet.

## 29/11/2021 - Sprint 0

Le premier jour nous avons échangé sur l'outil de gestion et suivi de projet que nous utiliserons. [Miro](https://miro.com/) c'est imposé comme l'outil idéal.

Après une prise en main de [Miro](https://miro.com/) nous avons défini les rôles de chacun selon les compétences et envies. Nous avons ensuite commencé le Cahier des Charges (CDC) avant de faire un grand brainstorm sur un paperboard interactif. Nous avons commencé à lister de la documentation/ressources potentiellement utiles.

Nous avons aussi fait un premier jet de l'arborescence du site.

Aujourd'hui nous désirons avancer sur le CDC et délimiter le Most Valuable Product (MVP).

## 30/11/2021 - Sprint 0

Hier nous avons défini le MVP puis autour de lui:

- Construit le Modèle Conceptuel de Données (MCD)
- Créé une nouvelle arborescence du site
- Continué de mettre à jour notre CDC
  - User stories
  - Cible du projet
  - Type d'utilisateur
- Commencé la création de nos wireframes (minimum 2 par personnes)

Beaucoup d'échanges autour du MVP et du rendu final pour aider à la visulisation du site. Production de plusieurs wireframes "léger" pour que l'équipe soit sur la même vision du rendu.

Nous constatons que les wireframes sont de plus en plus rapides à créer, même si la prise en main de l'outil que nous utilisons a été longue. Nous constatons aussi qu'ils deviennent vite obsolètes car le projet a régulièrement de micros ajustements en terme de fonctionnalité et d'envie de rendu.

Aujourd'hui nous voulons mettre en forme le CDC, créer les routes nécessaires au MVP et produire des wireframes plus proches du rendu du MVP.

### 01/12/2021 - Sprint 0

Hier nous avons remis à jour/en page le CDC, continué les wireframes et commencé le .md des routes + le dictionnaire des données.

Nous avons beaucoup échanger en faisant la liste des routes, afin de nous accorder sur la façon dont le front et le back vont communiquer via API. Utilisations des wireframes en parallèle pour se représenter les routes nécessaires.

Ce matin nous voulons terminer la liste des routes et le dictionnaire des données (DDD).

Cet après-midi nous présenterons notre avancé à nos référents pédagogique pendant 45min, afin de voir si notre MVP est cohérents et si ce que nous mettons en place autour l'est aussi. Ensuite nous réajusterons notre projet en fonction de la conclusion de cette présentation.


### 02/12/2021 - Spint 0

Hier nous terminé notre dictionnaire des données et notre DDD.

Les retours sur l'avancement du projet par l'équipe pédagogique ont été positifs, nous avons retiré une table dans le MCD (table Role qui n'avait pas d'intérêt dans notre projet), corrigé une ligne sur nos routes et corriger des coquilles de nomenclature sur notre DDD. Il nous a surtout été demandé de retirer quelquess fonctionnalités à notre Front, car nos référents avaient peur que ça fasse trop pour le temps de dev.

Aujourd'hui, préparation du design:

- Selection de la palette des couleurs
- Création d'une maquette
- Choix de la librairie que nous allons utiliser pour le front (hors BackOffice): Material UI
- Choix des composents à intégrer suivant les fonctionnalités attendues.

Puis point fait sur l'organisation du travail en équipe via github par notre Git Master, installation de l'infrastructure de notre repo

### 03/12/2021 - Sprint 01

Hier, après une validation des corrections apportées aui projet de la part de notre équipe pédagogique nous avons:
- Mis en place le repo pour séparer back et front
- Installé nos frameworks et librairies

L'équipe React et l'équipe Symfony se sont séparé pour commencer à travailler sur des fonctionnalités de bases:
  - Khaled, Erwann et Cedric (React) ont échangé et commencé à mettre en place leurs outils, puis ont commencé l'intégration. Travail sur la navbar + le responsive. 
  - Jennifer et Brice (Symfo) ont fait les entités pour la DB. 

Problème rencontrés :
  - Front: pas de soucis, beaucoup d'organisation et recherche de ressources.
  - Back: 
      - Gestion d'une relation avec du contenu, entre deux entités (cas non vu en cours). Doc recherché, problème rélgé.
      - Questionnement sur la nécessité de créer une table non prévue jusque là pour éviter de laisser l'utilisateur rentrer ce qu'il veut dans le champs "Département" lorsqu'il s'inscrit ou crée un event. Choix de ne laisser qu'un "integer" à rentrer par l'utilisateur, puis comparaison avec le nombre de département en France (101).

Aujourd'hui, présentation et Q&R devant la promotion puis:

Frontend: Terminer footer + body de la home page pour pouvoir commencer les fonctionnalités.
Backend: Attaquer la création des entités, et commencer les fixtures pour créer une DB fictive puis, commencer les Controller.

Les fixtures ont été gardées de côté pour du travail perso, nous nous sommes concentré sur la première les routes API. Remise à niveau nécessaire puis code... puis victoire !

### 06/12/2021 - Sprint 01

Vendredi dernier nous avons présenté le projet au reste de la promotion. 

Après ça, nous avons continué de coder.

L'équipe Frontend a développé la home page, en attaquant la carte de la France interactive, et en continuant leurs recherches sur les fonctionnalités.

Des problèmes ont été rencontré pour rendre la carte, car difficulté pour rendre responsive le format svg. Recherches effectuées et issue faite... A la fin de l'histoire, il se trouve que c'était une erreur de typo. La leçon est retenue !

Les formulaires d'inscription + log inscription + encart `event` commencé. 

L'équipe Backend a créé les entités nécessaires au projet, puis les routes api pour la home page. Dans le weekend les fixtures pour toutes la DB ont étés créées.

Après avoir créé les fixtures nous avons commencé les routes API. Nous nous somment partagé le travail entre les routes event et les autres. Mais nous nous sommes rendu compte qu'on devait attaquer la sécurité en même temps donc révision des objectifs pour intégrer les bases de la sécurité au srpint.

Aujourd'hui nous allons:

- Continuer les API + sécurité sur login/logout + CSS
- Terminer la home/carte pour dynamiser les events affichés en fonction de la région sélectionné et faire les formulaires (avec utilisation de Formik - formulaire pour simplifier React + création du DB en dur dans un json pour travailler sans connexion avec le back ).

Le responsive a posé des soucis (CSS). 
L'ajout d'avatar n'est pas satisfaisant pour l'instant. Avant que le formulaire fonctionne, l'import d'une dépendance a posé problème (yup.). Problème réglé après recherche en groupe.

Pour l'équipe backend nous continuons à faire les routes API selon les routes désirées. Nous avons dû commencer la sécurité lorsque nous sommes arrivé à la partie login. Quelques références circulaires a régler au passage. Nous avons constater que plusieurs routes contenaient des terminologies innexactes. Quelques correction sur .roads pendant le dev, communniqués à l'équipe front.



### 07/12/2021 - Sprint 01

Hier nous terminé les formulaires de co et d'inscription avons commencé le dashboard. 

Aujourd'hui, choix de la date de la première installation (demain 08/12/2021) sur serveur pour connecter les deux parties via API.

La partie frontend va: 
- Commencer a diviser les routes et les permissions pour rediriger les users si log ou non.
- Continuer à faire le CSS et faire la fenêtre pop-up de login (en haut à droite).
- Régler la présentation de l'avatar lors de l'inscription

La partie backend va terminer les routes API (une dernière route sur event qui bloque et la partie login a revérifier), puis merge les deux fichiers avant d'envoyer à la mise en prod.

### 08/12/2021 - Sprint 01

Ca matin nous avons une présentation d'une heure avec notre équipe pédagogique pour faire le point. Retour positif.

Aujourd'hui nous désirons fix quelques soucis mineurs non-bloquant du back avant de le déployer sur serveur. Côté front faire le formulaire de creéation d'events, terminer le formulaire de connexion + mise en page du dashboard et création de la page de présentation d'events.

### 09/12/2021 - Sprint 01

Hier nous avons eu des difficultés à déployer la partie back, nous comptons la finaliser ce matin, ainsi que celle du front pour connecter les deux et avoir une fonctionnalité OK pour la présentation à la promotion demain. 

Après quelques difficultés, nous sommes parvenus à déployer la partie back avec aws. Nous avons réalisé des tests avec le front afin de contrôler que les infos que nous souhaitions. La connexion etre back et front fonctionne.

### 10/12/2021 - Sprint 01

Hier nous avons terminé la mise en ligne du back.

Côté back, nous avons également commencé à mettre en place le backoffice.

Ce matin, nous présentons notre projet. Nous allons également pouvoir voir le travail des autres équipes. 

Cet après-midi nous prévoyons de continuer de travailler sur le backoffice.

Côté front, le travail s'est essentiellement orienté sur la modification de la map de la page d'accueil, la mise en place de la page détail de d'un event et de la préparation du sprint 2.

### 13/12/2021 - Sprint 01 

Vendredi, nous nous sommes rendu compte qu'il nous manquait des routes. En effet, nous ne gérions pas la validation et le refus de la participation d'un user. De même, nous ne pouvions gérer l'ajout d'une participation. Nous avons donc beaucoup discuter par rapport à tout ça. Nous avons décidé de créer une table participation à part entière. 

Nous avons donc crée : une entité, un controller, un formulaire participation.

Aujourd'hui, nous allons contrôler que tout fonctionne suite aux modifications que nous avons effectuées.

Côté front, le travail doit s'orienter sur la page du profil user, et des tests vont être effectués sur la connexion au site.

### 14/12/2021 - Sprint 02

Hier nous avons mis en place des restrictions côté back afin qu"un user ne puisse pas faire plusieurs fois la même demande de participation, ou bien encore qu'il ne puisse pas participer à un évènement qui est complet.

Nous avons réglée aussi un bug rapporté par le front par rapport à la connexion. Nous avons mis à jour le serveur en relançant les jwt.

Aujourd'hui nous allons retravailler sur les form types pour ajouter des contraintes sur les formulaires, et mettre en place des voters.

Côté front, le travail continue sur la page détail d'un événement mais aussi sur toute la partie connexion et déconnexion. 
Nous avençons aussi sur la partie css, design du site.

### 15/12/2021 - Sprint 02

Nous avons hier terminé côté back la mise en place de voters pour les évènements, les commentaires et les participations pour gérer les permissions suivants les actions réalisées.

Les contraintes des formulaires mis en place ont été également finalisées. Après plusieurs tests, tout est fonctionnel.

Aujourd'hui nous ajoutons des informations demandées par le front. 

Un service d'image à uploader pour l'avatar du user est en cours et sera terminé ce matin. 

Nous envisageons de nous remettre sur le backoffice.

Pour le front, après une mise à jour du serveur, l'objectif sera de terminer la page détail d'un évènement mais aussi de finaliser la page profil qui doit récupérer les 

informations du user.

### 16/12/2021 - Sprint 02

Hier, nous avons dû chercher une solution pour que le front puisse communiquer evac le back. Nous avons cherché du côté du fichier nelmio_cors.yaml. 

Le front a passé une partie de l'après-midi sur un problème au niveau de formik.

Ils ont également terminé de travailler sur la mise à jour du profil et de la page event.

Côté back, nous avons terminé la mise en place des contraints sur les formulaires. Nous avons mis des contrôles au niveau des participations. Tout cela est en place. Nous continuons de travailler sur le backoffice.

### 17/02/2021 - Sprint 02

En modifiant de nouveau le fichier nelmio_cors.yaml en back, nous sommes parvenu à faire communiquer le back et le front.

Le backoffice est quasiment en place.

Mise en page d'inscription. Surtt travail de mise en page.

mise en place du bouton pour accéder au back office.

Aujourd'hui, nous allons présenter ce qui a été fait lors de ce 2ème sprint.

Concernant le scraping, nous sommes proches de réussir à récupérer l'intégralité du site que l'on vise (il nous manque les categories).

Le front va poursuivre son travail pour que toutes les fonctionnalités prévues dans le mvp soient prêtes pour la présentation de la semaine prochaine.





