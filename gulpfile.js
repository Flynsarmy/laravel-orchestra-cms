var gulp = require('gulp'),
	autoprefixer = require('gulp-autoprefixer'),
	notify = require('gulp-notify'),
	sass = require('gulp-ruby-sass'),
	uglify = require('gulp-uglify'),
	jshint = require('gulp-jshint'),
	bower = require('gulp-bower'),
	csslint = require('gulp-csslint'),
	gutil = require('gulp-util'),
	exec = require('child_process').exec,
	sys = require('sys');

// My asset directories
var sassFiles = 'assets/sass/**/*.scss',
	jsFiles = 'assets/js/**/*.js',
	bowerFile = './bower.json',
	phpFiles = ['src/**/*.php', 'tests/**/*.php'];
	// Compiled asset directories
	targetAssetDir = 'public',
	targetCSSDir = targetAssetDir+'/css',
	targetJSDir = targetAssetDir+'/js',
	targetBowerDir = targetAssetDir+'/vendor';

// CSS
gulp.task('css', function() {
	return gulp.src(sassFiles)
		.pipe(sass({ style: 'compressed' }).on('error', gutil.log))
		.pipe(csslint({
			'adjoining-classes': false // This only affects <= IE6
		}))
		.pipe(csslint.reporter())
		.pipe(autoprefixer('last 10 versions', 'ie 8'))
		.pipe(gulp.dest(targetCSSDir))
		.pipe(notify({ message: 'CSS all done, master!' }));
});

// Javascript
gulp.task('js', function() {
	return gulp.src(jsFiles)
		.pipe(jshint())
		.pipe(jshint.reporter('default'))
		.pipe(uglify())
		.pipe(gulp.dest(targetJSDir))
		.pipe(notify({ message: 'JS all done, master!' }));
});
gulp.task('bower', function() {
	bower()
    	.pipe(gulp.dest(targetBowerDir));
});

// Unit tests
gulp.task('phpunit', function() {
	exec('phpunit', function(error, stdout) {
		sys.puts(stdout);
	});
});

// Watch for changes and recompile
gulp.task('watch', function() {
	gulp.watch(sassFiles, ['css']);
	gulp.watch(jsFiles, ['js']);
	gulp.watch(bowerFile, ['bower']);
	gulp.watch(phpFiles, ['phpunit']);
});

gulp.task('default', ['css', 'js', 'bower', 'phpunit', 'watch']);