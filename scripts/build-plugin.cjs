const { readdirSync } = require( 'node:fs' );
const path = require( 'node:path' );
const AdmZip = require( 'adm-zip' );

const projectRoot = path.resolve( __dirname, '..' );
const slug = 'product-gallery-swiper-for-woocommerce';
const archive = new AdmZip();

function addDirectory( directory ) {
	const entries = readdirSync( path.join( projectRoot, directory ), {
		withFileTypes: true,
	} ).sort( ( first, second ) => first.name.localeCompare( second.name ) );

	for ( const entry of entries ) {
		const relativePath = path.posix.join( directory, entry.name );

		if ( entry.isDirectory() ) {
			addDirectory( relativePath );
		} else if ( entry.isFile() && ! /\.md$/i.test( entry.name ) ) {
			addFile( relativePath );
		}
	}
}

function addFile( relativePath ) {
	archive.addLocalFile(
		path.join( projectRoot, relativePath ),
		path.posix.join( slug, path.posix.dirname( relativePath ) )
	);
}

for ( const directory of [ 'admin', 'includes', 'languages', 'public' ] ) {
	addDirectory( directory );
}

for ( const file of [
	'wdevs-gallery-swiper.php',
	'index.php',
	'uninstall.php',
	'README.txt',
	'LICENSE.txt',
	'blueprint.json',
] ) {
	addFile( file );
}

const filename = `${ slug }.zip`;
archive.writeZip( path.join( projectRoot, filename ) );
console.log( `Built ${ filename } (${ archive.getEntryCount() } files).` );
