# plugin-rsfr-plate

(...)

#### Rename:    
ROOT DIR  
```shell
/plugin-rsfr-plate
```  

IN ROOT DIR  
```shell
/plugin-rsfr-plate.php   
/wp-plugin-rsfr.json
```        

In wp-plugin-rsfr.json  
```shell
 "name" : "BC Plugin Rsfr",  
 "slug" : "bc-plugin-rsfr-plate",  
 "download_url" : "http://plugins.bettercollective.rocks/wp-plugin-rsfr/wp-plugin-rsfr.zip"  
 "description" : "Plugin Rsfr"
```  


In plugin-rsfr-plate.php  
```shell
 Plugin Name: BC Plugin Rsfr  
 Description: BC WP Plugin for showing WP content on non WP sites.  
 
 define('BC_RSFR_VERSION', '1.0.0');  
 
 define('BC_RSFR_DIR', __DIR__);
 define('BC_RSFR_URL', \plugin_dir_url(__FILE__));  
 define('BC_RSFR_FILE', __FILE__);  
 define('BC_RSFR_IS_DEV_ENV', __FILE__);  
 Rsfr::getInstance();
```  
    

In /src DIR  
```shell
src/Rsfr.php  
replace Rsfr in namespaces
```  
  

In composer.json  
```shell
"name": "bettercollective/wp-plugin-rsfr", 
"BetterCollective\\WpPlugins\\Rsfr\\" : "src/",  
"BetterCollective\\WpPlugins\\RsfrTest\\" : "tests/"
```  

In Gruntfile.js  
```shell
'wp-plugin-plugin_name.json'  
'build/plugin_name'
'wp-plugin-plugin_name.zip'
```  

In package.json  
```shell
"name": "plugin-bc-rsfr"  
"url": "git@github.com:BetterCollective/plugin-rsfr-plate.git"
```  


(...)

# Installation
In order to build and test plugin, you'll need to install its dev dependencies. We will assume [node]( https://nodejs.org/ ) (`$ npm install`) is installed and `npm` is added to system path.

#### Install Grunt CLI as global
Install this globally and you'll have access to the `grunt` command anywhere on your system.
```shell
npm install -g grunt-cli
```
>**Note**: The job of the grunt command is to load and run the version of `grunt` you have installed locally to your project, irrespective of its version

#### Install npm in /plugins/plugin-rsfr-plate
This command installs a package, and any packages that it depends on in the local `node_modules` folder. The package has a [package-lock.json](https://docs.npmjs.com/files/package-lock.json) and the installation of dependencies will be driven by that.
```shell
npm install
```

#### Install Composer Packages
```shell 
composer install --prefer-dist --no-dev
```

#### Grunt commands
Now when everything is installed you can use following grunt commands:
```shell 
grunt
grunt watch
grunt dev
grunt build
grunt deploy
```

#### Optional composer packages
    "kint-php/kint" : "^2.0",
    "squizlabs/php_codesniffer": "3.*",
    "phpmetrics/phpmetrics": "^2.4",
    "phpmd/phpmd": "@stable",
    "phpunit/phpunit": "^5"

### Hooks
List all hooks used in the plugin

Happy Coding :octocat: :sunny:
