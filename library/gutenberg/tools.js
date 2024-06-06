const fs = require( 'fs' )

const insertCharsetToFile = (file, charset = 'UTF-8') => {
	const content         = fs.readFileSync( file, 'utf8' );
	const newContent      = "@charset \"" + charset + "\";\n" + content;
	fs.writeFileSync( file, newContent, 'utf8' );
}

insertCharsetToFile( './dist/build/blocks.css' )
insertCharsetToFile( './dist/build/style-blocks.css' )
