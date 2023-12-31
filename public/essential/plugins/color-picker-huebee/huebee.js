/*!
 * Huebee PACKAGED v2.1.1
 * 1-click color picker
 * MIT license
 * https://huebee.buzz
 * Copyright 2020 Metafizzy
 */
(function (t, e) {
    if (typeof define == "function" && define.amd) {
        define("ev-emitter/ev-emitter", e)
    } else if (typeof module == "object" && module.exports) {
        module.exports = e()
    } else {
        t.EvEmitter = e()
    }
})(typeof window != "undefined" ? window : this, function () {
    "use strict";

    function t() {}
    var e = t.prototype;
    e.on = function (t, e) {
        if (!t || !e) {
            return
        }
        var i = this._events = this._events || {};
        var n = i[t] = i[t] || [];
        if (n.indexOf(e) == -1) {
            n.push(e)
        }
        return this
    };
    e.once = function (t, e) {
        if (!t || !e) {
            return
        }
        this.on(t, e);
        var i = this._onceEvents = this._onceEvents || {};
        var n = i[t] = i[t] || {};
        n[e] = true;
        return this
    };
    e.off = function (t, e) {
        var i = this._events && this._events[t];
        if (!i || !i.length) {
            return
        }
        var n = i.indexOf(e);
        if (n != -1) {
            i.splice(n, 1)
        }
        return this
    };
    e.emitEvent = function (t, e) {
        var i = this._events && this._events[t];
        if (!i || !i.length) {
            return
        }
        i = i.slice(0);
        e = e || [];
        var n = this._onceEvents && this._onceEvents[t];
        for (var o = 0; o < i.length; o++) {
            var s = i[o];
            var r = n && n[s];
            if (r) {
                this.off(t, s);
                delete n[s]
            }
            s.apply(this, e)
        }
        return this
    };
    e.allOff = function () {
        delete this._events;
        delete this._onceEvents
    };
    return t
});
/*!
 * Unipointer v2.3.0
 * base class for doing one thing with pointer event
 * MIT license
 */
(function (e, i) {
    if (typeof define == "function" && define.amd) {
        define("unipointer/unipointer", ["ev-emitter/ev-emitter"], function (t) {
            return i(e, t)
        })
    } else if (typeof module == "object" && module.exports) {
        module.exports = i(e, require("ev-emitter"))
    } else {
        e.Unipointer = i(e, e.EvEmitter)
    }
})(window, function t(o, e) {
    "use strict";

    function i() {}

    function n() {}
    var s = n.prototype = Object.create(e.prototype);
    s.bindStartEvent = function (t) {
        this._bindStartEvent(t, true)
    };
    s.unbindStartEvent = function (t) {
        this._bindStartEvent(t, false)
    };
    s._bindStartEvent = function (t, e) {
        e = e === undefined ? true : e;
        var i = e ? "addEventListener" : "removeEventListener";
        var n = "mousedown";
        if (o.PointerEvent) {
            n = "pointerdown"
        } else if ("ontouchstart" in o) {
            n = "touchstart"
        }
        t[i](n, this)
    };
    s.handleEvent = function (t) {
        var e = "on" + t.type;
        if (this[e]) {
            this[e](t)
        }
    };
    s.getTouch = function (t) {
        for (var e = 0; e < t.length; e++) {
            var i = t[e];
            if (i.identifier == this.pointerIdentifier) {
                return i
            }
        }
    };
    s.onmousedown = function (t) {
        var e = t.button;
        if (e && (e !== 0 && e !== 1)) {
            return
        }
        this._pointerDown(t, t)
    };
    s.ontouchstart = function (t) {
        this._pointerDown(t, t.changedTouches[0])
    };
    s.onpointerdown = function (t) {
        this._pointerDown(t, t)
    };
    s._pointerDown = function (t, e) {
        if (t.button || this.isPointerDown) {
            return
        }
        this.isPointerDown = true;
        this.pointerIdentifier = e.pointerId !== undefined ? e.pointerId : e.identifier;
        this.pointerDown(t, e)
    };
    s.pointerDown = function (t, e) {
        this._bindPostStartEvents(t);
        this.emitEvent("pointerDown", [t, e])
    };
    var r = {
        mousedown: ["mousemove", "mouseup"],
        touchstart: ["touchmove", "touchend", "touchcancel"],
        pointerdown: ["pointermove", "pointerup", "pointercancel"]
    };
    s._bindPostStartEvents = function (t) {
        if (!t) {
            return
        }
        var e = r[t.type];
        e.forEach(function (t) {
            o.addEventListener(t, this)
        }, this);
        this._boundPointerEvents = e
    };
    s._unbindPostStartEvents = function () {
        if (!this._boundPointerEvents) {
            return
        }
        this._boundPointerEvents.forEach(function (t) {
            o.removeEventListener(t, this)
        }, this);
        delete this._boundPointerEvents
    };
    s.onmousemove = function (t) {
        this._pointerMove(t, t)
    };
    s.onpointermove = function (t) {
        if (t.pointerId == this.pointerIdentifier) {
            this._pointerMove(t, t)
        }
    };
    s.ontouchmove = function (t) {
        var e = this.getTouch(t.changedTouches);
        if (e) {
            this._pointerMove(t, e)
        }
    };
    s._pointerMove = function (t, e) {
        this.pointerMove(t, e)
    };
    s.pointerMove = function (t, e) {
        this.emitEvent("pointerMove", [t, e])
    };
    s.onmouseup = function (t) {
        this._pointerUp(t, t)
    };
    s.onpointerup = function (t) {
        if (t.pointerId == this.pointerIdentifier) {
            this._pointerUp(t, t)
        }
    };
    s.ontouchend = function (t) {
        var e = this.getTouch(t.changedTouches);
        if (e) {
            this._pointerUp(t, e)
        }
    };
    s._pointerUp = function (t, e) {
        this._pointerDone();
        this.pointerUp(t, e)
    };
    s.pointerUp = function (t, e) {
        this.emitEvent("pointerUp", [t, e])
    };
    s._pointerDone = function () {
        this._pointerReset();
        this._unbindPostStartEvents();
        this.pointerDone()
    };
    s._pointerReset = function () {
        this.isPointerDown = false;
        delete this.pointerIdentifier
    };
    s.pointerDone = i;
    s.onpointercancel = function (t) {
        if (t.pointerId == this.pointerIdentifier) {
            this._pointerCancel(t, t)
        }
    };
    s.ontouchcancel = function (t) {
        var e = this.getTouch(t.changedTouches);
        if (e) {
            this._pointerCancel(t, e)
        }
    };
    s._pointerCancel = function (t, e) {
        this._pointerDone();
        this.pointerCancel(t, e)
    };
    s.pointerCancel = function (t, e) {
        this.emitEvent("pointerCancel", [t, e])
    };
    n.getPointerPoint = function (t) {
        return {
            x: t.pageX,
            y: t.pageY
        }
    };
    return n
});
/*!
 * Huebee v2.1.1
 * 1-click color picker
 * MIT license
 * https://huebee.buzz
 * Copyright 2020 Metafizzy
 */
(function (i, n) {
    if (typeof define == "function" && define.amd) {
        define(["ev-emitter/ev-emitter", "unipointer/unipointer"], function (t, e) {
            return n(i, t, e)
        })
    } else if (typeof module == "object" && module.exports) {
        module.exports = n(i, require("ev-emitter"), require("unipointer"))
    } else {
        i.Huebee = n(i, i.EvEmitter, i.Unipointer)
    }
})(window, function t(e, i, n) {
    function s(t, e) {
        t = b(t);
        if (!t) {
            throw new Error("Bad element for Huebee: " + t)
        }
        this.anchor = t;
        this.options = {};
        this.option(s.defaults);
        this.option(e);
        this.create()
    }
    s.defaults = {
        hues: 12,
        hue0: 0,
        shades: 5,
        saturations: 3,
        notation: "shortHex",
        setText: true,
        setBGColor: true
    };
    var o = s.prototype = Object.create(i.prototype);
    o.option = function (t) {
        this.options = E(this.options, t)
    };
    var r = 0;
    var a = {};
    o.create = function () {
        var t = this.guid = ++r;
        this.anchor.huebeeGUID = t;
        a[t] = this;
        this.setBGElems = this.getSetElems(this.options.setBGColor);
        this.setTextElems = this.getSetElems(this.options.setText);
        this.outsideCloseIt = this.outsideClose.bind(this);
        this.onDocKeydown = this.docKeydown.bind(this);
        this.closeIt = this.close.bind(this);
        this.openIt = this.open.bind(this);
        this.onElemTransitionend = this.elemTransitionend.bind(this);
        this.isInputAnchor = this.anchor.nodeName == "INPUT";
        if (!this.options.staticOpen) {
            this.anchor.addEventListener("click", this.openIt);
            this.anchor.addEventListener("focus", this.openIt)
        }
        if (this.isInputAnchor) {
            this.anchor.addEventListener("input", this.inputInput.bind(this))
        }
        var e = this.element = document.createElement("div");
        e.className = "huebee ";
        e.className += this.options.staticOpen ? "is-static-open " : "is-hidden ";
        e.className += this.options.className || "";
        var i = this.container = document.createElement("div");
        i.className = "huebee__container";

        function n(t) {
            if (t.target == i) {
                t.preventDefault()
            }
        }
        i.addEventListener("mousedown", n);
        i.addEventListener("touchstart", n);
        this.createCanvas();
        this.cursor = document.createElement("div");
        this.cursor.className = "huebee__cursor is-hidden";
        i.appendChild(this.cursor);
        this.createCloseButton();
        e.appendChild(i);
        if (!this.options.staticOpen) {
            var o = getComputedStyle(this.anchor.parentNode);
            if (o.position != "relative" && o.position != "absolute") {
                this.anchor.parentNode.style.position = "relative"
            }
        }
        var s = this.getCustomLength();
        this.satY = s ? Math.ceil(s / this.options.hues) + 1 : 0;
        this.updateColors();
        this.setAnchorColor();
        if (this.options.staticOpen) {
            this.open()
        }
    };
    o.getSetElems = function (t) {
        if (t === true) {
            return [this.anchor]
        } else if (typeof t == "string") {
            return document.querySelectorAll(t)
        }
    };
    o.getCustomLength = function () {
        var t = this.options.customColors;
        return t && t.length || 0
    };
    o.createCanvas = function () {
        var t = this.canvas = document.createElement("canvas");
        t.className = "huebee__canvas";
        this.ctx = t.getContext("2d");
        var e = this.canvasPointer = new n;
        e._bindStartEvent(t);
        e.on("pointerDown", this.canvasPointerDown.bind(this));
        e.on("pointerMove", this.canvasPointerMove.bind(this));
        this.container.appendChild(t)
    };
    var h = "http://www.w3.org/2000/svg";
    o.createCloseButton = function () {
        if (this.options.staticOpen) {
            return
        }
        var t = document.createElementNS(h, "svg");
        t.setAttribute("class", "huebee__close-button");
        t.setAttribute("viewBox", "0 0 24 24");
        t.setAttribute("width", "24");
        t.setAttribute("height", "24");
        var e = document.createElementNS(h, "path");
        e.setAttribute("d", "M 7,7 L 17,17 M 17,7 L 7,17");
        e.setAttribute("class", "huebee__close-button__x");
        t.appendChild(e);
        t.addEventListener("click", this.closeIt);
        this.container.appendChild(t)
    };
    o.updateColors = function () {
        this.swatches = {};
        this.colorGrid = {};
        this.updateColorModer();
        var t = this.options.shades;
        var e = this.options.saturations;
        var o = this.options.hues;
        if (this.getCustomLength()) {
            var s = 0;
            this.options.customColors.forEach(function (t) {
                var e = s % o;
                var i = Math.floor(s / o);
                var n = g(t);
                if (n) {
                    this.addSwatch(n, e, i);
                    s++
                }
            }.bind(this))
        }
        var i;
        for (i = 0; i < e; i++) {
            var n = 1 - i / e;
            var r = t * i + this.satY;
            this.updateSaturationGrid(i, n, r)
        }
        var a = this.getGrayCount();
        for (i = 0; i < a; i++) {
            var h = 1 - i / (t + 1);
            var u = this.colorModer(0, 0, h);
            var c = g(u);
            this.addSwatch(c, o + 1, i)
        }
    };
    o.getGrayCount = function () {
        return this.options.shades ? this.options.shades + 2 : 0
    };
    o.updateSaturationGrid = function (t, e, i) {
        var n = this.options.shades;
        var o = this.options.hues;
        var s = this.options.hue0;
        for (var r = 0; r < n; r++) {
            for (var a = 0; a < o; a++) {
                var h = Math.round(a * 360 / o + s) % 360;
                var u = 1 - (r + 1) / (n + 1);
                var c = this.colorModer(h, e, u);
                var f = g(c);
                var d = r + i;
                this.addSwatch(f, a, d)
            }
        }
    };
    o.addSwatch = function (t, e, i) {
        this.swatches[e + "," + i] = t;
        this.colorGrid[t.color.toUpperCase()] = {
            x: e,
            y: i
        }
    };
    var u = {
        hsl: function (t, e, i) {
            e = Math.round(e * 100);
            i = Math.round(i * 100);
            return "hsl(" + t + ", " + e + "%, " + i + "%)"
        },
        hex: C,
        shortHex: function (t, e, i) {
            var n = C(t, e, i);
            return S(n)
        }
    };
    o.updateColorModer = function () {
        this.colorModer = u[this.options.notation] || u.shortHex
    };
    o.renderColors = function () {
        var t = this.gridSize * 2;
        for (var e in this.swatches) {
            var i = this.swatches[e];
            var n = e.split(",");
            var o = n[0];
            var s = n[1];
            this.ctx.fillStyle = i.color;
            this.ctx.fillRect(o * t, s * t, t, t)
        }
    };
    o.setAnchorColor = function () {
        if (this.isInputAnchor) {
            this.setColor(this.anchor.value)
        }
    };
    var c = document.documentElement;
    o.open = function () {
        if (this.isOpen) {
            return
        }
        var t = this.anchor;
        var e = this.element;
        if (!this.options.staticOpen) {
            e.style.left = t.offsetLeft + "px";
            e.style.top = t.offsetTop + t.offsetHeight + "px"
        }
        this.bindOpenEvents(true);
        e.removeEventListener("transitionend", this.onElemTransitionend);
        t.parentNode.insertBefore(e, t.nextSibling);
        var i = getComputedStyle(e).transitionDuration;
        this.hasTransition = i && i != "none" && parseFloat(i);
        this.isOpen = true;
        this.updateSizes();
        this.renderColors();
        this.setAnchorColor();
        var n = e.offsetHeight;
        e.classList.remove("is-hidden")
    };
    o.bindOpenEvents = function (t) {
        if (this.options.staticOpen) {
            return
        }
        var e = (t ? "add" : "remove") + "EventListener";
        c[e]("mousedown", this.outsideCloseIt);
        c[e]("touchstart", this.outsideCloseIt);
        document[e]("focusin", this.outsideCloseIt);
        document[e]("keydown", this.onDocKeydown);
        this.anchor[e]("blur", this.closeIt)
    };
    o.updateSizes = function () {
        var t = this.options.hues;
        var e = this.options.shades;
        var i = this.options.saturations;
        var n = this.getGrayCount();
        var o = this.getCustomLength();
        this.cursorBorder = parseInt(getComputedStyle(this.cursor).borderTopWidth, 10);
        this.gridSize = Math.round(this.cursor.offsetWidth - this.cursorBorder * 2);
        this.canvasOffset = {
            x: this.canvas.offsetLeft,
            y: this.canvas.offsetTop
        };
        var s, r;
        if (o && !n) {
            s = Math.min(o, t);
            r = Math.ceil(o / t)
        } else {
            s = t + 2;
            r = Math.max(e * i + this.satY, n)
        }
        var a = this.canvas.width = s * this.gridSize * 2;
        this.canvas.height = r * this.gridSize * 2;
        this.canvas.style.width = a / 2 + "px"
    };
    o.outsideClose = function (t) {
        var e = this.anchor.contains(t.target);
        var i = this.element.contains(t.target);
        if (!e && !i) {
            this.close()
        }
    };
    var f = {
        13: true,
        27: true
    };
    o.docKeydown = function (t) {
        if (f[t.keyCode]) {
            this.close()
        }
    };
    var d = typeof c.style.transform == "string";
    o.close = function () {
        if (!this.isOpen) {
            return
        }
        if (d && this.hasTransition) {
            this.element.addEventListener("transitionend", this.onElemTransitionend)
        } else {
            this.remove()
        }
        this.element.classList.add("is-hidden");
        this.bindOpenEvents(false);
        this.isOpen = false
    };
    o.remove = function () {
        var t = this.element.parentNode;
        if (t.contains(this.element)) {
            t.removeChild(this.element)
        }
    };
    o.elemTransitionend = function (t) {
        if (t.target != this.element) {
            return
        }
        this.element.removeEventListener("transitionend", this.onElemTransitionend);
        this.remove()
    };
    o.inputInput = function () {
        this.setColor(this.anchor.value)
    };
    o.canvasPointerDown = function (t, e) {
        t.preventDefault();
        this.updateOffset();
        this.canvasPointerChange(e)
    };
    o.updateOffset = function () {
        var t = this.canvas.getBoundingClientRect();
        this.offset = {
            x: t.left + e.pageXOffset,
            y: t.top + e.pageYOffset
        }
    };
    o.canvasPointerMove = function (t, e) {
        this.canvasPointerChange(e)
    };
    o.canvasPointerChange = function (t) {
        var e = Math.round(t.pageX - this.offset.x);
        var i = Math.round(t.pageY - this.offset.y);
        var n = this.gridSize;
        var o = Math.floor(e / n);
        var s = Math.floor(i / n);
        var r = this.swatches[o + "," + s];
        this.setSwatch(r)
    };
    o.setColor = function (t) {
        var e = g(t);
        this.setSwatch(e)
    };
    o.setSwatch = function (t) {
        var e = t && t.color;
        if (!t) {
            return
        }
        var i = e == this.color;
        this.color = e;
        this.hue = t.hue;
        this.sat = t.sat;
        this.lum = t.lum;
        var n = this.lum - Math.cos((this.hue + 70) / 180 * Math.PI) * .15;
        this.isLight = n > .5;
        var o = this.colorGrid[e.toUpperCase()];
        this.updateCursor(o);
        this.setTexts();
        this.setBackgrounds();
        if (!i) {
            this.emitEvent("change", [e, t.hue, t.sat, t.lum])
        }
    };
    o.setTexts = function () {
        if (!this.setTextElems) {
            return
        }
        for (var t = 0; t < this.setTextElems.length; t++) {
            var e = this.setTextElems[t];
            var i = e.nodeName == "INPUT" ? "value" : "textContent";
            e[i] = this.color
        }
    };
    o.setBackgrounds = function () {
        if (!this.setBGElems) {
            return
        }
        var t = this.isLight ? "#222" : "white";
        for (var e = 0; e < this.setBGElems.length; e++) {
            var i = this.setBGElems[e];
            i.style.backgroundColor = this.color;
            i.style.color = t
        }
    };
    o.updateCursor = function (t) {
        if (!this.isOpen) {
            return
        }
        var e = t ? "remove" : "add";
        this.cursor.classList[e]("is-hidden");
        if (!t) {
            return
        }
        var i = this.gridSize;
        var n = this.canvasOffset;
        var o = this.cursorBorder;
        this.cursor.style.left = t.x * i + n.x - o + "px";
        this.cursor.style.top = t.y * i + n.y - o + "px"
    };
    var v = e.console;

    function p() {
        var t = document.querySelectorAll("[data-huebee]");
        for (var e = 0; e < t.length; e++) {
            var i = t[e];
            var n = i.getAttribute("data-huebee");
            var o;
            try {
                o = n && JSON.parse(n)
            } catch (t) {
                if (v) {
                    v.error("Error parsing data-huebee on " + i.className + ": " + t)
                }
                continue
            }
            new s(i, o)
        }
    }
    var l = document.readyState;
    if (l == "complete" || l == "interactive") {
        p()
    } else {
        document.addEventListener("DOMContentLoaded", p)
    }
    s.data = function (t) {
        t = b(t);
        var e = t && t.huebeeGUID;
        return e && a[e]
    };
    var m;

    function g(t) {
        if (!m) {
            var e = document.createElement("canvas");
            e.width = e.height = 1;
            m = e.getContext("2d")
        }
        m.clearRect(0, 0, 1, 1);
        m.fillStyle = "#010203";
        m.fillStyle = t;
        m.fillRect(0, 0, 1, 1);
        var i = m.getImageData(0, 0, 1, 1).data;
        i = [i[0], i[1], i[2], i[3]];
        if (i.join(",") == "1,2,3,255") {
            return
        }
        var n = _.apply(this, i);
        return {
            color: t.trim(),
            hue: n[0],
            sat: n[1],
            lum: n[2]
        }
    }

    function E(t, e) {
        for (var i in e) {
            t[i] = e[i]
        }
        return t
    }

    function b(t) {
        if (typeof t == "string") {
            t = document.querySelector(t)
        }
        return t
    }

    function C(t, e, i) {
        var n = w(t, e, i);
        return y(n)
    }

    function w(t, e, i) {
        var n = (1 - Math.abs(2 * i - 1)) * e;
        var o = t / 60;
        var s = n * (1 - Math.abs(o % 2 - 1));
        var r, a;
        switch (Math.floor(o)) {
            case 0:
                r = [n, s, 0];
                break;
            case 1:
                r = [s, n, 0];
                break;
            case 2:
                r = [0, n, s];
                break;
            case 3:
                r = [0, s, n];
                break;
            case 4:
                r = [s, 0, n];
                break;
            case 5:
                r = [n, 0, s];
                break;
            default:
                r = [0, 0, 0]
        }
        a = i - n / 2;
        r = r.map(function (t) {
            return t + a
        });
        return r
    }

    function _(t, e, i) {
        t /= 255;
        e /= 255;
        i /= 255;
        var n = Math.max(t, e, i);
        var o = Math.min(t, e, i);
        var s = n - o;
        var r = .5 * (n + o);
        var a = s === 0 ? 0 : s / (1 - Math.abs(2 * r - 1));
        var h;
        if (s === 0) {
            h = 0
        } else if (n === t) {
            h = (e - i) / s % 6
        } else if (n === e) {
            h = (i - t) / s + 2
        } else if (n === i) {
            h = (t - e) / s + 4
        }
        var u = 60 * h;
        return [u, parseFloat(a), parseFloat(r)]
    }

    function y(t) {
        var e = t.map(function (t) {
            t = Math.round(t * 255);
            var e = t.toString(16).toUpperCase();
            e = e.length < 2 ? "0" + e : e;
            return e
        });
        return "#" + e.join("")
    }

    function S(t) {
        return "#" + t[1] + t[3] + t[5]
    }
    return s
});