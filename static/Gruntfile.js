var path = require('path');
var _ = require('underscore');

/**
 * Путь для сборки страничных скриптов
 */
function prepareBuildPath(dest, src) {
  return dest + '/' + src.replace('/app/pages', '/pages');
}

/**
 * Правила преобразования алиасов в пути к блокам
 */
function blocksAliasFilter(src) {
  var match = src.match(/^(\S+)\/(blocks|blocks-modules|blocks-pages)\/(\S+)\.js/);

  if (!match) {
    return '';
  }

  var alias;
  var base = path.join(match[1], match[2]);
  var parts = match[3].split('/');

  // Блок или его модификатор
  if (parts.length === 2) {
    alias = path.join(base, parts[1]);
  }
  // Элемент или его модификатор
  else {
    alias = path.join(base, parts[0], parts[2].replace(parts[0] + '_', ''))
  }

//  console.log(alias, '->', src);

  return alias
}

function appAliasFilter(src, basedir) {
  var alias = src.replace('.js', '');
  if (/pages/.test(basedir)) {
    return ''
  }

//  console.log(alias, '->', src);

  return alias;
}

function memoizeAliasFilter(func) {
  var memFunc = _.memoize(func, function(src) {
    return src;
  });

  return memFunc
}


module.exports = function(grunt) {

  grunt.initConfig({

    pkg: grunt.file.readJSON('package.json'),

    watch: {
      less: {
        files: ['src/**/*.less'],
        tasks: ['dev-less'],
        options: {
          spawn: false
        }
      },
      js: {
        files: [
          'src/**/*.coffee',
          'src/**/*.js'
        ],
        tasks: ['dev-js'],
        options: {
          spawn: false
        }
      }
    },

    less: {
      build: {
        files: [{
          expand: true,
          flatten: false,
          cwd: 'src',
          src: ['*/app/pages/**/style.less'],
          dest: 'build/dev',
          ext: '.css',
          rename: prepareBuildPath
        }]
      }
    },

    coffee: {
      build: {
        files: [{
          expand: true,
          cwd: 'src',
          src: ['**/*.coffee'],
          dest: 'build/src',
          ext: '.js'
        }]
      }
    },

    copy: {
      build: {
        files: [{
          expand: true,
          flatten: false,
          cwd: 'src',
          src: ['**/*.js'],
          dest: 'build/src'
        }]
      }
    },

//    coffee: {
//      build: {
//        files: [{
//          expand: true,
//          cwd: 'src',
//          src: ['*/app/pages/**/script.coffee'],
//          dest: 'build/src',
//          ext: '.js',
//          rename: prepareBuildPath
//        }]
//      }
//    },
//
//    copy: {
//      build: {
//        files: [{
//          expand: true,
//          flatten: false,
//          cwd: 'src',
//          src: ['*/app/pages/**/script.js'],
//          dest: 'build/src',
//          rename: prepareBuildPath
//        }]
//      }
//    },

    browserify: {
      build: {
        options: {
//          aliasMappings: {
//            cwd: './src/backend',
//            src: ['blocks-modules/**/*.js']
//          },

          alias: {
//            'blocks-modules/backbone': './src/common/blocks-modules/backbone/backbone.js',
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
                filter: memoizeAliasFilter(blocksAliasFilter)
              }, {
              src: '**/app/**/*.js',
              cwd: 'build/src',
              filter: memoizeAliasFilter(appAliasFilter)
            }]
            ]
          ]
//          transform: ['coffeeify']
        },
        files: [{
          expand: true,
          cwd: 'build/src',
          src: [
//            '*/app/pages/**/script.coffee',
            '*/app/pages/**/script.js'
          ],
          dest: 'build/dev',
          rename: prepareBuildPath
        }]
      }
    },

    uglify: {
      options: {
        mangle: true, // Калечит имена
        beautify: {
          semicolons: true // Точка с запятой, вместо переноса строки (там где это возможно)
        }
      },
      build: {
        files: [{
          expand: true,
          cwd: 'build/dev',
          src: '**/script.js',
          dest: 'build/prod'
        }]
      }
    },

    cssmin: {
      build: {
        files: [{
          expand: true,
          cwd: 'build/dev',
          src: '**/style.css',
          dest: 'build/prod'
        }]
      }
    }

  });

  grunt.loadNpmTasks('grunt-contrib-coffee');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-watch');
//  grunt.loadNpmTasks('grunt-watchify');
  grunt.loadNpmTasks('grunt-browserify');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-cssmin');

//  grunt.loadNpmTasks('grunt-contrib-requirejs')
//  grunt.loadNpmTasks('grunt-contrib-jst')

//  // A very basic default task.
//  grunt.registerTask('default', function() {
//    grunt.log.write('Logging some stuff...').ok();
//  });


  grunt.registerTask('dev-js', ['coffee:build', 'copy:build', 'browserify:build']);
  grunt.registerTask('dev-less', ['less:build']);
  grunt.registerTask('dev', ['dev-less', 'dev-js']);
  grunt.registerTask('prod', ['dev', 'uglify:build', 'cssmin:build']);
  grunt.registerTask('default', 'dev')

};