'use strict';

let theme       = 'woostify',
    site_name   = 'wootify',
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
    buffer      = require( 'vinyl-buffer' );


/* SASS: `compressed` `expanded` `compact` `nested` */
gulp.task( 'sass', () =>
    gulp.src( 'style.scss' )
        .pipe( globbing({
            extensions: ['.scss']
        }))
        .pipe( sourcemaps.init() )
        .pipe( sass( { outputStyle: 'expanded' } ).on( 'error', sass.logError ) )
        .pipe( sourcemaps.write( '.' ) )
        .pipe( gulp.dest( '.' ) )
);

/* CONSOLE */
function handleError ( e ) {
    console.log( e.toString() );
    this.emit( 'end' );
}

/* BROSWER SYNC */
gulp.task( 'browser-sync', () =>
    browserSync({
        files: 'style.css',
        proxy: "http://" + site_name + ".ss"
    })
);

/* CREATE .POT FILE */
gulp.task( 'pot', () => {
    gulp.src( '**/*.php' )
        .pipe( wpPot( {
            domain: theme,
            package: 'Haintheme'
        } ) )
        .on( 'error', handleError )
        .pipe( gulp.dest( 'languages/' + theme + '.pot' ) );
} );

/* CLEAN */
gulp.task( 'clean', del.bind( null, ['build'] ) );

/* .POT */
gulp.task( 'createPot', ['browser-sync'], () => {
    gulp.watch( '**/*.php', ['pot'] );
});

/*WATCH*/
gulp.task( 'watch', ['browser-sync'], () => {
    gulp.watch( ['assets/css/sass/**/*.scss', 'style.scss'], ['sass'] );
});

/* DEFAULT TASK */
gulp.task( 'default', ['watch'] );