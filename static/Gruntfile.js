module.exports = function(grunt) {

  grunt.initConfig({

    pkg: grunt.file.readJSON('package.json'),

    watch: {
      less: {
        files: ['src/**/*.less'],
        tasks: ['less:development'],
        options: {
          spawn: false
        }
      }
    },

    less: {
      development: {
        options: {
          inlineCSS: false
        },
        files: [{
          expand: true,
          flatten: false,
          cwd: 'src',
          src: ['*/pages/**/style.less'],
          rename: function() {
            return 'dev/' + arguments[1].replace('/style.less', '.css');
          }
        }]
      }
    }

  });

  grunt.loadNpmTasks('grunt-contrib-watch')
  grunt.loadNpmTasks('grunt-contrib-less');

//  grunt.loadNpmTasks('grunt-contrib-coffee')
//  grunt.loadNpmTasks('grunt-contrib-requirejs')
//  grunt.loadNpmTasks('grunt-contrib-jst')




//  // A very basic default task.
//  grunt.registerTask('default', function() {
//    grunt.log.write('Logging some stuff...').ok();
//  });


//  grunt.registerTask('default', ['less', 'coffee'])
  grunt.registerTask('default', ['less:development'])


};