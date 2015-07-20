var tasks = {
  prod: {
    files: [{
      expand: true,
      src: 'build/prod/**/style.css'
    }]
  }
};


module.exports = tasks;