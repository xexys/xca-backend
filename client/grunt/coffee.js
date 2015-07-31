var tasks = {
  build: {
    files: [{
      expand: true,
      cwd: 'src',
      src: ['**/*.coffee'],
      dest: 'build/src',
      ext: '.js'
    }]
  }
};


module.exports = tasks;
