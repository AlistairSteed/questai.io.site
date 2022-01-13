var ToastrDemo = function () {
    var t = function () {
        var t, o = -1, e = 0;
        $("#showtoast").click(function () {
            var n, a = $("#toastTypeGroup input:radio:checked").val(), i = $("#message").val(),
                s = $("#title").val() || "", r = $("#showDuration"), l = $("#hideDuration"), c = $("#timeOut"),
                p = $("#extendedTimeOut"), u = $("#showEasing"), d = $("#hideEasing"), h = $("#showMethod"),
                v = $("#hideMethod"), g = e++, f = $("#addClear").prop("checked");
            toastr.options = {
                closeButton: $("#closeButton").prop("checked"),
                debug: $("#debugInfo").prop("checked"),
                newestOnTop: $("#newestOnTop").prop("checked"),
                progressBar: $("#progressBar").prop("checked"),
                positionClass: $("#positionGroup input:radio:checked").val() || "toast-top-right",
                preventDuplicates: $("#preventDuplicates").prop("checked"),
                onclick: null
            }, $("#addBehaviorOnToastClick").prop("checked") && (toastr.options.onclick = function () {
                alert("You can perform some custom action after a toast goes away")
            }), r.val().length && (toastr.options.showDuration = r.val()), l.val().length && (toastr.options.hideDuration = l.val()), c.val().length && (toastr.options.timeOut = f ? 0 : c.val()), p.val().length && (toastr.options.extendedTimeOut = f ? 0 : p.val()), u.val().length && (toastr.options.showEasing = u.val()), d.val().length && (toastr.options.hideEasing = d.val()), h.val().length && (toastr.options.showMethod = h.val()), v.val().length && (toastr.options.hideMethod = v.val()), f && (i = function (t) {
                return t = t || "Clear itself?", t += '<br /><br /><button type="button" class="btn btn-outline-light btn-sm m-btn m-btn--air m-btn--wide clear">Yes</button>'
            }(i), toastr.options.tapToDismiss = !1), i || (++o === (n = ["New order has been placed!", "Are you the six fingered man?", "Inconceivable!", "I do not think that means what you think it means.", "Have fun storming the castle!"]).length && (o = 0), i = n[o]), $("#toastrOptions").text("toastr.options = " + JSON.stringify(toastr.options, null, 2) + ";\n\ntoastr." + a + '("' + i + (s ? '", "' + s : "") + '");');
            var k = toastr[a](i, s);
            t = k, void 0 !== k && (k.find("#okBtn").length && k.delegate("#okBtn", "click", function () {
                alert("you clicked me. i was toast #" + g + ". goodbye!"), k.remove()
            }), k.find("#surpriseBtn").length && k.delegate("#surpriseBtn", "click", function () {
                alert("Surprise! you clicked me. i was toast #" + g + ". You could perform an action here.")
            }), k.find(".clear").length && k.delegate(".clear", "click", function () {
                toastr.clear(k, {force: !0})
            }))
        }), $("#clearlasttoast").click(function () {
            toastr.clear(t)
        }), $("#cleartoasts").click(function () {
            toastr.clear()
        })
    };
    return {
        init: function () {
            t()
        }
    }
}();
jQuery(document).ready(function () {
    ToastrDemo.init()
});
