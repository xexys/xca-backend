var tasks = {
  prod: {
    options: {
      mangle: true, // Калечит имена
      beautify: {
        semicolons: true // Точка с запятой, вместо переноса строки (там где это возможно)
      }
    },
    files: [{
      expand: true,
      src: 'build/prod/**/script.js'
    }]
  }
};


module.exports = tasks;
