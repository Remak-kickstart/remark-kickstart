# CKEditor for Symphony CMS

 * Version: 1.2.4
 * CKEditor version: 3.6.2
 * Date: 12-12-2011
 * Authors: Tony Arnold <tony@thecocoabots.com>, Giel Berkers <info@gielberkers.com>
 * Repository: <http://github.com/kanduvisla/symphony-ckeditor/>
 * Requirements: Symphony CMS 2.2 or higher <http://github.com/symphony/symphony-2/tree/master>

## Introduction

This extension provides [CKEditor](http://ckeditor.com/) as text-formatter for Symphony CMS. It also has an integrated file browser which uses Symphony sections to get it's files from.
For further information about the editor please visit [www.ckeditor.com](http://ckeditor.com/).

It is based upon code found in [Nils H&ouml;rrmann's WYMEditor](http://github.com/nilshoerrmann/wymeditor).

## Contributors

Significant work and bug fixes have been contributed by the following users:

 * Giel Berkers - <http://github.com/kanduvisla> contributed major clean-ups and a new Symphony file browser that is compatible with CKEditor;
 * Rob Stanford - contributed bug fixes.
 
For full details, please see the Github commit log - <http://github.com/tonyarnold/symphony-ckeditor/commits/master>.

## Special notes

The version of CKEditor included with this Symphony extension is stripped down to the bare essentials. This means:

 * Text formatting is limited to the following functions:
   * Paragraph Format
   * Bold
   * Italic
   * Strike-through
   * Subscript / Superscript
   * Ordered list / Unordered list
   * Indent / Outdent
   * Block quote
   * Hyperlinks
   * Horizontal rule
   * View source
   * Full screen
 * *Most of CKEditor's plug-ins have been removed*: if you wish to add more plug-ins, please download the original [CKEditor](http://ckeditor.com) package and extract the plugins you'd like to include.
 * *All languages other than US English are removed*: If you wish to make use of additional languages, please download the original version of [CKEditor](http://ckeditor.com) and extract the languages you'd like to include.

## Built-in file browser

This Symphony extension comes with a built-in file browser that is compatible with CKEditor. This file browser uses Symphony sections to store and retrieve uploaded files. It works as follows:

 * Make sure you have created at least one section for your uploaded files with a 'File Upload' field attached;
 * Go to Symphony's System Preferences and make the CKEditor file browser available to one or more of your sections;
 * Once you've enabled the file browser for at least one of your sections, you make use of the 'Browse Server' button in CKEditor to select existing files from within your section and add them to the entry you are editing. You can also upload new files using the file browser on the fly!

## Link templates

As of Symphony 2.3, it's possible to create link templates for CKEditor. This works as following:

Say, you got a page called 'News', and a section called 'News articles' in which you store all your news articles. This means
your news articles probably got URL's like:

 * /news/detail/25/my-new-site/
 * /news/detail/31/grand-opening/
 * /news/detail/40/visit-of-the-queen/

You might want to link to these pages from other pages, but you don't want to copy/paste those links. You just want them to
be there in your dropdown of Symphony Pages when you select a link. This is where link templates come in: You can create
a link template like: `/news/detail/{$id}/{$title}/`, choose a section the generate the list from, and select the page
where to show these links. You can set these in the preferences page of your Symphony installation.