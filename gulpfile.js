var gulp = require('gulp'),
    sass = require('gulp-ruby-sass'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    minifyCSS = require('gulp-minify-css'),
    jshint = require('gulp-jshint'),
    rename = require('gulp-rename'),
    size = require('gulp-size'),
    stripDebug = require('gulp-strip-debug'),
    sourcemaps = require('gulp-sourcemaps'),
    pkg = require('./package.json');

var paths = {
  styles: './css/style.scss',
  scripts: ['./bower_components/gsap/src/uncompressed/TweenMax.js', './bower_components/validationEngine/js/languages/jquery.validationEngine-en.js', './bower_components/validationEngine/js/jquery.validationEngine.js', './bower_components/bootstrap-datepicker/js/bootstrap-datepicker.js', './bower_components/plupload/js/plupload.full.min.js', './bower_components/slick-carousel/slick/slick.js', './js/StackBlur.js', './js/main.js']
};

gulp.task('styles', ['components'], function() {
  return sass(paths.styles, { sourcemap: false })
  .on('error', function (err) {
    console.error('Error', err.message);
  })
  .pipe(rename('app.css'))
  .pipe(gulp.dest('./css/'))
  .pipe(rename('app.min.css'))
  .pipe(minifyCSS())
  .pipe(sourcemaps.write())
  .pipe(size())
  .pipe(gulp.dest('./css/'));
});

gulp.task('components', function() {
  return gulp.src(['./bower_components/normalize.css/normalize.css'])
  .pipe(rename('_normalize.scss'))
  .pipe(gulp.dest('./bower_components/normalize.css/'));
});

gulp.task('scripts', ['lint', 'plugins'], function() {
  gulp.src(paths.scripts)
    .pipe(concat('app.js'))
    .pipe(gulp.dest('./js/'))
    .pipe(rename('app.min.js'))
    //.pipe(stripDebug())
    .pipe(uglify({ preserveComments: 'some' }))
    .pipe(size())
    .pipe(gulp.dest('./js/'));
});

gulp.task('plugins', function() {
  return gulp.src(['./bower_components/jquery/dist/jquery.min.js'])
  .pipe(rename('jquery.min.js'))
  .pipe(gulp.dest('./js/'));
});

gulp.task('lint', function () {
  return gulp.src('./js/main.js')
    .pipe(jshint('.jshintrc'))
    .pipe(jshint.reporter('jshint-stylish'));
});

// Rerun the task when a file changes
gulp.task('watch', function() {
  gulp.watch('./js/main.js', ['scripts']);
  gulp.watch('./css/*.scss', ['styles']);
  gulp.watch(['*.html'], ['html']);
});

// The default task (called when you run `gulp` from cli)
gulp.task('default', ['styles', 'scripts']);
