var gulp = require("gulp");

var concat = require("gulp-concat");
var uglify = require("gulp-uglify");
var minifyCss = require("gulp-minify-css");
var autoprefixer = require("gulp-autoprefixer");
var sass = require('gulp-sass');

var fs = require('fs');
var exec = require('child_process').exec;

// Concatenate & Minify JS
var scripts = {
	main: [
		"assets/js/jpi/expandedSlideShow.js",
		"assets/js/jpi/slideShow.js",
		"assets/js/jpi/helpers.js",
		"assets/js/jpi/ajax.js",
		"assets/js/jpi/projects.js",
		"assets/js/jpi/home.js",
		"assets/js/jpi/form.js",
		"assets/js/jpi/stickyFooter.js",
		"assets/js/third-party/waypoint.min.js",
		"assets/js/third-party/jquery.countTo.js",
		"assets/js/jpi/nav.js",
		"assets/js/jpi/main.js"
	],
	admin: [
		"assets/js/jpi/helpers.js",
		"assets/js/jpi/stickyFooter.js",
		"assets/js/jpi/dragNDrop.js",
		"assets/js/jpi/nav.js",
		"assets/js/third-party/jquery-ui.min.js",
		"assets/js/third-party/sortable.js"
	]
};
var scriptNames = Object.keys(scripts);
scriptNames.forEach(function (key, i) {
	gulp.task("scripts-" + key, function () {
		return gulp.src(scripts[key])
				.pipe(concat(key + ".min.js"))
				.pipe(uglify())
				.pipe(gulp.dest("assets/js"));
	});
});
gulp.task("scripts", ["scripts-main", "scripts-admin"]);

// Minify Stylesheets
var stylesheets = {
	main: [
		"assets/css/style.css"
	]
};
var stylesheetNames = Object.keys(stylesheets);
stylesheetNames.forEach(function (key) {
	gulp.task("styles-" + key, function () {
		return gulp.src(stylesheets[key])
				.pipe(concat(key + ".min.css"))
				.pipe(autoprefixer({
					browsers: ["> 0.5%", "ie 8-11"],
					remove: false
				}))
				.pipe(minifyCss({
					compatibility: "ie8"
				}))
				.pipe(gulp.dest("assets/css"));
	});
});
gulp.task("styles", ["styles-main"]);

gulp.task('sass', function () {
	return gulp.src('assets/css/style.scss')
			.pipe(sass().on('error', sass.logError))
			.pipe(gulp.dest('assets/css/'));
});
// Watch Files For Changes
gulp.task('watch', function () {
	gulp.watch('assets/css/**/*.scss', ['sass']);
});

gulp.task("store-version", function() {

	var fileName = "assets/version.txt";

	var githubBaseUrl = "https://github.com/JahidulPabelIslam/Portfolio/";

	// Try to get current branch name
	exec("git branch | grep \\* | cut -d ' ' -f2", function (branchNameErr, branchName, branchNameStderr) {

		// If name found store in text file
		// If current branch if master we used use tags (As most likely this is in production environment)
		// Else it is one of dev branches so display branch name
		if (branchName && branchName !== "null" && branchName !== "master")
		{
			var string = "<a href='" + githubBaseUrl + "tree/" + branchName +"' target='_blank'>" + branchName + "</a>";
			fs.writeFile(fileName, string);
		}
		else
		{
			// Else just log errors & try to store latest tag name string in text file
			console.log(branchNameErr);
			console.log(branchName);
			console.log(branchNameStderr);

			// Try and get the latest tag on current branch
			exec("git describe --abbrev=0 --tags\n", function (tagNameErr, tagName, tagNameStderr) {

				// If found store in text file
				if (tagName && tagName !== "null")
				{
					var string = "<a href='" + githubBaseUrl + "releases/tag/" + tagName + "' target='_blank'>" + tagName + "</a>";
					fs.writeFile(fileName, string);
				}
				else
				{
					// Else log any errors
					console.log(tagNameErr);
					console.log(tagName);
					console.log(tagNameStderr);

					// Else drop back to branch name if exists else remove version value from file
					if (branchName && branchName !== "null")
					{
						fs.writeFile(fileName, branchName);
					}
					else
					{
						fs.writeFile(fileName, '');
					}
				}
			});
		}
	});
});

gulp.task("default", ["scripts", "styles"]);