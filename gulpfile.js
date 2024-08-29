// Cargamos los plugins
import { src, dest, watch, parallel } from 'gulp'
import sass from 'gulp-sass'
import postcss from 'gulp-postcss'
import autoprefixer from  'gulp-autoprefixer'
import cssnano from 'cssnano'
import sourcemaps from 'gulp-sourcemaps'
import concat from 'gulp-concat'
import terser from 'gulp-terser'


const paths = {
    scss: 'src/scss/**/*.scss',
    js: 'src/js/**/*.js'
}

// Create functions

// scss
function css() {
    return src(paths.scss, {sourcemaps: true})
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError)) // Compila SCSS a CSS, maneja errores de Sass
        .pipe(postcss([autoprefixer(), cssnano()])) // Procesa el CSS con PostCSS, aoto-prefixer y cssnano para minificar
        .pipe(sourcemaps.write('.')) // Escribe los mapas de origen en el mismo directorio que el CSS
        .pipe(dest('public/dist/css')) // Guarda el CSS en la carpeta de destino
}

// js
function js() {
    return src(paths.js, {sourcemaps: true})
        .pipe(sourcemaps.init()) // Inicia la generacion de mapas de origen
        .pipe(concat('bundle.js')) // Concatena todos los archivos JS en un solo archivo
        .pipe(terser()) // Minifica el JS
        .pipe(sourcemaps.write('.')) // Escribe los mapas de origen en el mismo directorio que el JS
        .pipe(rename({ suffix: '.min' })) // Agrega el sufijo .min al archivo para indicar que esta minificado
        .pipe(dest('public/dist/js')) // Guarda el JS en la carpeta de destino
}

function watchArchivos() {
    watch(paths.scss, css)
    watch(paths.js, js)
}

// Exporta la funcion para ser utilizada por gulp
exports.css = css;
exports.watchArchivos = watchArchivos
exports.default = parallel(css, js, watchArchivos)
