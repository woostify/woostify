/**
 * Gulp file
 *
 * @package woostify
 */

'use strict';

let theme       = 'woostify',
	site_name   = 'woostify',
	gulp        = require( 'gulp' ),
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
	vinylBuffer = require( 'vinyl-buffer' );


/* SASS: `compressed` `expanded` `compact` `nested` */
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

/* SASS: Admin */
gulp.task( 'sass-admin', () =>
	gulp.src( ['assets/css/admin/**/*.scss', '!assets/css/admin/**/*.css'] )
		.pipe( globbing( {
			extensions: [ '.scss' ]
		} ) )
		.pipe( sass( { outputStyle: 'expanded' } )
		.on( 'error', sass.logError ) )
		.pipe( gulp.dest( 'assets/css/admin' ) )
);

/* CONSOLE */
function handleError( e ) {
	console.log( e.toString() );
	this.emit( 'end' );
}

/* BROSWER SYNC */
gulp.task( 'browser-sync', () =>
	browserSync( {
		files: 'style.css',
		proxy: "http://" + site_name + ".io"
	} )
);

/* CREATE .POT FILE */
gulp.task( 'pot', () => {
	gulp.src( '**/*.php' )
		.pipe( wpPot( {
			domain: theme,
			package: 'Woostify'
		} ) )
		.on( 'error', handleError )
		.pipe( gulp.dest( 'languages/' + theme + '.pot' ) );
} );


/* MIN JS FILE */
gulp.task( 'min-js', () => {
	gulp.src( [ 'assets/js/**/*.js', '!assets/js/**/*.min.js'] )
		.pipe( uglify() )
		.on( 'error', err => { console.log( err ) } )
		.pipe( rename( { suffix: '.min' } ) )
		.pipe( gulp.dest( 'assets/js' ) );
} );

/*WATCH*/
gulp.task( 'watch', [ 'browser-sync' ], () => {
	gulp.watch( ['assets/css/sass/**/*.scss', 'style.scss' ], ['sass'] );
	gulp.watch( ['assets/css/admin/**/*.scss', '!assets/css/admin/**/*.css'], ['sass-admin'] );
	gulp.watch( ['assets/js/**/*.js', '!assets/js/**/*.min.js'], ['min-js'] );
	gulp.watch( '**/*.php', ['pot'] );
} );

/* DEFAULT TASK */
gulp.task( 'default', ['watch', 'min-js'] );

/* CLEAN */
gulp.task( 'clean', del.bind( null, ['build'] ) );
