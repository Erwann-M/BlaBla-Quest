# Memo Git

![Git image](../imgReadme/git.png)

Salut, c'est votre **Git Master préféré** !😎<br>
Pour ne pas que ce soit la zouze dans les commits, on va essayer de respecter quelque règles :

- On code chacun sa fonctionnalité.
- À chaque fonctionnalité, on créé une branche.
- On push le soir avant de partir faire ces petites affaires.
- Si on code sur la fonctionnalité d'un copain, on n'oublie pas de pull le matin pour être à jour (au cas où il aurait codé toute la nuit).
- Pour les merge, on attend d'être en équipe pour régler d'éventuels conflits.
- On essaye de faire un maximum de commits (à chaque changement majeur) pour s'y retrouver plus facilement. (pas obligé de push à chaque fois, on peut le faire qu'en fin de journée).
- On ne tape pas ses collègues.
- Si vous avez un souci, contactez votre super Git master !
- Et le plus important : **LA COMMUNICATION !**🗣

## La syntaxe des commits

### exemple

```
<type>(<scope>): <subject>
```

### "type"

- ```build``` : modifications liées à la construction (Par exemple : liées à npm/ajout de dépendances externes).
- ```chore```: un changement de code que l'utilisateur externe ne verra pas (par exemple : changement vers le fichier .gitignore ou le fichier .prettierrc).
- ```feat```: une nouvelle fonctionnalité.
- ```fix```: une correction de bug.
- ```docs```: modifications liées à la documentation.
- ```refactor```: un code qui ne corrige pas de bug ni n'ajoute de fonctionnalité. (par exemple : vous pouvez l'utiliser lorsqu'il y a des changements sémantiques comme renommer un nom de variable/fonction).
- ```perf```: un code qui améliore les performances.
- ```style```: un code lié au style.
- ```test```: ajout d'un nouveau test ou modification d'un test existant.

### "scope" (facultatif)

- La portée doit être un nom et elle représente la section de la section de la base de code.

### "subject"

- utilisez l'impératif, le présent (par exemple : utilisez « add » au lieu de « added » ou « adds »).
- ne pas utiliser de point (.) à la fin.
- ne pas mettre la première lettre en majuscule.
