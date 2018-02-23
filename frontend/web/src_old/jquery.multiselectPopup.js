(function ($) {
    $.fn.multiselectPopup = function (method) {
        var settings = {
            title: multiselectPopupLanguage.select, //
            emptyText: 'Указать',
            notEmptyText: 'Изменить',

            itemsDisplayMode: 'nested',             // отображение пунктов ('nested' либо 'inline')
            itemsNestedMode: 'dropdown',            // принимает значение 'dropdown' или 'frames', имеет значение лишь только
                                                    // если itemsDisplayMode => 'nested'
            itemsChildEagerDisplaying: false,       // отображать ли дочение пункты сразу (true) либо при быборе пункта (false)
            multiply: true,                         // множественный или единичный выбор
            maxSelectedItems: null,                 // максимальное количество выбраных элементов
            dataUrl: '',                            // url для загрузки данных
            dataRequestType: 'post',                //
            dataType: 'json',                       //

            showNavigation: true,                   //
            showSearchFilter: true,                 //
            showBulkButtons: true,                  //
            showBreadcrumbs: false,                 // показывать ли хлебные крошки в модальном окне
            showSelectedCount: false,               //
            showSelectedHiddenInputs: false,        //
            showSelectedLabels: true,               //
            maxSelectedLabels: 10,

            resetSelectedAfterLoading: false,       //
            selectedValues: [],                     // выбранные пункты
            inputName: null,                        // имя текстового поля
            resetAfterClose: false,                 //
            enableCaching: true,                    // управление кешированием
            data: [],                               //
            modalId: 'select-modal',                // ID модального окна
            selectableOptions: {},                  // опции для jQuery seleclable

            selectedValueTemplate: '',
            breadcrumbsTemplate: '',                // шаблон для хлебных крошек
            navigationTemplate:
                '<div class="mp-nav">'
                    + '<div class="multiselect-popup-breadcrumbs"></div>'
                        + '<input maxlength="50" class="mp-search form-control inline" type="text" placeholder="{search}" style="width: 190px;display: inline-block;">'
                        + '<button class="mp-deselect-all inline submit5 btn btn-md btn-primary">{clear}</button>'
                        + '<button class="mp-select-all inline submit5 btn btn-md btn-primary">{selectAll}</button>'
                        + '<span class="count"></span>'
                + '</div>',
            // шаблон модального окна
            modalTemplate:
                '<div id="{uniqueModalId}" class="modal fade {modalId}">'
                    + '<div class="modal-dialog mp-dialog">'
                        + '<div class="modal-content">'
                            + '<div class="modal-header">'
                                + '<button type="button" class="close close-load btn btn-md btn-primary" data-dismiss="modal" aria-label="Close">'
                                    + '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>'
                                + '</button> <h4 class="modal-title">{title}</h4>'
                            + '</div>'
                            + '<div class="modal-body multiselect-popup">'
                                + '{navigation}'
                                + '<div class="mp-items"></div>'
                            + '</div>'
                        + '</div>'
                    + '</div>'
                + '</div>',
        };

        var selector = this.selector;
        var modalSelector;
        var items;
        var dataCache;
        var selectedStack = [];     // стек выбранных пунктов от дочернего к родительскому
        var selectedValues;

        var methods = {
            init: function (params) {
                settings = $.extend(settings, params);
                dataCache = settings.items;
                selectedValues = !settings.selectedValues ? {} : settings.selectedValues;

                return this.each(function () {
                    var self = $(this);

                    if (settings.showSelectedLabels) {
                        self.after('<div class="mp-selected-labels"></div>');

                        self.parent().find('.mp-selected-labels').on('click', 'span[data-action=label]', function () {
                            var label = $(this);
                            var key = label.data('value');
                            delete selectedValues[key];
                            label.remove();
                            methods.triggerChangeEvent.apply(self);
                        });
                    }

                    if (settings.showSelectedHiddenInputs) {
                        self.after('<span class="mp-selected-hidden-inputs"></span>');
                    }

                    if (settings.showSelectedCount) {
                        self.after('<span class="mp-selected-count"></span>');
                    }

                    methods.showStatistics.apply(self);

                    $(this).click(function (event) {
                        methods.show.apply(self);
                    });

                    if (selectedValues && selectedValues.length > 0) {
                        if (settings.showSelectedCount) {
                            self.parent().find('.mp-selected-count').show().css('display', 'inline-block')
                                .text(multiselectPopupLanguage.selected + selectedValues.length);
                        }

                        if (settings.showSelectedHiddenInputs) {
                            $.each(selectedValues, function (key, value) {
                                var v = value.toString();
                                selectedValues[key] = v;
                                self.parent()
                                    .find('.mp-selected-hidden-inputs')
                                    .append('<input type="hidden" name="' + settings.inputName + '[]" value="' + v + '">');
                            });
                        }
                    }
                });
            },

            show: function () {
                var self = $(this);

                var modalId = settings.modalId + '-' + Math.round(Math.random() * 100);
                modalSelector = '#' + modalId;

                var html = settings.modalTemplate
                    .replace('{uniqueModalId}', modalId)
                    .replace('{modalId}', settings.modalId)
                    .replace('{navigation}', settings.showNavigation ? settings.navigationTemplate : '')
                    .replace('{title}', settings.title)
                    .replace('{search}', multiselectPopupLanguage.search)
                    .replace('{clear}', multiselectPopupLanguage.clear)
                    .replace('{selectAll}', multiselectPopupLanguage.selectAll);
                $('body').append(html);

                $(modalSelector).modal('show').on('hidden.bs.modal', function (e) {
                    methods.close.apply(self);
                    $('.close-load').trigger('click');
                    $(modalSelector).remove();
                });

                methods.showItems.apply(self);

                $(modalSelector).find('input.mp-search').keyup(function () {
                    var searchString = $(this).val();

                    $(modalSelector).find(' ul.mp-selectable li').each(function () {
                        var t = $(this).text();
                        var idx = t.toLowerCase().indexOf(searchString.toLowerCase());
                        if (idx >= 0) {
                            $(this).html(t.substr(0, idx) + '<span style="background-color:#ffff00;text-decoration: underline">' + t.substr(idx, searchString.length) + '</span>' + t.substr(idx + searchString.length));
                            $(this).show();
                        } else {
                            $(this).hide()
                        };
                    });
                });

                if (!settings.itemsChildEagerDisplaying) {
                    $('.multiselect-popup').on('click', 'li[data-has-items]', function (event) {
                        methods.showItems.apply(self, [$(this)]);
                    });
                }

                $(modalSelector).find('.multiselect-popup').fadeIn(200);
                $(modalSelector).find('.close').click(function () {
                    // methods.close.apply(self);
                });
            },

            showItems: function (clickedDomItem) {
                var self = $(this);
                var clickedItemId = clickedDomItem ? clickedDomItem.attr('data-value') : null;

                var items = methods.getItems.apply(self, [clickedItemId, function (items) {
                    methods.drawItemsList.apply(self, [items, clickedDomItem]);
                }]);

                if (items) {
                    methods.drawItemsList.apply(self, [items, clickedDomItem]);
                }
            },

            drawItemsList: function (itemsList, clickedDomItem, returnData) {
                var self = $(this),
                    level = (level == 'undefined') ? 0 : ++level,
                    html = '', sel;

                $.each(itemsList, function (key, value) {
                    html += methods.drawItem(key, value, level);
                });

                if (returnData) {
                    return html;
                } else {
                    if (clickedDomItem) {
                        $(clickedDomItem.attr('href')).html(html);
                    } else {
                        var attrs = '';
                        if (settings.itemsDisplayMode == 'inline') {
                            attrs = ' class="mp-selectable"';
                        }
                        html = '<ul' + attrs + '>' + html + '</ul>';
                        $(modalSelector + ' .mp-items').html(html);
                    }

                    //methods.drawBreadcrumbs.apply(self);
                    methods.recalcCount.apply(self);
                    methods.initSelectable.apply(self);
                }
            },

            drawItem: function (key, value) {
                var html = '';
                var clsAttr = selectedValues[key] ? ' class="mp-selected"' : '';

                if (typeof value == 'object') {
                    var itemsHtml = '';
                    html += '<li data-value="' + key + '"' + clsAttr + ' data-has-items="true" data-toggle="collapse" href="#' + key + '" aria-expanded="true" aria-controls="' + key + '">' + value.title + '</li>';

                    if (value.items && settings.itemsChildEagerDisplaying) {
                        itemsHtml += methods.drawItemsList.apply(self, [value.items, null, true]);
                    }

                    html += '<li id="' + key + '" class="collapse"><ul class="mp-selectable">' + itemsHtml + '</ul></li>';
                } else {
                    html += '<li data-value="' + key + '"' + clsAttr + '>' + value + '</li>';
                }

                return html;
            },

            getItems: function (parentId, successCallback) {
                if (!parentId) {
                    return dataCache;
                } else {
                    for (var key in dataCache) {
                        if (parentId == key) {
                            var item = dataCache[key];

                            if (!item.items && !settings.itemsChildEagerDisplaying) {
                                $.ajax({
                                    type: settings.dataRequestType,
                                    url: item.attr('data-items-url'),
                                    data: settings.loadParams,
                                    dataType: settings.dataType,
                                    successCallback: successCallback,
                                    error: function (xhr, ajaxOptions, thrownError) {
                                        alert(xhr.responseText);
                                    }
                                });
                                return false;
                            } else {
                                return item.items;
                            }
                        }
                    }
                }
                return false;
            },

            drawBreadcrumbs: function () {
                var ui = $('.multiselect-popup-breadcrumbs').html('');

                $(selectedStack).each(function (key, value) {
                    ui.append('<span data-value="' + key + '">' + value.title + '</span>');
                });
            },

            initSelectable: function () {
                var self = $(this);
                var selectableOptions = $.extend({
                    selected: function (event, ui) {
                        if ($(ui.selected).hasClass('mp-selected')) {
                            $(ui.selected).removeClass('mp-selected').removeClass('ui-selected');
                        } else {
                            if (!settings.multiply) {
                                $(modalSelector).find('.mp-selected').removeClass('mp-selected').removeClass('ui-selected');
                            }
                            $(ui.selected).addClass('mp-selected').addClass('ui-selected');
                        }
                        methods.recalcCount.apply(self);
                    },
                }, settings.selectableOptions);

                $(modalSelector + ' .mp-items ul.mp-selectable').selectable(selectableOptions);

                $(modalSelector + ' .mp-nav .mp-deselect-all').click(function () {
                    $('.mp-items ul.mp-selectable li').removeClass('mp-selected').removeClass('ui-selected');
                    methods.recalcCount.apply(self);
                });

                $(modalSelector + ' .mp-nav .mp-select-all').click(function () {
                    $('.mp-items ul.mp-selectable li').removeClass('mp-selected').removeClass('ui-selected').addClass('mp-selected');
                    methods.recalcCount.apply(self);
                });
            },

            recalcCount: function () {
                var ul = $(modalSelector).find('.mp-items ul.mp-selectable');

                var selCount = $(ul).find('li.mp-selected').length;
                var allCount = $(ul).find('li').length;
                $(".mp-nav .count").text(multiselectPopupLanguage.selected + selCount + multiselectPopupLanguage.from + allCount);
            },

            close: function () {
                var self = $(this);

                methods.updateSelectedValues.apply(self);
                methods.showStatistics.apply(self);
                methods.triggerChangeEvent.apply(self);
            },

            triggerChangeEvent: function () {
                var self = $(this);

                self.html(selectedValues.length ? settings.notEmptyText : settings.emptyText)
                    .parent()
                    .find('[name=' + settings.inputName + ']')
                    .attr('value', Object.keys(selectedValues).join(','))
                    .trigger('change');
            },

            updateSelectedValues: function () {
                selectedValues = {};

                $(modalSelector).find('ul.mp-selectable li.mp-selected').each(function () {
                    var self = $(this);
                    var v = self.data('value').toString();
                    selectedValues[v] = self.html();
                });
            },

            showStatistics: function () {
                var self = $(this),
                    parent = self.parent(),
                    selectedLabelsHtml = '',
                    selectedHiddenInputsHtml = '',
                    shownLabels = 0;

                for (var key in selectedValues) {
                    var title = selectedValues[key];

                    if (settings.showSelectedLabels && shownLabels < settings.maxSelectedLabels) {
                        selectedLabelsHtml += methods.drawSelectedValueLabel.apply(self, [key, title]);
                        shownLabels++;
                    } else if (settings.showSelectedLabels && shownLabels == settings.maxSelectedLabels) {
                        selectedLabelsHtml += ' <span>И еще <span>' + (Object.keys(selectedValues).length - shownLabels) + '</span></span>';
                        shownLabels++;
                    }

                    if (settings.showSelectedHiddenInputs) {
                        selectedHiddenInputsHtml += methods.drawSelectedHiddenInput.apply(self, [settings.inputName, key]);
                    }
                }

                if (settings.showSelectedLabels) {
                    parent.find('.mp-selected-labels').html(selectedLabelsHtml);
                }

                if (settings.showSelectedHiddenInputs) {
                    parent.find('.mp-selected-hidden-inputs').html(selectedHiddenInputsHtml);
                }

                if (settings.showSelectedCount && settings.multiply) {
                    parent.find('.mp-selected-count').text(multiselectPopupLanguage.selected + selectedValues.length).show().css('display', 'inline-block');
                }
            },
            
            drawSelectedValueLabel: function (key, title) {
                return '<span data-value="' + key + '" data-action="label">' + title + '<i class="glyphicon glyphicon-remove pull-right"></i></span>'
            },

            drawSelectedHiddenInput: function (inputName, key) {
                return '<input type="hidden" name="' + inputName + '[]" value="' + key + '">';
            }
        };
        

        if (methods[method]) {
            // если запрашиваемый метод существует, мы его вызываем
            // все параметры, кроме имени метода прийдут в метод
            // this так же перекочует в метод
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            // если первым параметром идет объект, либо совсем пусто
            // выполняем метод init
            return methods.init.apply(this, arguments);
        } else {
            // если ничего не получилось
            $.error('Метод "' + method + '" не найден в плагине jQuery.multiselectPopup');
        }

    }
})(jQuery);