# projet-o-game

## Languages: 

### front
<p>
  <img alt="html" src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white" height="30">
  <img alt="sass" src="https://img.shields.io/badge/Sass-CC6699?style=for-the-badge&logo=sass&logoColor=white" height="30">
  <img alt="js" src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" height="30">
  <img alt="react" src="https://img.shields.io/badge/React-20232A?style=for-the-badge&logo=react&logoColor=61DAFB" height="30">
  <img alt="redux" src="https://img.shields.io/badge/Redux-593D88?style=for-the-badge&logo=redux&logoColor=white" height="30">
</p>

### Back

<p>
  <img alt="php" src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" height="30">
  <img alt="mysql" src="https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white" height="30">
  <img alt="symphony" src="imgReadme/Symfony.png" height="30">
</p>

## Backend

Require:
- Symphony
- Fixture bundle: ```composer require --dev orm-fixtures```
- Faker bundle: ```composer require --dev fakerphp/faker```
- JWT bundle: ```composer require lexik/jwt-authentication-bundle```
- nelmio cors bundle: ```composer req nelmio/cors-bundle```

Global install:

```composer install```

Create the connexion with your database by adding a `.env.local` with the informations of your DB.

DB:
- Creation: ```bin/console doctrine:database:create```
- Load fixtures: ```bin/console doctrine:fixtures:load```

Security:
- Generate SSL keys for JWT: ```bin/console lexik:jwt:generate-keypair```