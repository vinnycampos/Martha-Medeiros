# `.ff-wordpress { content: 'theme'; }`

This boilerplate has support for a few libraries/resources:

* Zurb Foundation Sites
* Font Awesome
* Open Sans
* html5shiv
* jQuery

## Getting started

* First of all, you need to [install NodeJS](https://nodejs.org/);
* Open the theme folder on terminal and run `npm run prestart`. That command will install [Gulp](http://gulpjs.com/) and [Bower](http://bower.io/) as global packages so we can use those to generate the build.
* `[sudo] npm install`
* Now you just need to run `gulp` and then Gulp will run all the tasks and generate the build folder (by default named as `ff-theme`) one directory above.

## Develpment process

### File structure

* **config:** All instances for `wp-config.php`;
* **data:** Exported databse files;
* **site:** Usual Wordpress files;
* **theme:** Theme files used for development;

### Theme folder

* **.bowerrc:** Bower components configurations;
* **.editorconfig:** Config file to keep the same editor configuration for all developers involved E.g. indent style, indent size;
* **.jshintrc:** Config file to run javascript lint;
* **bower.json:** List with all Bower dependencies in the current project;
* **Gulpfile.js:** The main file with all the tasks;
* **package.json:** List with all Node/Gulp dependencies in the current project;
* **assets/images:** Images used to build the current project;
* **assets/scripts:** Scripts for the current project. Could have his own architecture insde.
* **assets/styles:** All styles for the current project. Has his own architecure based on [ITCSS](https://www.youtube.com/watch?v=1OKZOV-iLj4);
* **MVC Structure:** Used to develop the components used over the current project;
* **plugins:** Customized plugins configurations should be insde this folder;
* **templates:** All themes files E.g. `single.php`, `functions.php`, `page.php`, etc.
* **vendor:** This folder is on `.gitignore` because here goes the Bower components used in the current project.

### Running the tasks

To run the tasks you just need to run `gulp` and the task name, E.g. `gulp build`.

* **`gulp styles`** Compile, minify and optimize the Sass files turning in to `style.css`;
* **`gulp csslint`** Syntax check for CSS and also look for problematic patterns or signs of inefficiency;
* **`gulp theme`** Get all the files/folders insde the `Templates` and put it in the root of the build folder;
* **`gulp scripts`** Compile, minify and concatenate the Javascript files turning in to `scripts.js`;
* **`gulp jshint`** Syntax check for JS and also look for problematic patterns or signs of inefficiency;
* **`gulp images`** Optimize the images weight and size;
* **`gulp bower`** Check if all Bower Components are installed, if they aren't the task does. All these components are droped insde the `source/vendor` folder;
* **`gulp vendor`** In this task you need to put just the Bower Components you need to be compiled, that way we don't have lots of unecessary librearies in the build folder;
* **`gulp watch`** Keep watching for changes in all the files and runs the respective task when has changes;
* **`gulp config`** Move the `config/wp-config-loc.php` to `site/wp-config.php`;
* **`gulp clear`** Clean up the build folder. If there's some issue when you run the `build` task, just run `gulp clear` before;
* **`gulp build`** Runs `config`, `bower`, `vendor`, `images`, `scripts`, `styles`, `theme` tasks and generate the build folder;
* **`gulp serve`** Runs BrowserSync. By default this task will run the server inside a specific virtual host: `wordpress.loc`. Check in your local server app how to create custom [virtual hosts like this](https://www.mamp.info/en/mamp-pro/#vhosts).
* **`gulp`** Runs the `build` and `serve` task.

### Getting the build

When you run the `build` task, Gulp generates a folder at the root of your `wp-content/themes/`. The default name for this build is `ff-theme` but you can change this inside your `Gulpfile.js`. After generate the build, just go to `wp-admin` panel and will be there a brand new theme to be activated.
