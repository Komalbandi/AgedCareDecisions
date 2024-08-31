## Environment

- I used Herd from Laravel
- I used PHP8.4

## Create table
- Run the SQL table in SQL directory

## Run the project
- Entry of the project is index.php
- run composer install
- set .env file
- sample .env file below
- DB_USERNAME=root
  DB_PASSWORD=root
  DB_HOST=127.0.0.1
  DB_DATABASE=AgedCareDecision
  DB_PORT=3306
- run in browser

### Note about the project
- I have not included unit test because of the time constraint
- I have not included the error handling because of the time constraint
- I have tried to relocate CallDetailsController and CallHeaderController to Controller folder, but running into issues, so I have created the empty folder.
- I have tried to relocate LoadEnv.php and LoadFirst.php to the Facade folder, but running into issues, so I have created the empty Facade folder.
- The summing of hours is not accurate, I need to work on the triggers.

