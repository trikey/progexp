const mix = require('laravel-mix');
const webpack = require('webpack');
const path = require('path');

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
  .sourceMaps()
  .version()
  .extract([
    'vue',
    'moment',
    'vee-validate',
    'vue-masked-input',
    'vue-resource',
    'lodash',
    'axios',
    'jquery',
  ])
  .sass('resources/sass/app.scss', 'public/css');


mix.webpackConfig({
  output: {
    filename: '[name].js',
    chunkFilename: '[name].js',
    publicPath: '/',
  },
  resolve: {
    alias: {
      _components: path.join(__dirname, 'resources', 'assets', 'js', 'components'),
      _resources: path.join(__dirname, 'resources', 'assets', 'js', 'resources'),
      _bus: path.join(__dirname, 'resources', 'assets', 'js', 'bus'),
      _mixins: path.join(__dirname, 'resources', 'assets', 'js', 'mixins'),
      _services: path.join(__dirname, 'resources', 'assets', 'js', 'services'),
    },
  },
  plugins: [
    new webpack.ContextReplacementPlugin(/moment[/\\]locale$/, /ru/),
    new webpack.ProvidePlugin({
      $: 'jquery',
      jQuery: 'jquery',
    }),
  ],
});
