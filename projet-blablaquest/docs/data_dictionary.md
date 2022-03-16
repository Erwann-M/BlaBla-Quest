# Data dictionary

## Game (`game`)

| Champ       | Type         | Spécificités                                    | Description                        |
| ----------- | ------------ | ----------------------------------------------- | ---------------------------------- |
| id          | INT          | PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT | Game id                            |
| name        | VARCHAR(255) | NOT NULL                                        | Game name                          |
| description | TEXT         | NOT NULL                                        | Game Desciption                    |
| picture     | VARCHAR(255) | NULL                                            | Game picture                       |
| playtime    | VARCHAR(255) | NULL                                            | Play time of the game              |
| player_min  | TINYINT(2)   | NOT NULL, DEFAULT 0                             | Minimum number of players who play |
| player_max  | TINYINT(2)   | NOT NULL, DEFAULT 0                             | Maximum number of players who play |
| age min     | TINYINT(2)   | NOT NULL, DEFAULT 0                             | Minimum age to play                |
| created_at  | TIMESTAMP    | NOT NULL, DEFAULT CURRENT_TIMESTAMP             | Creation date of the game          |
| updated_at  | TIMESTAMP    | NULL                                            | Updated date of the game           |

## Category (`category`)

| Champ      | Type         | Spécificités                                    | Description                   |
| ---------- | ------------ | ----------------------------------------------- | ----------------------------- |
| id         | INT          | PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT | Category id                   |
| name       | VARCHAR(255) | NOT NULL                                        | Category name                 |
| created_at | TIMESTAMP    | NOT NULL, DEFAULT CURRENT_TIMESTAMP             | Creation date of the category |
| updated_at | TIMESTAMP    | NULL                                            | Updated date of the category  |

## Event (`event`)

| Champ                 | Type         | Spécificités                                    | Description                                               |
| --------------------- | ------------ | ----------------------------------------------- | --------------------------------------------------------- |
| id                    | INT          | PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT | Event id                                                  |
| name                  | VARCHAR(255) | NOT NULL                                        | Event name                                                |
| description           | TEXT         | NOT NULL                                        | Event description                                         |
| area                  | VARCHAR(255) | NOT NULL, DEFAULT 0                             | Event area                                                |
| date_time             | TIMESTAMP    | NOT NULL, DEFAULT 0                             | Event Datetime                                            |
| entrants_numbers      | TINYINT(2)   | NOT NULL, DEFAULT 0                             | Entrants numbers                                          |
| status                | TINYINT(2)   | NOT NULL, DEFAULT 0                             | The status of the event ("Open"/Close)                    |
| total_users_validated | INT          | NOT NULL, DEFAULT 1                             | Total amount of users validated by the owner of the event |
| created_at            | TIMESTAMP    | NOT NULL, DEFAULT CURRENT_TIMESTAMP             | Creation date of the event                                |
| updated_at            | TIMESTAMP    | NULL                                            | Updated date of the event                                 |
| game_id               | ENTITY       | NOT NULL                                        | ID of the game                                            |
| user_id               | ENTITY       | NOT NULL                                        | ID of the user                                            |

## User (`user`)

| Champ      | Type         | Spécificités                                    | Description               |
| ---------- | ------------ | ----------------------------------------------- | ------------------------- |
| id         | INT          | PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT | User id                   |
| nickname   | VARCHAR(255) | NOT NULL                                        | User Nickname             |
| mail       | VARCHAR(255) | NOT NULL                                        | User Mail                 |
| password   | VARCHAR(255) | NOT NULL                                        | User password             |
| area       | VARCHAR(255) | NOT NULL                                        | Area                      |
| picture    | VARCHAR(255) | NULL                                            | Picture                   |
| role       | VARCHAR(255) | NOT NULL, DEFAULT ROLE_USER                     | Role                      |
| created_at | TIMESTAMP    | NOT NULL, DEFAULT CURRENT_TIMESTAMP             | Creation date of the user |
| updated_at | TIMESTAMP    | NULL                                            | Updated date of the user  |


## Comments (`comments`)

| Champ      | Type      | Spécificités                                    | Description                  |
| ---------- | --------- | ----------------------------------------------- | ---------------------------- |
| id         | INT       | PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT | Comment id                   |
| event_id   | INT       | FOREIGN KEY, NOT NULL, UNSIGNED                 | Event id                     |
| user_id    | INT       | FOREIGN KEY, NOT NULL, UNSIGNED                 | User id                      |
| content    | TEXT      | NOT NULL                                        | Content                      |
| created_at | TIMESTAMP | NOT NULL, DEFAULT CURRENT_TIMESTAMP             | Creation date of the comment |
| updated_at | TIMESTAMP | NULL                                            | Updated date of the comment  |

## Participation (`participation`)

| Champ        | Type      | Spécificités                                    | Description                  |
| ------------ | --------- | ----------------------------------------------- | ---------------------------- |
| id           | INT       | PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT | Participation id             |
| event_id     | INT       | FOREIGN KEY, NOT NULL, UNSIGNED                 | Event id                     |
| user_id      | INT       | FOREIGN KEY, NOT NULL, UNSIGNED                 | User id                      |
| is_validated | BOOLEAN   | NOT NULL, DEFAULT FALSE                         | Status of the participation  |
| is_refused   | BOOLEAN   | NOT NULL, DEFAULT FALSE                         | Status of the participation  |
| created_at   | TIMESTAMP | NOT NULL, DEFAULT CURRENT_TIMESTAMP             | Creation date of the comment |