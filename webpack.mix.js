const mix = require('laravel-mix');
const { VueLoaderPlugin } = require('vue-loader');

require('dotenv').config();

mix.js('resources/js/app.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .version()
  .browserSync('http://127.0.0.1:8000')
  .webpackConfig({
    module: {
      rules: [
        {
          test: /\.vue$/,
          loader: 'vue-loader'
        }
      ]
    },
    resolve: {
      extensions: ['.js', '.jsx', '.ts', '.tsx', '.vue', '.json'],
      alias: {
        '@': __dirname + '/resources/js',
      },
    },
    plugins: [
      new VueLoaderPlugin()
    ]
  });
