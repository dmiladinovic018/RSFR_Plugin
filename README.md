# plugin-boiler-plate

(...)

#### Rename:    
ROOT DIR  
```shell
/plugin-boiler-plate
```  

IN ROOT DIR  
```shell
/plugin-boiler-plate.php   
/wp-plugin-boiler-plate.json
```        

In wp-plugin-boiler-plate.json  
```shell
 "name" : "BC Plugin Boiler Plate",  
 "slug" : "bc-plugin-boiler-plate",  
 "download_url" : "http://plugins.bettercollective.rocks/wp-plugin-boiler-plate/wp-plugin-boiler-plate.zip"  
 "description" : "Plugin Boiler Plate"
```  


In plugin-boiler-plate.php  
```shell
 Plugin Name: BC Plugin Boiler Plate  
 Description: BC WP Plugin Starter Kit for Developers.  
 
 define('BC_PLUGIN_BOILER_PLATE_VERSION', '1.0.0');  
 
 define('BC_PLUGIN_BOILER_PLATE_DIR', __DIR__);
 define('BC_PLUGIN_BOILER_PLATE_URL', \plugin_dir_url(__FILE__));  
 define('BC_PLUGIN_BOILER_PLATE_FILE', __FILE__);  
 define('BC_PLUGIN_BOILER_PLATE_IS_DEV_ENV', __FILE__);  
 BoilerPlate::getInstance();
```  
    

In /src DIR  
```shell
src/BoilerPlate.php  
replace BoilerPlate in namespaces
```  
  

In composer.json  
```shell
"name": "bettercollective/wp-plugin-boiler-plate", 
"BetterCollective\\WpPlugins\\BoilerPlate\\" : "src/",  
"BetterCollective\\WpPlugins\\BoilerPlateTest\\" : "tests/"
```  

In Gruntfile.js  
```shell
'wp-plugin-plugin_name.json'  
'build/plugin_name'
'wp-plugin-plugin_name.zip'
```  

In package.json  
```shell
"name": "plugin-bc-boiler-plate"  
"url": "git@github.com:BetterCollective/plugin-boiler-plate.git"
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

#### Install npm in /plugins/plugin-boiler-plate
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
