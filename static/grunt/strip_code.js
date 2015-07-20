var tasks = {
  prod: {
    options: {
      start_comment: 'dev-code-start',
      end_comment: 'dev-code-end'
    },
    files: [{
      src: 'build/prod/**/*.js'
    }]
  }
};


module.exports = tasks;