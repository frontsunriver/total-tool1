define(function(require) {
    var checkbox                    = require('text!templates/widget/checkbox.html')
        , file                      = require('text!templates/widget/file.html')
        , heading                   = require('text!templates/widget/heading.html')
        , paragraph                 = require('text!templates/widget/paragraph.html')
        , radio                     = require('text!templates/widget/radio.html')
        , selectlist                = require('text!templates/widget/selectlist.html')
        , textarea                  = require('text!templates/widget/textarea.html')
        , text                      = require('text!templates/widget/text.html')
        , snippet                   = require('text!templates/widget/snippet.html')
        , recaptcha                 = require('text!templates/widget/recaptcha.html')
        , number                    = require('text!templates/widget/number.html')
        , date                      = require('text!templates/widget/date.html')
        , email                     = require('text!templates/widget/email.html')
        , hidden                    = require('text!templates/widget/hidden.html')
        , pagebreak                 = require('text!templates/widget/pagebreak.html')
        , spacer                    = require('text!templates/widget/spacer.html')
        , signature                 = require('text!templates/widget/signature.html')
        , matrix                    = require('text!templates/widget/matrix.html')
        , button                    = require('text!templates/widget/button.html');

    return {
        checkbox                    : checkbox
        , file                      : file
        , heading                   : heading
        , paragraph                 : paragraph
        , radio                     : radio
        , selectlist                : selectlist
        , textarea                  : textarea
        , text                      : text
        , date                      : date
        , email                     : email
        , snippet                   : snippet
        , recaptcha                 : recaptcha
        , number                    : number
        , hidden                    : hidden
        , pagebreak                 : pagebreak
        , spacer                    : spacer
        , signature                 : signature
        , matrix                    : matrix
        , button                    : button
    }
});
