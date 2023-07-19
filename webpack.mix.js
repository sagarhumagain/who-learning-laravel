require('dotenv').config();

const mix = require('laravel-mix');
const webpack = require('webpack');

const dotenvplugin = new webpack.DefinePlugin({
  'process.env': {
    APP_NAME: JSON.stringify(process.env.APP_NAME || 'Default app name'),
    NODE_ENV: JSON.stringify(process.env.NODE_ENV || 'development'),
    APP_URL: JSON.stringify(process.env.APP_URL || 'http://localhost:8000'),
  },
});

mix
  .webpackConfig({
    plugins: [dotenvplugin],
  })
  .webpackConfig({
    module: {
      rules: [
        {
          test: /\.tsx?$/,
          use: {
            loader: 'ts-loader',
            options: {
              appendTsSuffixTo: [/\.vue$/],
            },
          },
          exclude: /node_modules/,
        },
      ],
    },
    resolve: {
      extensions: ['.js', '.jsx', '.vue', '.ts', '.tsx', '.json'],
      alias: {
        // 'vue$': 'vue/dist/vue.esm.js',
        '@': `${__dirname}/resources/js`,
      },
    },
  });

mix
  .js('resources/js/app.js', 'public/js')
  .vue({ version: 3 }) // Use the appropriate Vue version (e.g., Vue 2 or Vue 3)
  .sass('resources/sass/app.scss', 'public/css')
  .version()
  .browserSync('http://127.0.0.1:8000');
