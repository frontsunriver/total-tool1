/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.11
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license https://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

/**
 * Form Widget Listener
 *
 * Listening for Events
 * @link https://docs.easyforms.dev/form-widget.html#interacting-with-the-form-via-javascript
 * @param e
 * @returns {boolean}
 */
function receiveMessage(e) {
    try {
        var data = (typeof e.data === 'string' || e.data instanceof String) ? JSON.parse(e.data) : e.data;
        switch (data.action) {
            case 'view':
                console.log('form', 'view')
                break;
            case 'fill':
                console.log('form', 'fill')
                break;
            case 'nextStep':
                console.log('form', 'nextStep')
                break;
            case 'previousStep':
                console.log('form', 'previousStep')
                break;
            case 'beforeSubmit':
                console.log('form', 'beforeSubmit')
                break;
            case 'error':
                console.log('form', 'error', data.data)
                break;
            case 'success':
                console.log('form', 'success', data.data, data.completionTime)
        }
    } catch (e) {
        return false;
    }
}
window.addEventListener('message', receiveMessage);