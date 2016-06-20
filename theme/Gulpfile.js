/*-----------------------------------*\
  #Gulpfile: Automating tasks
\*-----------------------------------*/





/**
 * LOAD PLUGINS
 */
var gulp          = require('gulp')
    ,browserSync  = require('browser-sync')
    ,reload       = browserSync.reload
    ,bower        = require('gulp-bower')
    ,merge        = require('merge-stream')
    ,del          = require('del')
    ,rs           = require('run-sequence')
    ,$            = require('gulp-load-plugins')();

var config = {
  stylesPath       : './source/assets/styles'
  ,scriptsPath     : './source/assets/scripts'
  ,imagesPath      : './source/assets/images'
  ,templatePath    : './source/templates'
  ,modelsPath      : './source/models'
  ,viewsPath       : './source/views'
  ,controllersPath : './source/controllers'
  ,vendorPath      : './source/vendor'
  ,pluginsPath     : './source/plugins/**/*'
  ,buildPath       : '../site/wp-content/themes/martha_medeiros'
  ,server          : 'wordpress.loc'
}





/**
 * CLEAR CACHE
 */
gulp.task('clear', function(cb) {
  return del(
    [
      config.buildPath  + '/**/*'
      ,config.buildPath + '/.*'
    ]
    ,{force: true}
    ,cb
  );
});





/**
 * BOWER
 */
gulp.task('bower', function() {
  return bower(config.vendorPath)
    .pipe($.size({title: 'Bower'}))
});
 
/**
 * COMPILE STYLE
 */
gulp.task('styles', function() {
  return gulp.src([config.stylesPath  + '/style.css'])
      .pipe($.autoprefixer({
       browsers: [
         'last 2 version'
         ,'> 1%'
         ,'safari 5'
         ,'ie 8'
         ,'ie 9'
         ,'opera 12.1'
         ,'ios 6'
         ,'android 4'
       ],
       cascade: false
      }))
      .pipe($.cssmin()
        .on('error', $.notify.onError(function (error) {
            return 'Error: ' + error.message;})))
      .pipe(gulp.dest(config.buildPath))
    .pipe($.size({title:'Styles'}))
    .pipe(reload({stream: true}));
});

/**
 * CSS LINT
 */
gulp.task('csslint', function() {
  return gulp.src(config.buildPath + '/style.css')
    .pipe($.csslint())
    .pipe($.csslint.reporter()
  );
});

/**
 * PRETTIFY THEME FILES
 */
gulp.task('theme', function() {
  var template = gulp.src(config.templatePath + '/**/*.php')
    .pipe($.prettify({
      indent_inner_html: true,
      indent_size: 2
    }))
    .pipe(gulp.dest(config.buildPath))
    .pipe($.size({title: 'Template'}));

  var m = gulp.src(config.modelsPath + '/**/*.*')
    .pipe($.prettify({
      indent_inner_html: true,
      indent_size: 2
    }))
    .pipe(gulp.dest(config.buildPath + '/models'))
    .pipe($.size({title: 'Models'}));

  var v = gulp.src(config.viewsPath + '/**/*.*')
    .pipe($.prettify({
      indent_inner_html: true,
      indent_size: 2
    }))
    .pipe(gulp.dest(config.buildPath + '/views'))
    .pipe($.size({title: 'Views'}));

  var c = gulp.src(config.controllersPath + '/**/*.*')
    .pipe($.prettify({
      indent_inner_html: true,
      indent_size: 2
    }))
    .pipe(gulp.dest(config.buildPath + '/controllers'))
    .pipe($.size({title: 'Controllers'}))
    .pipe(reload({stream: true}));

  return merge(template, m, v, c);
});





/**
 * COMPILE SCRIPTS
 */
gulp.task('scripts', function() {
  return gulp.src(config.scriptsPath  + '/scripts.js')
    .pipe($.sourcemaps.init())
      .pipe($.concat('scripts.js'))
      .pipe($.uglify())
    .pipe(gulp.dest(config.buildPath + '/assets/js'))
    .pipe($.sourcemaps.write('./.maps/'))
    .pipe(gulp.dest(config.buildPath))
    .pipe($.size({title: 'Scripts'}))
    .pipe(reload({stream: true}));
});

/**
 * JSHINT
 */
gulp.task('jshint', function() {
  return gulp.src(config.scriptsPath + '/*.js')
    .pipe($.jshint())
    .pipe($.jshint.reporter()
  );
});





/**
 * COMPRESS IMAGES AND CACHE THEM
 */
gulp.task('images', function() {
  var imgs = gulp.src(config.imagesPath + '/**/*')
    .pipe(
      $.imagemin({
        optimizationLevel: 5,
        progressive: true,
        interlaced: true
      })
    )
    .pipe(gulp.dest(config.buildPath + '/assets/img'))
    .pipe($.size({title: 'Images'}));

  var ss = gulp.src(config.imagesPath + '/screenshot.jpg')
    .pipe(gulp.dest(config.buildPath))
    .pipe(reload({stream: true}));

  return merge(imgs, ss);
});





/**
 * COMPILE VENDOR FILES
 */
gulp.task('vendor', function() {

  /**
   * COMPILE FONTS VENDOR FILES
   */
  var fonts = gulp.src([
    config.vendorPath  + '/font-awesome/fonts/**.*'
    ,config.vendorPath + '/open-sans/fonts/**/**.*'
  ]) 
    .pipe(gulp.dest(config.buildPath + '/assets/vendor/fonts'))
    .pipe($.size({title: 'Vendor: Fonts'}));

  /**
   * COMPILE JS VENDOR FILES
   */
  var js = gulp.src([
    config.vendorPath  + '/jquery/dist/jquery.js'
    ,config.vendorPath + '/fancybox/source/jquery.fancybox.js'
    ,config.vendorPath + '/html5shiv/dist/html5shiv.js'
  ])
    .pipe($.uglify())
    .pipe(gulp.dest(config.buildPath + '/assets/vendor/js'))
    .pipe($.size({title: 'Vendor: JS'}));

  var plugins = gulp.src([config.pluginsPath])
    .pipe(gulp.dest(config.buildPath));

  return merge(fonts, js, plugins);
});





/**
 * WATCHING FOR CHANGES
 */
gulp.task('watch', function() {
  gulp.watch([
    config.templatePath     + '/**/*'
    ,config.modelsPath      + '/**/*'
    ,config.viewsPath       + '/**/*'
    ,config.controllersPath + '/**/*'
  ], ['theme']);
  gulp.watch(config.stylesPath   + '/**/*', ['styles']);
  gulp.watch(config.scriptsPath  + '/**/*', ['scripts']);
  gulp.watch(config.imagesPath   + '/**/*', ['images']);
  gulp.watch('../config/wp-config-loc.php', ['config']);
});





/**
 * MOVE CONFIG FILES
 */
gulp.task('config', function() {
  return gulp.src('../config/wp-config-loc.php')
    .pipe($.rename({basename: 'wp-config'}))
    .pipe(gulp.dest('../site/'));
});





/**
 * BUILD TASK
 */
gulp.task('build', function(cb) {
  rs(
    'config'
    ,'clear'
    ,'bower'
    ,'vendor'
    ,'scripts'
    ,'styles'
    ,'theme'
    ,'images'
    ,cb
  );
});





/**
 * RUN SERVER
 */
gulp.task('serve', ['watch'], function() {
  browserSync({
    proxy: config.server
  });
});





/**
 * DEFAULT TASK
 */
gulp.task('default', function(cb) {
  rs(
    'build'
    ,'serve'
    ,cb
  );
});
