var tasks = {
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
};


module.exports = tasks;