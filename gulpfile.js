/*Load all plugin define in package.json*/
var gulp = require('gulp'),
	gulpLoadPlugins = require('gulp-load-plugins'),
	plugins = gulpLoadPlugins();

/*JS task*/
gulp.task('dist', function () {
	return gulp.src([ 'assets/js/admin.js' ])
		.pipe(plugins.jshint())
		.pipe(plugins.uglify())
		.pipe(plugins.concat('admin.min.js'))
		.pipe(gulp.dest('assets/js/'));
});

gulp.task('check-js', function () {
	return gulp.src('assets/js/admin.js')
		.pipe(plugins.jshint())
		.pipe(plugins.jshint.reporter('default'));
});

// On default task, just compile on demand
gulp.task('default', function() {
	gulp.watch('assets/js/*.js', [ 'check-js']);
});