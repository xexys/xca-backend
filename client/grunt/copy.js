var tasks = {
  // Копируем исходные js файлы без компиляции
  dev: {
    files: [{
      expand: true,
      flatten: false,
      cwd: 'src',
      src: ['**/*.js'],
      dest: 'build/src'
    }]
  },
  // Копируем весь dev в prod
  prod: {
    files: [{
      expand: true,
      flatten: false,
      cwd: 'build/dev',
      src: '**',
      dest: 'build/prod'
    }]
  }
};


module.exports = tasks;
