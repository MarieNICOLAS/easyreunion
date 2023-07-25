const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');




/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.webpackConfig(webpack => {
    return {
        plugins: [
            new webpack.DefinePlugin({
                __VUE_OPTIONS_API__: true,
                __VUE_PROD_DEVTOOLS__: false,
            })
        ]
    }
});

let fs = require('fs');

let getFiles = function (dir) {
    // get all 'files' in this directory
    // filter directories
    return fs.readdirSync(dir).filter(file => {
        return fs.statSync(`${dir}/${file}`).isFile();
    });
};

getFiles('resources/js/pages/').forEach(function (filepath) {
    mix.js('resources/js/pages/' + filepath, 'public/js');
});


mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/admin.js', 'public/js')
    .js('resources/js/components/guest/catalogue', 'public/js')
    .js('resources/js/components/user/messaging', 'public/js')
    .js('resources/js/components/user/addresses', 'public/js')
    .js('resources/js/components/calendar', 'public/js')
    .js('resources/js/components/calendar/agenda-elements-editor', 'public/js')
    .js('resources/js/components/admin/booking-editor', 'public/js')
    .js('resources/js/components/admin/create-estimate', 'public/js')
    .js('resources/js/components/admin/dashboard', 'public/js')
    .js('resources/js/components/admin/estimates', 'public/js')
    .js('resources/js/components/admin/bookings', 'public/js')
    .js('resources/js/components/admin/settings', 'public/js')
    .js('resources/js/components/admin/estimate-editor', 'public/js')
    .js('resources/js/components/admin/partners-index/', 'public/js')
    .options({
        processCssUrls: false,
        postCss: [tailwindcss('./tailwind.config.js')]
    })
    .vue()
    .sass('resources/scss/app.scss', 'public/css')
    .sass('resources/scss/backoffice.scss', 'public/css')
    .copy('resources/images', 'public/images')
    .copy('resources/images/about', 'public/images/about')
    .copy('resources/images/home', 'public/images/home')
    .copy('resources/fonts/Poppins', 'public/fonts/Poppins')
    .version();
