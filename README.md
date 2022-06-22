## Podcast Codetest

An application that does two things:

# Webhook

A webhook is setup to take in data about episode downloads. The data is validated and then stored to be queried against later.
This happens in the DownloadController Store method.

# Frontend API

An api that takes an episode_id as a parameter and returns the amount of downloads over the last 7 days, grouped by day. The data is setup in a way that should make it easy for a front-end developer to create a chart/graph out of it.

# Cloning and setup

 - Clone repo
 - Create an empty database, and change .env details to match the database
 - run 'php artisan migrate'
 - run 'php artisan db:seed'
 - run 'php artisan test'

# Relevant URLS

POST url for webhook: /webhook
GET url for front-end api: /api/download_data/{episode_id}

# What I'd do differently in production

- The webhook would have some security with a secret http header to make sure the request is coming from the right place. I could use this
package to easily do this: https://github.com/spatie/laravel-webhook-client


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
