NoTemplateLayout = require('views/layouts/noTemplate');

class BasePageView extends NoTemplateLayout

  initialize: ->
    @on('show', @_setSelect)


  _setSelect: ->
    @$('select').select2(
      minimumResultsForSearch: 10
    )



module.exports = BasePageView

