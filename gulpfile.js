var gulp = require('gulp');
var concat = require('gulp-concat');
var minifyCSS = require('gulp-minify-css');
var cleanCSS = require('gulp-clean-css');
var clean = require('gulp-clean');
var runSequence = require('run-sequence');
var cssimport = require("gulp-cssimport");
var concatCss = require('gulp-concat-css');
var cssRetarget = require('gulp-cssretarget');

var root_dir = '../../..';

var header_styles = [
  '/wp-content/plugins/jck_woo_quickview/assets/frontend/css/main.css',
  '/wp-content/plugins/bloom/css/style.css',
  '/wp-content/plugins/contact-form-7/includes/css/styles.css',
  '/wp-content/plugins/revslider/public/assets/css/settings.css',
  '/wp-content/plugins/swift-framework/includes/page-builder/frontend-assets/css/spb-styles.css',
  '/wp-content/plugins/woocommerce-brands/assets/css/style.css',
  '/wp-content/plugins/woocommerce/assets/css/woocommerce-layout.css',
  '/wp-content/plugins/woocommerce/assets/css/woocommerce-smallscreen.css',
  '/wp-content/plugins/woocommerce/assets/css/woocommerce.css',
  '/wp-content/themes/atelier/style.css',
  '/wp-content/themes/atelier/css/sf-combined.css',
  '/wp-content/themes/atelier/css/responsive.css',
  '/wp-content/themes/cdnasyid-atelier/style.css',
].map(function(val) { return root_dir + val; });

gulp.task('test', function() {
  console.log(header_styles);
});

gulp.task('clean', function () {
  return gulp.src('dist', {read: false})
    .pipe(clean());
});

gulp.task('css', function() {
  gulp.src(header_styles)
    .pipe(cssRetarget({ root: root_dir }))
    .pipe(cleanCSS({
      keepSpecialComments: 0
    }))
    .pipe(concat('cdnasyid-base.min.css'))
    .pipe(gulp.dest('dist/css'));
});

// gulp.task('js', function() {
//   gulp.src(style_files)
//     .pipe(minifyCSS())
//     .pipe(concat('cdnasyid.min.css'))
//     .pipe(gulp.dest('dist/css'))
// });

gulp.task('build', function (cb) {
  runSequence(
    'clean',
    'css',
    cb
  );
});
