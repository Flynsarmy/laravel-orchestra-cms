var gulp = require('gulp'),
	gulpLoadPlugins = require("gulp-load-plugins"),
	$ = gulpLoadPlugins({
		lazy: false, // whether the plugins should be lazy loaded on demand
	});

// My asset directories
var sassFiles = 'assets/sass/**/*.scss',
	jsFiles = 'assets/js/**/*.js',
	imgFiles = 'assets/img/**/*.{png,gif,jpg,jpeg}',
	bowerFile = './bower.json',
	phpFiles = ['src/**/*.php', 'tests/**/*.php'];
	// Compiled asset directories
	targetAssetDir = 'public',
	targetCSSDir = targetAssetDir+'/css',
	targetJSDir = targetAssetDir+'/js',
	targetImgDir = targetAssetDir+'/img',
	targetBowerDir = targetAssetDir+'/vendor';

// CSS
gulp.task('css', function() {
	return gulp.src(sassFiles)
		.pipe($.plumber())
		.pipe($.rubySass({ style: 'compressed' }).on('error', $.util.log).on('error', $.notify.onError({
			title: "Failed compiling SASS!",
			message: "<%= error.message %>"
		})))
		.pipe($.csslint({
			'adjoining-classes': false // This only affects <= IE6
		}))
		.pipe($.csslint.reporter())
		.pipe($.autoprefixer('last 10 versions', 'ie 8'))
		.pipe($.size({
			showFiles: true
		}))
		.pipe(gulp.dest(targetCSSDir));
});

// Javascript
gulp.task('js', function() {
	return gulp.src(jsFiles)
		.pipe($.jshint())
		.pipe($.jshint.reporter('default'))
		.pipe($.uglify())
		.pipe($.size({
			showFiles: true
		}))
		.pipe(gulp.dest(targetJSDir));
});
gulp.task('bower', function() {
	$.bower()
		.pipe(gulp.dest(targetBowerDir));
});

// Images
gulp.task('images', function () {
	return gulp.src(imgFiles)
		.pipe($.cache($.imagemin({
			optimizationLevel: 3,
			progressive: true,
			interlaced: true
        })))
		.pipe($.size({
			showFiles: true
		}))
		.pipe(gulp.dest(targetImgDir));
});

// Unit tests
gulp.task('phpunit', function() {
	var options = {debug: false, notify: true};
	gulp.src('tests/**/*.php')
		.pipe($.phpunit('phpunit', options)).on('error', $.notify.onError({
			title: "Failed Tests!",
			message: "Error(s) occurred during testing..."
		}));
});

// Watch for changes and recompile
gulp.task('watch', function() {
	gulp.watch(sassFiles, ['css']);
	gulp.watch(jsFiles, ['js']);
	gulp.watch(bowerFile, ['bower']);
	gulp.watch(imgFiles, ['images']);
	gulp.watch(phpFiles, ['phpunit']);
});

gulp.task('default', ['css', 'js', 'bower', 'images', 'phpunit', 'watch']);