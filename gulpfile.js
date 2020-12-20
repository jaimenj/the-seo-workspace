'use strict'

const gulp = require("gulp")
const { parallel } = require("gulp")
const sass = require("gulp-sass")
const cleanCss = require("gulp-clean-css")
const concat = require('gulp-concat')
const uglify = require('gulp-uglify-es').default
const sourcemaps = require('gulp-sourcemaps')
const rename = require('gulp-rename');

function css() {
    return gulp.src('./lib/tsw.scss')
        //.pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(cleanCss())
        .pipe(rename('tsw.min.css'))
        //.pipe(sourcemaps.write())
        .pipe(gulp.dest('./lib'))
}

function watchCss() {
    gulp.watch('./lib/tsw.scss', parallel('css'))
}

function js() {
    return gulp.src('./lib/tsw.js')
        //.pipe(sourcemaps.init())
        .pipe(uglify())
        .pipe(concat('tsw.min.js'))
        //.pipe(sourcemaps.write())
        .pipe(gulp.dest('./lib'))
}

function watchJs() {
    gulp.watch('./lib/tsw.js', parallel('js'))
}

exports.css = css
exports.js = js
exports.watch = gulp.parallel(watchCss, watchJs)
exports.default = this.watch
