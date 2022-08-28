# Blog

## 📖 Project description

*TODO*


## Prerequisites

* docker docker-compose


## How to set up local runtime using Docker

Go to the project directory on your local machine.

To build an image and have container up and running on background, run the following command: `docker-compose up -d --build`

This process might take for a while.

## How to run utilities

To install dependencies you can run `docker-compose run --rm composer install`.

Now you should be able to access the website on localhost:8000.

You also can run `docker-compose run --rm artisan` to use artisan.

Docker will create a (new) container everytime but only temporarily, so it will get removed.

## How to Start and Stop

In the project directory you can run commands below to start and stop all containers.

- `docker-compose up -d`
- `docker-compose stop`

## Resources

- https://laracasts.com/discuss/channels/laravel/sqlstate01000-warning-1265-data-truncated-for-column-priority-at-row-1
- https://community.postman.com/t/extract-value-from-a-json-response-body-via-the-test-scripts/11835/2
- https://readerstacks.com/how-to-change-data-type-of-column-in-laravel-9-migration/
- https://github.com/laravel/sanctum/issues/284
- https://www.thisprogrammingthing.com/2020/Working-With-Laravels-SoftDelete-Trait/
