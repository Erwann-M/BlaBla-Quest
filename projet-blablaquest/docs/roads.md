# 🗺️ Road - BlablaQuest

## Back

| URL                                           | HTTP Method | Controller                                      | Method                | Content                                  | Comment |
| --------------------------------------------- | ----------- | ----------------------------------------------- | --------------------- | ---------------------------------------- | ------- |
| `/api/v1/login_check`                         | `POST`      | `App\Controller\Api\V1\SecurityController`      | `login`               | Login form                               | -       |
| `/api/v1/logout/`                             | `POST`      | `App\Controller\Api\V1\SecurityController`      | `logout`              | Logout form                              | -       |
| `/api/v1/user/registration`                   | `POST`      | `App\Controller\Api\V1\UserController`          | `register`            | Registration user form                   | -       |
| `/api/v1/user/registration/{id}`              | `PUT`       | `App\Controller\Api\V1\UserController`          | `edit`                | Edit user form                           | -       |
| `/api/v1/user/{id}`                           | `GET`       | `App\Controller\Api\V1\UserController`          | `read`                | User details                             | -       |
| `/api/v1/user/{id}/event`                     | `GET`       | `App\Controller\Api\V1\UserController`          | `browseEvent`         | Events fallowed by the user              | -       |
| `/api/v1/game/`                               | `GET`       | `App\Controller\Api\V1\GameController`          | `browse`              | Liste of games in DB                     | -       |
| `/api/v1/game/{id}`                           | `GET`       | `App\Controller\Api\V1\GameController`          | `read`                | Game details                             | -       |
| `/api/v1/game/add`                            | `POST`      | `App\Controller\Api\V1\GameController`          | `add`                 | Add a game                               | -       |
| `/api/v1/event`                               | `GET`       | `App\Controller\Api\V1\EventController`         | `browse`              | Home page listing events                 | -       |
| `/api/v1/event/area/{area}`                   | `GET`       | `App\Controller\Api\V1\EventController`         | `browseArea`          | List of events in the area               | -       |
| `/api/v1/event`                               | `POST`      | `App\Controller\Api\V1\EventController`         | `add`                 | Add an event                             | -       |
| `/api/v1/event/{id}`                          | `GET`       | `App\Controller\Api\V1\EventController`         | `readById`            | Event details                            | -       |
| `/api/v1/event/{id}/participation`            | `GET`       | `App\Controller\Api\V1\EventController`         | `browseParticipation` | Users validated and total amount of them | -       |
| `/api/v1/event/{id}`                          | `PUT`       | `App\Controller\Api\V1\EventController`         | `edit`                | Edit an event                            | -       |
| `/api/v1/event/{id}`                          | `DELETE`    | `App\Controller\Api\V1\EventController`         | `delete`              | Delete an event                          | -       |
| `/api/v1/event/{id}/comment`                  | `GET`       | `App\Controller\Api\V1\EventController`         | `browseComment`       | All comments by event                    | -       |
| `/api/v1/event/{id}/comment`                       | `POST`      | `App\Controller\Api\V1\EventController`         | `addComment`          | Add a comment                            | -       |
| `/api/v1/event/{id}/comment`                  | `PUT`       | `App\Controller\Api\V1\EventController`         | `editComment`         | Edit a comment                           | -       |
| `/api/v1/event/{id}/comment`                  | `DELETE`    | `App\Controller\Api\V1\EventController`         | `deleteComment`       | Delete a comment                         | -       |
| `/api/v1/participation/{id}`                  | `POST`      | `App\Controller\Api\V1\ParticipationController` | `add`                 | Apply to the event                       | -       |
| `/api/v1/participation/{id}/validate/{event}` | `PUT`       | `App\Controller\Api\V1\ParticipationController` | `acceptUser`          | Accept user to the event                 | -       |
| `/api/v1/participation/{id}/refuse/{event}`           | `PUT`       | `App\Controller\Api\V1\ParticipationController` | `refuseUser`          | Refuse user to the event                 | -       |
| `/api/v1/participation/{id}`                  | `DELETE`    | `App\Controller\Api\V1\ParticipationController` | `delete`              | Delete the user apply to the event       | -       |
| ---------------------------------             | ----------- | ------------------------------------------      | ----------------      | ------------------------                 | ------- |
| `/admin/event/browse`                         | `GET`       | `EventController`                               | `browse`              | All events                               | -       |
| `/admin/event/read`                           | `GET`       | `EventController`                               | `read`                | Event details                            | -       |
| `/admin/event/edit`                           | `PUT`       | `EventController`                               | `edit`                | Event details                            | -       |
| `/admin/event/add`                            | `POST`      | `EventController`                               | `add`                 | Event details                            | -       |
| `/admin/event/delete`                         | `DELETE`    | `EventController`                               | `delete`              | Event details                            | -       |
| `/admin/game/browse`                          | `GET`       | `GameController`                                | `browse`              | Event details                            | -       |
| `/admin/game/read`                            | `GET`       | `GameController`                                | `read`                | Event details                            | -       |
| `/admin/game/edit`                            | `PUT`       | `GameController`                                | `edit`                | Event details                            | -       |
| `/admin/game/add`                             | `POST`      | `GameController`                                | `add`                 | Event details                            | -       |
| `/admin/game/delete`                          | `DELETE`    | `GameController`                                | `delete`              | Event details                            | -       |
| `/admin/user/browse`                          | `GET`       | `UserController`                                | `browse`              | Event details                            | -       |
| `/admin/user/read`                            | `GET`       | `UserController`                                | `read`                | Event details                            | -       |
| `/admin/user/edit`                            | `PUT`       | `UserController`                                | `edit`                | Event details                            | -       |
| `/admin/user/add`                             | `POST`      | `UserController`                                | `add`                 | Event details                            | -       |
| `/admin/user/delete`                          | `DELETE`    | `UserController`                                | `delete`              | Event details                            | -       |
| `/admin/category/browse`                      | `GET`       | `CategoryController`                            | `browse`              | Event details                            | -       |
| `/admin/category/read`                        | `GET`       | `CategoryController`                            | `read`                | Event details                            | -       |
| `/admin/category/edit`                        | `PUT`       | `CategoryController`                            | `edit`                | Event details                            | -       |
| `/admin/category/add`                         | `POST`      | `CategoryController`                            | `add`                 | Event details                            | -       |
| `/admin/category/delete`                      | `DELETE`    | `CategoryController`                            | `delete`              | Event details                            | -       |
| `/admin/role/browse`                          | `GET`       | `RoleController`                                | `browse`              | Event details                            | -       |
| `/admin/role/read`                            | `GET`       | `RoleController`                                | `read`                | Event details                            | -       |
| `/admin/role/edit`                            | `PUT`       | `RoleController`                                | `edit`                | Event details                            | -       |
| `/admin/role/add`                             | `POST`      | `RoleController`                                | `add`                 | Event details                            | -       |
| `/admin/role/delete`                          | `DELETE`    | `RoleController`                                | `delete`              | Event details                            | -       |

## Front

| URL             | HTTP Method | Title                | Content                                | Comment                     |
| --------------- | ----------- | -------------------- | -------------------------------------- | --------------------------- |
| `/`             | `GET`       | Accueil              | Home page listing events & display map | Home for not connected user |
| `/registration` | `GET`       | Inscription          | registration form                      | -                           |
| `/dashboard`    | `GET`       | Panneau de controlle | home/dashboard                         | Home for connected user     |
| `/{id}/area`    | `GET`       | Change de region     | home/dashboard find new region         | -                           |
| `/event/{id}`   | `GET`       | Description          | Event page ( display 1 event )         | -                           |
| `/profile`      | `GET`       | Profil               | Profile page                           | -                           |
