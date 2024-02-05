$(function () {
  // create by Hisyam 10-11-2023
  //
  $(".confirm-workorder-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#confirm-workorder-modal")
        .modal("show")
        .find("#confirm-workorder")
        .empty()
        .append(html);
    });
  });
  $(".workorder-proc-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#workorder-proc-modal")
        .modal("show")
        .find("#workorder-proc")
        .empty()
        .append(html);
    });
  });
  $(".workorder-upload-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#workorder-upload-modal")
        .modal("show")
        .find("#workorder-upload")
        .empty()
        .append(html);
    });
  });
  $(".viewworkorder-modal-click").click(function (e) {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#viewworkorder-modal")
        .modal("show")
        .find("#viewworkorder")
        .empty()
        .append(html);
    });
  });
  $(".updateworkorder-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#updateworkorder-modal")
        .modal("show")
        .find("#updateworkorder")
        .empty()
        .append(html);
    });
  });
  $(".createworkorder-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#createworkorder-modal")
        .modal("show")
        .find("#createworkorder")
        .empty()
        .append(html);
    });
  });
  //
  $(".viewwohiring-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#viewwohiring-modal")
        .modal("show")
        .find("#view-wohiring-view")
        .empty()
        .append(html);
    });
  });
  $(".createwohiring-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#createwohiring-modal")
        .modal("create")
        .find("#createwohiring")
        .empty()
        .append(html);
    });
  });
  $(".showwohiring-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#showwohiring-modal")
        .modal("show")
        .find("#showwohiring")
        .empty()
        .append(html);
    });
  });
  $(".approvewohiring-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#approvewohiring-modal")
        .modal("show")
        .find("#approvewohiring")
        .empty()
        .append(html);
    });
  });
    $(".addcandidate-modal-click").click(function () {
      var loading = new Loading({
        direction: "hor",
        discription: "Loading...",
        defaultApply: true,
      });

      event.preventDefault();
      this.blur();
      $.get($(this).attr("value"), function (html) {
        loading.out();
        $("#addcandidate-modal")
          .modal("show")
          .find("#addcandidateform")
          .empty()
          .append(html);
      });
    });
    $(".addcandidate2workorder-modal-click").click(function () {
      var loading = new Loading({
        direction: "hor",
        discription: "Loading...",
        defaultApply: true,
      });

      event.preventDefault();
      this.blur();
      $.get($(this).attr("value"), function (html) {
        loading.out();
        $("#addcandidate2workorder-modal")
          .modal("show")
          .find("#addcandidateform2")
          .empty()
          .append(html);
      });
    });
});
