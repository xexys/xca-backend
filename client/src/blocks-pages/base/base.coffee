NoTemplateLayout = require('views/layouts/noTemplate');
cosmetic = require('blocks/cosmetic');

class BasePageView extends NoTemplateLayout

  initialize: ->
    @on('show', @_setSelect)


  _setSelect: ->
    cosmetic.setSelect(@$el);


module.exports = BasePageView

