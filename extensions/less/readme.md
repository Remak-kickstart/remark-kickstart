# less.php for Symphony #

This extension is an implementation of [less.php](https://github.com/dresende/less.php) for Symphony CMS.

## Usage: ##

Create less-stylesheets by adding the extension `.less` to them instead of `.css`:

    <link rel="stylesheet" type="text/css" href="{$assets}/css/screen.less" />
	
The extension will automaticly compile the `.less`-file and replace the tag with a linke to the cached `.css`-file.

For more information about the LESS-syntax, look at the [readme](https://github.com/dresende/less.php#readme) of [less.php](https://github.com/dresende/less.php).

## Please note: ##

The compiled CSS-files will be placed in the same folder as the LESS-files. Therefore the directory should be writable.

Also, since editing of the CSS is only used when a site is still in it's production environment, it's encouraged to disable
the extension and used the cached result when the site goes to a live environment.