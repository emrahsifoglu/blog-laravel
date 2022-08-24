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
