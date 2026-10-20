const { readFileSync } = require( 'node:fs' );
const path = require( 'node:path' );

const projectRoot = path.resolve( __dirname, '..' );
const read = ( filename ) =>
	readFileSync( path.join( projectRoot, filename ), 'utf8' );
const packageJson = JSON.parse( read( 'package.json' ) );
const packageLock = JSON.parse( read( 'package-lock.json' ) );
const version = packageJson.version;
const tag = process.argv[ 2 ];

if ( ! /^\d+\.\d+\.\d+$/.test( version ) || tag !== `v${ version }` ) {
	throw new Error( `Expected release tag v${ version }, received ${ tag }.` );
}

const plugin = read( 'wdevs-gallery-swiper.php' );
const versions = {
	'package-lock.json': packageLock.version,
	'package-lock.json root package': packageLock.packages[ '' ].version,
	'plugin header': plugin.match( /^\s*\* Version:\s*(\S+)/m )?.[ 1 ],
	'plugin version constant': plugin.match(
		/define\(\s*'WDEVS_GALLERY_SWIPER_VERSION',\s*'([^']+)'/
	)?.[ 1 ],
	'README.txt stable tag':
		read( 'README.txt' ).match( /^Stable tag:\s*(\S+)/m )?.[ 1 ],
};

for ( const [ source, value ] of Object.entries( versions ) ) {
	if ( value !== version ) {
		throw new Error(
			`${ source } must be ${ version }, received ${ value }.`
		);
	}
}

const section = read( 'CHANGELOG.md' )
	.split( /^## /m )
	.find( ( entry ) => entry.startsWith( `[${ version }] - ` ) );
const notes = section?.split( '\n' ).slice( 1 ).join( '\n' ).trim();

if ( ! notes ) {
	throw new Error( `Missing changelog entry for ${ version }.` );
}

process.stdout.write( `${ notes }\n` );
