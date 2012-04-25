# Packages #

## What does this extension do? ##

When developing a website, you most of the time end up with doing the same stuff over and over again. After all, each
client wants a news module, an image gallery, a contact form, a faq, etc.

This extension allows you to create a package of such a module (like a news module for example), save it as a ZIP-file
with an installation script, and import it on another site to have the same logic there.

## So how does this is any different of the Export Ensemble extension? ##

Simple: Where export ensemble creates an ensemble of a complete site, a package is a small part of a site you wish to
re-use in other projects as well. It allows you to select sections, data-sources, events, utilities, pages, extensions
and other resources (such as your own JavaScript- or CSS-files) to get packaged into one ZIP file, ready to be included
in any other Symphony site of yours...

## But wait! Doesn't that cause issues with mismatching ID's and stuff? ##

Nope! The installer script is not a SQL-script, but a PHP-script with various logic in it. For example:

- When creating sections and fields, it keeps track of the ID's of the newly created items, so it works correctly in your database.
- It uses some pretty clever regular expressions to change the datasource- and event-files to make sure any references to old section- and field-ID's are changed to their new ones.
- It does some magic to the newly added pages so parenting is staid intact.

## Sounds risky, are you sure it's fool-proof? ##

To be honest: I'm not entirely sure ;-). I did some tests with pages, sections, datasources, etc. and that worked pretty well.
But if you want to help, please inform me with any bugs you might encounter with this one.