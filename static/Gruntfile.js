/**
 * Путь для сборки страничных скриптов
 */
function preparePath() {
  return 'dev/' + arguments[1].replace('/app/pages', '/pages');
}

module.exports = function(grunt) {

  grunt.initConfig({

    pkg: grunt.file.readJSON('package.json'),

    watch: {
      less: {
        files: ['src/**/*.less'],
        tasks: ['less:dev'],
        options: {
          spawn: false
        }
      },
      coffee: {
        files: ['src/**/*.coffee'],
        tasks: ['coffee:dev'],
        options: {
          spawn: false
        }
      }
    },

    less: {
      dev: {
        files: [{
          expand: true,
          flatten: false,
          cwd: 'src',
          src: ['*/app/pages/**/style.less'],
//          dest: 'dev',
          ext: '.css',
          rename: preparePath
        }]
      }
    },

    coffee: {
      dev: {
        files: [{
          expand: true,
          flatten: false,
          cwd: 'src',
          src: ['*/app/pages/**/script.coffee'],
//          dest: 'dev',
          ext: '.js',
          rename: preparePath
        }]
      }
    }

  });

  grunt.loadNpmTasks('grunt-contrib-watch')
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-coffee')

//  grunt.loadNpmTasks('grunt-contrib-requirejs')
//  grunt.loadNpmTasks('grunt-contrib-jst')




//  // A very basic default task.
//  grunt.registerTask('default', function() {
//    grunt.log.write('Logging some stuff...').ok();
//  });


//  grunt.registerTask('default', ['less', 'coffee'])
  grunt.registerTask('default', ['less:dev', 'coffee:dev'])


};