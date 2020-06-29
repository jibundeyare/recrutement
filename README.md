# recrutement.popschool-lens.fr

## Deploy

Requirements:

- [Deployer – A deployment tool for php](https://deployer.org/)

To deploy:

    dep deploy

## URLs

- admin_application_index    GET        ANY      ANY    /admin/candidature/
- admin_application_new      GET|POST   ANY      ANY    /admin/candidature/new
- admin_application_show     GET        ANY      ANY    /admin/candidature/{id}
- admin_application_edit     GET|POST   ANY      ANY    /admin/candidature/{id}/edit
- admin_application_delete   DELETE     ANY      ANY    /admin/candidature/{id}
- application_new            GET|POST   ANY      ANY    /candidature/
- application_show           GET        ANY      ANY    /candidature/{id}
- main_index                 ANY        ANY      ANY    /
- app_login                  ANY        ANY      ANY    /login
- app_logout                 ANY        ANY      ANY    /logout

## Texts

Main page :

- `templates/main/index.html.twig`

Application confirmation :

- `templates/application/show.html.twig`
- `templates/email/application_confirmation.html.twig`
- `templates/email/application_confirmation.txt.twig`

## Email addresses

See `.env*` files.

## Admin password

See `.env*` files.

## Known issues

### Rename uploaded file with entity id

This is impossible unless additional postprocessing is done after persisting the object.
The reason is that the file name is computed before the object is persisted, so the id is not yet available.
For more details, see: [symfony - VichUploaderBundle: How to get related entity ID in DirectoryNamer? - Stack Overflow](https://stackoverflow.com/questions/34002643/vichuploaderbundle-how-to-get-related-entity-id-in-directorynamer).

