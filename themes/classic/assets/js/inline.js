/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var mfp, // As we have only one instance of MagnificPopup object, we define it locally to not to use 'this'
	MagnificPopup = function(){},
	_isJQ = !!(window.jQuery),
	_prevStatus,
	_window = $(window),
	_body,
	_document,
	_prevContentType,
	_wrapClasses,
	_currPopupType;

var INLINE_NS = 'inline',
        _hiddenClass,
        _inlinePlaceholder,
        _lastInlineElement,
        _putInlineElementsBack = function() {
            if (_lastInlineElement) {
                _inlinePlaceholder.after(_lastInlineElement.addClass(_hiddenClass)).detach();
                _lastInlineElement = null;
            }
        };

$.magnificPopup.registerModule(INLINE_NS, {
    options: {
        hiddenClass: 'hide', // will be appended with `mfp-` prefix
        markup: '',
        tNotFound: 'Content not found'
    },
    proto: {
        initInline: function() {
            mfp.types.push(INLINE_NS);

            _mfpOn(CLOSE_EVENT + '.' + INLINE_NS, function() {
                _putInlineElementsBack();
            });
        },
        getInline: function(item, template) {

            _putInlineElementsBack();

            if (item.src) {
                var inlineSt = mfp.st.inline,
                        el = $(item.src);

                if (el.length) {

// If target element has parent - we replace it with placeholder and put it back after popup is closed
                    var parent = el[0].parentNode;
                    if (parent && parent.tagName) {
                        if (!_inlinePlaceholder) {
                            _hiddenClass = inlineSt.hiddenClass;
                            _inlinePlaceholder = _getEl(_hiddenClass);
                            _hiddenClass = 'mfp-' + _hiddenClass;
                        }
// replace target inline element with placeholder
                        _lastInlineElement = el.after(_inlinePlaceholder).detach().removeClass(_hiddenClass);
                    }

                    mfp.updateStatus('ready');
                } else {
                    mfp.updateStatus('error', inlineSt.tNotFound);
                    el = $('<div>');
                }

                item.inlineElement = el;
                return el;
            }

            mfp.updateStatus('ready');
            mfp._parseMarkup(template, {}, item);
            return template;
        }
    }
});
