var gulp         = require('gulp'),
    sass         = require('gulp-sass'),
    cssnano      = require('gulp-cssnano'),
    autoprefixer = require('gulp-autoprefixer'),
    rename       = require('gulp-rename')

var paths = {
  styles: ['./scss/**/*']
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
});

gulp.task('watch', function(){
  gulp.watch(paths.styles, ['styles'])
})

gulp.task('default', ['styles','watch'])