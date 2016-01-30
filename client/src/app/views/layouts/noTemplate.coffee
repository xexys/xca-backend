Marionette = require('blocks-modules/marionette');
BaseRegion = require('regions/base');

class NoTemplateLayout extends Marionette.LayoutView

  regionClass: BaseRegion

  template: false


module.exports = NoTemplateLayout

