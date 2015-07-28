var path = require('path');
var _ = require('underscore');

function memoizeAliasFilter(func) {
  var memFunc = _.memoize(func, function(src) {
    return src;
  });

  return memFunc
}

/**
 * Правила преобразования алиасов в пути к блокам
 */
function blocksAliasFilter(src) {
  var match = src.match(/^(\S+)\/(blocks|blocks-widgets|blocks-modules|blocks-pages)\/(\S+)\.js/);

  if (!match) {
    return '';
  }

  var alias;
  var base = path.join(match[1], match[2]);
  var parts = match[3].split('/');

  // Блок или его модификатор
  if (parts.length === 2) {
    alias = path.join(base, parts[1]);
  }
  // Элемент или его модификатор
  else {
    alias = path.join(base, parts[0], parts[2].replace(parts[0] + '_', ''))
  }

//  console.log(alias, '->', src);

  return alias
}

function appAliasFilter(src, basedir) {
  var alias = src.replace('/app', '');
  alias = alias.replace('.js', '');

//  console.log(alias, '->', src);

  return alias;
}


module.exports = {
  blocksAliasFilter: memoizeAliasFilter(blocksAliasFilter),
  appAliasFilter: memoizeAliasFilter(appAliasFilter)

};
