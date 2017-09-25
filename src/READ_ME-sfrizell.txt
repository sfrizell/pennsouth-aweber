// see http://symfony.com/doc/2.8/setup.html
// to load the app in a web server type this command in the terminal:
 php app/console server:run

 Then go to URL: localhost:8000

 I placed auth0 javascript login code and login button in app/Resources/views/default/base.html.twig

Note: Before deployment of code to production server, reinstate commented-out code in web/config.php per Lynda.com symfony course recommendation

Doctrine how-to: For guidance on generating a single entity from an existing database (i.e., without regenerating the ORM code for the whole schema),
    see: http://stackoverflow.com/questions/10371600/generating-a-single-entity-from-existing-database-using-symfony2-and-doctrine