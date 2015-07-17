/**
 * Путь для сборки страничных скриптов
 */
function preparePath(dest, src) {
  return dest + '/' + src.replace('/app/pages', '/pages');
}

module.exports = function(grunt) {

  grunt.initConfig({

    pkg: grunt.file.readJSON('package.json'),

    // @link: https://github.com/gruntjs/grunt-contrib-watch
    watch: {
      less: {
        files: ['src/**/*.less'],
        tasks: ['less:build'],
        options: {
          spawn: false
        }
      },
      js: {
        files: [
          'src/**/*.coffee',
          'src/**/*.js'
        ],
        tasks: ['browserify:build'],
        options: {
          spawn: false
        }
      }
    },

    // @link https://github.com/gruntjs/grunt-contrib-less
    less: {
      build: {
        files: [{
          expand: true,
          flatten: false,
          cwd: 'src',
          src: ['*/app/pages/**/style.less'],
          dest: 'build/dev',
          ext: '.css',
          rename: preparePath
        }]
      }
    },

//    coffee: {
//      dev: {
//        files: [{
//          expand: true,
//          flatten: false,
//          cwd: 'src',
//          src: ['*/app/pages/**/script.coffee'],
//          dest: 'build/src',
//          ext: '.js',
//          rename: preparePath
//        }]
//      }
//    },
//
//    copy: {
//      dev: {
//        files: [{
//          expand: true,
//          flatten: false,
//          cwd: 'src',
//          src: ['*/app/pages/**/script.js'],
//          dest: 'build/src',
//          rename: preparePath
//        }]
//      }
//    },

    // @link https://github.com/jmreidy/grunt-browserify
    browserify: {
      build: {
        options: {
          transform: ['coffeeify']
        },
        files: [{
          expand: true,
          cwd: 'src',
          src: [
            '*/app/pages/**/script.coffee',
            '*/app/pages/**/script.js'
          ],
          dest: 'build/dev',
          ext: '.js',
          rename: preparePath
        }]
      }
    },

    // @link: https://github.com/gruntjs/grunt-contrib-uglify
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

    // @link: https://github.com/gruntjs/grunt-contrib-cssmin
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

//  grunt.loadNpmTasks('grunt-contrib-coffee');
//  grunt.loadNpmTasks('grunt-contrib-copy');
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


  grunt.registerTask('dev', ['less:build', 'browserify:build']);
  grunt.registerTask('prod', ['dev', 'uglify:build', 'cssmin:build']);
  grunt.registerTask('default', 'dev')

};