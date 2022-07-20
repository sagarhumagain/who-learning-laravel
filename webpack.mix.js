require('dotenv').config();
let webpack = require('webpack');
const mix = require('laravel-mix');

let dotenvplugin = new webpack.DefinePlugin({
    'process.env': {
        APP_NAME: JSON.stringify(process.env.APP_NAME || 'Default app name'),
        NODE_ENV: JSON.stringify(process.env.NODE_ENV || 'development'),
        APP_URL: JSON.stringify(process.env.APP_URL || 'http://localhost:8000'),
    }
});


mix.webpackConfig({
    plugins: [
        dotenvplugin,
    ]
});
mix.webpackConfig({
  module: {
    rules: [
      {
        test: /\.tsx?$/,
        loader: "ts-loader",
        options: { appendTsSuffixTo: [/\.vue$/] },
        exclude: /node_modules/
      }
    ]
  },
  resolve: {
    extensions: [".js", ".jsx", ".vue", ".ts", ".tsx", ".json"],
    alias: {
      // 'vue$': 'vue/dist/vue.esm.js',
      '@': __dirname + '/resources/js'
    },
  },
})

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

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css').version()
    .browserSync('http://127.0.0.1:8000');
