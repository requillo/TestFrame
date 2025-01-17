/**
 * Amsify Suggestags
 * https://github.com/amsify42/jquery.amsify.suggestags
 * http://www.amsify42.com
 */

/**
 * AmsifySuggestags made global
 * @type AmsifySuggestags
 */
var AmsifySuggestags;

(function (factory) {
  if(typeof module === "object" && typeof module.exports === "object") {
    factory(require("jquery"), window, document);
  } else {
    factory(jQuery, window, document);
  }
}(function($, window, document, undefined) {    
    /**
     * Initialization begins from here
     * @type {Object}
     */
    AmsifySuggestags = function(selector) {
        this.selector      = selector;
        this.settings      = {
            type              : 'bootstrap',
            tagLimit          : -1,
            suggestions       : [],
            suggestionsAction : {},
            defaultTagClass   : '',
            classes           : [],
            backgrounds       : [],
            colors            : [],
            whiteList         : false,
            afterAdd          : {},
            afterRemove       : {},
            selectOnHover     : true,
            triggerChange     : false,
            noSuggestionMsg   : '',
            defaultLabel      : 'Type here',
        };
        this.method        = undefined;
        this.name          = null;
        this.defaultLabel  = this.settings.defaultLabel;
        this.classes       = {
          sTagsArea     : '.amsify-suggestags-area',
          inputArea     : '.amsify-suggestags-input-area',
          inputAreaDef  : '.amsify-suggestags-input-area-default',
          focus         : '.amsify-focus',
          sTagsInput    : '.amsify-suggestags-input',
          listArea      : '.amsify-suggestags-list',
          list          : '.amsify-list',
          listItem      : '.amsify-list-item',
          itemPad       : '.amsify-item-pad',
          inputType     : '.amsify-select-input',
          tagItem       : '.amsify-select-tag',
          colBg         : '.col-bg',
          removeTag     : '.amsify-remove-tag',
          readyToRemove : '.ready-to-remove',
          noSuggestion  : '.amsify-no-suggestion',
       };
       this.selectors     = {
          sTagsArea     : null,
          inputArea     : null,
          inputAreaDef  : null,
          sTagsInput    : null,
          listArea      : null,
          list          : null,
          listGroup     : null,
          listItem      : null,
          itemPad       : null,
          inputType     : null,
       };
       this.ajaxActive = false; 
       this.tagNames   = [];
    };

    AmsifySuggestags.prototype = {
       /**
         * Merging default settings with custom
         * @type {object}
         */
        _settings : function(settings) {
           this.settings = $.extend(this.settings, settings);      
        },

        _setMethod : function(method) {
           this.method = method;
        },

        _init : function() {
          if(this.checkMethod()) {
            this.name       = ($(this.selector).attr('name'))? $(this.selector).attr('name')+'_amsify': 'amsify_suggestags';
            this.createHTML();
            this.setEvents();
            $(this.selector).hide();
            this.setDefault();
          }
        },

        createHTML : function() {
          var HTML                      = '<div class="'+this.classes.sTagsArea.substring(1)+'"></div>';
          this.selectors.sTagsArea      = $(HTML).insertAfter(this.selector);
          var labelHTML                 = '<div class="'+this.classes.inputArea.substring(1)+'"></div>';
          this.selectors.inputArea      = $(labelHTML).appendTo(this.selectors.sTagsArea);

          this.defaultLabel             = ($(this.selector).attr('placeholder') !== undefined)? $(this.selector).attr('placeholder'): this.settings.defaultLabel;
          var sTagsInput                = '<input type="text" class="'+this.classes.sTagsInput.substring(1)+'" placeholder="'+this.settings.defaultLabel+'">';
          this.selectors.sTagsInput     = $(sTagsInput).appendTo(this.selectors.inputArea).attr('autocomplete', 'off');

          var listArea              = '<div class="'+this.classes.listArea.substring(1)+'"></div>';
          this.selectors.listArea   = $(listArea).appendTo(this.selectors.sTagsArea);
          $(this.selectors.listArea).width($(this.selectors.sTagsArea).width()-3);

          var list                  = '<ul class="'+this.classes.list.substring(1)+'"></ul>';
          this.selectors.list       = $(list).appendTo(this.selectors.listArea);
          this.updateSuggestionList();
          this.fixCSS();
        },

        updateSuggestionList : function() {
          $(this.selectors.list).html('');
          $(this.createList()).appendTo(this.selectors.list);
        },         

        setEvents : function() {
          var _self = this;
          $(this.selectors.inputArea).attr('style', $(this.selector).attr('style'))
                                     .addClass($(this.selector).attr('class'));
          this.setTagEvents();
          if(window !== undefined) {
            $(window).resize(function(){
              $(_self.selectors.listArea).width($(_self.selectors.sTagsArea).width()-3);
            });
          }
          this.setSuggestionsEvents();
          this.setRemoveEvent();
        },

        setTagEvents : function() {
          var _self = this;
          $(this.selectors.sTagsInput).focus(function(){
            $(this).closest(_self.classes.inputArea).addClass(_self.classes.focus.substring(1));
            if(_self.settings.type == 'materialize') {
              $(this).css({
                'border-bottom': 'none',
                '-webkit-box-shadow': 'none',
                'box-shadow': 'none',
              });
            }
          });
          $(this.selectors.sTagsInput).blur(function(){
            $(this).closest(_self.classes.inputArea).removeClass(_self.classes.focus.substring(1));
          });
          $(this.selectors.sTagsInput).keyup(function(e){
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if(keycode == '13' || keycode == '188') {
               var value = $.trim($(this).val().replace(/,/g , ''));
               $(this).val('');
              _self.addTag(value);
            } else if(keycode == '8' && !$(this).val()) {
              var removeClass = _self.classes.readyToRemove.substring(1);
              if($(this).hasClass(removeClass)) {
                $item = $(this).closest(_self.classes.inputArea).find(_self.classes.tagItem+':last');
                _self.removeTagByItem($item, false);
              } else {
                $(this).addClass(removeClass);
              }
              $(_self.selectors.listArea).hide();
            } else if((_self.settings.suggestions.length || _self.isSuggestAction()) && $(this).val()) {
              $(this).removeClass(_self.classes.readyToRemove.substring(1));
              _self.processWhiteList(keycode, $(this).val());
            }
          });
          $(this.selectors.sTagsArea).click(function(){
            $(_self.selectors.sTagsInput).focus();
          });
        },

        setSuggestionsEvents : function() {
          var _self = this;
          if(this.settings.selectOnHover) {
            $(this.selectors.listArea).find(this.classes.listItem).hover(function(){
              $(_self.selectors.listArea).find(_self.classes.listItem).removeClass('active');
              $(this).addClass('active');
              $(_self.selectors.sTagsInput).val($(this).data('val'));
            }, function() {
               $(this).removeClass('active');
            });
          }
          $(this.selectors.listArea).find(this.classes.listItem).click(function(){
             _self.addTag($(this).data('val'));
             $(_self.selectors.sTagsInput).val('').focus();
          });
        },

        isSuggestAction : function() {
            return (this.settings.suggestionsAction && this.settings.suggestionsAction.url);
        },

        processAjaxSuggestion : function(value, keycode) {
          var _self           = this;
          var actionMethod    = this.getActionURL(this.settings.suggestionsAction.url);
          var params          = {existing: this.settings.suggestions, term: value };
          var ajaxConfig      = (this.settings.suggestionsAction.callbacks)? this.settings.suggestionsAction.callbacks: {};

          var ajaxFormParams  = {
            url : actionMethod+'?'+$.param(params),
          };
          
          if(this.settings.suggestionsAction.beforeSend !== undefined && typeof this.settings.suggestionsAction.beforeSend == "function") {
              ajaxFormParams['beforeSend'] = this.settings.suggestionsAction.beforeSend;
          }
          ajaxFormParams['success'] = function(data) {
            if(data && data.suggestions) {
              _self.settings.suggestions = $.merge(_self.settings.suggestions, data.suggestions);
              _self.settings.suggestions = _self.unique(_self.settings.suggestions);
              _self.updateSuggestionList();
              _self.setSuggestionsEvents();
              _self.suggestWhiteList(value, keycode);
            }
            if(_self.settings.suggestionsAction.success !== undefined && typeof _self.settings.suggestionsAction.success == "function") {
                _self.settings.suggestionsAction.success(data);
            }
          };
          if(this.settings.suggestionsAction.error !== undefined && typeof this.settings.suggestionsAction.error == "function") {
              ajaxFormParams['error'] = this.settings.suggestionsAction.error;
          }
          ajaxFormParams['complete'] = function(data) {
            if(_self.settings.suggestionsAction.complete !== undefined && typeof _self.settings.suggestionsAction.complete == "function") {
                _self.settings.suggestionsAction.complete(data);
            }
            _self.ajaxActive = false;
          };
          $.ajax(ajaxFormParams);
        },

        processWhiteList : function(keycode, value) {
          if(keycode == '40' || keycode == '38') {
            var type = (keycode == '40')? 'down': 'up';
            this.upDownSuggestion(value, type);
          } else {
            if(this.isSuggestAction() && !this.ajaxActive) {
               this.ajaxActive = true;
               this.processAjaxSuggestion(value, keycode);
            } else {
              this.suggestWhiteList(value, keycode);
            }
          }
        },

        upDownSuggestion : function(value, type) {
          var _self     = this;
          var isActive  = false;
          $(this.selectors.listArea).find(this.classes.listItem+':visible').each(function(){
               if($(this).hasClass('active')) {
                $(this).removeClass('active');
                  if(type == 'up') {
                    $item = $(this).prevAll(_self.classes.listItem+':visible:first');
                  } else {
                    $item = $(this).nextAll(_self.classes.listItem+':visible:first');
                  }
                  if($item.length) {
                    isActive = true;
                    $item.addClass('active');
                    $(_self.selectors.sTagsInput).val($item.text());
                  }
                return false;
               }
          });
          if(!isActive) {
            var childItem = (type == 'down')? 'first': 'last';
            $item = $(this.selectors.listArea).find(this.classes.listItem+':visible:'+childItem);
            if($item.length) {
              $item.addClass('active');
              $(_self.selectors.sTagsInput).val($item.text());
            }
          }
        },

        suggestWhiteList : function(value, keycode) {
          var _self = this;
          var found = false;
          $(this.selectors.listArea).find(_self.classes.noSuggestion).hide();
          $(this.selectors.listArea).find(this.classes.listItem).each(function(){
            if(~$(this).attr('data-val').toLowerCase().indexOf(value.toLowerCase()) && $.inArray($(this).attr('data-val'), _self.tagNames) === -1) {
              $(this).show();
              found = true;
            } else {
              $(this).hide();
            }
          });
          if(found) {
            $(this.selectors.listArea).show();
            /**
             * If only one item left in whitelist suggestions
             */
            $item = $(this.selectors.listArea).find(this.classes.listItem+':visible');
            if($item.length == 1 && keycode != '8') {
              if((this.settings.whiteList && this.isSimilarText(value.toLowerCase(), $item.text().toLowerCase(), 40)) || this.isSimilarText(value.toLowerCase(), $item.text().toLowerCase(), 60)) {
                $item.addClass('active');
                $(this.selectors.sTagsInput).val($item.text());
              }
            } else {
              $item.removeClass('active');
            }
          } else {
            if(value && _self.settings.noSuggestionMsg) {
              $(this.selectors.listArea).find(_self.classes.listItem).hide();
              $(this.selectors.listArea).find(_self.classes.noSuggestion).show();
            } else {
              $(this.selectors.listArea).hide();
            }
          }
        },

        setDefault : function() {
          var _self = this;
          var items = $(this.selector).val().split(',');
          if(items.length) {
            $.each(items, function(index, item){
              _self.addTag($.trim(item));
            });
          }
        },

        setRemoveEvent: function() {
          var _self = this;
          $(this.selectors.inputArea).find(this.classes.removeTag).click(function(e){
              e.stopImmediatePropagation();
              $tagItem = $(this).closest(_self.classes.tagItem);
              _self.removeTagByItem($tagItem, false);
          });
        },

        createList : function() {
          var _self     = this;
          var listHTML  = '';
          $.each(this.settings.suggestions, function(index, item){
              listHTML += '<li class="'+_self.classes.listItem.substring(1)+'" data-val="'+item+'">'+item+'</li>';
          });
          if(_self.settings.noSuggestionMsg) {
            listHTML += '<li class="'+_self.classes.noSuggestion.substring(1)+'">'+_self.settings.noSuggestionMsg+'</li>';
          }
          return listHTML;
        },

        addTag : function(value) {
          if(!value) return;
          var html          = '<span class="'+this.classes.tagItem.substring(1)+'" data-val="'+value+'">'+value+' '+this.setIcon()+'</span>';
          $item             = $(html).insertBefore($(this.selectors.sTagsInput));
          if(this.settings.defaultTagClass) {
            $item.addClass(this.settings.defaultTagClass);
          }
          if(this.settings.tagLimit != -1 && this.settings.tagLimit > 0 && this.tagNames.length >= this.settings.tagLimit) {
            this.animateRemove($item, true);
            this.flashItem(value);
            return false;
          }
          var itemKey = $.inArray(value, this.settings.suggestions);
          if(this.settings.whiteList && itemKey === -1) {
            this.animateRemove($item, true);
            this.flashItem(value);
            return false;
          }
          if(this.isPresent(value)) {
            this.animateRemove($item, true);
            this.flashItem(value);
          } else {
            this.customStylings($item, itemKey);
            this.tagNames.push(value);
            this.setRemoveEvent();
            this.setInputValue();
            if(this.settings.afterAdd && typeof this.settings.afterAdd == "function") {
              this.settings.afterAdd(value);
            }
          }
          $(this.selector).trigger('suggestags.add', [value]);
          $(this.selector).trigger('suggestags.change');
          if(this.settings.triggerChange) {
            $(this.selector).trigger('change');
          }
          $(this.selectors.listArea).find(this.classes.listItem).removeClass('active');
          $(this.selectors.listArea).hide();
          $(this.selectors.sTagsInput).removeClass(this.classes.readyToRemove.substring(1));
        },

        isPresent : function(value) {
          var present = false;
          $.each(this.tagNames, function(index, tag){
            if(value.toLowerCase() == tag.toString().toLowerCase()) {
              present = true;
              return false;
            }
          });
          return present;
        },

        customStylings : function(item, key) {
          var isCutom = false;
          if(this.settings.classes[key]) {
            isCutom = true;
            $(item).addClass(this.settings.classes[key]);
          }
          if(this.settings.backgrounds[key]) {
            isCutom = true;
            $(item).css('background', this.settings.backgrounds[key]);
          }
          if(this.settings.colors[key]) {
            isCutom = true;
            $(item).css('color', this.settings.colors[key]);
          }
          if(!isCutom) $(item).addClass(this.classes.colBg.substring(1));
        },

        removeTag: function(value) {
          var _self = this;
          $findTags = $(this.selectors.sTagsArea).find('[data-val="'+value+'"]');
          if($findTags.length) {
            $findTags.each(function(){
              _self.removeTagByItem(this, true);
            });
          }
        },

        removeTagByItem : function(item, animate) {
          this.tagNames.splice($(item).index(), 1);
          this.animateRemove(item, animate);
          this.setInputValue();
          $(this.selector).trigger('suggestags.remove', [$(item).attr('data-val')]);
          $(this.selector).trigger('suggestags.change');
          if(this.settings.triggerChange) {
            $(this.selector).trigger('change');
          }
          if(this.settings.afterRemove && typeof this.settings.afterRemove == "function") {
            this.settings.afterRemove($(item).attr('data-val'));
          }
          $(this.selectors.sTagsInput).removeClass(this.classes.readyToRemove.substring(1));
        },

        animateRemove : function(item, animate) {
          $(item).addClass('disabled');
          if(animate) {
            setTimeout(function(){
              $(item).slideUp();
              setTimeout(function(){
                $(item).remove();
              }, 500);
            }, 500);
          } else {
            $(item).remove();
          }
        },

        flashItem : function(value) {
          $item  = '';
          $(this.selectors.sTagsArea).find(this.classes.tagItem).each(function(){
            var tagName = $.trim($(this).attr('data-val'));
            if(value.toLowerCase() == tagName.toLowerCase()) {
              $item = $(this);
              return false;
            }
          });
          if($item) {
            $item.addClass('flash');
            setTimeout(function(){
              $item.removeClass('flash');
            }, 1500);
          }
        },

        setIcon : function() {
          var removeClass = this.classes.removeTag.substring(1);
          if(this.settings.type == 'bootstrap') {
            return '<span class="fa fa-times '+removeClass+'"></span>';
          } else if(this.settings.type == 'materialize') {
            return '<i class="material-icons right '+removeClass+'">clear</i>';
          } else {
            return '<b class="'+removeClass+'">&#10006;</b>';
          }
        },

        setInputValue: function() {
          $(this.selector).val(this.tagNames.join(','));
          this.printValues();
        },

        fixCSS : function() {
          if(this.settings.type == 'amsify') {
            $(this.selectors.inputArea).addClass(this.classes.inputAreaDef.substring(1)).css({'padding': '5px 5px'});
          } else if(this.settings.type == 'materialize') {
            $(this.selectors.inputArea).addClass(this.classes.inputAreaDef.substring(1)).css({'height': 'auto', 'padding': '5px 5px'});
            $(this.selectors.sTagsInput).css({'margin': '0', 'height': 'auto'});
          }
        },

        printValues : function() {
          console.info(this.tagNames, $(this.selector).val());
        },

        checkMethod : function() {
          $findTags = $(this.selector).next(this.classes.sTagsArea);
          if($findTags.length)  $findTags.remove();
          $(this.selector).show();
          if(typeof this.method !== undefined && this.method == 'destroy') {
            return false;
          } else {
            return true;
          }
        },

        refresh : function() {
          this._setMethod('refresh');
          this._init();
        },

        destroy : function() {
          this._setMethod('destroy');
          this._init();
        },

        getActionURL : function(urlString) {
          var URL = '';
          if(window !== undefined) {
              URL = window.location.protocol+'//'+window.location.host;
          }
          if(this.isAbsoluteURL(urlString)) {
            URL = urlString;
          } else {
            URL += '/'+urlString.replace(/^\/|\/$/g, '');
          }
          return URL;
        },

        isAbsoluteURL : function(urlString) {
          var regexURL  = new RegExp('^(?:[a-z]+:)?//', 'i');
          return (regexURL.test(urlString))? true: false;
        },

        unique: function(list) {
          var result = [];
          $.each(list, function(i, e) {
            if ($.inArray(e, result) == -1) result.push(e);
          });
          return result;
        },

        isSimilarText: function(str1, str2, perc) {
          var percent = this.similarity(str1, str2);
          return (percent*100 >= perc)? true: false;
        },

        similarity: function(s1, s2) {
          var longer = s1;
          var shorter = s2;
          if(s1.length < s2.length) {
            longer = s2;
            shorter = s1;
          }
          var longerLength = longer.length;
          if(longerLength == 0) {
            return 1.0;
          }
          return (longerLength - this.editDistance(longer, shorter))/parseFloat(longerLength);
        },

        editDistance: function(s1, s2) {
          s1 = s1.toLowerCase();
          s2 = s2.toLowerCase();
          var costs = new Array();
          for(var i = 0; i <= s1.length; i++) {
            var lastValue = i;
            for(var j = 0; j <= s2.length; j++) {
              if(i == 0) {
                costs[j] = j;
              } else {
                if(j > 0) {
                  var newValue = costs[j - 1];
                  if(s1.charAt(i - 1) != s2.charAt(j - 1))
                    newValue = Math.min(Math.min(newValue, lastValue), costs[j]) + 1;
                    costs[j - 1] = lastValue;
                    lastValue = newValue;
                  }
                }
              }
            if(i > 0)
              costs[s2.length] = lastValue;
          }
         return costs[s2.length];
       }
    };

    $.fn.amsifySuggestags = function(options, method) {
        /**
         * Initializing each instance of selector
         * @return {object}
         */
        return this.each(function() {
          var amsifySuggestags = new AmsifySuggestags(this);
          amsifySuggestags._settings(options);
          amsifySuggestags._setMethod(method);
          amsifySuggestags._init();
        });
    };
}));