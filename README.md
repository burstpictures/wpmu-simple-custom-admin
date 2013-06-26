=======================================
Wordpress-Multisite-Simple-Custom-Admin
=======================================

Simplifies and Customizes the admin for wordpress single site and multisite, geared towards setting up
multilingual sites on WPMU but it also works on single site installs.

This plugin was developped to reside within the mu-plugins directory of wordpress as all options are hardcoded and
remain invisible to the main users.

================
The plugin will:
================

01.  redirect to a tempory page landing page or old website folder on your domain whilst designing a wordpress theme;
02.  force 1 column on the site and network Dashboards;
03.  remove annoying Dashboard widgets, Welcome Panel and access to help for all users;
04.  add a 20px x 20px logo to the admin bar on a single wordpress install;
05.  white Label the footer and remove wordpress version from the admin interface;
06.  customize the login page with a clean minimalist style;
07.  replace the "My Sites" dropdown menu WP logos with the language flags of the corresponding blog language and
     add the language locale at the end of the site name;
08.  replace the name "Dashboard" for each site with the language flagand the language locale at the end of the site name;
09.  switch media upload yyyy/mm folder structure off for newly created sites and force it to off for existing ones;
10.  redirect the Network super-admin to the Network Admin page after login;


=============
Installation:
=============

Copy the whole folder to your mu-plugins directory within the wp-content folder. If the directory does not exist, create one.
Create a load.php file in your mu-plugins directory and add the following lines to it:

<?php
// mu-plugins/load.php
require WPMU_PLUGIN_DIR . '/simple-custom-admin/simple-custom-admin.php';


Replace the logos within the images folder with your logos. Keep the same file names and image sizes.
Adapt any other code to your liking and share!
That's it, you should see the changes.
