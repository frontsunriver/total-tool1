/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.0
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

// Get css element
var css = $(options.css);
// Set iframe id
var iID = options.iframe;
// Set iframe height
var iH = "250";
// Boolean iframe is in the DOM
var iExists = false;

/**
 * When a no one form is selected
 *
 * @param e
 * @returns {boolean}
 */
var previewUnselected = function (e) {
    e.preventDefault();
    // Hide container
    $("#preview-container").hide();
    // Remove iframe
    $('#'+iID).remove();
    return iExists = false;
};

/**
 * When a form is selected
 *
 * @param e
 * @returns {boolean}
 */
var previewSelected = function (e) {
    e.preventDefault();
    // Show container
    $("#preview-container").show();
    // Load iframe
    var src = $(e.currentTarget).val();
    if( iExists === true ) {
        // If iframe exists, only change its src
        $('#'+iID).attr("src", src);
    } else {
        // Create iframe
        var i = $('<iframe></iframe>').attr({
            src: src,
            id: iID,
            frameborder: 0,
            width: '100%',
            height: iH
        });
        // Add event listener, to change its css styles
        i.load(function(){
            $('#'+iID).contents().find("#liveCSS").text(editor.getSession().getValue());
        });
        // Add iframe to div preview
        $("#preview").html(i);
        // Flag to true
        return iExists = true;
    }
};

/**
 * Resize iframe
 */
$("#resizeFull").click(function(e) {
    e.preventDefault();
    if(iExists) {
        // To expand
        var iEl = $("#"+iID);
        iEl.height( iEl.contents().find("html").height() );
        $(".toogleButton").toggle();
    }
});
$("#resizeSmall").click(function(e) {
    e.preventDefault();
    if(iExists) {
        // To contract
        $("#"+iID).height( iH );
        $(".toogleButton").toggle();
    }
});

$( document ).ready(function() {
    // Create & configure the css editor
    editor = ace.edit("editor");
    editor.$blockScrolling = Infinity;
    editor.setTheme("ace/theme/clouds");
    editor.getSession().setMode("ace/mode/css");

    // Pass the content of textarea to the editor
    editor.getSession().setValue(css.val());

    // With each change, update the textarea's value
    editor.getSession().on('change', function(){
        // Get styles form the editor
        var styles = editor.getSession().getValue();
        // Update the textarea
        css.val(styles);
        // Update the iframe if exists
        if(iExists) {
            $('#'+iID).contents().find("#liveCSS").text(styles);
        }
    });

});
