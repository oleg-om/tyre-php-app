eval(
  (function (p, a, c, k, e, r) {
    e = function (c) {
      return (
        (c < a ? "" : e(parseInt(c / a))) +
        ((c = c % a) > 35 ? String.fromCharCode(c + 29) : c.toString(36))
      );
    };
    if (!"".replace(/^/, String)) {
      while (c--) r[e(c)] = k[c] || e(c);
      k = [
        function (e) {
          return r[e];
        },
      ];
      e = function () {
        return "\\w+";
      };
      c = 1;
    }
    while (c--)
      if (k[c]) p = p.replace(new RegExp("\\b" + e(c) + "\\b", "g"), k[c]);
    return p;
  })(
    ';(6($){$.u.N=6(){5 j=6(a,v,t,b,c){5 d=11.12("U");d.p=v,d.H=t;5 o=a.z;5 e=o.q;3(!a.A){a.A={};x(5 i=0;i<e;i++){a.A[o[i].p]=i}}3(c||c==0){5 f=d;x(5 g=c;g<=e;g++){5 h=a.z[g];a.z[g]=f;o[g]=f;a.A[o[g].p]=g;f=h}}3(9 a.A[v]=="V")a.A[v]=e;a.z[a.A[v]]=d;3(b){d.s=8}};5 a=W;3(a.q==0)7 4;5 k=8;5 m=B;5 l,v,t;3(9(a[0])=="D"){m=8;l=a[0]}3(a.q>=2){3(9(a[1])=="O"){k=a[1];E=a[2]}n 3(9(a[2])=="O"){k=a[2];E=a[1]}n{E=a[1]}3(!m){v=a[0];t=a[1]}}4.y(6(){3(4.F.C()!="G")7;3(m){x(5 a 13 l){j(4,a,l[a],k,E);E+=1}}n{j(4,v,t,k,E)}});7 4};$.u.14=6(b,c,d,e,f){3(9(b)!="J")7 4;3(9(c)!="D")c={};3(9(d)!="O")d=8;4.y(6(){5 a=4;$.15(b,c,6(r){$(a).N(r,d);3(9 e=="6"){3(9 f=="D"){e.16(a,f)}n{e.P(a)}}})});7 4};$.u.X=6(){5 a=W;3(a.q==0)7 4;5 d=9(a[0]);5 v,K;3(d=="J"||d=="D"||d=="6"){v=a[0];3(v.I==Y){5 l=v.q;x(5 i=0;i<l;i++){4.X(v[i],a[1])}7 4}}n 3(d=="17")K=a[0];n 7 4;4.y(6(){3(4.F.C()!="G")7;3(4.A)4.A=Z;5 b=B;5 o=4.z;3(!!v){5 c=o.q;x(5 i=c-1;i>=0;i--){3(v.I==Q){3(o[i].p.R(v)){b=8}}n 3(o[i].p==v){b=8}3(b&&a[1]===8)b=o[i].s;3(b){o[i]=Z}b=B}}n{3(a[1]===8){b=o[K].s}n{b=8}3(b){4.18(K)}}});7 4};$.u.19=6(f){5 g=$(4).10();5 a=9(f)=="V"?8:!!f;4.y(6(){3(4.F.C()!="G")7;5 o=4.z;5 d=o.q;5 e=[];x(5 i=0;i<d;i++){e[i]={v:o[i].p,t:o[i].H}}e.1a(6(b,c){L=b.t.C(),M=c.t.C();3(L==M)7 0;3(a){7 L<M?-1:1}n{7 L>M?-1:1}});x(5 i=0;i<d;i++){o[i].H=e[i].t;o[i].p=e[i].v}}).S(g,8);7 4};$.u.S=6(b,d){5 v=b;5 e=9(b);3(e=="D"&&v.I==Y){5 f=4;$.y(v,6(){f.S(4,d)})};5 c=d||B;3(e!="J"&&e!="6"&&e!="D")7 4;4.y(6(){3(4.F.C()!="G")7 4;5 o=4.z;5 a=o.q;x(5 i=0;i<a;i++){3(v.I==Q){3(o[i].p.R(v)){o[i].s=8}n 3(c){o[i].s=B}}n{3(o[i].p==v){o[i].s=8}n 3(c){o[i].s=B}}}});7 4};$.u.1b=6(b,c){5 w=c||"s";3($(b).1c()==0)7 4;4.y(6(){3(4.F.C()!="G")7 4;5 o=4.z;5 a=o.q;x(5 i=0;i<a;i++){3(w=="1d"||(w=="s"&&o[i].s)){$(b).N(o[i].p,o[i].H)}}});7 4};$.u.1e=6(b,c){5 d=B;5 v=b;5 e=9(v);5 f=9(c);3(e!="J"&&e!="6"&&e!="D")7 f=="6"?4:d;4.y(6(){3(4.F.C()!="G")7 4;3(d&&f!="6")7 B;5 o=4.z;5 a=o.q;x(5 i=0;i<a;i++){3(v.I==Q){3(o[i].p.R(v)){d=8;3(f=="6")c.P(o[i],i)}}n{3(o[i].p==v){d=8;3(f=="6")c.P(o[i],i)}}}});7 f=="6"?4:d};$.u.10=6(){5 v=[];4.T().y(6(){v[v.q]=4.p});7 v};$.u.1f=6(){5 t=[];4.T().y(6(){t[t.q]=4.H});7 t};$.u.T=6(){7 4.1g("U:s")}})(1h);',
    62,
    80,
    "|||if|this|var|function|return|true|typeof||||||||||||||else||value|length||selected||fn|||for|each|options|cache|false|toLowerCase|object|startindex|nodeName|select|text|constructor|string|index|o1t|o2t|addOption|boolean|call|RegExp|match|selectOptions|selectedOptions|option|undefined|arguments|removeOption|Array|null|selectedValues|document|createElement|in|ajaxAddOption|getJSON|apply|number|remove|sortOptions|sort|copyOptions|size|all|containsOption|selectedTexts|find|jQuery".split(
      "|"
    ),
    0,
    {}
  )
);
var jaaulde = window.jaaulde || {};
jaaulde.utils = jaaulde.utils || {};
jaaulde.utils.cookies = (function () {
  var cookies = [];
  var defaultOptions = {
    hoursToLive: null,
    path: "/",
    domain: null,
    secure: false,
  };
  var resolveOptions = function (options) {
    var returnValue;
    if (typeof options !== "object" || options === null) {
      returnValue = defaultOptions;
    } else {
      returnValue = {
        hoursToLive:
          typeof options.hoursToLive === "number" && options.hoursToLive !== 0
            ? options.hoursToLive
            : defaultOptions.hoursToLive,
        path:
          typeof options.path === "string" && options.path !== ""
            ? options.path
            : defaultOptions.path,
        domain:
          typeof options.domain === "string" && options.domain !== ""
            ? options.domain
            : defaultOptions.domain,
        secure:
          typeof options.secure === "boolean" && options.secure
            ? options.secure
            : defaultOptions.secure,
      };
    }
    return returnValue;
  };
  var expiresGMTString = function (hoursToLive) {
    var dateObject = new Date();
    dateObject.setTime(dateObject.getTime() + hoursToLive * 60 * 60 * 1000);
    return dateObject.toGMTString();
  };
  var assembleOptionsString = function (options) {
    options = resolveOptions(options);
    return (
      (typeof options.hoursToLive === "number"
        ? "; expires=" + expiresGMTString(options.hoursToLive)
        : "") +
      "; path=" +
      options.path +
      (typeof options.domain === "string" ? "; domain=" + options.domain : "") +
      (options.secure === true ? "; secure" : "")
    );
  };
  var splitCookies = function () {
    cookies = {};
    var pair,
      name,
      value,
      separated = document.cookie.split(";");
    for (var i = 0; i < separated.length; i = i + 1) {
      pair = separated[i].split("=");
      name = pair[0].replace(/^\s*/, "").replace(/\s*$/, "");
      value = decodeURIComponent(pair[1]);
      cookies[name] = value;
    }
    return cookies;
  };
  var constructor = function () {};
  constructor.prototype.get = function (cookieName) {
    var returnValue;
    splitCookies();
    if (typeof cookieName === "string") {
      returnValue =
        typeof cookies[cookieName] !== "undefined" ? cookies[cookieName] : null;
    } else if (typeof cookieName === "object" && cookieName !== null) {
      returnValue = {};
      for (var item in cookieName) {
        if (typeof cookies[cookieName[item]] !== "undefined") {
          returnValue[cookieName[item]] = cookies[cookieName[item]];
        } else {
          returnValue[cookieName[item]] = null;
        }
      }
    } else {
      returnValue = cookies;
    }
    return returnValue;
  };
  constructor.prototype.filter = function (cookieNameRegExp) {
    var returnValue = {};
    splitCookies();
    if (typeof cookieNameRegExp === "string") {
      cookieNameRegExp = new RegExp(cookieNameRegExp);
    }
    for (var cookieName in cookies) {
      if (cookieName.match(cookieNameRegExp)) {
        returnValue[cookieName] = cookies[cookieName];
      }
    }
    return returnValue;
  };
  constructor.prototype.set = function (cookieName, value, options) {
    if (typeof value === "undefined" || value === null) {
      if (typeof options !== "object" || options === null) {
        options = {};
      }
      value = "";
      options.hoursToLive = -8760;
    }
    var optionsString = assembleOptionsString(options);
    document.cookie =
      cookieName + "=" + encodeURIComponent(value) + optionsString;
  };
  constructor.prototype.del = function (cookieName, options) {
    var allCookies = {};
    if (typeof options !== "object" || options === null) {
      options = {};
    }
    if (typeof cookieName === "boolean" && cookieName === true) {
      allCookies = this.get();
    } else if (typeof cookieName === "string") {
      allCookies[cookieName] = true;
    }
    for (var name in allCookies) {
      if (typeof name === "string" && name !== "") {
        this.set(name, null, options);
      }
    }
  };
  constructor.prototype.test = function () {
    var returnValue = false,
      testName = "cT",
      testValue = "data";
    this.set(testName, testValue);
    if (this.get(testName) === testValue) {
      this.del(testName);
      returnValue = true;
    }
    return returnValue;
  };
  constructor.prototype.setOptions = function (options) {
    if (typeof options !== "object") {
      options = null;
    }
    defaultOptions = resolveOptions(options);
  };
  return new constructor();
})();
(function () {
  if (window.jQuery) {
    (function ($) {
      $.cookies = jaaulde.utils.cookies;
      var extensions = {
        cookify: function (options) {
          return this.each(function () {
            var i,
              resolvedName = false,
              resolvedValue = false,
              name = "",
              value = "",
              nameAttrs = ["name", "id"],
              nodeName,
              inputType;
            for (i in nameAttrs) {
              if (!isNaN(i)) {
                name = $(this).attr(nameAttrs[i]);
                if (typeof name === "string" && name !== "") {
                  resolvedName = true;
                  break;
                }
              }
            }
            if (resolvedName) {
              nodeName = this.nodeName.toLowerCase();
              if (
                nodeName !== "input" &&
                nodeName !== "textarea" &&
                nodeName !== "select" &&
                nodeName !== "img"
              ) {
                value = $(this).html();
                resolvedValue = true;
              } else {
                inputType = $(this).attr("type");
                if (typeof inputType === "string" && inputType !== "") {
                  inputType = inputType.toLowerCase();
                }
                if (inputType !== "radio" && inputType !== "checkbox") {
                  value = $(this).val();
                  resolvedValue = true;
                }
              }
              if (resolvedValue) {
                if (typeof value !== "string" || value === "") {
                  value = null;
                }
                $.cookies.set(name, value, options);
              }
            }
          });
        },
        cookieFill: function () {
          return this.each(function () {
            var i,
              resolvedName = false,
              name = "",
              value,
              nameAttrs = ["name", "id"],
              iteration = 0,
              nodeName;
            for (i in nameAttrs) {
              if (!isNaN(i)) {
                name = $(this).attr(nameAttrs[i]);
                if (typeof name === "string" && name !== "") {
                  resolvedName = true;
                  break;
                }
              }
            }
            if (resolvedName) {
              value = $.cookies.get(name);
              if (value !== null) {
                nodeName = this.nodeName.toLowerCase();
                if (
                  nodeName === "input" ||
                  nodeName === "textarea" ||
                  nodeName === "select"
                ) {
                  $(this).val(value);
                } else {
                  $(this).html(value);
                }
              }
            }
            iteration = 0;
          });
        },
        cookieBind: function (options) {
          return this.each(function () {
            $(this)
              .cookieFill()
              .change(function () {
                $(this).cookify(options);
              });
          });
        },
      };
      $.each(extensions, function (i) {
        $.fn[i] = this;
      });
    })(window.jQuery);
  }
})();
(function (c) {
  c.extend(c.fn, {
    validate: function (a) {
      if (this.length) {
        var b = c.data(this[0], "validator");
        if (b) return b;
        this.attr("novalidate", "novalidate");
        b = new c.validator(a, this[0]);
        c.data(this[0], "validator", b);
        if (b.settings.onsubmit) {
          a = this.find("input, button");
          a.filter(".cancel").click(function () {
            b.cancelSubmit = true;
          });
          b.settings.submitHandler &&
            a.filter(":submit").click(function () {
              b.submitButton = this;
            });
          this.submit(function (d) {
            function e() {
              if (b.settings.submitHandler) {
                if (b.submitButton)
                  var f = c("<input type='hidden'/>")
                    .attr("name", b.submitButton.name)
                    .val(b.submitButton.value)
                    .appendTo(b.currentForm);
                b.settings.submitHandler.call(b, b.currentForm);
                b.submitButton && f.remove();
                return false;
              }
              return true;
            }
            b.settings.debug && d.preventDefault();
            if (b.cancelSubmit) {
              b.cancelSubmit = false;
              return e();
            }
            if (b.form()) {
              if (b.pendingRequest) {
                b.formSubmitted = true;
                return false;
              }
              return e();
            } else {
              b.focusInvalid();
              return false;
            }
          });
        }
        return b;
      } else
        a &&
          a.debug &&
          window.console &&
          console.warn("nothing selected, can't validate, returning nothing");
    },
    valid: function () {
      if (c(this[0]).is("form")) return this.validate().form();
      else {
        var a = true,
          b = c(this[0].form).validate();
        this.each(function () {
          a &= b.element(this);
        });
        return a;
      }
    },
    removeAttrs: function (a) {
      var b = {},
        d = this;
      c.each(a.split(/\s/), function (e, f) {
        b[f] = d.attr(f);
        d.removeAttr(f);
      });
      return b;
    },
    rules: function (a, b) {
      var d = this[0];
      if (a) {
        var e = c.data(d.form, "validator").settings,
          f = e.rules,
          g = c.validator.staticRules(d);
        switch (a) {
          case "add":
            c.extend(g, c.validator.normalizeRule(b));
            f[d.name] = g;
            if (b.messages)
              e.messages[d.name] = c.extend(e.messages[d.name], b.messages);
            break;
          case "remove":
            if (!b) {
              delete f[d.name];
              return g;
            }
            var h = {};
            c.each(b.split(/\s/), function (j, i) {
              h[i] = g[i];
              delete g[i];
            });
            return h;
        }
      }
      d = c.validator.normalizeRules(
        c.extend(
          {},
          c.validator.metadataRules(d),
          c.validator.classRules(d),
          c.validator.attributeRules(d),
          c.validator.staticRules(d)
        ),
        d
      );
      if (d.required) {
        e = d.required;
        delete d.required;
        d = c.extend({ required: e }, d);
      }
      return d;
    },
  });
  c.extend(c.expr[":"], {
    blank: function (a) {
      return !c.trim("" + a.value);
    },
    filled: function (a) {
      return !!c.trim("" + a.value);
    },
    unchecked: function (a) {
      return !a.checked;
    },
  });
  c.validator = function (a, b) {
    this.settings = c.extend(true, {}, c.validator.defaults, a);
    this.currentForm = b;
    this.init();
  };
  c.validator.format = function (a, b) {
    if (arguments.length == 1)
      return function () {
        var d = c.makeArray(arguments);
        d.unshift(a);
        return c.validator.format.apply(this, d);
      };
    if (arguments.length > 2 && b.constructor != Array)
      b = c.makeArray(arguments).slice(1);
    if (b.constructor != Array) b = [b];
    c.each(b, function (d, e) {
      a = a.replace(RegExp("\\{" + d + "\\}", "g"), e);
    });
    return a;
  };
  c.extend(c.validator, {
    defaults: {
      messages: {},
      groups: {},
      rules: {},
      errorClass: "error",
      validClass: "valid",
      errorElement: "label",
      focusInvalid: true,
      errorContainer: c([]),
      errorLabelContainer: c([]),
      onsubmit: true,
      ignore: ":hidden",
      ignoreTitle: false,
      onfocusin: function (a) {
        this.lastActive = a;
        if (this.settings.focusCleanup && !this.blockFocusCleanup) {
          this.settings.unhighlight &&
            this.settings.unhighlight.call(
              this,
              a,
              this.settings.errorClass,
              this.settings.validClass
            );
          this.addWrapper(this.errorsFor(a)).hide();
        }
      },
      onfocusout: function (a) {
        if (
          !this.checkable(a) &&
          (a.name in this.submitted || !this.optional(a))
        )
          this.element(a);
      },
      onkeyup: function (a) {
        if (a.name in this.submitted || a == this.lastElement) this.element(a);
      },
      onclick: function (a) {
        if (a.name in this.submitted) this.element(a);
        else a.parentNode.name in this.submitted && this.element(a.parentNode);
      },
      highlight: function (a, b, d) {
        a.type === "radio"
          ? this.findByName(a.name).addClass(b).removeClass(d)
          : c(a).addClass(b).removeClass(d);
      },
      unhighlight: function (a, b, d) {
        a.type === "radio"
          ? this.findByName(a.name).removeClass(b).addClass(d)
          : c(a).removeClass(b).addClass(d);
      },
    },
    setDefaults: function (a) {
      c.extend(c.validator.defaults, a);
    },
    messages: {
      required: "This field is required.",
      remote: "Please fix this field.",
      email: "Please enter a valid email address.",
      url: "Please enter a valid URL.",
      date: "Please enter a valid date.",
      dateISO: "Please enter a valid date (ISO).",
      number: "Please enter a valid number.",
      digits: "Please enter only digits.",
      creditcard: "Please enter a valid credit card number.",
      equalTo: "Please enter the same value again.",
      accept: "Please enter a value with a valid extension.",
      maxlength: c.validator.format(
        "Please enter no more than {0} characters."
      ),
      minlength: c.validator.format("Please enter at least {0} characters."),
      rangelength: c.validator.format(
        "Please enter a value between {0} and {1} characters long."
      ),
      range: c.validator.format("Please enter a value between {0} and {1}."),
      max: c.validator.format(
        "Please enter a value less than or equal to {0}."
      ),
      min: c.validator.format(
        "Please enter a value greater than or equal to {0}."
      ),
    },
    autoCreateRanges: false,
    prototype: {
      init: function () {
        function a(e) {
          var f = c.data(this[0].form, "validator"),
            g = "on" + e.type.replace(/^validate/, "");
          f.settings[g] && f.settings[g].call(f, this[0], e);
        }
        this.labelContainer = c(this.settings.errorLabelContainer);
        this.errorContext =
          (this.labelContainer.length && this.labelContainer) ||
          c(this.currentForm);
        this.containers = c(this.settings.errorContainer).add(
          this.settings.errorLabelContainer
        );
        this.submitted = {};
        this.valueCache = {};
        this.pendingRequest = 0;
        this.pending = {};
        this.invalid = {};
        this.reset();
        var b = (this.groups = {});
        c.each(this.settings.groups, function (e, f) {
          c.each(f.split(/\s/), function (g, h) {
            b[h] = e;
          });
        });
        var d = this.settings.rules;
        c.each(d, function (e, f) {
          d[e] = c.validator.normalizeRule(f);
        });
        c(this.currentForm)
          .validateDelegate(
            "[type='text'], [type='password'], [type='file'], select, textarea, [type='number'], [type='search'] ,[type='tel'], [type='url'], [type='email'], [type='datetime'], [type='date'], [type='month'], [type='week'], [type='time'], [type='datetime-local'], [type='range'], [type='color'] ",
            "focusin focusout keyup",
            a
          )
          .validateDelegate(
            "[type='radio'], [type='checkbox'], select, option",
            "click",
            a
          );
        this.settings.invalidHandler &&
          c(this.currentForm).bind(
            "invalid-form.validate",
            this.settings.invalidHandler
          );
      },
      form: function () {
        this.checkForm();
        c.extend(this.submitted, this.errorMap);
        this.invalid = c.extend({}, this.errorMap);
        this.valid() ||
          c(this.currentForm).triggerHandler("invalid-form", [this]);
        this.showErrors();
        return this.valid();
      },
      checkForm: function () {
        this.prepareForm();
        for (var a = 0, b = (this.currentElements = this.elements()); b[a]; a++)
          this.check(b[a]);
        return this.valid();
      },
      element: function (a) {
        this.lastElement = a = this.validationTargetFor(this.clean(a));
        this.prepareElement(a);
        this.currentElements = c(a);
        var b = this.check(a);
        if (b) delete this.invalid[a.name];
        else this.invalid[a.name] = true;
        if (!this.numberOfInvalids())
          this.toHide = this.toHide.add(this.containers);
        this.showErrors();
        return b;
      },
      showErrors: function (a) {
        if (a) {
          c.extend(this.errorMap, a);
          this.errorList = [];
          for (var b in a)
            this.errorList.push({
              message: a[b],
              element: this.findByName(b)[0],
            });
          this.successList = c.grep(this.successList, function (d) {
            return !(d.name in a);
          });
        }
        this.settings.showErrors
          ? this.settings.showErrors.call(this, this.errorMap, this.errorList)
          : this.defaultShowErrors();
      },
      resetForm: function () {
        c.fn.resetForm && c(this.currentForm).resetForm();
        this.submitted = {};
        this.lastElement = null;
        this.prepareForm();
        this.hideErrors();
        this.elements().removeClass(this.settings.errorClass);
      },
      numberOfInvalids: function () {
        return this.objectLength(this.invalid);
      },
      objectLength: function (a) {
        var b = 0,
          d;
        for (d in a) b++;
        return b;
      },
      hideErrors: function () {
        this.addWrapper(this.toHide).hide();
      },
      valid: function () {
        return this.size() == 0;
      },
      size: function () {
        return this.errorList.length;
      },
      focusInvalid: function () {
        if (this.settings.focusInvalid)
          try {
            c(
              this.findLastActive() ||
                (this.errorList.length && this.errorList[0].element) ||
                []
            )
              .filter(":visible")
              .focus()
              .trigger("focusin");
          } catch (a) {}
      },
      findLastActive: function () {
        var a = this.lastActive;
        return (
          a &&
          c.grep(this.errorList, function (b) {
            return b.element.name == a.name;
          }).length == 1 &&
          a
        );
      },
      elements: function () {
        var a = this,
          b = {};
        return c(this.currentForm)
          .find("input, select, textarea")
          .not(":submit, :reset, :image, [disabled]")
          .not(this.settings.ignore)
          .filter(function () {
            !this.name &&
              a.settings.debug &&
              window.console &&
              console.error("%o has no name assigned", this);
            if (this.name in b || !a.objectLength(c(this).rules()))
              return false;
            return (b[this.name] = true);
          });
      },
      clean: function (a) {
        return c(a)[0];
      },
      errors: function () {
        return c(
          this.settings.errorElement + "." + this.settings.errorClass,
          this.errorContext
        );
      },
      reset: function () {
        this.successList = [];
        this.errorList = [];
        this.errorMap = {};
        this.toShow = c([]);
        this.toHide = c([]);
        this.currentElements = c([]);
      },
      prepareForm: function () {
        this.reset();
        this.toHide = this.errors().add(this.containers);
      },
      prepareElement: function (a) {
        this.reset();
        this.toHide = this.errorsFor(a);
      },
      check: function (a) {
        a = this.validationTargetFor(this.clean(a));
        var b = c(a).rules(),
          d = false,
          e;
        for (e in b) {
          var f = { method: e, parameters: b[e] };
          try {
            var g = c.validator.methods[e].call(
              this,
              a.value.replace(/\r/g, ""),
              a,
              f.parameters
            );
            if (g == "dependency-mismatch") d = true;
            else {
              d = false;
              if (g == "pending") {
                this.toHide = this.toHide.not(this.errorsFor(a));
                return;
              }
              if (!g) {
                this.formatAndAdd(a, f);
                return false;
              }
            }
          } catch (h) {
            this.settings.debug &&
              window.console &&
              console.log(
                "exception occured when checking element " +
                  a.id +
                  ", check the '" +
                  f.method +
                  "' method",
                h
              );
            throw h;
          }
        }
        if (!d) {
          this.objectLength(b) && this.successList.push(a);
          return true;
        }
      },
      customMetaMessage: function (a, b) {
        if (c.metadata) {
          var d = this.settings.meta
            ? c(a).metadata()[this.settings.meta]
            : c(a).metadata();
          return d && d.messages && d.messages[b];
        }
      },
      customMessage: function (a, b) {
        var d = this.settings.messages[a];
        return d && (d.constructor == String ? d : d[b]);
      },
      findDefined: function () {
        for (var a = 0; a < arguments.length; a++)
          if (arguments[a] !== undefined) return arguments[a];
      },
      defaultMessage: function (a, b) {
        return this.findDefined(
          this.customMessage(a.name, b),
          this.customMetaMessage(a, b),
          (!this.settings.ignoreTitle && a.title) || undefined,
          c.validator.messages[b],
          "<strong>Warning: No message defined for " + a.name + "</strong>"
        );
      },
      formatAndAdd: function (a, b) {
        var d = this.defaultMessage(a, b.method),
          e = /\$?\{(\d+)\}/g;
        if (typeof d == "function") d = d.call(this, b.parameters, a);
        else if (e.test(d))
          d = jQuery.format(d.replace(e, "{$1}"), b.parameters);
        this.errorList.push({ message: d, element: a });
        this.errorMap[a.name] = d;
        this.submitted[a.name] = d;
      },
      addWrapper: function (a) {
        if (this.settings.wrapper) a = a.add(a.parent(this.settings.wrapper));
        return a;
      },
      defaultShowErrors: function () {
        for (var a = 0; this.errorList[a]; a++) {
          var b = this.errorList[a];
          this.settings.highlight &&
            this.settings.highlight.call(
              this,
              b.element,
              this.settings.errorClass,
              this.settings.validClass
            );
          this.showLabel(b.element, b.message);
        }
        if (this.errorList.length)
          this.toShow = this.toShow.add(this.containers);
        if (this.settings.success)
          for (a = 0; this.successList[a]; a++)
            this.showLabel(this.successList[a]);
        if (this.settings.unhighlight) {
          a = 0;
          for (b = this.validElements(); b[a]; a++)
            this.settings.unhighlight.call(
              this,
              b[a],
              this.settings.errorClass,
              this.settings.validClass
            );
        }
        this.toHide = this.toHide.not(this.toShow);
        this.hideErrors();
        this.addWrapper(this.toShow).show();
      },
      validElements: function () {
        return this.currentElements.not(this.invalidElements());
      },
      invalidElements: function () {
        return c(this.errorList).map(function () {
          return this.element;
        });
      },
      showLabel: function (a, b) {
        var d = this.errorsFor(a);
        if (d.length) {
          d.removeClass(this.settings.validClass).addClass(
            this.settings.errorClass
          );
          d.attr("generated") && d.html(b);
        } else {
          d = c("<" + this.settings.errorElement + "/>")
            .attr({ for: this.idOrName(a), generated: true })
            .addClass(this.settings.errorClass)
            .html(b || "");
          if (this.settings.wrapper)
            d = d
              .hide()
              .show()
              .wrap("<" + this.settings.wrapper + "/>")
              .parent();
          this.labelContainer.append(d).length ||
            (this.settings.errorPlacement
              ? this.settings.errorPlacement(d, c(a))
              : d.insertAfter(a));
        }
        if (!b && this.settings.success) {
          d.text("");
          typeof this.settings.success == "string"
            ? d.addClass(this.settings.success)
            : this.settings.success(d);
        }
        this.toShow = this.toShow.add(d);
      },
      errorsFor: function (a) {
        var b = this.idOrName(a);
        return this.errors().filter(function () {
          return c(this).attr("for") == b;
        });
      },
      idOrName: function (a) {
        return (
          this.groups[a.name] || (this.checkable(a) ? a.name : a.id || a.name)
        );
      },
      validationTargetFor: function (a) {
        if (this.checkable(a))
          a = this.findByName(a.name).not(this.settings.ignore)[0];
        return a;
      },
      checkable: function (a) {
        return /radio|checkbox/i.test(a.type);
      },
      findByName: function (a) {
        var b = this.currentForm;
        return c(document.getElementsByName(a)).map(function (d, e) {
          return (e.form == b && e.name == a && e) || null;
        });
      },
      getLength: function (a, b) {
        switch (b.nodeName.toLowerCase()) {
          case "select":
            return c("option:selected", b).length;
          case "input":
            if (this.checkable(b))
              return this.findByName(b.name).filter(":checked").length;
        }
        return a.length;
      },
      depend: function (a, b) {
        return this.dependTypes[typeof a]
          ? this.dependTypes[typeof a](a, b)
          : true;
      },
      dependTypes: {
        boolean: function (a) {
          return a;
        },
        string: function (a, b) {
          return !!c(a, b.form).length;
        },
        function: function (a, b) {
          return a(b);
        },
      },
      optional: function (a) {
        return (
          !c.validator.methods.required.call(this, c.trim(a.value), a) &&
          "dependency-mismatch"
        );
      },
      startRequest: function (a) {
        if (!this.pending[a.name]) {
          this.pendingRequest++;
          this.pending[a.name] = true;
        }
      },
      stopRequest: function (a, b) {
        this.pendingRequest--;
        if (this.pendingRequest < 0) this.pendingRequest = 0;
        delete this.pending[a.name];
        if (
          b &&
          this.pendingRequest == 0 &&
          this.formSubmitted &&
          this.form()
        ) {
          c(this.currentForm).submit();
          this.formSubmitted = false;
        } else if (!b && this.pendingRequest == 0 && this.formSubmitted) {
          c(this.currentForm).triggerHandler("invalid-form", [this]);
          this.formSubmitted = false;
        }
      },
      previousValue: function (a) {
        return (
          c.data(a, "previousValue") ||
          c.data(a, "previousValue", {
            old: null,
            valid: true,
            message: this.defaultMessage(a, "remote"),
          })
        );
      },
    },
    classRuleSettings: {
      required: { required: true },
      email: { email: true },
      url: { url: true },
      date: { date: true },
      dateISO: { dateISO: true },
      dateDE: { dateDE: true },
      number: { number: true },
      numberDE: { numberDE: true },
      digits: { digits: true },
      creditcard: { creditcard: true },
    },
    addClassRules: function (a, b) {
      a.constructor == String
        ? (this.classRuleSettings[a] = b)
        : c.extend(this.classRuleSettings, a);
    },
    classRules: function (a) {
      var b = {};
      (a = c(a).attr("class")) &&
        c.each(a.split(" "), function () {
          this in c.validator.classRuleSettings &&
            c.extend(b, c.validator.classRuleSettings[this]);
        });
      return b;
    },
    attributeRules: function (a) {
      var b = {};
      a = c(a);
      for (var d in c.validator.methods) {
        var e;
        if (
          (e =
            d === "required" && typeof c.fn.prop === "function"
              ? a.prop(d)
              : a.attr(d))
        )
          b[d] = e;
        else if (a[0].getAttribute("type") === d) b[d] = true;
      }
      b.maxlength &&
        /-1|2147483647|524288/.test(b.maxlength) &&
        delete b.maxlength;
      return b;
    },
    metadataRules: function (a) {
      if (!c.metadata) return {};
      var b = c.data(a.form, "validator").settings.meta;
      return b ? c(a).metadata()[b] : c(a).metadata();
    },
    staticRules: function (a) {
      var b = {},
        d = c.data(a.form, "validator");
      if (d.settings.rules)
        b = c.validator.normalizeRule(d.settings.rules[a.name]) || {};
      return b;
    },
    normalizeRules: function (a, b) {
      c.each(a, function (d, e) {
        if (e === false) delete a[d];
        else if (e.param || e.depends) {
          var f = true;
          switch (typeof e.depends) {
            case "string":
              f = !!c(e.depends, b.form).length;
              break;
            case "function":
              f = e.depends.call(b, b);
          }
          if (f) a[d] = e.param !== undefined ? e.param : true;
          else delete a[d];
        }
      });
      c.each(a, function (d, e) {
        a[d] = c.isFunction(e) ? e(b) : e;
      });
      c.each(["minlength", "maxlength", "min", "max"], function () {
        if (a[this]) a[this] = Number(a[this]);
      });
      c.each(["rangelength", "range"], function () {
        if (a[this]) a[this] = [Number(a[this][0]), Number(a[this][1])];
      });
      if (c.validator.autoCreateRanges) {
        if (a.min && a.max) {
          a.range = [a.min, a.max];
          delete a.min;
          delete a.max;
        }
        if (a.minlength && a.maxlength) {
          a.rangelength = [a.minlength, a.maxlength];
          delete a.minlength;
          delete a.maxlength;
        }
      }
      a.messages && delete a.messages;
      return a;
    },
    normalizeRule: function (a) {
      if (typeof a == "string") {
        var b = {};
        c.each(a.split(/\s/), function () {
          b[this] = true;
        });
        a = b;
      }
      return a;
    },
    addMethod: function (a, b, d) {
      c.validator.methods[a] = b;
      c.validator.messages[a] = d != undefined ? d : c.validator.messages[a];
      b.length < 3 &&
        c.validator.addClassRules(a, c.validator.normalizeRule(a));
    },
    methods: {
      required: function (a, b, d) {
        if (!this.depend(d, b)) return "dependency-mismatch";
        switch (b.nodeName.toLowerCase()) {
          case "select":
            return (a = c(b).val()) && a.length > 0;
          case "input":
            if (this.checkable(b)) return this.getLength(a, b) > 0;
          default:
            return c.trim(a).length > 0;
        }
      },
      remote: function (a, b, d) {
        if (this.optional(b)) return "dependency-mismatch";
        var e = this.previousValue(b);
        this.settings.messages[b.name] || (this.settings.messages[b.name] = {});
        e.originalMessage = this.settings.messages[b.name].remote;
        this.settings.messages[b.name].remote = e.message;
        d = (typeof d == "string" && { url: d }) || d;
        if (this.pending[b.name]) return "pending";
        if (e.old === a) return e.valid;
        e.old = a;
        var f = this;
        this.startRequest(b);
        var g = {};
        g[b.name] = a;
        c.ajax(
          c.extend(
            true,
            {
              url: d,
              mode: "abort",
              port: "validate" + b.name,
              dataType: "json",
              data: g,
              success: function (h) {
                f.settings.messages[b.name].remote = e.originalMessage;
                var j = h === true;
                if (j) {
                  var i = f.formSubmitted;
                  f.prepareElement(b);
                  f.formSubmitted = i;
                  f.successList.push(b);
                  f.showErrors();
                } else {
                  i = {};
                  h = h || f.defaultMessage(b, "remote");
                  i[b.name] = e.message = c.isFunction(h) ? h(a) : h;
                  f.showErrors(i);
                }
                e.valid = j;
                f.stopRequest(b, j);
              },
            },
            d
          )
        );
        return "pending";
      },
      minlength: function (a, b, d) {
        return this.optional(b) || this.getLength(c.trim(a), b) >= d;
      },
      maxlength: function (a, b, d) {
        return this.optional(b) || this.getLength(c.trim(a), b) <= d;
      },
      rangelength: function (a, b, d) {
        a = this.getLength(c.trim(a), b);
        return this.optional(b) || (a >= d[0] && a <= d[1]);
      },
      min: function (a, b, d) {
        return this.optional(b) || a >= d;
      },
      max: function (a, b, d) {
        return this.optional(b) || a <= d;
      },
      range: function (a, b, d) {
        return this.optional(b) || (a >= d[0] && a <= d[1]);
      },
      email: function (a, b) {
        return (
          this.optional(b) ||
          /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(
            a
          )
        );
      },
      url: function (a, b) {
        return (
          this.optional(b) ||
          /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(
            a
          )
        );
      },
      date: function (a, b) {
        return this.optional(b) || !/Invalid|NaN/.test(new Date(a));
      },
      dateISO: function (a, b) {
        return this.optional(b) || /^\d{4}[\/-]\d{1,2}[\/-]\d{1,2}$/.test(a);
      },
      number: function (a, b) {
        return (
          this.optional(b) || /^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/.test(a)
        );
      },
      digits: function (a, b) {
        return this.optional(b) || /^\d+$/.test(a);
      },
      creditcard: function (a, b) {
        if (this.optional(b)) return "dependency-mismatch";
        if (/[^0-9 -]+/.test(a)) return false;
        var d = 0,
          e = 0,
          f = false;
        a = a.replace(/\D/g, "");
        for (var g = a.length - 1; g >= 0; g--) {
          e = a.charAt(g);
          e = parseInt(e, 10);
          if (f) if ((e *= 2) > 9) e -= 9;
          d += e;
          f = !f;
        }
        return d % 10 == 0;
      },
      accept: function (a, b, d) {
        d = typeof d == "string" ? d.replace(/,/g, "|") : "png|jpe?g|gif";
        return this.optional(b) || a.match(RegExp(".(" + d + ")$", "i"));
      },
      equalTo: function (a, b, d) {
        d = c(d)
          .unbind(".validate-equalTo")
          .bind("blur.validate-equalTo", function () {
            c(b).valid();
          });
        return a == d.val();
      },
    },
  });
  c.format = c.validator.format;
})(jQuery);
(function (c) {
  var a = {};
  if (c.ajaxPrefilter)
    c.ajaxPrefilter(function (d, e, f) {
      e = d.port;
      if (d.mode == "abort") {
        a[e] && a[e].abort();
        a[e] = f;
      }
    });
  else {
    var b = c.ajax;
    c.ajax = function (d) {
      var e = ("port" in d ? d : c.ajaxSettings).port;
      if (("mode" in d ? d : c.ajaxSettings).mode == "abort") {
        a[e] && a[e].abort();
        return (a[e] = b.apply(this, arguments));
      }
      return b.apply(this, arguments);
    };
  }
})(jQuery);
(function (c) {
  !jQuery.event.special.focusin &&
    !jQuery.event.special.focusout &&
    document.addEventListener &&
    c.each({ focus: "focusin", blur: "focusout" }, function (a, b) {
      function d(e) {
        e = c.event.fix(e);
        e.type = b;
        return c.event.handle.call(this, e);
      }
      c.event.special[b] = {
        setup: function () {
          this.addEventListener(a, d, true);
        },
        teardown: function () {
          this.removeEventListener(a, d, true);
        },
        handler: function (e) {
          arguments[0] = c.event.fix(e);
          arguments[0].type = b;
          return c.event.handle.apply(this, arguments);
        },
      };
    });
  c.extend(c.fn, {
    validateDelegate: function (a, b, d) {
      return this.bind(b, function (e) {
        var f = c(e.target);
        if (f.is(a)) return d.apply(f, arguments);
      });
    },
  });
})(jQuery);
(function (t, m, e) {
  var l = e(t),
    q = e(m),
    a = (e.fancybox = function () {
      a.open.apply(this, arguments);
    }),
    r = !1,
    s = "undefined" !== typeof m.createTouch;
  e.extend(a, {
    version: "2.0.5",
    defaults: {
      padding: 15,
      margin: 20,
      width: 800,
      height: 600,
      minWidth: 100,
      minHeight: 100,
      maxWidth: 9999,
      maxHeight: 9999,
      autoSize: !0,
      autoResize: !s,
      autoCenter: !s,
      fitToView: !0,
      aspectRatio: !1,
      topRatio: 0.5,
      fixed: !(e.browser.msie && 6 >= e.browser.version) && !s,
      scrolling: "auto",
      wrapCSS: "fancybox-default",
      arrows: !0,
      closeBtn: !0,
      closeClick: !1,
      nextClick: !1,
      mouseWheel: !0,
      autoPlay: !1,
      playSpeed: 3e3,
      preload: 3,
      modal: !1,
      loop: !0,
      ajax: { dataType: "html", headers: { "X-fancyBox": !0 } },
      keys: { next: [13, 32, 34, 39, 40], prev: [8, 33, 37, 38], close: [27] },
      tpl: {
        wrap: '<div class="fancybox-wrap"><div class="fancybox-outer"><div class="fancybox-inner"></div></div></div>',
        image: '<img class="fancybox-image" src="{href}" alt="" />',
        iframe:
          '<iframe class="fancybox-iframe" name="fancybox-frame{rnd}" frameborder="0" hspace="0"' +
          (e.browser.msie ? ' allowtransparency="true"' : "") +
          "></iframe>",
        swf: '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%"><param name="wmode" value="transparent" /><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="{href}" /><embed src="{href}" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="100%" height="100%" wmode="transparent"></embed></object>',
        error:
          '<p class="fancybox-error">The requested content cannot be loaded.<br/>Please try again later.</p>',
        closeBtn:
          '<div title="Close" class="fancybox-item fancybox-close"></div>',
        next: '<a title="Next" class="fancybox-nav fancybox-next"><span></span></a>',
        prev: '<a title="Previous" class="fancybox-nav fancybox-prev"><span></span></a>',
      },
      openEffect: "fade",
      openSpeed: 250,
      openEasing: "swing",
      openOpacity: !0,
      openMethod: "zoomIn",
      closeEffect: "fade",
      closeSpeed: 250,
      closeEasing: "swing",
      closeOpacity: !0,
      closeMethod: "zoomOut",
      nextEffect: "elastic",
      nextSpeed: 300,
      nextEasing: "swing",
      nextMethod: "changeIn",
      prevEffect: "elastic",
      prevSpeed: 300,
      prevEasing: "swing",
      prevMethod: "changeOut",
      helpers: {
        overlay: {
          speedIn: 0,
          speedOut: 300,
          opacity: 0.8,
          css: { cursor: "pointer" },
          closeClick: !0,
        },
        title: { type: "float" },
      },
    },
    group: {},
    opts: {},
    coming: null,
    current: null,
    isOpen: !1,
    isOpened: !1,
    wrap: null,
    outer: null,
    inner: null,
    player: { timer: null, isActive: !1 },
    ajaxLoad: null,
    imgPreload: null,
    transitions: {},
    helpers: {},
    open: function (b, c) {
      a.close(!0);
      b && !e.isArray(b) && (b = b instanceof e ? e(b).get() : [b]);
      a.isActive = !0;
      a.opts = e.extend(!0, {}, a.defaults, c);
      e.isPlainObject(c) &&
        "undefined" !== typeof c.keys &&
        (a.opts.keys = c.keys ? e.extend({}, a.defaults.keys, c.keys) : !1);
      a.group = b;
      a._start(a.opts.index || 0);
    },
    cancel: function () {
      (a.coming && !1 === a.trigger("onCancel")) ||
        ((a.coming = null),
        a.hideLoading(),
        a.ajaxLoad && a.ajaxLoad.abort(),
        (a.ajaxLoad = null),
        a.imgPreload &&
          (a.imgPreload.onload =
            a.imgPreload.onabort =
            a.imgPreload.onerror =
              null));
    },
    close: function (b) {
      a.cancel();
      a.current &&
        !1 !== a.trigger("beforeClose") &&
        (a.unbindEvents(),
        !a.isOpen || (b && !0 === b[0])
          ? (e(".fancybox-wrap").stop().trigger("onReset").remove(),
            a._afterZoomOut())
          : ((a.isOpen = a.isOpened = !1),
            e(".fancybox-item, .fancybox-nav").remove(),
            a.wrap.stop(!0).removeClass("fancybox-opened"),
            a.inner.css("overflow", "hidden"),
            a.transitions[a.current.closeMethod]()));
    },
    play: function (b) {
      var c = function () {
          clearTimeout(a.player.timer);
        },
        d = function () {
          c();
          a.current &&
            a.player.isActive &&
            (a.player.timer = setTimeout(a.next, a.current.playSpeed));
        },
        g = function () {
          c();
          e("body").unbind(".player");
          a.player.isActive = !1;
          a.trigger("onPlayEnd");
        };
      if (a.player.isActive || (b && !1 === b[0])) g();
      else if (
        a.current &&
        (a.current.loop || a.current.index < a.group.length - 1)
      )
        (a.player.isActive = !0),
          e("body").bind({
            "afterShow.player onUpdate.player": d,
            "onCancel.player beforeClose.player": g,
            "beforeLoad.player": c,
          }),
          d(),
          a.trigger("onPlayStart");
    },
    next: function () {
      a.current && a.jumpto(a.current.index + 1);
    },
    prev: function () {
      a.current && a.jumpto(a.current.index - 1);
    },
    jumpto: function (b) {
      a.current &&
        ((b = parseInt(b, 10)),
        1 < a.group.length &&
          a.current.loop &&
          (b >= a.group.length ? (b = 0) : 0 > b && (b = a.group.length - 1)),
        "undefined" !== typeof a.group[b] && (a.cancel(), a._start(b)));
    },
    reposition: function (b) {
      a.isOpen && a.wrap.css(a._getPosition(b));
    },
    update: function (b) {
      a.isOpen &&
        (r ||
          setTimeout(function () {
            var c = a.current;
            if (r && ((r = !1), c)) {
              if (c.autoResize || (b && "orientationchange" === b.type))
                c.autoSize &&
                  (a.inner.height("auto"), (c.height = a.inner.height())),
                  a._setDimension(),
                  c.canGrow && a.inner.height("auto");
              c.autoCenter && a.reposition();
              a.trigger("onUpdate");
            }
          }, 100),
        (r = !0));
    },
    toggle: function () {
      a.isOpen && ((a.current.fitToView = !a.current.fitToView), a.update());
    },
    hideLoading: function () {
      e("#fancybox-loading").remove();
    },
    showLoading: function () {
      a.hideLoading();
      e('<div id="fancybox-loading"><div></div></div>')
        .click(a.cancel)
        .appendTo("body");
    },
    getViewport: function () {
      return {
        x: l.scrollLeft(),
        y: l.scrollTop(),
        w: l.width(),
        h: l.height(),
      };
    },
    unbindEvents: function () {
      a.wrap && a.wrap.unbind(".fb");
      q.unbind(".fb");
      l.unbind(".fb");
    },
    bindEvents: function () {
      var b = a.current,
        c = b.keys;
      b &&
        (l.bind("resize.fb, orientationchange.fb", a.update),
        c &&
          q.bind("keydown.fb", function (b) {
            var g;
            !b.ctrlKey &&
              !b.altKey &&
              !b.shiftKey &&
              !b.metaKey &&
              0 >
                e.inArray(b.target.tagName.toLowerCase(), [
                  "input",
                  "textarea",
                  "select",
                  "button",
                ]) &&
              ((g = b.keyCode),
              -1 < e.inArray(g, c.close)
                ? (a.close(), b.preventDefault())
                : -1 < e.inArray(g, c.next)
                ? (a.next(), b.preventDefault())
                : -1 < e.inArray(g, c.prev) && (a.prev(), b.preventDefault()));
          }),
        e.fn.mousewheel &&
          b.mouseWheel &&
          1 < a.group.length &&
          a.wrap.bind("mousewheel.fb", function (b, c) {
            var f = e(b.target).get(0);
            if (
              0 === f.clientHeight ||
              (f.scrollHeight === f.clientHeight &&
                f.scrollWidth === f.clientWidth)
            )
              b.preventDefault(), a[0 < c ? "prev" : "next"]();
          }));
    },
    trigger: function (b) {
      var c,
        d =
          a[
            -1 < e.inArray(b, ["onCancel", "beforeLoad", "afterLoad"])
              ? "coming"
              : "current"
          ];
      if (d) {
        e.isFunction(d[b]) &&
          (c = d[b].apply(d, Array.prototype.slice.call(arguments, 1)));
        if (!1 === c) return !1;
        d.helpers &&
          e.each(d.helpers, function (c, f) {
            if (
              f &&
              "undefined" !== typeof a.helpers[c] &&
              e.isFunction(a.helpers[c][b])
            )
              a.helpers[c][b](f, d);
          });
        e.event.trigger(b + ".fb");
      }
    },
    isImage: function (a) {
      return a && a.match(/\.(jpg|gif|png|bmp|jpeg)(.*)?$/i);
    },
    isSWF: function (a) {
      return a && a.match(/\.(swf)(.*)?$/i);
    },
    _start: function (b) {
      var c = {},
        d = a.group[b] || null,
        g,
        f,
        k;
      if (d && (d.nodeType || d instanceof e))
        (g = !0), e.metadata && (c = e(d).metadata());
      c = e.extend(
        !0,
        {},
        a.opts,
        { index: b, element: d },
        e.isPlainObject(d) ? d : c
      );
      e.each(["href", "title", "content", "type"], function (b, f) {
        c[f] = a.opts[f] || (g && e(d).attr(f)) || c[f] || null;
      });
      "number" === typeof c.margin &&
        (c.margin = [c.margin, c.margin, c.margin, c.margin]);
      c.modal &&
        e.extend(!0, c, {
          closeBtn: !1,
          closeClick: !1,
          nextClick: !1,
          arrows: !1,
          mouseWheel: !1,
          keys: null,
          helpers: { overlay: { css: { cursor: "auto" }, closeClick: !1 } },
        });
      a.coming = c;
      if (!1 === a.trigger("beforeLoad")) a.coming = null;
      else {
        f = c.type;
        b = c.href || d;
        f ||
          (g &&
            ((k = e(d).data("fancybox-type")),
            !k &&
              d.className &&
              (f = (k = d.className.match(/fancybox\.(\w+)/)) ? k[1] : null)),
          !f &&
            "string" === e.type(b) &&
            (a.isImage(b)
              ? (f = "image")
              : a.isSWF(b)
              ? (f = "swf")
              : b.match(/^#/) && (f = "inline")),
          f || (f = g ? "inline" : "html"),
          (c.type = f));
        if ("inline" === f || "html" === f) {
          if (
            (c.content ||
              (c.content =
                "inline" === f
                  ? e(
                      "string" === e.type(b)
                        ? b.replace(/.*(?=#[^\s]+$)/, "")
                        : b
                    )
                  : d),
            !c.content || !c.content.length)
          )
            f = null;
        } else b || (f = null);
        c.group = a.group;
        c.isDom = g;
        c.href = b;
        "image" === f
          ? a._loadImage()
          : "ajax" === f
          ? a._loadAjax()
          : f
          ? a._afterLoad()
          : a._error("type");
      }
    },
    _error: function (b) {
      a.hideLoading();
      e.extend(a.coming, {
        type: "html",
        autoSize: !0,
        minHeight: 0,
        hasError: b,
        content: a.coming.tpl.error,
      });
      a._afterLoad();
    },
    _loadImage: function () {
      a.imgPreload = new Image();
      a.imgPreload.onload = function () {
        this.onload = this.onerror = null;
        a.coming.width = this.width;
        a.coming.height = this.height;
        a._afterLoad();
      };
      a.imgPreload.onerror = function () {
        this.onload = this.onerror = null;
        a._error("image");
      };
      a.imgPreload.src = a.coming.href;
      a.imgPreload.width || a.showLoading();
    },
    _loadAjax: function () {
      a.showLoading();
      a.ajaxLoad = e.ajax(
        e.extend({}, a.coming.ajax, {
          url: a.coming.href,
          error: function (b, c) {
            "abort" !== c ? a._error("ajax", b) : a.hideLoading();
          },
          success: function (b, c) {
            "success" === c && ((a.coming.content = b), a._afterLoad());
          },
        })
      );
    },
    _preloadImages: function () {
      var b = a.group,
        c = a.current,
        d = b.length,
        g;
      if (c.preload && !(2 > b.length))
        for (var f = 1; f <= Math.min(c.preload, d - 1); f++)
          if (((g = b[(c.index + f) % d]), (g = e(g).attr("href") || g)))
            new Image().src = g;
    },
    _afterLoad: function () {
      a.hideLoading();
      !a.coming || !1 === a.trigger("afterLoad", a.current)
        ? (a.coming = !1)
        : (a.isOpened
            ? (e(".fancybox-item").remove(),
              a.wrap.stop(!0).removeClass("fancybox-opened"),
              a.inner.css("overflow", "hidden"),
              a.transitions[a.current.prevMethod]())
            : (e(".fancybox-wrap").stop().trigger("onReset").remove(),
              a.trigger("afterClose")),
          a.unbindEvents(),
          (a.isOpen = !1),
          (a.current = a.coming),
          (a.wrap = e(a.current.tpl.wrap)
            .addClass(
              "fancybox-" +
                (s ? "mobile" : "desktop") +
                " fancybox-tmp " +
                a.current.wrapCSS
            )
            .appendTo("body")),
          (a.outer = e(".fancybox-outer", a.wrap).css(
            "padding",
            a.current.padding + "px"
          )),
          (a.inner = e(".fancybox-inner", a.wrap)),
          a._setContent());
    },
    _setContent: function () {
      var b,
        c,
        d = a.current,
        g = d.type;
      switch (g) {
        case "inline":
        case "ajax":
        case "html":
          b = d.content;
          b instanceof e &&
            ((b = b.show().detach()),
            b.parent().hasClass("fancybox-inner") &&
              b.parents(".fancybox-wrap").trigger("onReset").remove(),
            e(a.wrap).bind("onReset", function () {
              b.appendTo("body").hide();
            }));
          d.autoSize &&
            ((c = e(
              '<div class="fancybox-tmp ' + a.current.wrapCSS + '"></div>'
            )
              .appendTo("body")
              .append(b)),
            (d.width = c.width()),
            (d.height = c.height()),
            c.width(a.current.width),
            c.height() > d.height &&
              (c.width(d.width + 1),
              (d.width = c.width()),
              (d.height = c.height())),
            (b = c.contents().detach()),
            c.remove());
          break;
        case "image":
          b = d.tpl.image.replace("{href}", d.href);
          d.aspectRatio = !0;
          break;
        case "swf":
          b = d.tpl.swf
            .replace(/\{width\}/g, d.width)
            .replace(/\{height\}/g, d.height)
            .replace(/\{href\}/g, d.href);
      }
      if ("iframe" === g) {
        b = e(d.tpl.iframe.replace("{rnd}", new Date().getTime())).attr(
          "scrolling",
          d.scrolling
        );
        d.scrolling = "auto";
        if (d.autoSize) {
          b.width(d.width);
          a.showLoading();
          b.data("ready", !1)
            .appendTo(a.inner)
            .bind({
              onCancel: function () {
                e(this).unbind();
                a._afterZoomOut();
              },
              load: function () {
                var b = e(this),
                  c;
                try {
                  this.contentWindow.document.location &&
                    ((c = b.contents().find("body").height() + 12),
                    b.height(c));
                } catch (g) {
                  d.autoSize = !1;
                }
                !1 === b.data("ready")
                  ? (a.hideLoading(),
                    c && (a.current.height = c),
                    a._beforeShow(),
                    b.data("ready", !0))
                  : c && a.update();
              },
            })
            .attr("src", d.href);
          return;
        }
        b.attr("src", d.href);
      } else if ("image" === g || "swf" === g)
        (d.autoSize = !1), (d.scrolling = "visible");
      a.inner.append(b);
      a._beforeShow();
    },
    _beforeShow: function () {
      a.coming = null;
      a.trigger("beforeShow");
      a._setDimension();
      a.wrap.hide().removeClass("fancybox-tmp");
      a.bindEvents();
      a._preloadImages();
      a.transitions[a.isOpened ? a.current.nextMethod : a.current.openMethod]();
    },
    _setDimension: function () {
      var b = a.wrap,
        c = a.outer,
        d = a.inner,
        g = a.current,
        f = a.getViewport(),
        k = g.margin,
        h = 2 * g.padding,
        i = g.width,
        j = g.height,
        o = g.maxWidth,
        l = g.maxHeight,
        p = g.minWidth,
        m = g.minHeight,
        n;
      f.w -= k[1] + k[3];
      f.h -= k[0] + k[2];
      -1 < i.toString().indexOf("%") && (i = ((f.w - h) * parseFloat(i)) / 100);
      -1 < j.toString().indexOf("%") && (j = ((f.h - h) * parseFloat(j)) / 100);
      k = i / j;
      i += h;
      j += h;
      g.fitToView && ((o = Math.min(f.w, o)), (l = Math.min(f.h, l)));
      g.aspectRatio
        ? (i > o && ((i = o), (j = (i - h) / k + h)),
          j > l && ((j = l), (i = (j - h) * k + h)),
          i < p && ((i = p), (j = (i - h) / k + h)),
          j < m && ((j = m), (i = (j - h) * k + h)))
        : ((i = Math.max(p, Math.min(i, o))),
          (j = Math.max(m, Math.min(j, l))));
      i = Math.round(i);
      j = Math.round(j);
      e(b.add(c).add(d)).width("auto").height("auto");
      d.width(i - h).height(j - h);
      b.width(i);
      n = b.height();
      if (i > o || n > l)
        for (; (i > o || n > l) && i > p && n > m; )
          (j -= 10),
            g.aspectRatio
              ? ((i = Math.round((j - h) * k + h)),
                i < p && ((i = p), (j = (i - h) / k + h)))
              : (i -= 10),
            d.width(i - h).height(j - h),
            b.width(i),
            (n = b.height());
      g.dim = { width: i, height: n };
      g.canGrow = g.autoSize && j > m && j < l;
      g.canShrink = !1;
      g.canExpand = !1;
      if (i - h < g.width || j - h < g.height) g.canExpand = !0;
      else if ((i > f.w || n > f.h) && i > p && j > m) g.canShrink = !0;
      b = n - h;
      a.innerSpace = b - d.height();
      a.outerSpace = b - c.height();
    },
    _getPosition: function (b) {
      var c = a.current,
        d = a.getViewport(),
        e = c.margin,
        f = a.wrap.width() + e[1] + e[3],
        k = a.wrap.height() + e[0] + e[2],
        h = { position: "absolute", top: e[0] + d.y, left: e[3] + d.x };
      if (c.fixed && (!b || !1 === b[0]) && k <= d.h && f <= d.w)
        h = { position: "fixed", top: e[0], left: e[3] };
      h.top = Math.ceil(Math.max(h.top, h.top + (d.h - k) * c.topRatio)) + "px";
      h.left = Math.ceil(Math.max(h.left, h.left + 0.5 * (d.w - f))) + "px";
      return h;
    },
    _afterZoomIn: function () {
      var b = a.current,
        c = b.scrolling;
      a.isOpen = a.isOpened = !0;
      a.wrap.addClass("fancybox-opened").css("overflow", "visible");
      a.update();
      a.inner.css(
        "overflow",
        "yes" === c ? "scroll" : "no" === c ? "hidden" : c
      );
      if (b.closeClick || b.nextClick)
        a.inner
          .css("cursor", "pointer")
          .bind("click.fb", b.nextClick ? a.next : a.close);
      b.closeBtn &&
        e(b.tpl.closeBtn).appendTo(a.outer).bind("click.fb", a.close);
      b.arrows &&
        1 < a.group.length &&
        ((b.loop || 0 < b.index) &&
          e(b.tpl.prev).appendTo(a.inner).bind("click.fb", a.prev),
        (b.loop || b.index < a.group.length - 1) &&
          e(b.tpl.next).appendTo(a.inner).bind("click.fb", a.next));
      a.trigger("afterShow");
      a.opts.autoPlay &&
        !a.player.isActive &&
        ((a.opts.autoPlay = !1), a.play());
    },
    _afterZoomOut: function () {
      a.trigger("afterClose");
      a.wrap.trigger("onReset").remove();
      e.extend(a, {
        group: {},
        opts: {},
        current: null,
        isActive: !1,
        isOpened: !1,
        isOpen: !1,
        wrap: null,
        outer: null,
        inner: null,
      });
    },
  });
  a.transitions = {
    getOrigPosition: function () {
      var b = a.current,
        c = b.element,
        d = b.padding,
        g = e(b.orig),
        f = {},
        k = 50,
        h = 50;
      !g.length &&
        b.isDom &&
        e(c).is(":visible") &&
        ((g = e(c).find("img:first")), g.length || (g = e(c)));
      g.length
        ? ((f = g.offset()),
          g.is("img") && ((k = g.outerWidth()), (h = g.outerHeight())))
        : ((b = a.getViewport()),
          (f.top = b.y + 0.5 * (b.h - h)),
          (f.left = b.x + 0.5 * (b.w - k)));
      return (f = {
        top: Math.ceil(f.top - d) + "px",
        left: Math.ceil(f.left - d) + "px",
        width: Math.ceil(k + 2 * d) + "px",
        height: Math.ceil(h + 2 * d) + "px",
      });
    },
    step: function (b, c) {
      var d, e, f;
      if ("width" === c.prop || "height" === c.prop)
        (e = f = Math.ceil(b - 2 * a.current.padding)),
          "height" === c.prop &&
            ((d = (b - c.start) / (c.end - c.start)),
            c.start > c.end && (d = 1 - d),
            (e -= a.innerSpace * d),
            (f -= a.outerSpace * d)),
          a.inner[c.prop](e),
          a.outer[c.prop](f);
    },
    zoomIn: function () {
      var b = a.wrap,
        c = a.current,
        d,
        g;
      d = c.dim;
      "elastic" === c.openEffect
        ? ((g = e.extend({}, d, a._getPosition(!0))),
          delete g.position,
          (d = this.getOrigPosition()),
          c.openOpacity && ((d.opacity = 0), (g.opacity = 1)),
          a.outer.add(a.inner).width("auto").height("auto"),
          b.css(d).show(),
          b.animate(g, {
            duration: c.openSpeed,
            easing: c.openEasing,
            step: this.step,
            complete: a._afterZoomIn,
          }))
        : (b.css(e.extend({}, d, a._getPosition())),
          "fade" === c.openEffect
            ? b.fadeIn(c.openSpeed, a._afterZoomIn)
            : (b.show(), a._afterZoomIn()));
    },
    zoomOut: function () {
      var b = a.wrap,
        c = a.current,
        d;
      "elastic" === c.closeEffect
        ? ("fixed" === b.css("position") && b.css(a._getPosition(!0)),
          (d = this.getOrigPosition()),
          c.closeOpacity && (d.opacity = 0),
          b.animate(d, {
            duration: c.closeSpeed,
            easing: c.closeEasing,
            step: this.step,
            complete: a._afterZoomOut,
          }))
        : b.fadeOut(
            "fade" === c.closeEffect ? c.closeSpeed : 0,
            a._afterZoomOut
          );
    },
    changeIn: function () {
      var b = a.wrap,
        c = a.current,
        d;
      "elastic" === c.nextEffect
        ? ((d = a._getPosition(!0)),
          (d.opacity = 0),
          (d.top = parseInt(d.top, 10) - 200 + "px"),
          b
            .css(d)
            .show()
            .animate(
              { opacity: 1, top: "+=200px" },
              {
                duration: c.nextSpeed,
                easing: c.nextEasing,
                complete: a._afterZoomIn,
              }
            ))
        : (b.css(a._getPosition()),
          "fade" === c.nextEffect
            ? b.hide().fadeIn(c.nextSpeed, a._afterZoomIn)
            : (b.show(), a._afterZoomIn()));
    },
    changeOut: function () {
      var b = a.wrap,
        c = a.current,
        d = function () {
          e(this).trigger("onReset").remove();
        };
      b.removeClass("fancybox-opened");
      "elastic" === c.prevEffect
        ? b.animate(
            { opacity: 0, top: "+=200px" },
            { duration: c.prevSpeed, easing: c.prevEasing, complete: d }
          )
        : b.fadeOut("fade" === c.prevEffect ? c.prevSpeed : 0, d);
    },
  };
  a.helpers.overlay = {
    overlay: null,
    update: function () {
      var a, c;
      this.overlay.width(0).height(0);
      e.browser.msie
        ? ((a = Math.max(m.documentElement.scrollWidth, m.body.scrollWidth)),
          (c = Math.max(m.documentElement.offsetWidth, m.body.offsetWidth)),
          (a = a < c ? l.width() : a))
        : (a = q.width());
      this.overlay.width(a).height(q.height());
    },
    beforeShow: function (b) {
      this.overlay ||
        ((b = e.extend(
          !0,
          {
            speedIn: "fast",
            closeClick: !0,
            opacity: 1,
            css: { background: "black" },
          },
          b
        )),
        (this.overlay = e('<div id="fancybox-overlay"></div>')
          .css(b.css)
          .appendTo("body")),
        this.update(),
        b.closeClick && this.overlay.bind("click.fb", a.close),
        l.bind("resize.fb", e.proxy(this.update, this)),
        this.overlay.fadeTo(b.speedIn, b.opacity));
    },
    onUpdate: function () {
      this.update();
    },
    afterClose: function (a) {
      this.overlay &&
        this.overlay.fadeOut(a.speedOut || 0, function () {
          e(this).remove();
        });
      this.overlay = null;
    },
  };
  a.helpers.title = {
    beforeShow: function (b) {
      var c;
      if ((c = a.current.title))
        (c = e(
          '<div class="fancybox-title fancybox-title-' +
            b.type +
            '-wrap">' +
            c +
            "</div>"
        ).appendTo("body")),
          "float" === b.type &&
            (c.width(c.width()),
            c.wrapInner('<span class="child"></span>'),
            (a.current.margin[2] += Math.abs(
              parseInt(c.css("margin-bottom"), 10)
            ))),
          c.appendTo(
            "over" === b.type
              ? a.inner
              : "outside" === b.type
              ? a.wrap
              : a.outer
          );
    },
  };
  e.fn.fancybox = function (b) {
    var c = e(this),
      d = this.selector || "",
      g,
      f = function (f) {
        var h = this,
          i = "rel",
          j = h[i],
          l = g;
        !f.ctrlKey &&
          !f.altKey &&
          !f.shiftKey &&
          !f.metaKey &&
          (f.preventDefault(),
          j ||
            ((i = "data-fancybox-group"),
            (j = e(h).attr("data-fancybox-group"))),
          j &&
            "" !== j &&
            "nofollow" !== j &&
            ((h = d.length ? e(d) : c),
            (h = h.filter("[" + i + '="' + j + '"]')),
            (l = h.index(this))),
          (b.index = l),
          a.open(h, b));
      },
      b = b || {};
    g = b.index || 0;
    d
      ? q.undelegate(d, "click.fb-start").delegate(d, "click.fb-start", f)
      : c.unbind("click.fb-start").bind("click.fb-start", f);
    return this;
  };
})(window, document, jQuery);
var tb_pathToImage = "/img/admin/loading.gif";
eval(
  (function (p, a, c, k, e, r) {
    e = function (c) {
      return (
        (c < a ? "" : e(parseInt(c / a))) +
        ((c = c % a) > 35 ? String.fromCharCode(c + 29) : c.toString(36))
      );
    };
    if (!"".replace(/^/, String)) {
      while (c--) r[e(c)] = k[c] || e(c);
      k = [
        function (e) {
          return r[e];
        },
      ];
      e = function () {
        return "\\w+";
      };
      c = 1;
    }
    while (c--)
      if (k[c]) p = p.replace(new RegExp("\\b" + e(c) + "\\b", "g"), k[c]);
    return p;
  })(
    '$(o).2S(9(){1u(\'a.18, 3n.18, 3i.18\');1w=1p 1t();1w.L=2H});9 1u(b){$(b).s(9(){6 t=X.Q||X.1v||M;6 a=X.u||X.23;6 g=X.1N||P;19(t,a,g);X.2E();H P})}9 19(d,f,g){3m{3(2t o.v.J.2i==="2g"){$("v","11").r({A:"28%",z:"28%"});$("11").r("22","2Z");3(o.1Y("1F")===M){$("v").q("<U 5=\'1F\'></U><4 5=\'B\'></4><4 5=\'8\'></4>");$("#B").s(G)}}n{3(o.1Y("B")===M){$("v").q("<4 5=\'B\'></4><4 5=\'8\'></4>");$("#B").s(G)}}3(1K()){$("#B").1J("2B")}n{$("#B").1J("2z")}3(d===M){d=""}$("v").q("<4 5=\'K\'><1I L=\'"+1w.L+"\' /></4>");$(\'#K\').2y();6 h;3(f.O("?")!==-1){h=f.3l(0,f.O("?"))}n{h=f}6 i=/\\.2s$|\\.2q$|\\.2m$|\\.2l$|\\.2k$/;6 j=h.1C().2h(i);3(j==\'.2s\'||j==\'.2q\'||j==\'.2m\'||j==\'.2l\'||j==\'.2k\'){1D="";1G="";14="";1z="";1x="";R="";1n="";1r=P;3(g){E=$("a[@1N="+g+"]").36();25(D=0;((D<E.1c)&&(R===""));D++){6 k=E[D].u.1C().2h(i);3(!(E[D].u==f)){3(1r){1z=E[D].Q;1x=E[D].u;R="<1e 5=\'1X\'>&1d;&1d;<a u=\'#\'>2T &2R;</a></1e>"}n{1D=E[D].Q;1G=E[D].u;14="<1e 5=\'1U\'>&1d;&1d;<a u=\'#\'>&2O; 2N</a></1e>"}}n{1r=1b;1n="1t "+(D+1)+" 2L "+(E.1c)}}}S=1p 1t();S.1g=9(){S.1g=M;6 a=2x();6 x=a[0]-1M;6 y=a[1]-1M;6 b=S.z;6 c=S.A;3(b>x){c=c*(x/b);b=x;3(c>y){b=b*(y/c);c=y}}n 3(c>y){b=b*(y/c);c=y;3(b>x){c=c*(x/b);b=x}}13=b+30;1a=c+2G;$("#8").q("<a u=\'\' 5=\'1L\' Q=\'1o\'><1I 5=\'2F\' L=\'"+f+"\' z=\'"+b+"\' A=\'"+c+"\' 23=\'"+d+"\'/></a>"+"<4 5=\'2D\'>"+d+"<4 5=\'2C\'>"+1n+14+R+"</4></4><4 5=\'2A\'><a u=\'#\' 5=\'Z\' Q=\'1o\'>1l</a> 1k 1j 1s</4>");$("#Z").s(G);3(!(14==="")){9 12(){3($(o).N("s",12)){$(o).N("s",12)}$("#8").C();$("v").q("<4 5=\'8\'></4>");19(1D,1G,g);H P}$("#1U").s(12)}3(!(R==="")){9 1i(){$("#8").C();$("v").q("<4 5=\'8\'></4>");19(1z,1x,g);H P}$("#1X").s(1i)}o.1h=9(e){3(e==M){I=2w.2v}n{I=e.2u}3(I==27){G()}n 3(I==3k){3(!(R=="")){o.1h="";1i()}}n 3(I==3j){3(!(14=="")){o.1h="";12()}}};16();$("#K").C();$("#1L").s(G);$("#8").r({Y:"T"})};S.L=f}n{6 l=f.2r(/^[^\\?]+\\??/,\'\');6 m=2p(l);13=(m[\'z\']*1)+30||3h;1a=(m[\'A\']*1)+3g||3f;W=13-30;V=1a-3e;3(f.O(\'2j\')!=-1){1E=f.1B(\'3d\');$("#15").C();3(m[\'1A\']!="1b"){$("#8").q("<4 5=\'2f\'><4 5=\'1H\'>"+d+"</4><4 5=\'2e\'><a u=\'#\' 5=\'Z\' Q=\'1o\'>1l</a> 1k 1j 1s</4></4><U 1W=\'0\' 2d=\'0\' L=\'"+1E[0]+"\' 5=\'15\' 1v=\'15"+1f.2c(1f.1y()*2b)+"\' 1g=\'1m()\' J=\'z:"+(W+29)+"p;A:"+(V+17)+"p;\' > </U>")}n{$("#B").N();$("#8").q("<U 1W=\'0\' 2d=\'0\' L=\'"+1E[0]+"\' 5=\'15\' 1v=\'15"+1f.2c(1f.1y()*2b)+"\' 1g=\'1m()\' J=\'z:"+(W+29)+"p;A:"+(V+17)+"p;\'> </U>")}}n{3($("#8").r("Y")!="T"){3(m[\'1A\']!="1b"){$("#8").q("<4 5=\'2f\'><4 5=\'1H\'>"+d+"</4><4 5=\'2e\'><a u=\'#\' 5=\'Z\'>1l</a> 1k 1j 1s</4></4><4 5=\'F\' J=\'z:"+W+"p;A:"+V+"p\'></4>")}n{$("#B").N();$("#8").q("<4 5=\'F\' 3c=\'3b\' J=\'z:"+W+"p;A:"+V+"p;\'></4>")}}n{$("#F")[0].J.z=W+"p";$("#F")[0].J.A=V+"p";$("#F")[0].3a=0;$("#1H").11(d)}}$("#Z").s(G);3(f.O(\'37\')!=-1){$("#F").q($(\'#\'+m[\'26\']).1T());$("#8").24(9(){$(\'#\'+m[\'26\']).q($("#F").1T())});16();$("#K").C();$("#8").r({Y:"T"})}n 3(f.O(\'2j\')!=-1){16();3($.1q.35){$("#K").C();$("#8").r({Y:"T"})}}n{$("#F").34(f+="&1y="+(1p 33().32()),9(){16();$("#K").C();1u("#F a.18");$("#8").r({Y:"T"})})}}3(!m[\'1A\']){o.21=9(e){3(e==M){I=2w.2v}n{I=e.2u}3(I==27){G()}}}}31(e){}}9 1m(){$("#K").C();$("#8").r({Y:"T"})}9 G(){$("#2Y").N("s");$("#Z").N("s");$("#8").2X("2W",9(){$(\'#8,#B,#1F\').2V("24").N().C()});$("#K").C();3(2t o.v.J.2i=="2g"){$("v","11").r({A:"1Z",z:"1Z"});$("11").r("22","")}o.1h="";o.21="";H P}9 16(){$("#8").r({2U:\'-\'+20((13/2),10)+\'p\',z:13+\'p\'});3(!(1V.1q.2Q&&1V.1q.2P<7)){$("#8").r({38:\'-\'+20((1a/2),10)+\'p\'})}}9 2p(a){6 b={};3(!a){H b}6 c=a.1B(/[;&]/);25(6 i=0;i<c.1c;i++){6 d=c[i].1B(\'=\');3(!d||d.1c!=2){39}6 e=2a(d[0]);6 f=2a(d[1]);f=f.2r(/\\+/g,\' \');b[e]=f}H b}9 2x(){6 a=o.2M;6 w=1S.2o||1R.2o||(a&&a.1Q)||o.v.1Q;6 h=1S.1P||1R.1P||(a&&a.2n)||o.v.2n;1O=[w,h];H 1O}9 1K(){6 a=2K.2J.1C();3(a.O(\'2I\')!=-1&&a.O(\'3o\')!=-1){H 1b}}',
    62,
    211,
    "|||if|div|id|var||TB_window|function||||||||||||||else|document|px|append|css|click||href|body||||width|height|TB_overlay|remove|TB_Counter|TB_TempArray|TB_ajaxContent|tb_remove|return|keycode|style|TB_load|src|null|unbind|indexOf|false|title|TB_NextHTML|imgPreloader|block|iframe|ajaxContentH|ajaxContentW|this|display|TB_closeWindowButton||html|goPrev|TB_WIDTH|TB_PrevHTML|TB_iframeContent|tb_position||thickbox|tb_show|TB_HEIGHT|true|length|nbsp|span|Math|onload|onkeydown|goNext|Esc|or|close|tb_showIframe|TB_imageCount|Close|new|browser|TB_FoundURL|Key|Image|tb_init|name|imgLoader|TB_NextURL|random|TB_NextCaption|modal|split|toLowerCase|TB_PrevCaption|urlNoQuery|TB_HideSelect|TB_PrevURL|TB_ajaxWindowTitle|img|addClass|tb_detectMacXFF|TB_ImageOff|150|rel|arrayPageSize|innerHeight|clientWidth|self|window|children|TB_prev|jQuery|frameborder|TB_next|getElementById|auto|parseInt|onkeyup|overflow|alt|unload|for|inlineId||100||unescape|1000|round|hspace|TB_closeAjaxWindow|TB_title|undefined|match|maxHeight|TB_iframe|bmp|gif|png|clientHeight|innerWidth|tb_parseQuery|jpeg|replace|jpg|typeof|which|keyCode|event|tb_getPageSize|show|TB_overlayBG|TB_closeWindow|TB_overlayMacFFBGHack|TB_secondLine|TB_caption|blur|TB_Image|60|tb_pathToImage|mac|userAgent|navigator|of|documentElement|Prev|lt|version|msie|gt|ready|Next|marginLeft|trigger|fast|fadeOut|TB_imageOff|hidden||catch|getTime|Date|load|safari|get|TB_inline|marginTop|continue|scrollTop|TB_modal|class|TB_|45|440|40|630|input|188|190|substr|try|area|firefox".split(
      "|"
    ),
    0,
    {}
  )
);
var preload_images = new Array(
  "/img/admin/ajax_loader.gif",
  "/img/admin/shadow-t.png",
  "/img/admin/shadow-b.png",
  "/img/admin/shadow-r.png",
  "/img/admin/shadow-l.png",
  "/img/admin/shadow-lt.png",
  "/img/admin/shadow-lb.png",
  "/img/admin/shadow-rt.png",
  "/img/admin/shadow-rb.png",
  "/img/admin/percentage-loader.gif"
);
var preloaded = new Array();
function preloadImages() {
  for (var i = 0; i < preload_images.length; i++) {
    preloaded[i] = new Image();
    preloaded[i].setAttribute("src", preload_images[i]);
  }
}
var replaces = new Array();
replaces[0] = new Array(
  "а",
  "б",
  "в",
  "г",
  "д",
  "е",
  "ё",
  "ж",
  "з",
  "и",
  "й",
  "к",
  "л",
  "м",
  "н",
  "о",
  "п",
  "р",
  "с",
  "т",
  "у",
  "ф",
  "х",
  "ц",
  "ч",
  "ш",
  "щ",
  "ъ",
  "ы",
  "ь",
  "э",
  "ю",
  "я",
  "А",
  "Б",
  "В",
  "Г",
  "Д",
  "Е",
  "Ё",
  "Ж",
  "З",
  "И",
  "Й",
  "К",
  "Л",
  "М",
  "Н",
  "О",
  "П",
  "Р",
  "С",
  "Т",
  "У",
  "Ф",
  "Х",
  "Ц",
  "Ч",
  "Ш",
  "Щ",
  "Ъ",
  "Ы",
  "Ь",
  "Э",
  "Ю",
  "Я",
  " "
);
replaces[1] = new Array(
  "a",
  "b",
  "v",
  "g",
  "d",
  "e",
  "e",
  "zh",
  "z",
  "i",
  "j",
  "k",
  "l",
  "m",
  "n",
  "o",
  "p",
  "r",
  "s",
  "t",
  "y",
  "f",
  "kh",
  "ts",
  "ch",
  "sh",
  "shch",
  "",
  "i",
  "",
  "e",
  "yu",
  "ya",
  "a",
  "b",
  "v",
  "g",
  "d",
  "e",
  "e",
  "zh",
  "z",
  "i",
  "j",
  "k",
  "l",
  "m",
  "n",
  "o",
  "p",
  "r",
  "s",
  "t",
  "y",
  "f",
  "kh",
  "ts",
  "ch",
  "sh",
  "shch",
  "",
  "i",
  "",
  "e",
  "yu",
  "ya",
  "-"
);
function submenu(i) {
  if (s_state[i] == 0) {
    s_state[i] = 1;
    $.cookies.set("kerch[s_state_" + i + "]", 1);
    $("#submenu" + i).slideUp();
  } else {
    s_state[i] = 0;
    $.cookies.set("kerch[s_state_" + i + "]", 0);
    $("#submenu" + i).slideDown();
  }
}
function menu() {
  if (m_state == 0) {
    $("#main-menu").animate({ width: "0px" }, 100, "linear", function () {
      $(this).hide();
    });
    $("#body").animate({ paddingRight: "30px" }, 100, "linear", function () {
      $("#body_left_box").css({
        "border-right-width": "30px",
        "margin-right": "-30px",
      });
      $("#main-menu-img").attr("src", "/img/admin/menu_show_reverse.gif");
    });
    m_state = 1;
    $.cookies.set("kerch[m_state]", 1);
  } else {
    $("#main-menu").animate({ width: "215px" }, 100, "linear", function () {
      $(this).show();
    });
    $("#body").animate({ paddingRight: "245px" }, 100, "linear", function () {
      $("#body_left_box").css({
        "border-right-width": "245px",
        "margin-right": "-245px",
      });
      $("#main-menu-img").attr("src", "/img/admin/menu_show.gif");
    });
    m_state = 0;
    $.cookies.set("kerch[m_state]", 0);
  }
}
function loader() {
  try {
    if (typeof document.body.style.maxHeight === "undefined") {
      $("body", "html").css({ height: "100%", width: "100%" });
      $("html").css("overflow", "hidden");
      if (document.getElementById("TB_HideSelect") === null) {
        $("#id_content").append(
          '<div id="overlay"></div><div id="loader" class="shadowed"><img src="/img/admin/ajax_loader.gif"/><div class="tl"></div><div class="t"></div><div class="tr"></div><div class="l"></div><div class="r"></div><div class="bl"></div><div class="b"></div><div class="br"></div></div>'
        );
      }
    } else {
      if (document.getElementById("overlay") === null) {
        $("#id_content").append(
          '<div id="overlay"></div><div id="loader" class="shadowed"><div class="tl"></div><div class="tr"></div><div class="bl"></div><div class="br"></div><div class="t"><div class="b"><div class="l"><div class="r"><div class="bg"><img src="/img/admin/ajax_loader.gif"/></div></div></div></div></div></div>'
        );
      }
    }
    var h = $("#id_content").height();
    var t = Math.floor((h - 65) / 2);
    $("#overlay").css({ width: "100%", height: h + "px" });
    $("#loader").css({ left: "50%", top: t + "px" });
    $(".flash-chart div").hide();
  } catch (e) {}
}
function delete_loader() {
  $("#overlay").remove();
  $("#loader").remove();
  $(".flash-chart div").show();
}
function percentage_loader() {
  try {
    if (typeof document.body.style.maxHeight === "undefined") {
      $("body", "html").css({ height: "100%", width: "100%" });
      $("html").css("overflow", "hidden");
      if (document.getElementById("TB_HideSelect") === null) {
        $("#id_content").append(
          '<div id="overlay"></div><div id="loader" class="percentage-loader"><p>0%</p><b><i></i></b></div>'
        );
      }
    } else {
      if (document.getElementById("overlay") === null) {
        $("#id_content").append(
          '<div id="overlay"></div><div id="loader" class="percentage-loader"><p>0%</p><b><i></i></b></div>'
        );
      }
    }
    var h = $("#id_content").height();
    var t = Math.floor((h - 55) / 2);
    $("#overlay").css({ width: "100%", height: h + "px" });
    $("#loader").css({ left: "50%", top: t + "px" });
    $(".flash-chart div").hide();
  } catch (e) {}
}
function delete_percentage_loader() {
  $("#overlay").remove();
  $("#loader").remove();
  $(".flash-chart div").show();
}
function ajax_load(u, item) {
  loader();
  $.getJSON(u, {}, function (data) {
    if (!data.deny) {
      $("#" + item).html(data.return_html);
      $("#infoMessage").remove();
      $("#errorMessage").remove();
      delete_loader();
    } else {
      $("#infoMessage").remove();
      $("#errorMessage").remove();
      delete_loader();
      alert(tt.message_access_denied);
    }
  });
}
function set_action() {
  var arg_action,
    arg_loader = 1,
    arg_confirm = "",
    arg_blank = 0;
  if (arguments.length == 1) {
    arg_action = arguments[0];
  } else if (arguments.length == 2) {
    arg_action = arguments[0];
    arg_loader = arguments[1];
  } else if (arguments.length == 3) {
    arg_action = arguments[0];
    arg_loader = arguments[1];
    arg_confirm = arguments[2];
  } else if (arguments.length == 4) {
    arg_action = arguments[0];
    arg_loader = arguments[1];
    arg_confirm = arguments[2];
    arg_blank = arguments[3];
  } else {
    return;
  }
  if (arg_blank) {
    $("#frm-grid").attr("target", "_blank");
  } else {
    $("#frm-grid").attr("target", "_self");
  }
  if (arg_confirm != "") {
    if (arg_action.substr(-6) == "delete") {
      var sel = false;
      $("#grid tbody input").each(function () {
        if ($(this).attr("checked")) {
          sel = true;
        }
      });
      if (!sel) {
        alert(tt.message_select_items);
        return;
      }
    }
    if (confirm(arg_confirm)) {
      if (arg_loader) {
        loader();
      }
      $("#frm-grid").attr("action", arg_action);
      $("#frm-grid").submit();
    }
  } else {
    if (arg_loader) {
      loader();
    }
    $("#frm-grid").attr("action", arg_action);
    $("#frm-grid").submit();
  }
}
function limit(limit) {
  loader();
  document.location =
    here.replace(/\/limit:[0-9]{2,3}/g, "") + "/limit:" + limit;
}
function filter() {
  loader();
  var url = here,
    field_parts = new Array();
  for (var i = 0; i < filter_fields.length; i++) {
    field_parts = filter_fields[i].split(".");
    value = trim($("#" + field_parts[0] + camelize(field_parts[1])).val());
    value = value.replace("\\", "");
    //value = value.replace('/', '');
    if (value !== "undefined") {
      var re = new RegExp("/" + filter_fields[i] + ":.*?/", "g");
      if (url.match(re)) {
        url =
          url.replace(re, "/") +
          "/" +
          filter_fields[i] +
          ":" +
          rawurlencode(value);
      } else {
        var re = new RegExp("/" + filter_fields[i] + ":.*?$", "g");
        url =
          url.replace(re, "") +
          "/" +
          filter_fields[i] +
          ":" +
          rawurlencode(value);
      }
    }
  }
  document.location = url.replace(/\/page:[0-9]+/g, "") + "/page:1";
}
function reset_filter() {
  loader();
  var url = here;
  for (var i = 0; i < filter_fields.length; i++) {
    var re = new RegExp("/" + filter_fields[i] + ":.+?/", "g");
    if (url.match(re)) {
      url = url.replace(re, "/") + "/" + filter_fields[i] + ":";
    } else {
      var re = new RegExp("/" + filter_fields[i] + ":.+?$", "g");
      url = url.replace(re, "") + "/" + filter_fields[i] + ":";
    }
  }
  document.location = url.replace(/\/page:[0-9]+/g, "") + "/page:1";
}
function camelize(phrase) {
  return str_replace(" ", "", ucwords(str_replace("_", " ", phrase)));
}
function str_replace(search, replace, subject, count) {
  var i = 0,
    j = 0,
    temp = "",
    repl = "",
    sl = 0,
    fl = 0,
    f = [].concat(search),
    r = [].concat(replace),
    s = subject,
    ra = r instanceof Array,
    sa = s instanceof Array;
  s = [].concat(s);
  if (count) {
    this.window[count] = 0;
  }
  for (i = 0, sl = s.length; i < sl; i++) {
    if (s[i] === "") {
      continue;
    }
    for (j = 0, fl = f.length; j < fl; j++) {
      temp = s[i] + "";
      repl = ra ? (r[j] !== undefined ? r[j] : "") : r[0];
      s[i] = temp.split(f[j]).join(repl);
      if (count && s[i] !== temp) {
        this.window[count] += (temp.length - s[i].length) / f[j].length;
      }
    }
  }
  return sa ? s : s[0];
}
function ucwords(str) {
  return (str + "").replace(/^(.)|\s(.)/g, function ($1) {
    return $1.toUpperCase();
  });
}
function transliterate(str) {
  var regEx = new RegExp("[^A-zА-я0-9 _-]", "gi");
  str = str.replace(regEx, "");
  for (i = 0; i < replaces[0].length; i++) {
    regEx = new RegExp(replaces[0][i], "gi");
    str = str.replace(regEx, replaces[1][i]);
  }
  return trim(str.toLowerCase());
}
function trim(str, charlist) {
  var whitespace,
    l = 0,
    i = 0;
  str += "";
  if (!charlist) {
    whitespace =
      " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
  } else {
    charlist += "";
    whitespace = charlist.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, "$1");
  }
  l = str.length;
  for (i = 0; i < l; i++) {
    if (whitespace.indexOf(str.charAt(i)) === -1) {
      str = str.substring(i);
      break;
    }
  }
  l = str.length;
  for (i = l - 1; i >= 0; i--) {
    if (whitespace.indexOf(str.charAt(i)) === -1) {
      str = str.substring(0, i + 1);
      break;
    }
  }
  return whitespace.indexOf(str.charAt(0)) === -1 ? str : "";
}
function rawurlencode(str) {
  str = (str + "").toString();
  return encodeURIComponent(str)
    .replace(/!/g, "%21")
    .replace(/'/g, "%27")
    .replace(/\(/g, "%28")
    .replace(/\)/g, "%29")
    .replace(/\*/g, "%2A");
}
function add_row(c) {
  var t = $(c);
  t.find(".add-row-box").before(
    t.find(".add-row").clone().removeClass("add-row")
  );
  reorder(t);
}
function delete_row(a) {
  $(a).parent().parent().remove();
}
function grid(grid, selector) {
  $("#" + grid + " tbody tr:even").hover(
    function () {
      if ($(this).attr("class") != "highlight_row_table")
        $(this).attr("class", "row_table_over");
    },
    function () {
      if ($(this).attr("class") != "highlight_row_table")
        $(this).attr("class", "row_table");
    }
  );
  $("#" + grid + " tbody tr:odd").hover(
    function () {
      if ($(this).attr("class") != "highlight_row_table_odd")
        $(this).attr("class", "row_table_over_odd");
    },
    function () {
      if ($(this).attr("class") != "highlight_row_table_odd")
        $(this).attr("class", "row_table_odd");
    }
  );
  $("#" + grid + " tbody tr:even input[type=checkbox]").click(function () {
    $(this).change();
  });
  $("#" + grid + " tbody tr:odd input[type=checkbox]").click(function () {
    $(this).change();
  });
  $("#" + grid + " tbody tr:even input[type=checkbox]").change(function () {
    if (this.checked) {
      $(this).parents("tr").attr("class", "highlight_row_table");
    } else {
      $(this).parents("tr").attr("class", "row_table");
    }
  });
  $("#" + grid + " tbody tr:odd input[type=checkbox]").change(function () {
    if (this.checked) {
      $(this).parents("tr").attr("class", "highlight_row_table_odd");
    } else {
      $(this).parents("tr").attr("class", "row_table_odd");
    }
  });
  if (selector) {
    $("#" + grid + "-selector").click(function () {
      state = this.checked;
      $("#" + grid + " tbody tr input[type=checkbox]").each(function () {
        if ($(this).attr("disabled") != "disabled") {
          this.checked = state;
          $(this).change();
        }
      });
    });
  }
}
function save() {
  $("#frm_action").val("save");
  $("#frm").submit();
}
(function ($) {
  var EYE = (window.EYE = (function () {
    var _registered = {
      init: [],
    };
    return {
      init: function () {
        $.each(_registered.init, function (nr, fn) {
          fn.call();
        });
      },
      extend: function (prop) {
        for (var i in prop) {
          if (prop[i] != undefined) {
            this[i] = prop[i];
          }
        }
      },
      register: function (fn, type) {
        if (!_registered[type]) {
          _registered[type] = [];
        }
        _registered[type].push(fn);
      },
    };
  })());
  $(EYE.init);
})(jQuery);
(function ($) {
  EYE.extend({
    getPosition: function (e, forceIt) {
      var x = 0;
      var y = 0;
      var es = e.style;
      var restoreStyles = false;
      if (forceIt && jQuery.curCSS(e, "display") == "none") {
        var oldVisibility = es.visibility;
        var oldPosition = es.position;
        restoreStyles = true;
        es.visibility = "hidden";
        es.display = "block";
        es.position = "absolute";
      }
      var el = e;
      if (el.getBoundingClientRect) {
        // IE
        var box = el.getBoundingClientRect();
        x =
          box.left +
          Math.max(
            document.documentElement.scrollLeft,
            document.body.scrollLeft
          ) -
          2;
        y =
          box.top +
          Math.max(
            document.documentElement.scrollTop,
            document.body.scrollTop
          ) -
          2;
      } else {
        x = el.offsetLeft;
        y = el.offsetTop;
        el = el.offsetParent;
        if (e != el) {
          while (el) {
            x += el.offsetLeft;
            y += el.offsetTop;
            el = el.offsetParent;
          }
        }
        if (
          jQuery.browser.safari &&
          jQuery.curCSS(e, "position") == "absolute"
        ) {
          x -= document.body.offsetLeft;
          y -= document.body.offsetTop;
        }
        el = e.parentNode;
        while (
          el &&
          el.tagName.toUpperCase() != "BODY" &&
          el.tagName.toUpperCase() != "HTML"
        ) {
          if (jQuery.curCSS(el, "display") != "inline") {
            x -= el.scrollLeft;
            y -= el.scrollTop;
          }
          el = el.parentNode;
        }
      }
      if (restoreStyles == true) {
        es.display = "none";
        es.position = oldPosition;
        es.visibility = oldVisibility;
      }
      return { x: x, y: y };
    },
    getSize: function (e) {
      var w = parseInt(jQuery.curCSS(e, "width"), 10);
      var h = parseInt(jQuery.curCSS(e, "height"), 10);
      var wb = 0;
      var hb = 0;
      if (jQuery.curCSS(e, "display") != "none") {
        wb = e.offsetWidth;
        hb = e.offsetHeight;
      } else {
        var es = e.style;
        var oldVisibility = es.visibility;
        var oldPosition = es.position;
        es.visibility = "hidden";
        es.display = "block";
        es.position = "absolute";
        wb = e.offsetWidth;
        hb = e.offsetHeight;
        es.display = "none";
        es.position = oldPosition;
        es.visibility = oldVisibility;
      }
      return { w: w, h: h, wb: wb, hb: hb };
    },
    getClient: function (e) {
      var h, w;
      if (e) {
        w = e.clientWidth;
        h = e.clientHeight;
      } else {
        var de = document.documentElement;
        w =
          window.innerWidth ||
          self.innerWidth ||
          (de && de.clientWidth) ||
          document.body.clientWidth;
        h =
          window.innerHeight ||
          self.innerHeight ||
          (de && de.clientHeight) ||
          document.body.clientHeight;
      }
      return { w: w, h: h };
    },
    getScroll: function (e) {
      var t = 0,
        l = 0,
        w = 0,
        h = 0,
        iw = 0,
        ih = 0;
      if (e && e.nodeName.toLowerCase() != "body") {
        t = e.scrollTop;
        l = e.scrollLeft;
        w = e.scrollWidth;
        h = e.scrollHeight;
      } else {
        if (document.documentElement) {
          t = document.documentElement.scrollTop;
          l = document.documentElement.scrollLeft;
          w = document.documentElement.scrollWidth;
          h = document.documentElement.scrollHeight;
        } else if (document.body) {
          t = document.body.scrollTop;
          l = document.body.scrollLeft;
          w = document.body.scrollWidth;
          h = document.body.scrollHeight;
        }
        if (typeof pageYOffset != "undefined") {
          t = pageYOffset;
          l = pageXOffset;
        }
        iw =
          self.innerWidth ||
          document.documentElement.clientWidth ||
          document.body.clientWidth ||
          0;
        ih =
          self.innerHeight ||
          document.documentElement.clientHeight ||
          document.body.clientHeight ||
          0;
      }
      return { t: t, l: l, w: w, h: h, iw: iw, ih: ih };
    },
    getMargins: function (e, toInteger) {
      var t = jQuery.curCSS(e, "marginTop") || "";
      var r = jQuery.curCSS(e, "marginRight") || "";
      var b = jQuery.curCSS(e, "marginBottom") || "";
      var l = jQuery.curCSS(e, "marginLeft") || "";
      if (toInteger)
        return {
          t: parseInt(t, 10) || 0,
          r: parseInt(r, 10) || 0,
          b: parseInt(b, 10) || 0,
          l: parseInt(l, 10),
        };
      else return { t: t, r: r, b: b, l: l };
    },
    getPadding: function (e, toInteger) {
      var t = jQuery.curCSS(e, "paddingTop") || "";
      var r = jQuery.curCSS(e, "paddingRight") || "";
      var b = jQuery.curCSS(e, "paddingBottom") || "";
      var l = jQuery.curCSS(e, "paddingLeft") || "";
      if (toInteger)
        return {
          t: parseInt(t, 10) || 0,
          r: parseInt(r, 10) || 0,
          b: parseInt(b, 10) || 0,
          l: parseInt(l, 10),
        };
      else return { t: t, r: r, b: b, l: l };
    },
    getBorder: function (e, toInteger) {
      var t = jQuery.curCSS(e, "borderTopWidth") || "";
      var r = jQuery.curCSS(e, "borderRightWidth") || "";
      var b = jQuery.curCSS(e, "borderBottomWidth") || "";
      var l = jQuery.curCSS(e, "borderLeftWidth") || "";
      if (toInteger)
        return {
          t: parseInt(t, 10) || 0,
          r: parseInt(r, 10) || 0,
          b: parseInt(b, 10) || 0,
          l: parseInt(l, 10) || 0,
        };
      else return { t: t, r: r, b: b, l: l };
    },
    traverseDOM: function (nodeEl, func) {
      func(nodeEl);
      nodeEl = nodeEl.firstChild;
      while (nodeEl) {
        EYE.traverseDOM(nodeEl, func);
        nodeEl = nodeEl.nextSibling;
      }
    },
    getInnerWidth: function (el, scroll) {
      var offsetW = el.offsetWidth;
      return scroll
        ? Math.max(el.scrollWidth, offsetW) - offsetW + el.clientWidth
        : el.clientWidth;
    },
    getInnerHeight: function (el, scroll) {
      var offsetH = el.offsetHeight;
      return scroll
        ? Math.max(el.scrollHeight, offsetH) - offsetH + el.clientHeight
        : el.clientHeight;
    },
    getExtraWidth: function (el) {
      if ($.boxModel)
        return (
          (parseInt($.curCSS(el, "paddingLeft")) || 0) +
          (parseInt($.curCSS(el, "paddingRight")) || 0) +
          (parseInt($.curCSS(el, "borderLeftWidth")) || 0) +
          (parseInt($.curCSS(el, "borderRightWidth")) || 0)
        );
      return 0;
    },
    getExtraHeight: function (el) {
      if ($.boxModel)
        return (
          (parseInt($.curCSS(el, "paddingTop")) || 0) +
          (parseInt($.curCSS(el, "paddingBottom")) || 0) +
          (parseInt($.curCSS(el, "borderTopWidth")) || 0) +
          (parseInt($.curCSS(el, "borderBottomWidth")) || 0)
        );
      return 0;
    },
    isChildOf: function (parentEl, el, container) {
      if (parentEl == el) {
        return true;
      }
      if (!el || !el.nodeType || el.nodeType != 1) {
        return false;
      }
      if (parentEl.contains && !$.browser.safari) {
        return parentEl.contains(el);
      }
      if (parentEl.compareDocumentPosition) {
        return !!(parentEl.compareDocumentPosition(el) & 16);
      }
      var prEl = el.parentNode;
      while (prEl && prEl != container) {
        if (prEl == parentEl) return true;
        prEl = prEl.parentNode;
      }
      return false;
    },
    centerEl: function (el, axis) {
      var clientScroll = EYE.getScroll();
      var size = EYE.getSize(el);
      if (!axis || axis == "vertically")
        $(el).css({
          top:
            clientScroll.t +
            (Math.min(clientScroll.h, clientScroll.ih) - size.hb) / 2 +
            "px",
        });
      if (!axis || axis == "horizontally")
        $(el).css({
          left:
            clientScroll.l +
            (Math.min(clientScroll.w, clientScroll.iw) - size.wb) / 2 +
            "px",
        });
    },
  });
  if (!$.easing.easeout) {
    $.easing.easeout = function (p, n, firstNum, delta, duration) {
      return -delta * ((n = n / duration - 1) * n * n * n - 1) + firstNum;
    };
  }
})(jQuery);
jQuery.ui ||
  (function (a) {
    a.ui = {
      version: "1.8",
      plugin: {
        add: function (c, d, f) {
          var e = a.ui[c].prototype;
          for (var b in f) {
            e.plugins[b] = e.plugins[b] || [];
            e.plugins[b].push([d, f[b]]);
          }
        },
        call: function (b, d, c) {
          var f = b.plugins[d];
          if (!f || !b.element[0].parentNode) {
            return;
          }
          for (var e = 0; e < f.length; e++) {
            if (b.options[f[e][0]]) {
              f[e][1].apply(b.element, c);
            }
          }
        },
      },
      contains: function (d, c) {
        return document.compareDocumentPosition
          ? d.compareDocumentPosition(c) & 16
          : d !== c && d.contains(c);
      },
      hasScroll: function (e, c) {
        if (a(e).css("overflow") == "hidden") {
          return false;
        }
        var b = c && c == "left" ? "scrollLeft" : "scrollTop",
          d = false;
        if (e[b] > 0) {
          return true;
        }
        e[b] = 1;
        d = e[b] > 0;
        e[b] = 0;
        return d;
      },
      isOverAxis: function (c, b, d) {
        return c > b && c < b + d;
      },
      isOver: function (g, c, f, e, b, d) {
        return a.ui.isOverAxis(g, f, b) && a.ui.isOverAxis(c, e, d);
      },
      keyCode: {
        BACKSPACE: 8,
        CAPS_LOCK: 20,
        COMMA: 188,
        CONTROL: 17,
        DELETE: 46,
        DOWN: 40,
        END: 35,
        ENTER: 13,
        ESCAPE: 27,
        HOME: 36,
        INSERT: 45,
        LEFT: 37,
        NUMPAD_ADD: 107,
        NUMPAD_DECIMAL: 110,
        NUMPAD_DIVIDE: 111,
        NUMPAD_ENTER: 108,
        NUMPAD_MULTIPLY: 106,
        NUMPAD_SUBTRACT: 109,
        PAGE_DOWN: 34,
        PAGE_UP: 33,
        PERIOD: 190,
        RIGHT: 39,
        SHIFT: 16,
        SPACE: 32,
        TAB: 9,
        UP: 38,
      },
    };
    a.fn.extend({
      _focus: a.fn.focus,
      focus: function (b, c) {
        return typeof b === "number"
          ? this.each(function () {
              var d = this;
              setTimeout(function () {
                a(d).focus();
                c && c.call(d);
              }, b);
            })
          : this._focus.apply(this, arguments);
      },
      enableSelection: function () {
        return this.attr("unselectable", "off")
          .css("MozUserSelect", "")
          .unbind("selectstart.ui");
      },
      disableSelection: function () {
        return this.attr("unselectable", "on")
          .css("MozUserSelect", "none")
          .bind("selectstart.ui", function () {
            return false;
          });
      },
      scrollParent: function () {
        var b;
        if (
          (a.browser.msie && /(static|relative)/.test(this.css("position"))) ||
          /absolute/.test(this.css("position"))
        ) {
          b = this.parents()
            .filter(function () {
              return (
                /(relative|absolute|fixed)/.test(
                  a.curCSS(this, "position", 1)
                ) &&
                /(auto|scroll)/.test(
                  a.curCSS(this, "overflow", 1) +
                    a.curCSS(this, "overflow-y", 1) +
                    a.curCSS(this, "overflow-x", 1)
                )
              );
            })
            .eq(0);
        } else {
          b = this.parents()
            .filter(function () {
              return /(auto|scroll)/.test(
                a.curCSS(this, "overflow", 1) +
                  a.curCSS(this, "overflow-y", 1) +
                  a.curCSS(this, "overflow-x", 1)
              );
            })
            .eq(0);
        }
        return /fixed/.test(this.css("position")) || !b.length
          ? a(document)
          : b;
      },
      zIndex: function (e) {
        if (e !== undefined) {
          return this.css("zIndex", e);
        }
        if (this.length) {
          var c = a(this[0]),
            b,
            d;
          while (c.length && c[0] !== document) {
            b = c.css("position");
            if (b == "absolute" || b == "relative" || b == "fixed") {
              d = parseInt(c.css("zIndex"));
              if (!isNaN(d) && d != 0) {
                return d;
              }
            }
            c = c.parent();
          }
        }
        return 0;
      },
    });
    a.extend(a.expr[":"], {
      data: function (d, c, b) {
        return !!a.data(d, b[3]);
      },
      focusable: function (c) {
        var d = c.nodeName.toLowerCase(),
          b = a.attr(c, "tabindex");
        return (
          (/input|select|textarea|button|object/.test(d)
            ? !c.disabled
            : "a" == d || "area" == d
            ? c.href || !isNaN(b)
            : !isNaN(b)) &&
          !a(c)["area" == d ? "parents" : "closest"](":hidden").length
        );
      },
      tabbable: function (c) {
        var b = a.attr(c, "tabindex");
        return (isNaN(b) || b >= 0) && a(c).is(":focusable");
      },
    });
  })(jQuery);
(function ($) {
  $.extend($.ui, { datepicker: { version: "1.8" } });
  var PROP_NAME = "datepicker";
  var dpuuid = new Date().getTime();
  function Datepicker() {
    this.debug = false;
    this._curInst = null;
    this._keyEvent = false;
    this._disabledInputs = [];
    this._datepickerShowing = false;
    this._inDialog = false;
    this._mainDivId = "ui-datepicker-div";
    this._inlineClass = "ui-datepicker-inline";
    this._appendClass = "ui-datepicker-append";
    this._triggerClass = "ui-datepicker-trigger";
    this._dialogClass = "ui-datepicker-dialog";
    this._disableClass = "ui-datepicker-disabled";
    this._unselectableClass = "ui-datepicker-unselectable";
    this._currentClass = "ui-datepicker-current-day";
    this._dayOverClass = "ui-datepicker-days-cell-over";
    this.regional = [];
    this.regional[""] = {
      closeText: "Done",
      prevText: "Prev",
      nextText: "Next",
      currentText: "Today",
      monthNames: [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
      ],
      monthNamesShort: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ],
      dayNames: [
        "Sunday",
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
      ],
      dayNamesShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
      dayNamesMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
      weekHeader: "Wk",
      dateFormat: "mm/dd/yy",
      firstDay: 0,
      isRTL: false,
      showMonthAfterYear: false,
      yearSuffix: "",
    };
    this._defaults = {
      showOn: "focus",
      showAnim: "show",
      showOptions: {},
      defaultDate: null,
      appendText: "",
      buttonText: "...",
      buttonImage: "",
      buttonImageOnly: false,
      hideIfNoPrevNext: false,
      navigationAsDateFormat: false,
      gotoCurrent: false,
      changeMonth: false,
      changeYear: false,
      yearRange: "c-10:c+10",
      showOtherMonths: false,
      selectOtherMonths: false,
      showWeek: false,
      calculateWeek: this.iso8601Week,
      shortYearCutoff: "+10",
      minDate: null,
      maxDate: null,
      duration: "_default",
      beforeShowDay: null,
      beforeShow: null,
      onSelect: null,
      onChangeMonthYear: null,
      onClose: null,
      numberOfMonths: 1,
      showCurrentAtPos: 0,
      stepMonths: 1,
      stepBigMonths: 12,
      altField: "",
      altFormat: "",
      constrainInput: true,
      showButtonPanel: false,
      autoSize: false,
    };
    $.extend(this._defaults, this.regional[""]);
    this.dpDiv = $(
      '<div id="' +
        this._mainDivId +
        '" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all ui-helper-hidden-accessible"></div>'
    );
  }
  $.extend(Datepicker.prototype, {
    markerClassName: "hasDatepicker",
    log: function () {
      if (this.debug) {
        console.log.apply("", arguments);
      }
    },
    _widgetDatepicker: function () {
      return this.dpDiv;
    },
    setDefaults: function (settings) {
      extendRemove(this._defaults, settings || {});
      return this;
    },
    _attachDatepicker: function (target, settings) {
      var inlineSettings = null;
      for (var attrName in this._defaults) {
        var attrValue = target.getAttribute("date:" + attrName);
        if (attrValue) {
          inlineSettings = inlineSettings || {};
          try {
            inlineSettings[attrName] = eval(attrValue);
          } catch (err) {
            inlineSettings[attrName] = attrValue;
          }
        }
      }
      var nodeName = target.nodeName.toLowerCase();
      var inline = nodeName == "div" || nodeName == "span";
      if (!target.id) {
        target.id = "dp" + ++this.uuid;
      }
      var inst = this._newInst($(target), inline);
      inst.settings = $.extend({}, settings || {}, inlineSettings || {});
      if (nodeName == "input") {
        this._connectDatepicker(target, inst);
      } else {
        if (inline) {
          this._inlineDatepicker(target, inst);
        }
      }
    },
    _newInst: function (target, inline) {
      var id = target[0].id.replace(/([^A-Za-z0-9_])/g, "\\\\$1");
      return {
        id: id,
        input: target,
        selectedDay: 0,
        selectedMonth: 0,
        selectedYear: 0,
        drawMonth: 0,
        drawYear: 0,
        inline: inline,
        dpDiv: !inline
          ? this.dpDiv
          : $(
              '<div class="' +
                this._inlineClass +
                ' ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div>'
            ),
      };
    },
    _connectDatepicker: function (target, inst) {
      var input = $(target);
      inst.append = $([]);
      inst.trigger = $([]);
      if (input.hasClass(this.markerClassName)) {
        return;
      }
      this._attachments(input, inst);
      input
        .addClass(this.markerClassName)
        .keydown(this._doKeyDown)
        .keypress(this._doKeyPress)
        .keyup(this._doKeyUp)
        .bind("setData.datepicker", function (event, key, value) {
          inst.settings[key] = value;
        })
        .bind("getData.datepicker", function (event, key) {
          return this._get(inst, key);
        });
      this._autoSize(inst);
      $.data(target, PROP_NAME, inst);
    },
    _attachments: function (input, inst) {
      var appendText = this._get(inst, "appendText");
      var isRTL = this._get(inst, "isRTL");
      if (inst.append) {
        inst.append.remove();
      }
      if (appendText) {
        inst.append = $(
          '<span class="' + this._appendClass + '">' + appendText + "</span>"
        );
        input[isRTL ? "before" : "after"](inst.append);
      }
      input.unbind("focus", this._showDatepicker);
      if (inst.trigger) {
        inst.trigger.remove();
      }
      var showOn = this._get(inst, "showOn");
      if (showOn == "focus" || showOn == "both") {
        input.focus(this._showDatepicker);
      }
      if (showOn == "button" || showOn == "both") {
        var buttonText = this._get(inst, "buttonText");
        var buttonImage = this._get(inst, "buttonImage");
        inst.trigger = $(
          this._get(inst, "buttonImageOnly")
            ? $("<img/>")
                .addClass(this._triggerClass)
                .attr({ src: buttonImage, alt: buttonText, title: buttonText })
            : $('<button type="button"></button>')
                .addClass(this._triggerClass)
                .html(
                  buttonImage == ""
                    ? buttonText
                    : $("<img/>").attr({
                        src: buttonImage,
                        alt: buttonText,
                        title: buttonText,
                      })
                )
        );
        input[isRTL ? "before" : "after"](inst.trigger);
        inst.trigger.click(function () {
          if (
            $.datepicker._datepickerShowing &&
            $.datepicker._lastInput == input[0]
          ) {
            $.datepicker._hideDatepicker();
          } else {
            $.datepicker._showDatepicker(input[0]);
          }
          return false;
        });
      }
    },
    _autoSize: function (inst) {
      if (this._get(inst, "autoSize") && !inst.inline) {
        var date = new Date(2009, 12 - 1, 20);
        var dateFormat = this._get(inst, "dateFormat");
        if (dateFormat.match(/[DM]/)) {
          var findMax = function (names) {
            var max = 0;
            var maxI = 0;
            for (var i = 0; i < names.length; i++) {
              if (names[i].length > max) {
                max = names[i].length;
                maxI = i;
              }
            }
            return maxI;
          };
          date.setMonth(
            findMax(
              this._get(
                inst,
                dateFormat.match(/MM/) ? "monthNames" : "monthNamesShort"
              )
            )
          );
          date.setDate(
            findMax(
              this._get(
                inst,
                dateFormat.match(/DD/) ? "dayNames" : "dayNamesShort"
              )
            ) +
              20 -
              date.getDay()
          );
        }
        inst.input.attr("size", this._formatDate(inst, date).length);
      }
    },
    _inlineDatepicker: function (target, inst) {
      var divSpan = $(target);
      if (divSpan.hasClass(this.markerClassName)) {
        return;
      }
      divSpan
        .addClass(this.markerClassName)
        .append(inst.dpDiv)
        .bind("setData.datepicker", function (event, key, value) {
          inst.settings[key] = value;
        })
        .bind("getData.datepicker", function (event, key) {
          return this._get(inst, key);
        });
      $.data(target, PROP_NAME, inst);
      this._setDate(inst, this._getDefaultDate(inst), true);
      this._updateDatepicker(inst);
      this._updateAlternate(inst);
    },
    _dialogDatepicker: function (input, date, onSelect, settings, pos) {
      var inst = this._dialogInst;
      if (!inst) {
        var id = "dp" + ++this.uuid;
        this._dialogInput = $(
          '<input type="text" id="' +
            id +
            '" style="position: absolute; top: -100px; width: 0px; z-index: -10;"/>'
        );
        this._dialogInput.keydown(this._doKeyDown);
        $("body").append(this._dialogInput);
        inst = this._dialogInst = this._newInst(this._dialogInput, false);
        inst.settings = {};
        $.data(this._dialogInput[0], PROP_NAME, inst);
      }
      extendRemove(inst.settings, settings || {});
      date =
        date && date.constructor == Date ? this._formatDate(inst, date) : date;
      this._dialogInput.val(date);
      this._pos = pos ? (pos.length ? pos : [pos.pageX, pos.pageY]) : null;
      if (!this._pos) {
        var browserWidth = document.documentElement.clientWidth;
        var browserHeight = document.documentElement.clientHeight;
        var scrollX =
          document.documentElement.scrollLeft || document.body.scrollLeft;
        var scrollY =
          document.documentElement.scrollTop || document.body.scrollTop;
        this._pos = [
          browserWidth / 2 - 100 + scrollX,
          browserHeight / 2 - 150 + scrollY,
        ];
      }
      this._dialogInput
        .css("left", this._pos[0] + 20 + "px")
        .css("top", this._pos[1] + "px");
      inst.settings.onSelect = onSelect;
      this._inDialog = true;
      this.dpDiv.addClass(this._dialogClass);
      this._showDatepicker(this._dialogInput[0]);
      if ($.blockUI) {
        $.blockUI(this.dpDiv);
      }
      $.data(this._dialogInput[0], PROP_NAME, inst);
      return this;
    },
    _destroyDatepicker: function (target) {
      var $target = $(target);
      var inst = $.data(target, PROP_NAME);
      if (!$target.hasClass(this.markerClassName)) {
        return;
      }
      var nodeName = target.nodeName.toLowerCase();
      $.removeData(target, PROP_NAME);
      if (nodeName == "input") {
        inst.append.remove();
        inst.trigger.remove();
        $target
          .removeClass(this.markerClassName)
          .unbind("focus", this._showDatepicker)
          .unbind("keydown", this._doKeyDown)
          .unbind("keypress", this._doKeyPress)
          .unbind("keyup", this._doKeyUp);
      } else {
        if (nodeName == "div" || nodeName == "span") {
          $target.removeClass(this.markerClassName).empty();
        }
      }
    },
    _enableDatepicker: function (target) {
      var $target = $(target);
      var inst = $.data(target, PROP_NAME);
      if (!$target.hasClass(this.markerClassName)) {
        return;
      }
      var nodeName = target.nodeName.toLowerCase();
      if (nodeName == "input") {
        target.disabled = false;
        inst.trigger
          .filter("button")
          .each(function () {
            this.disabled = false;
          })
          .end()
          .filter("img")
          .css({ opacity: "1.0", cursor: "" });
      } else {
        if (nodeName == "div" || nodeName == "span") {
          var inline = $target.children("." + this._inlineClass);
          inline.children().removeClass("ui-state-disabled");
        }
      }
      this._disabledInputs = $.map(this._disabledInputs, function (value) {
        return value == target ? null : value;
      });
    },
    _disableDatepicker: function (target) {
      var $target = $(target);
      var inst = $.data(target, PROP_NAME);
      if (!$target.hasClass(this.markerClassName)) {
        return;
      }
      var nodeName = target.nodeName.toLowerCase();
      if (nodeName == "input") {
        target.disabled = true;
        inst.trigger
          .filter("button")
          .each(function () {
            this.disabled = true;
          })
          .end()
          .filter("img")
          .css({ opacity: "0.5", cursor: "default" });
      } else {
        if (nodeName == "div" || nodeName == "span") {
          var inline = $target.children("." + this._inlineClass);
          inline.children().addClass("ui-state-disabled");
        }
      }
      this._disabledInputs = $.map(this._disabledInputs, function (value) {
        return value == target ? null : value;
      });
      this._disabledInputs[this._disabledInputs.length] = target;
    },
    _isDisabledDatepicker: function (target) {
      if (!target) {
        return false;
      }
      for (var i = 0; i < this._disabledInputs.length; i++) {
        if (this._disabledInputs[i] == target) {
          return true;
        }
      }
      return false;
    },
    _getInst: function (target) {
      try {
        return $.data(target, PROP_NAME);
      } catch (err) {
        throw "Missing instance data for this datepicker";
      }
    },
    _optionDatepicker: function (target, name, value) {
      var inst = this._getInst(target);
      if (arguments.length == 2 && typeof name == "string") {
        return name == "defaults"
          ? $.extend({}, $.datepicker._defaults)
          : inst
          ? name == "all"
            ? $.extend({}, inst.settings)
            : this._get(inst, name)
          : null;
      }
      var settings = name || {};
      if (typeof name == "string") {
        settings = {};
        settings[name] = value;
      }
      if (inst) {
        if (this._curInst == inst) {
          this._hideDatepicker();
        }
        var date = this._getDateDatepicker(target, true);
        extendRemove(inst.settings, settings);
        this._attachments($(target), inst);
        this._autoSize(inst);
        this._setDateDatepicker(target, date);
        this._updateDatepicker(inst);
      }
    },
    _changeDatepicker: function (target, name, value) {
      this._optionDatepicker(target, name, value);
    },
    _refreshDatepicker: function (target) {
      var inst = this._getInst(target);
      if (inst) {
        this._updateDatepicker(inst);
      }
    },
    _setDateDatepicker: function (target, date) {
      var inst = this._getInst(target);
      if (inst) {
        this._setDate(inst, date);
        this._updateDatepicker(inst);
        this._updateAlternate(inst);
      }
    },
    _getDateDatepicker: function (target, noDefault) {
      var inst = this._getInst(target);
      if (inst && !inst.inline) {
        this._setDateFromField(inst, noDefault);
      }
      return inst ? this._getDate(inst) : null;
    },
    _doKeyDown: function (event) {
      var inst = $.datepicker._getInst(event.target);
      var handled = true;
      var isRTL = inst.dpDiv.is(".ui-datepicker-rtl");
      inst._keyEvent = true;
      if ($.datepicker._datepickerShowing) {
        switch (event.keyCode) {
          case 9:
            $.datepicker._hideDatepicker();
            handled = false;
            break;
          case 13:
            var sel = $("td." + $.datepicker._dayOverClass, inst.dpDiv).add(
              $("td." + $.datepicker._currentClass, inst.dpDiv)
            );
            if (sel[0]) {
              $.datepicker._selectDay(
                event.target,
                inst.selectedMonth,
                inst.selectedYear,
                sel[0]
              );
            } else {
              $.datepicker._hideDatepicker();
            }
            return false;
            break;
          case 27:
            $.datepicker._hideDatepicker();
            break;
          case 33:
            $.datepicker._adjustDate(
              event.target,
              event.ctrlKey
                ? -$.datepicker._get(inst, "stepBigMonths")
                : -$.datepicker._get(inst, "stepMonths"),
              "M"
            );
            break;
          case 34:
            $.datepicker._adjustDate(
              event.target,
              event.ctrlKey
                ? +$.datepicker._get(inst, "stepBigMonths")
                : +$.datepicker._get(inst, "stepMonths"),
              "M"
            );
            break;
          case 35:
            if (event.ctrlKey || event.metaKey) {
              $.datepicker._clearDate(event.target);
            }
            handled = event.ctrlKey || event.metaKey;
            break;
          case 36:
            if (event.ctrlKey || event.metaKey) {
              $.datepicker._gotoToday(event.target);
            }
            handled = event.ctrlKey || event.metaKey;
            break;
          case 37:
            if (event.ctrlKey || event.metaKey) {
              $.datepicker._adjustDate(event.target, isRTL ? +1 : -1, "D");
            }
            handled = event.ctrlKey || event.metaKey;
            if (event.originalEvent.altKey) {
              $.datepicker._adjustDate(
                event.target,
                event.ctrlKey
                  ? -$.datepicker._get(inst, "stepBigMonths")
                  : -$.datepicker._get(inst, "stepMonths"),
                "M"
              );
            }
            break;
          case 38:
            if (event.ctrlKey || event.metaKey) {
              $.datepicker._adjustDate(event.target, -7, "D");
            }
            handled = event.ctrlKey || event.metaKey;
            break;
          case 39:
            if (event.ctrlKey || event.metaKey) {
              $.datepicker._adjustDate(event.target, isRTL ? -1 : +1, "D");
            }
            handled = event.ctrlKey || event.metaKey;
            if (event.originalEvent.altKey) {
              $.datepicker._adjustDate(
                event.target,
                event.ctrlKey
                  ? +$.datepicker._get(inst, "stepBigMonths")
                  : +$.datepicker._get(inst, "stepMonths"),
                "M"
              );
            }
            break;
          case 40:
            if (event.ctrlKey || event.metaKey) {
              $.datepicker._adjustDate(event.target, +7, "D");
            }
            handled = event.ctrlKey || event.metaKey;
            break;
          default:
            handled = false;
        }
      } else {
        if (event.keyCode == 36 && event.ctrlKey) {
          $.datepicker._showDatepicker(this);
        } else {
          handled = false;
        }
      }
      if (handled) {
        event.preventDefault();
        event.stopPropagation();
      }
    },
    _doKeyPress: function (event) {
      var inst = $.datepicker._getInst(event.target);
      if ($.datepicker._get(inst, "constrainInput")) {
        var chars = $.datepicker._possibleChars(
          $.datepicker._get(inst, "dateFormat")
        );
        var chr = String.fromCharCode(
          event.charCode == undefined ? event.keyCode : event.charCode
        );
        return event.ctrlKey || chr < " " || !chars || chars.indexOf(chr) > -1;
      }
    },
    _doKeyUp: function (event) {
      var inst = $.datepicker._getInst(event.target);
      if (inst.input.val() != inst.lastVal) {
        try {
          var date = $.datepicker.parseDate(
            $.datepicker._get(inst, "dateFormat"),
            inst.input ? inst.input.val() : null,
            $.datepicker._getFormatConfig(inst)
          );
          if (date) {
            $.datepicker._setDateFromField(inst);
            $.datepicker._updateAlternate(inst);
            $.datepicker._updateDatepicker(inst);
          }
        } catch (event) {
          $.datepicker.log(event);
        }
      }
      return true;
    },
    _showDatepicker: function (input) {
      input = input.target || input;
      if (input.nodeName.toLowerCase() != "input") {
        input = $("input", input.parentNode)[0];
      }
      if (
        $.datepicker._isDisabledDatepicker(input) ||
        $.datepicker._lastInput == input
      ) {
        return;
      }
      var inst = $.datepicker._getInst(input);
      if ($.datepicker._curInst && $.datepicker._curInst != inst) {
        $.datepicker._curInst.dpDiv.stop(true, true);
      }
      var beforeShow = $.datepicker._get(inst, "beforeShow");
      extendRemove(
        inst.settings,
        beforeShow ? beforeShow.apply(input, [input, inst]) : {}
      );
      inst.lastVal = null;
      $.datepicker._lastInput = input;
      $.datepicker._setDateFromField(inst);
      if ($.datepicker._inDialog) {
        input.value = "";
      }
      if (!$.datepicker._pos) {
        $.datepicker._pos = $.datepicker._findPos(input);
        $.datepicker._pos[1] += input.offsetHeight;
      }
      var isFixed = false;
      $(input)
        .parents()
        .each(function () {
          isFixed |= $(this).css("position") == "fixed";
          return !isFixed;
        });
      if (isFixed && $.browser.opera) {
        $.datepicker._pos[0] -= document.documentElement.scrollLeft;
        $.datepicker._pos[1] -= document.documentElement.scrollTop;
      }
      var offset = { left: $.datepicker._pos[0], top: $.datepicker._pos[1] };
      $.datepicker._pos = null;
      inst.dpDiv.css({
        position: "absolute",
        display: "block",
        top: "-1000px",
      });
      $.datepicker._updateDatepicker(inst);
      offset = $.datepicker._checkOffset(inst, offset, isFixed);
      inst.dpDiv.css({
        position:
          $.datepicker._inDialog && $.blockUI
            ? "static"
            : isFixed
            ? "fixed"
            : "absolute",
        display: "none",
        left: offset.left + "px",
        top: offset.top + "px",
      });
      if (!inst.inline) {
        var showAnim = $.datepicker._get(inst, "showAnim");
        var duration = $.datepicker._get(inst, "duration");
        var postProcess = function () {
          $.datepicker._datepickerShowing = true;
          var borders = $.datepicker._getBorders(inst.dpDiv);
          inst.dpDiv
            .find("iframe.ui-datepicker-cover")
            .css({
              left: -borders[0],
              top: -borders[1],
              width: inst.dpDiv.outerWidth(),
              height: inst.dpDiv.outerHeight(),
            });
        };
        inst.dpDiv.zIndex($(input).zIndex() + 1);
        if ($.effects && $.effects[showAnim]) {
          inst.dpDiv.show(
            showAnim,
            $.datepicker._get(inst, "showOptions"),
            duration,
            postProcess
          );
        } else {
          inst.dpDiv[showAnim || "show"](
            showAnim ? duration : null,
            postProcess
          );
        }
        if (!showAnim || !duration) {
          postProcess();
        }
        if (inst.input.is(":visible") && !inst.input.is(":disabled")) {
          inst.input.focus();
        }
        $.datepicker._curInst = inst;
      }
    },
    _updateDatepicker: function (inst) {
      var self = this;
      var borders = $.datepicker._getBorders(inst.dpDiv);
      inst.dpDiv
        .empty()
        .append(this._generateHTML(inst))
        .find("iframe.ui-datepicker-cover")
        .css({
          left: -borders[0],
          top: -borders[1],
          width: inst.dpDiv.outerWidth(),
          height: inst.dpDiv.outerHeight(),
        })
        .end()
        .find(
          "button, .ui-datepicker-prev, .ui-datepicker-next, .ui-datepicker-calendar td a"
        )
        .bind("mouseout", function () {
          $(this).removeClass("ui-state-hover");
          if (this.className.indexOf("ui-datepicker-prev") != -1) {
            $(this).removeClass("ui-datepicker-prev-hover");
          }
          if (this.className.indexOf("ui-datepicker-next") != -1) {
            $(this).removeClass("ui-datepicker-next-hover");
          }
        })
        .bind("mouseover", function () {
          if (
            !self._isDisabledDatepicker(
              inst.inline ? inst.dpDiv.parent()[0] : inst.input[0]
            )
          ) {
            $(this)
              .parents(".ui-datepicker-calendar")
              .find("a")
              .removeClass("ui-state-hover");
            $(this).addClass("ui-state-hover");
            if (this.className.indexOf("ui-datepicker-prev") != -1) {
              $(this).addClass("ui-datepicker-prev-hover");
            }
            if (this.className.indexOf("ui-datepicker-next") != -1) {
              $(this).addClass("ui-datepicker-next-hover");
            }
          }
        })
        .end()
        .find("." + this._dayOverClass + " a")
        .trigger("mouseover")
        .end();
      var numMonths = this._getNumberOfMonths(inst);
      var cols = numMonths[1];
      var width = 17;
      if (cols > 1) {
        inst.dpDiv
          .addClass("ui-datepicker-multi-" + cols)
          .css("width", width * cols + "em");
      } else {
        inst.dpDiv
          .removeClass(
            "ui-datepicker-multi-2 ui-datepicker-multi-3 ui-datepicker-multi-4"
          )
          .width("");
      }
      inst.dpDiv[
        (numMonths[0] != 1 || numMonths[1] != 1 ? "add" : "remove") + "Class"
      ]("ui-datepicker-multi");
      inst.dpDiv[(this._get(inst, "isRTL") ? "add" : "remove") + "Class"](
        "ui-datepicker-rtl"
      );
      if (
        inst == $.datepicker._curInst &&
        $.datepicker._datepickerShowing &&
        inst.input &&
        inst.input.is(":visible") &&
        !inst.input.is(":disabled")
      ) {
        inst.input.focus();
      }
    },
    _getBorders: function (elem) {
      var convert = function (value) {
        return { thin: 1, medium: 2, thick: 3 }[value] || value;
      };
      return [
        parseFloat(convert(elem.css("border-left-width"))),
        parseFloat(convert(elem.css("border-top-width"))),
      ];
    },
    _checkOffset: function (inst, offset, isFixed) {
      var dpWidth = inst.dpDiv.outerWidth();
      var dpHeight = inst.dpDiv.outerHeight();
      var inputWidth = inst.input ? inst.input.outerWidth() : 0;
      var inputHeight = inst.input ? inst.input.outerHeight() : 0;
      var viewWidth =
        document.documentElement.clientWidth + $(document).scrollLeft();
      var viewHeight =
        document.documentElement.clientHeight + $(document).scrollTop();
      offset.left -= this._get(inst, "isRTL") ? dpWidth - inputWidth : 0;
      offset.left -=
        isFixed && offset.left == inst.input.offset().left
          ? $(document).scrollLeft()
          : 0;
      offset.top -=
        isFixed && offset.top == inst.input.offset().top + inputHeight
          ? $(document).scrollTop()
          : 0;
      offset.left -= Math.min(
        offset.left,
        offset.left + dpWidth > viewWidth && viewWidth > dpWidth
          ? Math.abs(offset.left + dpWidth - viewWidth)
          : 0
      );
      offset.top -= Math.min(
        offset.top,
        offset.top + dpHeight > viewHeight && viewHeight > dpHeight
          ? Math.abs(dpHeight + inputHeight)
          : 0
      );
      return offset;
    },
    _findPos: function (obj) {
      var inst = this._getInst(obj);
      var isRTL = this._get(inst, "isRTL");
      while (obj && (obj.type == "hidden" || obj.nodeType != 1)) {
        obj = obj[isRTL ? "previousSibling" : "nextSibling"];
      }
      var position = $(obj).offset();
      return [position.left, position.top];
    },
    _hideDatepicker: function (input) {
      var inst = this._curInst;
      if (!inst || (input && inst != $.data(input, PROP_NAME))) {
        return;
      }
      if (this._datepickerShowing) {
        var showAnim = this._get(inst, "showAnim");
        var duration = this._get(inst, "duration");
        var postProcess = function () {
          $.datepicker._tidyDialog(inst);
          this._curInst = null;
        };
        if ($.effects && $.effects[showAnim]) {
          inst.dpDiv.hide(
            showAnim,
            $.datepicker._get(inst, "showOptions"),
            duration,
            postProcess
          );
        } else {
          inst.dpDiv[
            showAnim == "slideDown"
              ? "slideUp"
              : showAnim == "fadeIn"
              ? "fadeOut"
              : "hide"
          ](showAnim ? duration : null, postProcess);
        }
        if (!showAnim) {
          postProcess();
        }
        var onClose = this._get(inst, "onClose");
        if (onClose) {
          onClose.apply(inst.input ? inst.input[0] : null, [
            inst.input ? inst.input.val() : "",
            inst,
          ]);
        }
        this._datepickerShowing = false;
        this._lastInput = null;
        if (this._inDialog) {
          this._dialogInput.css({
            position: "absolute",
            left: "0",
            top: "-100px",
          });
          if ($.blockUI) {
            $.unblockUI();
            $("body").append(this.dpDiv);
          }
        }
        this._inDialog = false;
      }
    },
    _tidyDialog: function (inst) {
      inst.dpDiv
        .removeClass(this._dialogClass)
        .unbind(".ui-datepicker-calendar");
    },
    _checkExternalClick: function (event) {
      if (!$.datepicker._curInst) {
        return;
      }
      var $target = $(event.target);
      if (
        $target[0].id != $.datepicker._mainDivId &&
        $target.parents("#" + $.datepicker._mainDivId).length == 0 &&
        !$target.hasClass($.datepicker.markerClassName) &&
        !$target.hasClass($.datepicker._triggerClass) &&
        $.datepicker._datepickerShowing &&
        !($.datepicker._inDialog && $.blockUI)
      ) {
        $.datepicker._hideDatepicker();
      }
    },
    _adjustDate: function (id, offset, period) {
      var target = $(id);
      var inst = this._getInst(target[0]);
      if (this._isDisabledDatepicker(target[0])) {
        return;
      }
      this._adjustInstDate(
        inst,
        offset + (period == "M" ? this._get(inst, "showCurrentAtPos") : 0),
        period
      );
      this._updateDatepicker(inst);
    },
    _gotoToday: function (id) {
      var target = $(id);
      var inst = this._getInst(target[0]);
      if (this._get(inst, "gotoCurrent") && inst.currentDay) {
        inst.selectedDay = inst.currentDay;
        inst.drawMonth = inst.selectedMonth = inst.currentMonth;
        inst.drawYear = inst.selectedYear = inst.currentYear;
      } else {
        var date = new Date();
        inst.selectedDay = date.getDate();
        inst.drawMonth = inst.selectedMonth = date.getMonth();
        inst.drawYear = inst.selectedYear = date.getFullYear();
      }
      this._notifyChange(inst);
      this._adjustDate(target);
    },
    _selectMonthYear: function (id, select, period) {
      var target = $(id);
      var inst = this._getInst(target[0]);
      inst._selectingMonthYear = false;
      inst["selected" + (period == "M" ? "Month" : "Year")] = inst[
        "draw" + (period == "M" ? "Month" : "Year")
      ] = parseInt(select.options[select.selectedIndex].value, 10);
      this._notifyChange(inst);
      this._adjustDate(target);
    },
    _clickMonthYear: function (id) {
      var target = $(id);
      var inst = this._getInst(target[0]);
      if (inst.input && inst._selectingMonthYear && !$.browser.msie) {
        inst.input.focus();
      }
      inst._selectingMonthYear = !inst._selectingMonthYear;
    },
    _selectDay: function (id, month, year, td) {
      var target = $(id);
      if (
        $(td).hasClass(this._unselectableClass) ||
        this._isDisabledDatepicker(target[0])
      ) {
        return;
      }
      var inst = this._getInst(target[0]);
      inst.selectedDay = inst.currentDay = $("a", td).html();
      inst.selectedMonth = inst.currentMonth = month;
      inst.selectedYear = inst.currentYear = year;
      this._selectDate(
        id,
        this._formatDate(
          inst,
          inst.currentDay,
          inst.currentMonth,
          inst.currentYear
        )
      );
    },
    _clearDate: function (id) {
      var target = $(id);
      var inst = this._getInst(target[0]);
      this._selectDate(target, "");
    },
    _selectDate: function (id, dateStr) {
      var target = $(id);
      var inst = this._getInst(target[0]);
      dateStr = dateStr != null ? dateStr : this._formatDate(inst);
      if (inst.input) {
        inst.input.val(dateStr);
      }
      this._updateAlternate(inst);
      var onSelect = this._get(inst, "onSelect");
      if (onSelect) {
        onSelect.apply(inst.input ? inst.input[0] : null, [dateStr, inst]);
      } else {
        if (inst.input) {
          inst.input.trigger("change");
        }
      }
      if (inst.inline) {
        this._updateDatepicker(inst);
      } else {
        this._hideDatepicker();
        this._lastInput = inst.input[0];
        if (typeof inst.input[0] != "object") {
          inst.input.focus();
        }
        this._lastInput = null;
      }
    },
    _updateAlternate: function (inst) {
      var altField = this._get(inst, "altField");
      if (altField) {
        var altFormat =
          this._get(inst, "altFormat") || this._get(inst, "dateFormat");
        var date = this._getDate(inst);
        var dateStr = this.formatDate(
          altFormat,
          date,
          this._getFormatConfig(inst)
        );
        $(altField).each(function () {
          $(this).val(dateStr);
        });
      }
    },
    noWeekends: function (date) {
      var day = date.getDay();
      return [day > 0 && day < 6, ""];
    },
    iso8601Week: function (date) {
      var checkDate = new Date(date.getTime());
      checkDate.setDate(checkDate.getDate() + 4 - (checkDate.getDay() || 7));
      var time = checkDate.getTime();
      checkDate.setMonth(0);
      checkDate.setDate(1);
      return Math.floor(Math.round((time - checkDate) / 86400000) / 7) + 1;
    },
    parseDate: function (format, value, settings) {
      if (format == null || value == null) {
        throw "Invalid arguments";
      }
      value = typeof value == "object" ? value.toString() : value + "";
      if (value == "") {
        return null;
      }
      var shortYearCutoff =
        (settings ? settings.shortYearCutoff : null) ||
        this._defaults.shortYearCutoff;
      var dayNamesShort =
        (settings ? settings.dayNamesShort : null) ||
        this._defaults.dayNamesShort;
      var dayNames =
        (settings ? settings.dayNames : null) || this._defaults.dayNames;
      var monthNamesShort =
        (settings ? settings.monthNamesShort : null) ||
        this._defaults.monthNamesShort;
      var monthNames =
        (settings ? settings.monthNames : null) || this._defaults.monthNames;
      var year = -1;
      var month = -1;
      var day = -1;
      var doy = -1;
      var literal = false;
      var lookAhead = function (match) {
        var matches =
          iFormat + 1 < format.length && format.charAt(iFormat + 1) == match;
        if (matches) {
          iFormat++;
        }
        return matches;
      };
      var getNumber = function (match) {
        lookAhead(match);
        var size =
          match == "@"
            ? 14
            : match == "!"
            ? 20
            : match == "y"
            ? 4
            : match == "o"
            ? 3
            : 2;
        var digits = new RegExp("^\\d{1," + size + "}");
        var num = value.substring(iValue).match(digits);
        if (!num) {
          throw "Missing number at position " + iValue;
        }
        iValue += num[0].length;
        return parseInt(num[0], 10);
      };
      var getName = function (match, shortNames, longNames) {
        var names = lookAhead(match) ? longNames : shortNames;
        for (var i = 0; i < names.length; i++) {
          if (value.substr(iValue, names[i].length) == names[i]) {
            iValue += names[i].length;
            return i + 1;
          }
        }
        throw "Unknown name at position " + iValue;
      };
      var checkLiteral = function () {
        if (value.charAt(iValue) != format.charAt(iFormat)) {
          throw "Unexpected literal at position " + iValue;
        }
        iValue++;
      };
      var iValue = 0;
      for (var iFormat = 0; iFormat < format.length; iFormat++) {
        if (literal) {
          if (format.charAt(iFormat) == "'" && !lookAhead("'")) {
            literal = false;
          } else {
            checkLiteral();
          }
        } else {
          switch (format.charAt(iFormat)) {
            case "d":
              day = getNumber("d");
              break;
            case "D":
              getName("D", dayNamesShort, dayNames);
              break;
            case "o":
              doy = getNumber("o");
              break;
            case "m":
              month = getNumber("m");
              break;
            case "M":
              month = getName("M", monthNamesShort, monthNames);
              break;
            case "y":
              year = getNumber("y");
              break;
            case "@":
              var date = new Date(getNumber("@"));
              year = date.getFullYear();
              month = date.getMonth() + 1;
              day = date.getDate();
              break;
            case "!":
              var date = new Date((getNumber("!") - this._ticksTo1970) / 10000);
              year = date.getFullYear();
              month = date.getMonth() + 1;
              day = date.getDate();
              break;
            case "'":
              if (lookAhead("'")) {
                checkLiteral();
              } else {
                literal = true;
              }
              break;
            default:
              checkLiteral();
          }
        }
      }
      if (year == -1) {
        year = new Date().getFullYear();
      } else {
        if (year < 100) {
          year +=
            new Date().getFullYear() -
            (new Date().getFullYear() % 100) +
            (year <= shortYearCutoff ? 0 : -100);
        }
      }
      if (doy > -1) {
        month = 1;
        day = doy;
        do {
          var dim = this._getDaysInMonth(year, month - 1);
          if (day <= dim) {
            break;
          }
          month++;
          day -= dim;
        } while (true);
      }
      var date = this._daylightSavingAdjust(new Date(year, month - 1, day));
      if (
        date.getFullYear() != year ||
        date.getMonth() + 1 != month ||
        date.getDate() != day
      ) {
        throw "Invalid date";
      }
      return date;
    },
    ATOM: "yy-mm-dd",
    COOKIE: "D, dd M yy",
    ISO_8601: "yy-mm-dd",
    RFC_822: "D, d M y",
    RFC_850: "DD, dd-M-y",
    RFC_1036: "D, d M y",
    RFC_1123: "D, d M yy",
    RFC_2822: "D, d M yy",
    RSS: "D, d M y",
    TICKS: "!",
    TIMESTAMP: "@",
    W3C: "yy-mm-dd",
    _ticksTo1970:
      ((1970 - 1) * 365 +
        Math.floor(1970 / 4) -
        Math.floor(1970 / 100) +
        Math.floor(1970 / 400)) *
      24 *
      60 *
      60 *
      10000000,
    formatDate: function (format, date, settings) {
      if (!date) {
        return "";
      }
      var dayNamesShort =
        (settings ? settings.dayNamesShort : null) ||
        this._defaults.dayNamesShort;
      var dayNames =
        (settings ? settings.dayNames : null) || this._defaults.dayNames;
      var monthNamesShort =
        (settings ? settings.monthNamesShort : null) ||
        this._defaults.monthNamesShort;
      var monthNames =
        (settings ? settings.monthNames : null) || this._defaults.monthNames;
      var lookAhead = function (match) {
        var matches =
          iFormat + 1 < format.length && format.charAt(iFormat + 1) == match;
        if (matches) {
          iFormat++;
        }
        return matches;
      };
      var formatNumber = function (match, value, len) {
        var num = "" + value;
        if (lookAhead(match)) {
          while (num.length < len) {
            num = "0" + num;
          }
        }
        return num;
      };
      var formatName = function (match, value, shortNames, longNames) {
        return lookAhead(match) ? longNames[value] : shortNames[value];
      };
      var output = "";
      var literal = false;
      if (date) {
        for (var iFormat = 0; iFormat < format.length; iFormat++) {
          if (literal) {
            if (format.charAt(iFormat) == "'" && !lookAhead("'")) {
              literal = false;
            } else {
              output += format.charAt(iFormat);
            }
          } else {
            switch (format.charAt(iFormat)) {
              case "d":
                output += formatNumber("d", date.getDate(), 2);
                break;
              case "D":
                output += formatName(
                  "D",
                  date.getDay(),
                  dayNamesShort,
                  dayNames
                );
                break;
              case "o":
                output += formatNumber(
                  "o",
                  (date.getTime() -
                    new Date(date.getFullYear(), 0, 0).getTime()) /
                    86400000,
                  3
                );
                break;
              case "m":
                output += formatNumber("m", date.getMonth() + 1, 2);
                break;
              case "M":
                output += formatName(
                  "M",
                  date.getMonth(),
                  monthNamesShort,
                  monthNames
                );
                break;
              case "y":
                output += lookAhead("y")
                  ? date.getFullYear()
                  : (date.getYear() % 100 < 10 ? "0" : "") +
                    (date.getYear() % 100);
                break;
              case "@":
                output += date.getTime();
                break;
              case "!":
                output += date.getTime() * 10000 + this._ticksTo1970;
                break;
              case "'":
                if (lookAhead("'")) {
                  output += "'";
                } else {
                  literal = true;
                }
                break;
              default:
                output += format.charAt(iFormat);
            }
          }
        }
      }
      return output;
    },
    _possibleChars: function (format) {
      var chars = "";
      var literal = false;
      var lookAhead = function (match) {
        var matches =
          iFormat + 1 < format.length && format.charAt(iFormat + 1) == match;
        if (matches) {
          iFormat++;
        }
        return matches;
      };
      for (var iFormat = 0; iFormat < format.length; iFormat++) {
        if (literal) {
          if (format.charAt(iFormat) == "'" && !lookAhead("'")) {
            literal = false;
          } else {
            chars += format.charAt(iFormat);
          }
        } else {
          switch (format.charAt(iFormat)) {
            case "d":
            case "m":
            case "y":
            case "@":
              chars += "0123456789";
              break;
            case "D":
            case "M":
              return null;
            case "'":
              if (lookAhead("'")) {
                chars += "'";
              } else {
                literal = true;
              }
              break;
            default:
              chars += format.charAt(iFormat);
          }
        }
      }
      return chars;
    },
    _get: function (inst, name) {
      return inst.settings[name] !== undefined
        ? inst.settings[name]
        : this._defaults[name];
    },
    _setDateFromField: function (inst, noDefault) {
      if (inst.input.val() == inst.lastVal) {
        return;
      }
      var dateFormat = this._get(inst, "dateFormat");
      var dates = (inst.lastVal = inst.input ? inst.input.val() : null);
      var date, defaultDate;
      date = defaultDate = this._getDefaultDate(inst);
      var settings = this._getFormatConfig(inst);
      try {
        date = this.parseDate(dateFormat, dates, settings) || defaultDate;
      } catch (event) {
        this.log(event);
        dates = noDefault ? "" : dates;
      }
      inst.selectedDay = date.getDate();
      inst.drawMonth = inst.selectedMonth = date.getMonth();
      inst.drawYear = inst.selectedYear = date.getFullYear();
      inst.currentDay = dates ? date.getDate() : 0;
      inst.currentMonth = dates ? date.getMonth() : 0;
      inst.currentYear = dates ? date.getFullYear() : 0;
      this._adjustInstDate(inst);
    },
    _getDefaultDate: function (inst) {
      return this._restrictMinMax(
        inst,
        this._determineDate(inst, this._get(inst, "defaultDate"), new Date())
      );
    },
    _determineDate: function (inst, date, defaultDate) {
      var offsetNumeric = function (offset) {
        var date = new Date();
        date.setDate(date.getDate() + offset);
        return date;
      };
      var offsetString = function (offset) {
        try {
          return $.datepicker.parseDate(
            $.datepicker._get(inst, "dateFormat"),
            offset,
            $.datepicker._getFormatConfig(inst)
          );
        } catch (e) {}
        var date =
          (offset.toLowerCase().match(/^c/)
            ? $.datepicker._getDate(inst)
            : null) || new Date();
        var year = date.getFullYear();
        var month = date.getMonth();
        var day = date.getDate();
        var pattern = /([+-]?[0-9]+)\s*(d|D|w|W|m|M|y|Y)?/g;
        var matches = pattern.exec(offset);
        while (matches) {
          switch (matches[2] || "d") {
            case "d":
            case "D":
              day += parseInt(matches[1], 10);
              break;
            case "w":
            case "W":
              day += parseInt(matches[1], 10) * 7;
              break;
            case "m":
            case "M":
              month += parseInt(matches[1], 10);
              day = Math.min(day, $.datepicker._getDaysInMonth(year, month));
              break;
            case "y":
            case "Y":
              year += parseInt(matches[1], 10);
              day = Math.min(day, $.datepicker._getDaysInMonth(year, month));
              break;
          }
          matches = pattern.exec(offset);
        }
        return new Date(year, month, day);
      };
      date =
        date == null
          ? defaultDate
          : typeof date == "string"
          ? offsetString(date)
          : typeof date == "number"
          ? isNaN(date)
            ? defaultDate
            : offsetNumeric(date)
          : date;
      date = date && date.toString() == "Invalid Date" ? defaultDate : date;
      if (date) {
        date.setHours(0);
        date.setMinutes(0);
        date.setSeconds(0);
        date.setMilliseconds(0);
      }
      return this._daylightSavingAdjust(date);
    },
    _daylightSavingAdjust: function (date) {
      if (!date) {
        return null;
      }
      date.setHours(date.getHours() > 12 ? date.getHours() + 2 : 0);
      return date;
    },
    _setDate: function (inst, date, noChange) {
      var clear = !date;
      var origMonth = inst.selectedMonth;
      var origYear = inst.selectedYear;
      date = this._restrictMinMax(
        inst,
        this._determineDate(inst, date, new Date())
      );
      inst.selectedDay = inst.currentDay = date.getDate();
      inst.drawMonth = inst.selectedMonth = inst.currentMonth = date.getMonth();
      inst.drawYear = inst.selectedYear = inst.currentYear = date.getFullYear();
      if (
        (origMonth != inst.selectedMonth || origYear != inst.selectedYear) &&
        !noChange
      ) {
        this._notifyChange(inst);
      }
      this._adjustInstDate(inst);
      if (inst.input) {
        inst.input.val(clear ? "" : this._formatDate(inst));
      }
    },
    _getDate: function (inst) {
      var startDate =
        !inst.currentYear || (inst.input && inst.input.val() == "")
          ? null
          : this._daylightSavingAdjust(
              new Date(inst.currentYear, inst.currentMonth, inst.currentDay)
            );
      return startDate;
    },
    _generateHTML: function (inst) {
      var today = new Date();
      today = this._daylightSavingAdjust(
        new Date(today.getFullYear(), today.getMonth(), today.getDate())
      );
      var isRTL = this._get(inst, "isRTL");
      var showButtonPanel = this._get(inst, "showButtonPanel");
      var hideIfNoPrevNext = this._get(inst, "hideIfNoPrevNext");
      var navigationAsDateFormat = this._get(inst, "navigationAsDateFormat");
      var numMonths = this._getNumberOfMonths(inst);
      var showCurrentAtPos = this._get(inst, "showCurrentAtPos");
      var stepMonths = this._get(inst, "stepMonths");
      var isMultiMonth = numMonths[0] != 1 || numMonths[1] != 1;
      var currentDate = this._daylightSavingAdjust(
        !inst.currentDay
          ? new Date(9999, 9, 9)
          : new Date(inst.currentYear, inst.currentMonth, inst.currentDay)
      );
      var minDate = this._getMinMaxDate(inst, "min");
      var maxDate = this._getMinMaxDate(inst, "max");
      var drawMonth = inst.drawMonth - showCurrentAtPos;
      var drawYear = inst.drawYear;
      if (drawMonth < 0) {
        drawMonth += 12;
        drawYear--;
      }
      if (maxDate) {
        var maxDraw = this._daylightSavingAdjust(
          new Date(
            maxDate.getFullYear(),
            maxDate.getMonth() - numMonths[0] * numMonths[1] + 1,
            maxDate.getDate()
          )
        );
        maxDraw = minDate && maxDraw < minDate ? minDate : maxDraw;
        while (
          this._daylightSavingAdjust(new Date(drawYear, drawMonth, 1)) > maxDraw
        ) {
          drawMonth--;
          if (drawMonth < 0) {
            drawMonth = 11;
            drawYear--;
          }
        }
      }
      inst.drawMonth = drawMonth;
      inst.drawYear = drawYear;
      var prevText = this._get(inst, "prevText");
      prevText = !navigationAsDateFormat
        ? prevText
        : this.formatDate(
            prevText,
            this._daylightSavingAdjust(
              new Date(drawYear, drawMonth - stepMonths, 1)
            ),
            this._getFormatConfig(inst)
          );
      var prev = this._canAdjustMonth(inst, -1, drawYear, drawMonth)
        ? '<a class="ui-datepicker-prev ui-corner-all" onclick="DP_jQuery_' +
          dpuuid +
          ".datepicker._adjustDate('#" +
          inst.id +
          "', -" +
          stepMonths +
          ", 'M');\" title=\"" +
          prevText +
          '"><span class="ui-icon ui-icon-circle-triangle-' +
          (isRTL ? "e" : "w") +
          '">' +
          prevText +
          "</span></a>"
        : hideIfNoPrevNext
        ? ""
        : '<a class="ui-datepicker-prev ui-corner-all ui-state-disabled" title="' +
          prevText +
          '"><span class="ui-icon ui-icon-circle-triangle-' +
          (isRTL ? "e" : "w") +
          '">' +
          prevText +
          "</span></a>";
      var nextText = this._get(inst, "nextText");
      nextText = !navigationAsDateFormat
        ? nextText
        : this.formatDate(
            nextText,
            this._daylightSavingAdjust(
              new Date(drawYear, drawMonth + stepMonths, 1)
            ),
            this._getFormatConfig(inst)
          );
      var next = this._canAdjustMonth(inst, +1, drawYear, drawMonth)
        ? '<a class="ui-datepicker-next ui-corner-all" onclick="DP_jQuery_' +
          dpuuid +
          ".datepicker._adjustDate('#" +
          inst.id +
          "', +" +
          stepMonths +
          ", 'M');\" title=\"" +
          nextText +
          '"><span class="ui-icon ui-icon-circle-triangle-' +
          (isRTL ? "w" : "e") +
          '">' +
          nextText +
          "</span></a>"
        : hideIfNoPrevNext
        ? ""
        : '<a class="ui-datepicker-next ui-corner-all ui-state-disabled" title="' +
          nextText +
          '"><span class="ui-icon ui-icon-circle-triangle-' +
          (isRTL ? "w" : "e") +
          '">' +
          nextText +
          "</span></a>";
      var currentText = this._get(inst, "currentText");
      var gotoDate =
        this._get(inst, "gotoCurrent") && inst.currentDay ? currentDate : today;
      currentText = !navigationAsDateFormat
        ? currentText
        : this.formatDate(currentText, gotoDate, this._getFormatConfig(inst));
      var controls = !inst.inline
        ? '<button type="button" class="ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all" onclick="DP_jQuery_' +
          dpuuid +
          '.datepicker._hideDatepicker();">' +
          this._get(inst, "closeText") +
          "</button>"
        : "";
      var buttonPanel = showButtonPanel
        ? '<div class="ui-datepicker-buttonpane ui-widget-content">' +
          (isRTL ? controls : "") +
          (this._isInRange(inst, gotoDate)
            ? '<button type="button" class="ui-datepicker-current ui-state-default ui-priority-secondary ui-corner-all" onclick="DP_jQuery_' +
              dpuuid +
              ".datepicker._gotoToday('#" +
              inst.id +
              "');\">" +
              currentText +
              "</button>"
            : "") +
          (isRTL ? "" : controls) +
          "</div>"
        : "";
      var firstDay = parseInt(this._get(inst, "firstDay"), 10);
      firstDay = isNaN(firstDay) ? 0 : firstDay;
      var showWeek = this._get(inst, "showWeek");
      var dayNames = this._get(inst, "dayNames");
      var dayNamesShort = this._get(inst, "dayNamesShort");
      var dayNamesMin = this._get(inst, "dayNamesMin");
      var monthNames = this._get(inst, "monthNames");
      var monthNamesShort = this._get(inst, "monthNamesShort");
      var beforeShowDay = this._get(inst, "beforeShowDay");
      var showOtherMonths = this._get(inst, "showOtherMonths");
      var selectOtherMonths = this._get(inst, "selectOtherMonths");
      var calculateWeek = this._get(inst, "calculateWeek") || this.iso8601Week;
      var defaultDate = this._getDefaultDate(inst);
      var html = "";
      for (var row = 0; row < numMonths[0]; row++) {
        var group = "";
        for (var col = 0; col < numMonths[1]; col++) {
          var selectedDate = this._daylightSavingAdjust(
            new Date(drawYear, drawMonth, inst.selectedDay)
          );
          var cornerClass = " ui-corner-all";
          var calender = "";
          if (isMultiMonth) {
            calender += '<div class="ui-datepicker-group';
            if (numMonths[1] > 1) {
              switch (col) {
                case 0:
                  calender += " ui-datepicker-group-first";
                  cornerClass = " ui-corner-" + (isRTL ? "right" : "left");
                  break;
                case numMonths[1] - 1:
                  calender += " ui-datepicker-group-last";
                  cornerClass = " ui-corner-" + (isRTL ? "left" : "right");
                  break;
                default:
                  calender += " ui-datepicker-group-middle";
                  cornerClass = "";
                  break;
              }
            }
            calender += '">';
          }
          calender +=
            '<div class="ui-datepicker-header ui-widget-header ui-helper-clearfix' +
            cornerClass +
            '">' +
            (/all|left/.test(cornerClass) && row == 0
              ? isRTL
                ? next
                : prev
              : "") +
            (/all|right/.test(cornerClass) && row == 0
              ? isRTL
                ? prev
                : next
              : "") +
            this._generateMonthYearHeader(
              inst,
              drawMonth,
              drawYear,
              minDate,
              maxDate,
              row > 0 || col > 0,
              monthNames,
              monthNamesShort
            ) +
            '</div><table class="ui-datepicker-calendar"><thead><tr>';
          var thead = showWeek
            ? '<th class="ui-datepicker-week-col">' +
              this._get(inst, "weekHeader") +
              "</th>"
            : "";
          for (var dow = 0; dow < 7; dow++) {
            var day = (dow + firstDay) % 7;
            thead +=
              "<th" +
              ((dow + firstDay + 6) % 7 >= 5
                ? ' class="ui-datepicker-week-end"'
                : "") +
              '><span title="' +
              dayNames[day] +
              '">' +
              dayNamesMin[day] +
              "</span></th>";
          }
          calender += thead + "</tr></thead><tbody>";
          var daysInMonth = this._getDaysInMonth(drawYear, drawMonth);
          if (
            drawYear == inst.selectedYear &&
            drawMonth == inst.selectedMonth
          ) {
            inst.selectedDay = Math.min(inst.selectedDay, daysInMonth);
          }
          var leadDays =
            (this._getFirstDayOfMonth(drawYear, drawMonth) - firstDay + 7) % 7;
          var numRows = isMultiMonth
            ? 6
            : Math.ceil((leadDays + daysInMonth) / 7);
          var printDate = this._daylightSavingAdjust(
            new Date(drawYear, drawMonth, 1 - leadDays)
          );
          for (var dRow = 0; dRow < numRows; dRow++) {
            calender += "<tr>";
            var tbody = !showWeek
              ? ""
              : '<td class="ui-datepicker-week-col">' +
                this._get(inst, "calculateWeek")(printDate) +
                "</td>";
            for (var dow = 0; dow < 7; dow++) {
              var daySettings = beforeShowDay
                ? beforeShowDay.apply(inst.input ? inst.input[0] : null, [
                    printDate,
                  ])
                : [true, ""];
              var otherMonth = printDate.getMonth() != drawMonth;
              var unselectable =
                (otherMonth && !selectOtherMonths) ||
                !daySettings[0] ||
                (minDate && printDate < minDate) ||
                (maxDate && printDate > maxDate);
              tbody +=
                '<td class="' +
                ((dow + firstDay + 6) % 7 >= 5
                  ? " ui-datepicker-week-end"
                  : "") +
                (otherMonth ? " ui-datepicker-other-month" : "") +
                ((printDate.getTime() == selectedDate.getTime() &&
                  drawMonth == inst.selectedMonth &&
                  inst._keyEvent) ||
                (defaultDate.getTime() == printDate.getTime() &&
                  defaultDate.getTime() == selectedDate.getTime())
                  ? " " + this._dayOverClass
                  : "") +
                (unselectable
                  ? " " + this._unselectableClass + " ui-state-disabled"
                  : "") +
                (otherMonth && !showOtherMonths
                  ? ""
                  : " " +
                    daySettings[1] +
                    (printDate.getTime() == currentDate.getTime()
                      ? " " + this._currentClass
                      : "") +
                    (printDate.getTime() == today.getTime()
                      ? " ui-datepicker-today"
                      : "")) +
                '"' +
                ((!otherMonth || showOtherMonths) && daySettings[2]
                  ? ' title="' + daySettings[2] + '"'
                  : "") +
                (unselectable
                  ? ""
                  : ' onclick="DP_jQuery_' +
                    dpuuid +
                    ".datepicker._selectDay('#" +
                    inst.id +
                    "'," +
                    printDate.getMonth() +
                    "," +
                    printDate.getFullYear() +
                    ', this);return false;"') +
                ">" +
                (otherMonth && !showOtherMonths
                  ? "&#xa0;"
                  : unselectable
                  ? '<span class="ui-state-default">' +
                    printDate.getDate() +
                    "</span>"
                  : '<a class="ui-state-default' +
                    (printDate.getTime() == today.getTime()
                      ? " ui-state-highlight"
                      : "") +
                    (printDate.getTime() == currentDate.getTime()
                      ? " ui-state-active"
                      : "") +
                    (otherMonth ? " ui-priority-secondary" : "") +
                    '" href="#">' +
                    printDate.getDate() +
                    "</a>") +
                "</td>";
              printDate.setDate(printDate.getDate() + 1);
              printDate = this._daylightSavingAdjust(printDate);
            }
            calender += tbody + "</tr>";
          }
          drawMonth++;
          if (drawMonth > 11) {
            drawMonth = 0;
            drawYear++;
          }
          calender +=
            "</tbody></table>" +
            (isMultiMonth
              ? "</div>" +
                (numMonths[0] > 0 && col == numMonths[1] - 1
                  ? '<div class="ui-datepicker-row-break"></div>'
                  : "")
              : "");
          group += calender;
        }
        html += group;
      }
      html +=
        buttonPanel +
        ($.browser.msie && parseInt($.browser.version, 10) < 7 && !inst.inline
          ? '<iframe src="javascript:false;" class="ui-datepicker-cover" frameborder="0"></iframe>'
          : "");
      inst._keyEvent = false;
      return html;
    },
    _generateMonthYearHeader: function (
      inst,
      drawMonth,
      drawYear,
      minDate,
      maxDate,
      secondary,
      monthNames,
      monthNamesShort
    ) {
      var changeMonth = this._get(inst, "changeMonth");
      var changeYear = this._get(inst, "changeYear");
      var showMonthAfterYear = this._get(inst, "showMonthAfterYear");
      var html = '<div class="ui-datepicker-title">';
      var monthHtml = "";
      if (secondary || !changeMonth) {
        monthHtml +=
          '<span class="ui-datepicker-month">' +
          monthNames[drawMonth] +
          "</span>";
      } else {
        var inMinYear = minDate && minDate.getFullYear() == drawYear;
        var inMaxYear = maxDate && maxDate.getFullYear() == drawYear;
        monthHtml +=
          '<select class="ui-datepicker-month" onchange="DP_jQuery_' +
          dpuuid +
          ".datepicker._selectMonthYear('#" +
          inst.id +
          "', this, 'M');\" onclick=\"DP_jQuery_" +
          dpuuid +
          ".datepicker._clickMonthYear('#" +
          inst.id +
          "');\">";
        for (var month = 0; month < 12; month++) {
          if (
            (!inMinYear || month >= minDate.getMonth()) &&
            (!inMaxYear || month <= maxDate.getMonth())
          ) {
            monthHtml +=
              '<option value="' +
              month +
              '"' +
              (month == drawMonth ? ' selected="selected"' : "") +
              ">" +
              monthNamesShort[month] +
              "</option>";
          }
        }
        monthHtml += "</select>";
      }
      if (!showMonthAfterYear) {
        html +=
          monthHtml +
          (secondary || !(changeMonth && changeYear) ? "&#xa0;" : "");
      }
      if (secondary || !changeYear) {
        html += '<span class="ui-datepicker-year">' + drawYear + "</span>";
      } else {
        var years = this._get(inst, "yearRange").split(":");
        var thisYear = new Date().getFullYear();
        var determineYear = function (value) {
          var year = value.match(/c[+-].*/)
            ? drawYear + parseInt(value.substring(1), 10)
            : value.match(/[+-].*/)
            ? thisYear + parseInt(value, 10)
            : parseInt(value, 10);
          return isNaN(year) ? thisYear : year;
        };
        var year = determineYear(years[0]);
        var endYear = Math.max(year, determineYear(years[1] || ""));
        year = minDate ? Math.max(year, minDate.getFullYear()) : year;
        endYear = maxDate ? Math.min(endYear, maxDate.getFullYear()) : endYear;
        html +=
          '<select class="ui-datepicker-year" onchange="DP_jQuery_' +
          dpuuid +
          ".datepicker._selectMonthYear('#" +
          inst.id +
          "', this, 'Y');\" onclick=\"DP_jQuery_" +
          dpuuid +
          ".datepicker._clickMonthYear('#" +
          inst.id +
          "');\">";
        for (; year <= endYear; year++) {
          html +=
            '<option value="' +
            year +
            '"' +
            (year == drawYear ? ' selected="selected"' : "") +
            ">" +
            year +
            "</option>";
        }
        html += "</select>";
      }
      html += this._get(inst, "yearSuffix");
      if (showMonthAfterYear) {
        html +=
          (secondary || !(changeMonth && changeYear) ? "&#xa0;" : "") +
          monthHtml;
      }
      html += "</div>";
      return html;
    },
    _adjustInstDate: function (inst, offset, period) {
      var year = inst.drawYear + (period == "Y" ? offset : 0);
      var month = inst.drawMonth + (period == "M" ? offset : 0);
      var day =
        Math.min(inst.selectedDay, this._getDaysInMonth(year, month)) +
        (period == "D" ? offset : 0);
      var date = this._restrictMinMax(
        inst,
        this._daylightSavingAdjust(new Date(year, month, day))
      );
      inst.selectedDay = date.getDate();
      inst.drawMonth = inst.selectedMonth = date.getMonth();
      inst.drawYear = inst.selectedYear = date.getFullYear();
      if (period == "M" || period == "Y") {
        this._notifyChange(inst);
      }
    },
    _restrictMinMax: function (inst, date) {
      var minDate = this._getMinMaxDate(inst, "min");
      var maxDate = this._getMinMaxDate(inst, "max");
      date = minDate && date < minDate ? minDate : date;
      date = maxDate && date > maxDate ? maxDate : date;
      return date;
    },
    _notifyChange: function (inst) {
      var onChange = this._get(inst, "onChangeMonthYear");
      if (onChange) {
        onChange.apply(inst.input ? inst.input[0] : null, [
          inst.selectedYear,
          inst.selectedMonth + 1,
          inst,
        ]);
      }
    },
    _getNumberOfMonths: function (inst) {
      var numMonths = this._get(inst, "numberOfMonths");
      return numMonths == null
        ? [1, 1]
        : typeof numMonths == "number"
        ? [1, numMonths]
        : numMonths;
    },
    _getMinMaxDate: function (inst, minMax) {
      return this._determineDate(inst, this._get(inst, minMax + "Date"), null);
    },
    _getDaysInMonth: function (year, month) {
      return 32 - new Date(year, month, 32).getDate();
    },
    _getFirstDayOfMonth: function (year, month) {
      return new Date(year, month, 1).getDay();
    },
    _canAdjustMonth: function (inst, offset, curYear, curMonth) {
      var numMonths = this._getNumberOfMonths(inst);
      var date = this._daylightSavingAdjust(
        new Date(
          curYear,
          curMonth + (offset < 0 ? offset : numMonths[0] * numMonths[1]),
          1
        )
      );
      if (offset < 0) {
        date.setDate(this._getDaysInMonth(date.getFullYear(), date.getMonth()));
      }
      return this._isInRange(inst, date);
    },
    _isInRange: function (inst, date) {
      var minDate = this._getMinMaxDate(inst, "min");
      var maxDate = this._getMinMaxDate(inst, "max");
      return (
        (!minDate || date.getTime() >= minDate.getTime()) &&
        (!maxDate || date.getTime() <= maxDate.getTime())
      );
    },
    _getFormatConfig: function (inst) {
      var shortYearCutoff = this._get(inst, "shortYearCutoff");
      shortYearCutoff =
        typeof shortYearCutoff != "string"
          ? shortYearCutoff
          : (new Date().getFullYear() % 100) + parseInt(shortYearCutoff, 10);
      return {
        shortYearCutoff: shortYearCutoff,
        dayNamesShort: this._get(inst, "dayNamesShort"),
        dayNames: this._get(inst, "dayNames"),
        monthNamesShort: this._get(inst, "monthNamesShort"),
        monthNames: this._get(inst, "monthNames"),
      };
    },
    _formatDate: function (inst, day, month, year) {
      if (!day) {
        inst.currentDay = inst.selectedDay;
        inst.currentMonth = inst.selectedMonth;
        inst.currentYear = inst.selectedYear;
      }
      var date = day
        ? typeof day == "object"
          ? day
          : this._daylightSavingAdjust(new Date(year, month, day))
        : this._daylightSavingAdjust(
            new Date(inst.currentYear, inst.currentMonth, inst.currentDay)
          );
      return this.formatDate(
        this._get(inst, "dateFormat"),
        date,
        this._getFormatConfig(inst)
      );
    },
  });
  function extendRemove(target, props) {
    $.extend(target, props);
    for (var name in props) {
      if (props[name] == null || props[name] == undefined) {
        target[name] = props[name];
      }
    }
    return target;
  }
  function isArray(a) {
    return (
      a &&
      (($.browser.safari && typeof a == "object" && a.length) ||
        (a.constructor && a.constructor.toString().match(/\Array\(\)/)))
    );
  }
  $.fn.datepicker = function (options) {
    if (!$.datepicker.initialized) {
      $(document)
        .mousedown($.datepicker._checkExternalClick)
        .find("body")
        .append($.datepicker.dpDiv);
      $.datepicker.initialized = true;
    }
    var otherArgs = Array.prototype.slice.call(arguments, 1);
    if (
      typeof options == "string" &&
      (options == "isDisabled" || options == "getDate" || options == "widget")
    ) {
      return $.datepicker["_" + options + "Datepicker"].apply(
        $.datepicker,
        [this[0]].concat(otherArgs)
      );
    }
    if (
      options == "option" &&
      arguments.length == 2 &&
      typeof arguments[1] == "string"
    ) {
      return $.datepicker["_" + options + "Datepicker"].apply(
        $.datepicker,
        [this[0]].concat(otherArgs)
      );
    }
    return this.each(function () {
      typeof options == "string"
        ? $.datepicker["_" + options + "Datepicker"].apply(
            $.datepicker,
            [this].concat(otherArgs)
          )
        : $.datepicker._attachDatepicker(this, options);
    });
  };
  $.datepicker = new Datepicker();
  $.datepicker.initialized = false;
  $.datepicker.uuid = new Date().getTime();
  $.datepicker.version = "1.8";
  window["DP_jQuery_" + dpuuid] = $;
})(jQuery);
var validator;
$(document).ready(function () {
  $(".spoiler h3").click(function () {
    if ($(".spoiler-box").css("display") == "none") {
      $(".spoiler-box").show();
      $(this).find("span").attr("class", "minus");
    } else {
      $(".spoiler-box").hide();
      $(this).find("span").attr("class", "plus");
    }
  });
  preloadImages();
  $("a").click(function () {
    if (
      !$(this).hasClass("no-loader") &&
      !$(this).hasClass("mceButton") &&
      !$(this).hasClass("mceText") &&
      !$(this).hasClass("mceOpen")
    )
      loader();
  });
  $("a.confirm").click(function () {
    if (confirm(tt.confirm_delete)) {
      loader();
      return true;
    }
    return false;
  });
  grid("grid", true);
  $(".admin_table_filter input, .admin_table_filter select").keypress(function (
    e
  ) {
    if (e.keyCode == 13) {
      filter();
      return false;
    }
  });
  jQuery.validator.setDefaults({
    errorClass: "invalid",
    errorElement: "span",
  });
  jQuery.validator.messages.required = "";
  jQuery.validator.messages.number = "";
  jQuery.validator.messages.email = "specify correct e-mail";
  validator = $("#frm").validate({
    submitHandler: function (form) {
      form.submit();
    },
  });
  $(".save-btn").click(function () {
    if (validator.numberOfInvalids() > 0) {
      var invalid_element = $("#frm input.invalid:first"),
        in_tab = invalid_element.parents(".tab-body");
      if (in_tab.length > 0) {
        $("#tab li").removeClass("current_li");
        $("#" + in_tab.prop("id").replace("_body", "")).addClass("current_li");
        $(".tab-body").hide();
        in_tab.show();
      }
      invalid_element.focus();
    }
  });
  if (typeof active_tab == "undefined" || active_tab === null) {
    var invalid_element = $("#frm input.form-error:first"),
      in_tab,
      tab = $("#tab li:first");
    if (invalid_element.length > 0) {
      in_tab = invalid_element.parents(".tab-body");
      if (in_tab.length > 0) {
        tab = $("#" + in_tab.prop("id").replace("_body", ""));
      }
    }
  } else {
    var tab = $("#tab_" + active_tab);
  }
  tab.addClass("current_li");
  $("#" + tab.prop("id") + "_body").show();
  if (invalid_element.length > 0) {
    invalid_element.focus();
  }
  $("#tab li").click(function () {
    $("#tab li").removeClass("current_li");
    $(this).addClass("current_li");
    $(".tab-body").hide();
    $("#" + $(this).prop("id") + "_body").show();
  });
  $(".letters-counter")
    .parent()
    .parent()
    .find("textarea")
    .each(function () {
      $(this)
        .parent()
        .find(".letters-counter")
        .html("Символов: " + $(this).val().length);
    });
  $(".letters-counter")
    .parent()
    .parent()
    .find("textarea")
    .keyup(function () {
      $(this)
        .parent()
        .find(".letters-counter")
        .html("Символов: " + $(this).val().length);
    });

  console.log(window.location.host);
  console.log("v. 5");
  $("textarea.mceEditor").tinymce({
    script_url: "/js/tinymce/tiny_mce.js",
    theme: "advanced",
    theme_advanced_toolbar_location: "top",
    theme_advanced_toolbar_align: "left",
    theme_advanced_statusbar_location: "bottom",
    plugins:
      "safari,pagebreak,style,layer,table,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,inlinepopups,imagemanager,filemanager",
    theme_advanced_buttons1:
      "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
    theme_advanced_buttons2:
      "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
    theme_advanced_buttons3:
      "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,fullscreen",
    theme_advanced_buttons4:
      "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,|,visualchars,nonbreaking,blockquote,pagebreak,|,insertfile,insertimage",
    language: lang,
    height: "400px",
    width: "100%",
    relative_urls: true,
    convert_urls: true,
    remove_script_host: 0,
    document_base_url: "http://" + window.location.host + "/",
  });
  $("textarea.mceSimpleEditor").tinymce({
    script_url: "/js/tinymce/tiny_mce.js",
    theme: "simple",
    theme_advanced_toolbar_location: "top",
    theme_advanced_toolbar_align: "left",
    theme_advanced_statusbar_location: "bottom",
    language: "ru",
    height: "200px",
    width: "100%",
    relative_urls: true,
    convert_urls: true,
    remove_script_host: 0,
    document_base_url: "http://" + window.location.host + "/",
  });
  $("textarea.mceImageEditor").tinymce({
    script_url: "/js/tinymce/tiny_mce.js",
    theme: "advanced",
    theme_advanced_toolbar_location: "top",
    theme_advanced_toolbar_align: "left",
    theme_advanced_statusbar_location: "bottom",
    plugins:
      "safari,pagebreak,style,layer,table,advhr,imageupload,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,inlinepopups",
    theme_advanced_buttons1:
      "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
    theme_advanced_buttons2:
      "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,imageupload,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
    theme_advanced_buttons3:
      "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,fullscreen",
    theme_advanced_buttons4:
      "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,|,visualchars,nonbreaking,blockquote,pagebreak",
    language: lang,
    height: "400px",
    width: "100%",
    relative_urls: true,
    convert_urls: true,
    remove_script_host: 0,
    document_base_url: "http://" + window.location.host + "/",
    urlconverter_callback: "myCustomURLConverter",
  });
});
function myCustomURLConverter(url, node, on_save, name) {
  // Do some custom URL conversion
  if (name == "src") {
    url = window.location.origin + "/uploads/" + url;
  }
  // Return new URL
  return "/" + url;
}
function move_row_down(a) {
  var item = $(a).parent().parent(),
    next = item.next();
  if (next.hasClass("row")) {
    item.insertAfter(next);
    reorder(item.parent());
  }
}
function move_row_up(a) {
  var item = $(a).parent().parent(),
    prev = item.prev();
  if (prev.hasClass("row")) {
    item.insertBefore(prev);
    reorder(item.parent());
  }
}
function reorder(c) {
  var i = 1;
  c.find(".sort_order").each(function () {
    $(this).val(i);
    i++;
  });
}
