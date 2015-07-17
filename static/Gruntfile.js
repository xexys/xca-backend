/**
 * Путь для сборки страничных скриптов
 */
function preparePath(dest, src) {
  return dest + '/' + src.replace('/app/pages', '/pages');
}

module.exports = function(grunt) {

  grunt.initConfig({

    pkg: grunt.file.readJSON('package.json'),

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
    }

  });

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-less');
//  grunt.loadNpmTasks('grunt-contrib-coffee');
//  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-browserify');

//  grunt.loadNpmTasks('grunt-contrib-requirejs')
//  grunt.loadNpmTasks('grunt-contrib-jst')

//  // A very basic default task.
//  grunt.registerTask('default', function() {
//    grunt.log.write('Logging some stuff...').ok();
//  });


//  grunt.registerTask('default', ['less', 'coffee'])
  grunt.registerTask('default', ['less:build', 'browserify:build'])



};