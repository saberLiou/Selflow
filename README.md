# Selflow
A full-stack CMS web application like a blog, with an admin panel for administrators to control, made of Laravel 5.4, developed in Homestead, with Cloudinary storing images.

After migrating all tables, you must use php artisan db:seed to insert default three roles "administrator, author and subscriber" and the category "Uncategorized" to set all the things done in this system. Default email and password for administrator is "admin@gmail.com" and "admin".

If a user of any role is "inactive", he or she may not create, update and delete a post, even leave a comment or make a reply on post. Active users can only write a comment and reply now, without editing or destroying.
