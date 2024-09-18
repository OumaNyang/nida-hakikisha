const gulp = require('gulp');
const terser = require('gulp-terser');
const concat = require('gulp-concat');
const rename = require('gulp-rename');

// Minify and Concatenate JavaScript files
gulp.task('minify', function() { 
  return gulp.src('assets/js/app.amplifier.js')           // Concatenate all JS files in assets/js/
    .pipe(concat('app.amplifier.bundle.js'))                   // Concatenate into a single file
    .pipe(terser())                              // Minify the concatenated file
    .pipe(rename({ extname: '.min.js' }))        // Rename output to bundle.min.js
    .pipe(gulp.dest('assets/js'));               // Output to assets/js
});

// Watch task to automate minification
gulp.task('watch', function() {
  gulp.watch('assets/js/app.amplifier.js', gulp.series('minify'));
});
