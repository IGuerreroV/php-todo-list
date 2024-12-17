// Cargamos los plugins

import * as dartSass from "sass";

import { dest, parallel, src, watch } from "gulp";

import gulpBabel from "gulp-babel";
import gulpPlumber from "gulp-plumber";
import gulpSass from "gulp-sass";
import terser from "gulp-terser";

const sass = gulpSass(dartSass); // Cargamos gulp-sass y le pasamos la instancia de Sass

const paths = {
	scss: "src/scss/**/*.scss",
	js: "src/js/**/*.js",
};

// scss
export function css(done) {
	src(paths.scss, { sourcemaps: true })
		.pipe(gulpPlumber()) // Evita que se detenga la ejecucion en caso de errores
		.pipe(
			sass({
				outputStyle: "compressed",
				silenceDeprecations: ["legacy-js-api"],
			}).on("error", sass.logError),
		) // Compila el SCSS a CSS y lo minifica
		.pipe(dest("./public/dist/css")); // Guarda el CSS en la carpeta de destino
	done();
}

// js
export function js(done) {
	src(paths.js, { sourcemaps: true })
		.pipe(gulpPlumber()) // Evita que se detenga la ejecucion en caso de errores
		.pipe(gulpBabel({ presets: ["@babel/preset-env"] })) // Convierte el JS a ES5
		.pipe(terser()) // Minifica el JS
		.pipe(dest("public/dist/js")); // Guarda el JS en la carpeta de destino
	done();
}

export function dev() {
	watch(paths.scss, css);
	watch(paths.js, js);
}

// Exporta la funcion para ser utilizada por gulp
export default parallel(css, js, dev);
