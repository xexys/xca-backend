var helpers = require('./helpers');

var tasks = {
  build: {
    files: [{
      expand: true,
      flatten: false,
      cwd: 'src',
      src: ['*/app/pages/**/style.less'],
      dest: 'build/dev',
      ext: '.css',
      rename: helpers.prepareBuildPath
    }]
  }
};


module.exports = tasks;
