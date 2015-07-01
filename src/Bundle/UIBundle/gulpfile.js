/**
 * Symfony compatible gulp implementation.
 *
 * Adapted from http://ericlbarnes.com/setting-gulp-bower-bootstrap-sass-fontawesome/
 * http://tylermcginnis.com/reactjs-tutorial-pt-2-building-react-applications-with-gulp-and-browserify/
 *
 * Uses:
 *    - Gulp
 *    - Bower
 *    - Less
 */

var gulp       = require('gulp'),
    browserify = require('gulp-browserify'),
    babel      = require('gulp-babel'),
    streamify  = require('gulp-streamify'),
    rename     = require('gulp-rename'),
    uglify     = require('gulp-uglify'),
    minify     = require('gulp-minify-css'),
    less       = require('gulp-less'),
    notify     = require('gulp-notify'),
    react      = require('gulp-react'),
    jshint     = require('gulp-jshint'),
    reload     = require('gulp-livereload'),
    clean      = require('gulp-clean'),
    source     = require('vinyl-source-stream'),
    babelify   = require('babelify');

var path = {
  LESS:   './Resources/assets/less',
  CSS:    './Resources/assets/css',
  COFFEE: './Resources/assets/coffee',
  JS:     './Resources/assets/js',
  NODE:   './node_modules',
  BUILD:  './build',
  DIST:   './build/dist',
  HTML:   './Resources/public'
};

var file = {
  LESS: [path.LESS + '/accard.less'],
  JS: [
    path.JS + '/**/*.js',
    path.JS + '/*.js'
  ],
  JS_FRONT: path.JS + '/index.js',
  JS_LIBS: [
    path.NODE + '/jquery/dist/jquery.min.js',
    path.NODE + '/bootstrap/dist/js/bootstrap.min.js'
  ]
};

function handleError(error) {
  return 'Error: ' + error.message;
};

/**
 * Move icons from font awesome component into public folder.
 */
gulp.task('icons', function() {
  return gulp.src(path.NODE + '/font-awesome/fonts/**.*')
    .pipe(gulp.dest(path.HTML + '/fonts'));
});

/**
 * CSS tasks.
 */
gulp
  .task('css', function() {
    return gulp.src(file.LESS)
      .pipe(less())
        .on('error', notify.onError(handleError))
      .pipe(rename('accard.css'))
      .pipe(gulp.dest(path.BUILD))
      .pipe(gulp.dest(path.DIST + '/css'));
  })
  .task('css-minify', ['css'], function() {
    return gulp.src(path.BUILD + '/accard.css')
      .pipe(minify())
        .on('error', notify.onError(handleError))
      .pipe(rename('accard.min.css'))
      .pipe(gulp.dest(path.DIST + '/css'));
  })
  .task('css-release', ['css-minify'], function() {
    return gulp.src([
      path.DIST + '/css/accard.css',
      path.DIST + '/css/accard.min.css'
    ])
      .pipe(gulp.dest(path.HTML + '/css'))
      .pipe(reload());
  })
;

/**
 * JS tasks.
 */
gulp
  .task('js-transform', function() {
    return gulp.src(file.JS)
      .pipe(react())
        .on('error', notify.onError(handleError))
      .pipe(babel())
      .pipe(jshint())
      .pipe(jshint.reporter('default'))
      .pipe(gulp.dest(path.BUILD + '/js'));
  })
  .task('js', ['js-transform'], function() {
    return gulp.src([
      path.BUILD + '/js/**/*.js',
      path.BUILD + '/js/*.js'
    ])
      .pipe(gulp.dest(path.DIST + '/js'));
  })
  .task('js-browserify', ['js'], function() {
    return gulp.src(file.JS_FRONT)
      .pipe(browserify({ insertGlobals: true }))
      .pipe(rename('accard.js'))
      .pipe(gulp.dest(path.DIST + '/js'));
  })
  .task('js-uglify', ['js-browserify'], function() {
    return gulp.src(path.DIST + '/js/accard.js')
      .pipe(uglify())
      .pipe(rename('accard.min.js'))
      .pipe(gulp.dest(path.DIST + '/js'));
  })
  .task('js-release', ['js-browserify', 'js-libs-release'], function() {
    return gulp.src([
      path.DIST + '/js/accard.js',
      path.DIST + '/js/accard.min.js'
    ])
      .pipe(gulp.dest(path.HTML + '/js'))
      .pipe(reload());
  })
  .task('js-libs-release', function() {
    return gulp.src(file.JS_LIBS)
      .pipe(gulp.dest(path.HTML + '/js/vendor'));
  })
  .task('js-uglify-release', ['js-uglify', 'js-release'])
;


/**
 * Watch files for auto builds.
 */
gulp
  .task('watch', function() {
    reload.listen();
    gulp.watch([
      path.LESS + '/*.less',
      path.LESS + '/**/*.less'
    ], ['css-release']);
    gulp.watch(file.JS, ['js-release']);
  })
;

/**
 * Clean up tasks.
 */
gulp
  .task('clean-dist', function() {
    return gulp.src(path.DIST).pipe(clean({ read: false, force: true }));
  })
  .task('clean-build', function() {
    return gulp.src(path.BUILD).pipe(clean({ read: false, force: true }));
  })
  .task('clean', ['clean-dist', 'clean-build']);

/**
 * Federated tasks.
 */
gulp
  .task('build', ['clean', 'icons', 'js-uglify', 'css-minify'])
  .task('development', ['build', 'css-release', 'js-uglify-release', 'watch'])
  .task('production', ['build', 'css-release', 'js-uglify-release'])
  .task('default', ['development']);
