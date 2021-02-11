# !/usr/bin/bash

heroku config:get TRUSTIFI_KEY --app esgi-projet-cloud -s  >> .env
heroku config:get TRUSTIFI_SECRET --app esgi-projet-cloud -s  >> .env
heroku config:get TRUSTIFI_URL --app esgi-projet-cloud -s  >> .env