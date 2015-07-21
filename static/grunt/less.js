var helpers = require('./helpers');

var tasks = {
  build: {
    files: [{
      expand: true,
      flatten: false,
      cwd: 'src',
      src: ['*/bundles/**/style.less'],
      dest: 'build/dev',
      ext: '.css'
    }]
  }
};


module.exports = tasks;
