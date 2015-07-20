module.exports = function(grunt) {

  grunt.initConfig({

    pkg: grunt.file.readJSON('package.json'),

    watch: require('./grunt/watch'),

    less: require('./grunt/less'),

    coffee: require('./grunt/coffee'),

    copy: require('./grunt/copy'),

    // Вырезает из prod код, который необходим только для разработки
    strip_code: require('./grunt/strip_code'),

    // Собирает код страниц в соответсвующие бандлы
    browserify: require('./grunt/browserify'),

    // Минифицирует js (из кода к этому моменту уже должен быть вырезан код для разработки!)
    uglify: require('./grunt/uglify'),

    // Минимизирует css
    cssmin: require('./grunt/cssmin')
  });

  grunt.loadNpmTasks('grunt-contrib-coffee');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-watch');
//  grunt.loadNpmTasks('grunt-watchify');
  grunt.loadNpmTasks('grunt-strip-code');
  grunt.loadNpmTasks('grunt-browserify');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-cssmin');

//  grunt.loadNpmTasks('grunt-contrib-requirejs')
//  grunt.loadNpmTasks('grunt-contrib-jst')

//  // A very basic default task.
//  grunt.registerTask('default', function() {
//    grunt.log.write('Logging some stuff...').ok();
//  });


  grunt.registerTask('dev-js', ['coffee:build', 'copy:dev', 'browserify:build']);
  grunt.registerTask('dev-less', ['less:build']);
  grunt.registerTask('dev', ['dev-less', 'dev-js']);
  grunt.registerTask('prod', ['dev', 'copy:prod', 'cssmin:prod', 'strip_code:prod', 'uglify:prod']);
  grunt.registerTask('default', 'dev')

};