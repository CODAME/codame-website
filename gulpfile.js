var gulp         = require('gulp'),
    sass         = require('gulp-sass'),
    cssnano      = require('gulp-cssnano'),
    autoprefixer = require('gulp-autoprefixer'),
    rename       = require('gulp-rename'),
    livereload   = require('gulp-livereload')

var paths = {
  styles: ['./scss/**/*'],
  php:    ['./**/*.php']
};

gulp.task('styles', function(){
  return gulp.src('./scss/imports.scss')
    .pipe(sass({ style: 'compressed' }))
    .pipe(autoprefixer({
      browsers: ['last 2 versions'],
      cascade: false
    }))
    .pipe(cssnano())
    .pipe(rename('style.css'))
    .pipe(gulp.dest('./'))
    .pipe(livereload())
});

gulp.task('livereload-listen', function(){
  livereload.listen()
});

gulp.task('reload',  function() {
  console.log('reloading.....')
  livereload.reload();
});

gulp.task('watch', function(){
  gulp.watch(paths.styles, ['styles'])
  gulp.watch(paths.php, ['reload'])
})

gulp.task('default', ['styles','livereload-listen','watch'])