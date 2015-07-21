var helpers = require('./helpers');

var tasks = {
  build: {
    options: {
//          aliasMappings: {
//            cwd: './src/backend',
//            src: ['blocks-modules/**/*.js']
//          },

      alias: {
        'backend/app': './build/src/backend/app/app.js'
//            'blocks-modules/marionette': './src/common/blocks-modules/marionette/marionette.js'

//            'backbone': './src/backend/blocks-modules/backbone/backbone.js'
//            'marionette': './src/backend/blocks-modules/marionette/marionette.js'
      },

//          require: [
//            ['./src/backend/blocks-modules/backbone/backbone.js', {expose: 'backbone'}]
//          ],

      plugin: [
        ['remapify', [{
              src: '**/*',
              cwd: 'build/src',
              filter: helpers.blocksAliasFilter
            }, {
              src: '**/app/**/*.js',
              cwd: 'build/src',
              filter: helpers.appAliasFilter
            }]
        ]
      ]
//          transform: ['coffeeify']
    },
    files: [{
      expand: true,
      cwd: 'build/src',
      src: '*/bundles/**/script.js',
      dest: 'build/dev'
    }]
  }
};


module.exports = tasks;
