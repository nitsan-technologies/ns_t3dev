define([
  "jquery",
  "TYPO3/CMS/Backend/Modal",
  "TYPO3/CMS/Backend/Severity",
  "TYPO3/CMS/RosengartenMemorials/Datatables",
], function ($, Modal, Severity) {



  $(".removeTrigger").on("click", function (e) {
    let modalButtons = [];
    console.log($(this).attr("href"));
    e.preventDefault();
    let url = $(this).attr("href");

    modalButtons.push({
      text: TYPO3.lang["buttons.confirm.delete_record.no"] || "Cancel",
      active: true,
      btnClass: "btn-default",
      name: "cancel",
      trigger: function () {
        Modal.currentModal.trigger("modal-dismiss");
      },
    });

    modalButtons.push({
      text: TYPO3.lang["buttons.confirm.delete_record.yes"] || "Yes, delete this record",
      active: true,
      btnClass: "btn-warning",
      name: "delete",
      trigger: function () {
        document.location = url;
        Modal.currentModal.trigger("modal-dismiss");
      },
    });

    Modal.show(
      TYPO3.lang["label.confirm.delete_record.title"] || "Delete this record?",
      TYPO3.lang["label.confirm.delete_record.content"] || "Are you sure you want to delete this record?",
      Severity.warning,
      modalButtons
    );

  });
});
