# Selflow(Roughly Completed.)
A blog like CMS web application with an admin panel for administrator to control, made of Laravel 5.4, developed in Homestead.

After migrate all tables, you must use php artisan db:seed to insert default three roles "administrator, author and subscriber" and the category "Uncategorized" to set all the things in the system.

If the user of any role is inactive, he or she may not create, update and delete a post, even with leave a comment or make a reply on post. Active users just can write a comment and reply now.

Because of developing stage, I just hosted it in a free heroku.
Here's the website link for demo: https://selflow.herokuapp.com/
