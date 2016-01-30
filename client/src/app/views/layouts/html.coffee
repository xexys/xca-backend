NoTemplateLayout = require('./noTemplate')

class HtmlLayout extends NoTemplateLayout

  el: 'html'

  regions:
    body: 'body'


  initialize: (options) ->
    @body.show(options.pageView)



module.exports = HtmlLayout