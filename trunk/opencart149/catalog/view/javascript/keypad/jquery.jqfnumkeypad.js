/*!
* JQFNumKeypad
* http://www.jqueryfun.com/
*/
(function($) {
  $.fn.JQFNumKeypad = function(options) {
    // Defaults
    var defaults = {
      fadeSpeed: 400,
      clearText: 'Clear'
    };
    // Extend options
    var options = $.extend(defaults, options);
    // Hide keypad on document click
    $(document).click(function() {$('.jqfnumkeypad').fadeOut('fast');});
    // Loop each instance
    return this.each(function() {
      // Instance
      var instance = $(this);
      // Keypad layout
      var keypad = '<div id="jqfnumkeypad_' + instance.attr('name') + '" class="jqfnumkeypad"><div class="jqfnumkeypad_keypad"><table width="100%" cellpadding="0" cellspacing="0">';
      for(var i = 1; i <= 9; i++) {
        if((i-1)%3 == 0) keypad += '<tr>';
        keypad += '<td class="jqfnumkeypad_digit">' + i + '</td>';
        if(i%3 == 0) keypad += '</tr>';
      }
      keypad += '<tr><td class="jqfnumkeypad_digit">0</td><td class="jqfnumkeypad_clear" colspan="2">' + options.clearText + '</td></tr></table></div></div>';
      $(keypad).insertAfter(instance).css({left: instance.position().left, top: instance.position().top+instance.outerHeight()});
      // Prevent hide on click
      instance.click(function(e) {e.stopPropagation();});
      // Define on focus event
      instance.focus(function() {
		$('#jqfnumkeypad_' + instance.attr('name')).css({left: instance.position().left, top: instance.position().top+instance.outerHeight()});
        // Hide all opened keypads
        $('.jqfnumkeypad').hide();
        $('#jqfnumkeypad_' + instance.attr('name')).fadeIn(options.fadeSpeed, function() {
          // Digit click
          $('#jqfnumkeypad_' + instance.attr('name') + ' .jqfnumkeypad_digit').unbind().bind('click', function(e) {
          if(instance.attr('maxlength') == -1 || instance.val().length < instance.attr('maxlength')) instance.val(instance.val() + parseFloat($(this).html()));
            e.stopPropagation();
          });
          // Clear click
          $('#jqfnumkeypad_' + instance.attr('name') + ' .jqfnumkeypad_clear').unbind().bind('click', function(e) {
            instance.val('');
            e.stopPropagation();
          });
        });
        // Blur to prevent instance events
        instance.blur();
      });
    });
  }
})(jQuery);