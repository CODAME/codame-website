var gulp         = require('gulp')                    // gulp task runner
var watch        = require('gulp-watch')              // watch for files that change
var sass         = require('gulp-sass')               // compiles sass
var autoprefixer = require('gulp-autoprefixer')       // applies CSS vendor prefixes
var rename       = require('gulp-rename')             // renames files
var livereload   = require('gulp-livereload')         // reload browser when files change
var concat       = require('gulp-concat')             // concatenate scripts
var plumber      = require('gulp-plumber')            // keeps pipes working even when error var ppens
var notify       = require('gulp-notify')             // system notification when error happevar 

// paths to files that are used in the project
var paths = {
  styles:    './src/scss/**/*',
  pages:     './src/pages/**/*',
  rootFiles: ['./src/root-files/**/*','./src/root-files/**/.*'],
  admin:     './src/admin/**/*',
  dist:      './dist'  
}

// these tasks execute in order when you run gulp
gulp.task('default', ['styles', 'copy-files', 'watch', 'livereload-listen'])

/*

███████╗████████╗██╗   ██╗██╗     ███████╗███████╗
██╔════╝╚══██╔══╝╚██╗ ██╔╝██║     ██╔════╝██╔════╝
███████╗   ██║    ╚████╔╝ ██║     █████╗  ███████╗
╚════██║   ██║     ╚██╔╝  ██║     ██╔══╝  ╚════██║
███████║   ██║      ██║   ███████╗███████╗███████║
╚══════╝   ╚═╝      ╚═╝   ╚══════╝╚══════╝╚══════╝

*****************************************************/

// compiles scss files into one, starting from style.scss
// sass searches style.scss for import statements and includes those files
// also minifies resulting css and auto-prefixes for browser compatibility

gulp.task('styles', [], function(){

  // show notification on scss error

  var scssError = function(err){
    notify.onError({
      title:    err.relativePath,
      subtitle: 'Line '+err.line,
      message:  '<%= error.messageOriginal %>'
    })(err)
    this.emit('end')
  }

  // do the scss compilation

  gulp.src('./src/scss/imports.scss')
    .pipe(plumber({
        errorHandler: scssError
    }))
    .pipe(sass({outputStyle: 'compressed'}))
    .pipe(autoprefixer({
      browsers: ['last 10 versions'],
      cascade: false
    }))
    .pipe(rename('style.css'))
    .pipe(gulp.dest(paths.dist))
    .pipe(livereload())
})



/*

 ██████╗ ██████╗ ██████╗ ██╗   ██╗ 
██╔════╝██╔═══██╗██╔══██╗╚██╗ ██╔╝ 
██║     ██║   ██║██████╔╝ ╚████╔╝  
██║     ██║   ██║██╔═══╝   ╚██╔╝   
╚██████╗╚██████╔╝██║        ██║    
 ╚═════╝ ╚═════╝ ╚═╝        ╚═╝    
                                   
███████╗██╗██╗     ███████╗███████╗
██╔════╝██║██║     ██╔════╝██╔════╝
█████╗  ██║██║     █████╗  ███████╗
██╔══╝  ██║██║     ██╔══╝  ╚════██║
██║     ██║███████╗███████╗███████║
╚═╝     ╚═╝╚══════╝╚══════╝╚══════╝

****************************************/

gulp.task('copy-files', ['copy-pages', 'copy-root-files', 'copy-admin-files'])

gulp.task('copy-pages', function () {
  return gulp.src(paths.pages)
    .pipe(gulp.dest(paths.dist))
    .pipe(livereload())
})

gulp.task('copy-root-files', function () {
  return gulp.src(paths.rootFiles)
    .pipe(gulp.dest(paths.dist))
    .pipe(livereload())
})

gulp.task('copy-admin-files', function () {
  return gulp.src(paths.admin)
    .pipe(gulp.dest(paths.dist+'/admin'))
    .pipe(livereload())
})


/*

██╗    ██╗ █████╗ ████████╗ ██████╗██╗  ██╗
██║    ██║██╔══██╗╚══██╔══╝██╔════╝██║  ██║
██║ █╗ ██║███████║   ██║   ██║     ███████║
██║███╗██║██╔══██║   ██║   ██║     ██╔══██║
╚███╔███╔╝██║  ██║   ██║   ╚██████╗██║  ██║
 ╚══╝╚══╝ ╚═╝  ╚═╝   ╚═╝    ╚═════╝╚═╝  ╚═╝

**********************************************/

// gulp watches the filesystem for changes, then compiles/copies the according files

gulp.task('watch',['copy-files'], function(){
  
  watch(paths.styles,function(){
    gulp.start('styles')
  })

  watch(paths.pages,function(){
    gulp.start('copy-pages')
  })

  watch(paths.rootFiles,function(){
    gulp.start('copy-root-files')
  })

  watch(paths.admin,function(){
    gulp.start('copy-admin-files')
  })
  
})

// tell livereload to start listening for changed files
// when a file changes the browser reloads itself
gulp.task('livereload-listen', function(){
  livereload.listen()
})