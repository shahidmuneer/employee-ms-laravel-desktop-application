(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
"use strict";

$(function () {

  $(document).on("click", ".btn-add", function () {

    var controlForm = $('tbody'),
        currentEntry = $(this).parents('tbody tr:first'),
        newEntry = $(currentEntry.clone()).appendTo(controlForm);
    newEntry.find('input').val('');
    controlForm.find('tr:not(:last) .buttons .btn-add').removeClass('btn-add').addClass('btn-remove').find(".fa-plus").removeClass("fa-plus").addClass("fa-remove");
  }).on('click', '.btn-remove', function () {
    $(this).parents('tr').remove();
  });

  $(document).on("click", "#selectall", function () {

    document.querySelectorAll('body #checkbox').forEach(function (item) {

      item.checked = document.querySelector('#selectall').checked;
    });
  });

  $(document).on("submit", "#editForm", function (e) {

    var str = "";
    document.querySelectorAll('body #checkbox').forEach(function (item) {

      if (item.checked) {
        str += item.value + ",";
      }
    });
    $("#editForm #editids").val(str);
  });
  $("#type_id").on("change", function () {
    var not_found = false;
    var date = $("#date").val();
    var type_id = $("#type_id").val();
    if (date == "") {
      alert("Date Cannot be empty !");
      $(undefined).prop("selected", false);
      return;
    }
    waitingDialog.show('Waiting to fetch grant heads available');

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    var controlForm = $('tbody'),
        currentEntry = $("tbody").find('tr:last'),
        newEntry;

    $.ajax({
      url: global_grantHead_route,
      type: "post",
      data: { date: date, _method: "POST", type_id: type_id },
      dataType: "json",
      success: function success(data) {
        $.each(data.grantHeads, function (index, item) {
          console.log(data);
          not_found = true;
          if (index == 0) {
            newEntry = controlForm.html(currentEntry.clone());
          } else {
            newEntry = $(currentEntry.clone()).appendTo(controlForm);
          }
          newEntry.find('#amount').val(item.credit == 0 ? item.debit : item.credit);
          newEntry.find('#grant_id').val(item.grant_id).prop("selected", true);
          newEntry.find('#doc').val(item.credit == 0 ? "0" : "1").prop("selected", true);

          controlForm.find('tr:not(:last) .buttons .btn-add').removeClass('btn-add').addClass('btn-remove').find(".fa-plus").removeClass("fa-plus").addClass("fa-remove");
        });
        waitingDialog.hide();

        if (!not_found) {
          console.log("not found sorry ");
          $.ajax({
            url: global_grant_route,
            type: "post",
            dataType: "json",
            success: function success(data) {

              $.each(data.grants, function (index, item) {

                if (index == 0) {
                  newEntry = controlForm.html(currentEntry.clone());
                } else {
                  newEntry = $(currentEntry.clone()).appendTo(controlForm);
                }
                newEntry.find('#amount').val("");
                newEntry.find('#grant_id').val(item.id).prop("selected", true);
                controlForm.find('tr:not(:last) .buttons .btn-add').removeClass('btn-add').addClass('btn-remove').find(".fa-plus").removeClass("fa-plus").addClass("fa-remove");
              });
            },

            error: function error(_error) {
              console.log(_error);
            }
          });
        }
      },
      error: function error(_error2) {
        console.log(_error2);
      }

    });
  });

  /**
   * Module for displaying "Waiting for..." dialog using Bootstrap
   *
   * @author Eugene Maslovich <ehpc@em42.ru>
   */

  var waitingDialog = waitingDialog || function ($) {
    'use strict';

    // Creating modal dialog's DOM

    var $dialog = $('<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' + '<div class="modal-dialog modal-m">' + '<div class="modal-content">' + '<div class="modal-header"><h3 style="margin:0;"></h3></div>' + '<div class="modal-body">' + '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' + '</div>' + '</div></div></div>');

    return {
      /**
       * Opens our dialog
       * @param message Custom message
       * @param options Custom options:
       * 				  options.dialogSize - bootstrap postfix for dialog size, e.g. "sm", "m";
       * 				  options.progressType - bootstrap postfix for progress bar type, e.g. "success", "warning".
       */
      show: function show(message, options) {
        // Assigning defaults
        if (typeof options === 'undefined') {
          options = {};
        }
        if (typeof message === 'undefined') {
          message = 'Loading';
        }
        var settings = $.extend({
          dialogSize: 'm',
          progressType: '',
          onHide: null // This callback runs after the dialog was hidden
        }, options);

        // Configuring dialog
        $dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
        $dialog.find('.progress-bar').attr('class', 'progress-bar');
        if (settings.progressType) {
          $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
        }
        $dialog.find('h3').text(message);
        // Adding callbacks
        if (typeof settings.onHide === 'function') {
          $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
            settings.onHide.call($dialog);
          });
        }
        // Opening dialog
        $dialog.modal();
      },
      /**
       * Closes dialog
       */
      hide: function hide() {
        $dialog.modal('hide');
      }
    };
  }(jQuery);
});

},{}]},{},[1]);

//# sourceMappingURL=main.js.map
