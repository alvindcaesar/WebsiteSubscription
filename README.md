# Laravel Subscription Platform

This is a simple Laravel subscription platform that allows users to subscribe to multiple websites and receive email notifications when new posts are published on those websites. The platform provides RESTful APIs and uses MySQL as the database backend.

## Prerequisites
- PHP 8.0 or higher
- Composer
- MySQL

## Getting Started

Run the migration:

`php artisan migrate`

Run the database seeder to populate the Website and Users(Subscribers) data:

`php artisan db:seed`

## API Endpoints

The platform provides the following endpoints:

### Create a post
Endpoint: `POST /api/websites/{website_id}/posts`

Request:
```json
{
    "title": "New Post",
    "description": "This is a new post."
}
```

Response:
```json
{
  "success": true,
  "message": "Post created successfully.",
  "data": {
    "website_id": 8,
    "title": "A New Post",
    "description": "A New Description",
    "updated_at": "2023-04-19T18:22:00.000000Z",
    "created_at": "2023-04-19T18:22:00.000000Z",
    "id": 2
  }
}
```

### Subscribe to a website
Endpoint: `POST /api/websites/{website_id}/subscriptions`

Request:
```json
{
    "user_id": 1
}
```

Response:
```json
{
  "success": true,
  "message": "Subscription created successfully.",
  "data": {
    "user_id": 1,
    "website_id": "10",
    "updated_at": "2023-04-19T17:33:01.000000Z",
    "created_at": "2023-04-19T17:33:01.000000Z",
    "id": 1
  }
}
```

## Artisan Command Implementation

The `notifications:send` command is responsible for sending email notifications to subscribers for new posts. 

To send emails to subscribers, the `notifications:send` command performs the following steps:

- Fetches all websites and their respective subscribers from the database.
- For each website, fetches all posts that have not yet been sent to subscribers.
- Sends email notifications to subscribers for each new post.
- Updates the database to mark the posts as sent.

To run the `notifications:send` command, use the following command:

`php artisan notifications:send`

## Running the Command on Schedule

To run the `notifications:send` command on a schedule, you can use Laravel's built-in task scheduler. The task scheduler allows you to define scheduled tasks that run automatically in the background.

The schedule task for this command is already defined in `app/Console/Kernel.php` file. It was set to run every minute.

To test the scheduled task on local machine, just use the following command:

`php artisan schedule:work`

This command runs indefinitely and executes scheduled tasks as they become due.