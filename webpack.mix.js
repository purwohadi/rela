const mix = require('laravel-mix')
const path = require("path")
require('laravel-mix-clean');

mix.options({
	hmrOptions: {
		host: process.env.DEV_URL,  // site's host name
		port: process.env.DEV_PORT,
	}
})

mix.disableNotifications()

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
// mix.config.fileLoaderDirs.fonts = 'webfonts'

/*
 |--------------------------------------------------------------------------
 | Mix Backend
 |--------------------------------------------------------------------------
 */
mix.js('resources/js/app.js', 'public/js')
// .js('resources/js/login.js', 'public/js')
	.sass('resources/sass/app.scss', 'public/css')
	.scripts('resources/parts/auth.js', 'public/js/parts/auth.js')
	.extract([
		"bootstrap",
		"bootstrap-vue",
		"jquery",
		// "esri-leaflet-geocoder",
	], 'public/js/vendor~bs.js')
	.extract([
		"@fullcalendar/daygrid",
		"@fullcalendar/interaction",
		"@fullcalendar/timegrid",
		"@fullcalendar/vue",
		"compressorjs",
		"exceljs",
		"file-saver",
		"typeface-poppins",
	], 'public/js/vendor~fc.js')
	.extract([
		"@syncfusion/ej2-vue-navigations",
	], 'public/js/vendor~sync.js')
	.extract([
		"sweetalert2",
		"lodash",
		"moment",
		"numeral",
		"popper.js",
		"axios",
		"vee-validate",
		"vue",
		"vue-cropperjs",
		"vue-form-wizard",
		"vue-i18n",
		"vue-multiselect",
		"vue-router",
		"vuex",
	], 'public/js/vendor~vue.js')


// theme asset backend
mix
	.scripts('resources/theme/smartadmin/dist/js/app.bundle.js', 'public/js/theme.js')
	.scripts([
		'resources/theme/smartadmin/dist/js/vendors.bundle.js',
		'resources/theme/smartadmin/dist/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js',
		'resources/theme/smartadmin/dist/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.id.min.js',
		'resources/theme/smartadmin/dist/js/statistics/peity/peity.bundle.js',
		'resources/theme/smartadmin/dist/js/formplugins/summernote/summernote.js',
		'resources/js/vendor/clockpicker/bootstrap4-clockpicker.min.js',
	], 'public/js/theme.vendor.js')
	.styles([
		'resources/theme/smartadmin/dist/css/vendors.bundle.css',
		'resources/theme/smartadmin/dist/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css',
		'resources/theme/smartadmin/dist/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css.map',
		'resources/theme/smartadmin/custom/skin/skin-master.css',
		'resources/theme/smartadmin/custom/app.bundle.css',
		'resources/theme/smartadmin/dist/css/fa-brands.css',
		'resources/theme/smartadmin/dist/css/fa-regular.css',
		'resources/theme/smartadmin/dist/css/fa-solid.css',
		'resources/theme/smartadmin/dist/css/formplugins/summernote/summernote.css',
		'resources/js/vendor/clockpicker/bootstrap4-clockpicker.min.css',
	], 'public/css/theme.css')
	.copyDirectory('resources/theme/smartadmin/dist/img/svg', 'public/img/svg')
	.copyDirectory('resources/theme/smartadmin/dist/webfonts', 'public/webfonts')
	.copyDirectory('resources/theme/smartadmin/dist/media/sound', 'public/media/sound')

/*
 |--------------------------------------------------------------------------
 | Mix Frontend
 |--------------------------------------------------------------------------
 */
mix.js('resources/js/auth.js', 'public/js')
	.styles([
		'resources/theme/smartadmin/dist/css/vendors.bundle.css',
		'resources/theme/smartadmin/dist/css/fa-brands.css',
		'resources/theme/smartadmin/dist/css/fa-regular.css',
		'resources/theme/smartadmin/dist/css/fa-solid.css',

	], 'public/css/theme~auth.css')

if (mix.inProduction()) {
	mix.options({
		terser: {
			terserOptions: {
				compress: {
					drop_console: true,
				}
			}
		}
	})
		.version()
}

// fix css files 404 issue
mix.webpackConfig({
	// add any webpack dev server config here
	resolve: {
		extensions: [".js", ".vue", ".json"],
		alias: {
			'@js': path.resolve(__dirname, "resources/js"),
			'@components': path.resolve(__dirname, "resources/js/components")
		},
	},
	devServer: {
		proxy: {
			host: process.env.DEV_HOST,  // host machine ip
			port: process.env.DEV_PORT,
		},
		watchOptions: {
			aggregateTimeout: process.env.DEV_TIMEOUT,
			poll: process.env.DEV_POLL
		},
	}
})
	.clean({
		cleanOnceBeforeBuildPatterns: ['./js/*'],
	})
