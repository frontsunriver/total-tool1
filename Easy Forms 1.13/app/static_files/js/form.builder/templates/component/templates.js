define(function(require) {

    var   heading                   = require('text!templates/component/heading.html')
        , paragraph                 = require('text!templates/component/paragraph.html')
        , text                      = require('text!templates/component/text.html')
        , number                    = require('text!templates/component/number.html')
        , date                      = require('text!templates/component/date.html')
        , email                     = require('text!templates/component/email.html')
        , textarea                  = require('text!templates/component/textarea.html')
        , checkbox                  = require('text!templates/component/checkbox.html')
        , radio                     = require('text!templates/component/radio.html')
        , selectlist                = require('text!templates/component/selectlist.html')
        , hidden                    = require('text!templates/component/hidden.html')
        , file                      = require('text!templates/component/file.html')
        , snippet                   = require('text!templates/component/snippet.html')
        , recaptcha                 = require('text!templates/component/recaptcha.html')
        , pagebreak                 = require('text!templates/component/pagebreak.html')
        , spacer                    = require('text!templates/component/spacer.html')
        , signature                 = require('text!templates/component/signature.html')
        , matrix                    = require('text!templates/component/matrix.html')
        , button                    = require('text!templates/component/button.html');

    return {
          heading                   : heading
        , paragraph                 : paragraph
        , text                      : text
        , number                    : number
        , date                      : date
        , email                     : email
        , textarea                  : textarea
        , checkbox                  : checkbox
        , radio                     : radio
        , selectlist                : selectlist
        , hidden                    : hidden
        , file                      : file
        , snippet                   : snippet
        , recaptcha                 : recaptcha
        , pagebreak                 : pagebreak
        , spacer                    : spacer
        , signature                 : signature
        , matrix                    : matrix
        , button                    : button
    }
});
