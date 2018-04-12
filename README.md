# **Plugin to Extend Look and Functionality of a Genesis Theme**

## The Basics
Instead of modifying a WordPress child theme of the [Genesis Framework](https://my.studiopress.com/themes/genesis/ "Genesis Framework for WordPress"). I decided to createa plugin to extend and change the child theme. The particular themeI modified using this plugin is Parallax, which is a child theme of Genesis. You can use this as a template if you would like to do something
similiar with your Genesis themes.

The plugin includes a new font, svg images, additional CSS,additiona; Javascript along
with filters and actions in a PHP file that changes and overrides some of
the theme functionality.

## Files

A **gulpfile** is included for minification of images and minification and autoprefixing
of CSS and minification of some Javascript.

A **package.json** is included to install the node_modules needed to run the gulpfile and bowser.

Bower is included as this plugin also uses bourbon and neat which are specified in the bower.json 
file.

To get started after cloning or forking run the two commands below:
```node
  npm install
  
  bower install
```