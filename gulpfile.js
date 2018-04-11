var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var sourcemaps = require('gulp-sourcemaps');
var jshint = require('gulp-jshint');
var concat = require('gulp-concat');
var minify = require('gulp-cssnano');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var imagemin = require('gulp-imagemin');
var plumber = require('gulp-plumber');
var notify = require('gulp-notify');
var livereload = require('gulp-livereload');
var changed = require('gulp-changed');
var svgmin = require('gulp-svgmin');
var sourcemaps = require('gulp-sourcemaps');

var fs = require('node-fs');

var fse = require('fs-extra');
var json = require('json-file');

var plugins = require('gulp-load-plugins')({
    camelize: true
  }),
  lr = require('tiny-lr'),
  server = lr();


// Lint Task
gulp.task('lint', function() {
  gulp.src(['js/*.js',
      'themes/parallax-pro/js/*.js'
    ])
    .pipe(plumber(plumberErrorHandler))
    .pipe(jshint())
    .pipe(jshint.reporter('default'))
    .pipe(plugins.notify({
      message: 'Lint task complete'
    }));
});

var gulp = require('gulp');

gulp.task('svgmin', function() {
  return gulp.src('img/*.svg')
    .pipe(svgmin())
    .pipe(gulp.dest('img/dist'));
});

gulp.task('sass', function() {
  gulp.src('sass/parallaxchild-styles.scss')
    .pipe(plumber(plumberErrorHandler))
    .pipe(sourcemaps.init()) // Process the original sources
    .pipe(sass())
    .pipe(autoprefixer())
    .pipe(minify())
    .pipe(sourcemaps.write()) // Add the map to modified source.
    .pipe(gulp.dest(""))
    .pipe(plugins.notify({
      message: 'Styles task complete'
    }));

});


gulp.task('plugin-scripts', function() {
  gulp.src('*.js')
    .pipe(plumber(plumberErrorHandler))
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(uglify())
    .pipe(gulp.dest('js/'))
    .pipe(plugins.notify({
      message: 'Scripts task complete'
    }));
});

gulp.task('images', function() {

  gulp.src('img/*.{png,jpg,gif}')
    .pipe(plumber(plumberErrorHandler))
    .pipe(changed('img/'))
    .pipe(plugins.imagemin({
      optimizationLevel: 7,
      progressive: true,
      interlaced: true
    }))
    .pipe(gulp.dest('../images'))
    .pipe(livereload())
    .pipe(plugins.notify({
      message: 'Images task complete'
    }));

});

/* Error Handler */
var plumberErrorHandler = {
  errorHandler: notify.onError({
    title: 'Gulp',
    message: 'Error: <%= error.message %>'
  })

};


// Watch Files For Changes
gulp.task('watch', function() {

  gulp.watch('*.svg', ['svgmin']);
  gulp.watch('sass/*.scss', ['sass']);
  gulp.watch('*.js', ['plugin-scripts']);
  gulp.watch('plugins/parallaxchild/*.js', ['plugin-scripts']);

});

// Default task
gulp.task('default', ['watch']);
