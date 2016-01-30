NoTemplateLayout = require('views/layouts/noTemplate');

class BasePageView extends NoTemplateLayout

  onShow: ->
    @$('select').select2(
      minimumResultsForSearch: 10
    )


module.exports = BasePageView

