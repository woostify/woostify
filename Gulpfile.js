/**
 * Gulp file
 *
 * @package woostify
 */

'use strict';

let theme       = 'woostify',
	site_name   = 'woostify',
	theme_ver   = '1.2.2',
	gulp        = require( 'gulp' ),
	zip         = require( 'gulp-zip' ),
	babel       = require( 'gulp-babel' ),
	autoLoad    = require( 'gulp-load-plugins' )(),
	del         = require( 'del' ),
	wpPot       = require( 'gulp-wp-pot' ),
	browserSync = require( 'browser-sync' ),
	runSequence = require( 'run-sequence' ),
	sass        = require( 'gulp-sass' ),
	sourcemaps  = require( 'gulp-sourcemaps' ),
	globbing    = require( 'gulp-css-globbing' ),
	concat      = require( 'gulp-concat' ),
	uglify      = require( 'gulp-uglify' ),
	rename      = require( 'gulp-rename' ),
	vinylBuffer = require( 'vinyl-buffer' ),
	debug       = require( 'gulp-debug' );


// Sass `compressed` `expanded` `compact` `nested`.
gulp.task( 'sass', () =>
	gulp.src( 'style.scss' )
		.pipe( globbing( {
			extensions: [ '.scss' ]
		} ) )
		.pipe( sourcemaps.init() )
		.pipe( sass( { outputStyle: 'expanded' } )
		.on( 'error', sass.logError ) )
		.pipe( sourcemaps.write( '.' ) )
		.pipe( gulp.dest( '.' ) )
		.pipe( browserSync.reload( { stream: true } ) )
);

// Sass admin.
gulp.task( 'sass-admin', () =>
	gulp.src( ['assets/css/admin/**/*.scss', '!assets/css/admin/**/*.css'] )
		.pipe( globbing( {
			extensions: [ '.scss' ]
		} ) )
		.pipe( sass( { outputStyle: 'expanded' } )
		.on( 'error', sass.logError ) )
		.pipe( gulp.dest( 'assets/css/admin' ) )
);

// Handle console.
function handleError( e ) {
	console.log( e.toString() );
	this.emit( 'end' );
}

// Broswer sync task.
gulp.task( 'browser-sync', () =>
	browserSync( {
		files: 'style.css',
		proxy: "http://" + site_name + ".io",
		notify: false
	} )
);

// Create .post file.
gulp.task( 'pot', () => {
	gulp.src( '**/*.php' )
		.pipe( wpPot( {
			domain: theme,
			package: 'Woostify'
		} ) )
		.on( 'error', handleError )
		.pipe( gulp.dest( 'languages/' + theme + '.pot' ) );
} );


// Min js file.
gulp.task( 'min-js', () => {
	gulp.src( [ 'assets/js/**/*.js', '!assets/js/**/*.min.js'] )
		.pipe( uglify() )
		.on( 'error', err => { console.log( err ) } )
		.pipe( rename( { suffix: '.min' } ) )
		.pipe( gulp.dest( 'assets/js' ) );
} );

// Watch task.
gulp.task( 'watch', [ 'browser-sync' ], () => {
	gulp.watch( ['assets/css/sass/**/*.scss', 'style.scss' ], ['sass'] );
	gulp.watch( ['assets/css/admin/**/*.scss', '!assets/css/admin/**/*.css'], ['sass-admin'] );
	gulp.watch( ['assets/js/**/*.js', '!assets/js/**/*.min.js'], ['min-js'] );
	gulp.watch( '**/*.php', ['pot'] );
} );

// Zip task.
gulp.task( 'zip', () =>
	gulp.src([
		'**/*',
		'!./{node_modules,node_modules/**/*}',
		'!./*.cache',
		'!./*.log',
		'!./*.xml',
		'!./*.lock',
		'!./*.json',
		'!./*.map',
		'!./**/*.scss',
		'!./{assets/css/sass,assets/css/sass/**/*}',
		'!./Gulpfile.js'
	] )
	/*.pipe( debug( { title: 'src' } ) )*/
	.pipe( zip( theme + '-' + theme_ver + '.zip' ) )
	.pipe( gulp.dest( '.' ) )
);

// Default task.
gulp.task( 'default', ['watch', 'min-js'] );

// Clean.
gulp.task( 'clean', del.bind( null, ['build'] ) );
