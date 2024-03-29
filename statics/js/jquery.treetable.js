/*
 * jQuery treeTable Plugin 2.3.0
 * http://ludo.cubicphuse.nl/jquery-plugins/treeTable/
 *
 * Copyright 2010, Ludo van den Boom
 * Dual licensed under the MIT or GPL Version 2 licenses.
 */
(function($) {
    var options;
    var defaultPaddingLeft;
    $.fn.treeTable = function(opts) {
        options = $.extend({}, $.fn.treeTable.defaults, opts);
        return this.each(function() {
            $(this).addClass("treeTable").find("tbody tr").each(function() {
                if (!options.expandable || $(this)[0].className.search(options.childPrefix) == -1 || $(this).data('initialize')) {
                	if($(this).data('hidden')){
                		this.style.display = "none"
                	}
                	else{
                        if (isNaN(defaultPaddingLeft)) {
                            defaultPaddingLeft = parseInt($($(this).children("td")[options.treeColumn]).css('padding-left'), 10)
                        }
                        initialize($(this))
                	}
                } else if (options.initialState == "collapsed") {
                    this.style.display = "none"
                }
            })
        })
    };
    $.fn.treeTable.defaults = {
        childPrefix: "child-of-",
        clickableNodeNames: false,
        expandable: true,
        indent: 19,
        initialState: "collapsed",
        treeColumn: 0
    };
    $.fn.collapse = function() {
        $(this).addClass("collapsed");
        childrenOf($(this)).each(function() {
            if (!$(this).hasClass("collapsed")) {
                $(this).collapse()
            }
            this.style.display = "none"
        });
        return this
    };
    $.fn.expand = function() {
        $(this).removeClass("collapsed").addClass("expanded");
        childrenOf($(this)).each(function() {
            initialize($(this));
            if ($(this).is(".expanded.parent")) {
                $(this).expand()
            }
            $(this).show()
        });
        return this
    };
    $.fn.reveal = function() {
        $(ancestorsOf($(this)).reverse()).each(function() {
            initialize($(this));
            $(this).expand().show()
        });
        return this
    };
    $.fn.appendBranchTo = function(destination) {
        var node = $(this);
        var parent = parentOf(node);
        var ancestorNames = $.map(ancestorsOf($(destination)), function(a) {
            return a.id
        });
        if ($.inArray(node[0].id, ancestorNames) == -1 && (!parent || (destination.id != parent[0].id)) && destination.id != node[0].id) {
            indent(node, ancestorsOf(node).length * options.indent * -1);
            if (parent) {
                node.removeClass(options.childPrefix + parent[0].id)
            }
            node.addClass(options.childPrefix + destination.id);
            move(node, destination);
            indent(node, ancestorsOf(node).length * options.indent)
        }
        return this
    };
    $.fn.reverse = function() {
        return this.pushStack(this.get().reverse(), arguments)
    };
    $.fn.toggleBranch = function() {
        if ($(this).hasClass("collapsed")) {
            $(this).expand()
        } else {
            $(this).removeClass("expanded").collapse()
        }
        return this
    };

    function ancestorsOf(node) {
        var ancestors = [];
        while (node = parentOf(node)) {
            ancestors[ancestors.length] = node[0]
        }
        return ancestors
    };

    function childrenOf(node) {
        return $("table.treeTable tbody tr." + options.childPrefix + node[0].id)
    };

    function getPaddingLeft(node) {
        var paddingLeft = parseInt(node[0].style.paddingLeft, 10);
        return (isNaN(paddingLeft)) ? defaultPaddingLeft : paddingLeft
    }

    function indent(node, value) {
        var cell = $(node.children("td")[options.treeColumn]);
        cell[0].style.paddingLeft = getPaddingLeft(cell) + value + "px";
        childrenOf(node).each(function() {
            indent($(this), value)
        })
    };

    function initialize(node) {
        if (!node.hasClass("initialized")) {
            node.addClass("initialized");
            var childNodes = childrenOf(node);
            if (!node.hasClass("parent") && childNodes.length > 0) {
                node.addClass("parent")
            }
            if (node.hasClass("parent")) {
                var cell = $(node.children("td")[options.treeColumn]);
                var padding = getPaddingLeft(cell) + options.indent;
                childNodes.each(function() {
                    $(this).children("td")[options.treeColumn].style.paddingLeft = padding + "px"
                });
                if (options.expandable) {
                    cell.prepend('<span style="padding-left: ' + options.indent + 'px" class="expander"></span>');
                    $(cell[0].firstChild).click(function() {
                        node.toggleBranch()
                    });
                    if (options.clickableNodeNames) {
                        cell[0].style.cursor = "pointer";
                        $(cell).click(function(e) {
                            if (e.target.className != 'expander') {
                                node.toggleBranch()
                            }
                        })
                    }
                    if (!(node.hasClass("expanded") || node.hasClass("collapsed"))) {
                        node.addClass(options.initialState)
                    }
                    if (node.hasClass("expanded")) {
                        node.expand()
                    }
                }
            }
        }
    };

    function move(node, destination) {
        node.insertAfter(destination);
        childrenOf(node).reverse().each(function() {
            move($(this), node[0])
        })
    };

    function parentOf(node) {
        var classNames = node[0].className.split(' ');
        for (key in classNames) {
            if (classNames[key].match(options.childPrefix)) {
                return $("#" + classNames[key].substring(9))
            }
        }
    }
})(jQuery);