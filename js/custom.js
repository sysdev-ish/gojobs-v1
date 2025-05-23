$(document).ready(function () {
  // javascript for form visa
  var n = $("input[type=checkbox]").length;
  $("#countcheck").val(n);
});

function horizontalNoTitle() {
  var loading = new Loading({
    direction: "hor",
    discription: "Loading...",
    defaultApply: true,
  });
}
function loadingOut(loading) {
  setTimeout(() => loading.out(), 3000);
}
$(function () {
  /*
  $(".user_language").change(function(){
    // console.log('AA');
    language=this.value;
    $.ajax({
      // url:'<?=Yii::$app->request->baseUrl?>/site/language',
      url:'site/language',
      type:"GET",
      data:{language:language},
      success:function(result){
        console.log(result);
        location.reload();
      },
    });
  });
	
  $(document).on('click','.language',function () {
    var lang = $(this).attr('id');
  	
    $.post('site/language',{'lang':lang},function(data){
      // location.reload();
    });
  });
  */

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
  $(".addcandidate2-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#addcandidate2-modal")
        .modal("show")
        .find("#addcandidateform2")
        .empty()
        .append(html);
    });
  });
  $(".canceljoin-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#canceljoin-modal")
        .modal("show")
        .find("#canceljoinview")
        .empty()
        .append(html);
    });
  });
  $(".stopjo-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#stopjo-modal").modal("show").find("#stopjoview").empty().append(html);
    });
  });

  // begin hold job view
  $(".hold-job-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#hold-job-modal").modal("show").find("#hold-job-view").empty().append(html);
    });
  });

  $(".viewuserrole-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#viewuserrole-modal")
        .modal("show")
        .find("#userroleview")
        .empty()
        .append(html);
    });
  });
  $(".viewuserlogin-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#viewuserlogin-modal")
        .modal("show")
        .find("#userloginview")
        .empty()
        .append(html);
    });
  });
  $(".viewgrouprolepermission-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#viewgrouprolepermission-modal")
        .modal("show")
        .find("#grouprolepermissionview")
        .empty()
        .append(html);
    });
  });
  $(".profileviewshort-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#profileviewshort-modal")
        .modal("show")
        .find("#profileviewshortview")
        .empty()
        .append(html);
    });
  });

  //add by kaha 23-9-2023
  $(".profileresultsummary-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#profileresultsummary-modal")
        .modal("show")
        .find("#profileresultsummaryview")
        .empty()
        .append(html);
    });
  });

  $(".recreq-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#recreq-modal").modal("show").find("#recreqview").empty().append(html);
    });
  });
  $(".invite-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#invite-modal").modal("show").find("#inviteview").empty().append(html);
    });
  });
  $(".viewmasterindustry-modal-click").click(function (e) {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#viewmasterindustry-modal")
        .modal("show")
        .find("#masterindustryview")
        .empty()
        .append(html);
    });
  });
  $(".updatemasterindustry-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#updatemasterindustry-modal")
        .modal("show")
        .find("#updatemasterindustry")
        .empty()
        .append(html);
    });
  });
  $(".createmasterindustry-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#createmasterindustry-modal")
        .modal("show")
        .find("#createmasterindustry")
        .empty()
        .append(html);
    });
  });

  $(".viewmasterjobfamily-modal-click").click(function (e) {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#viewmasterjobfamily-modal")
        .modal("show")
        .find("#masterjobfamilyview")
        .empty()
        .append(html);
    });
  });
  $(".updatemasterjobfamily-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#updatemasterjobfamily-modal")
        .modal("show")
        .find("#updatemasterjobfamily")
        .empty()
        .append(html);
    });
  });
  $(".createmasterjobfamily-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#createmasterjobfamily-modal")
        .modal("show")
        .find("#createmasterjobfamily")
        .empty()
        .append(html);
    });
  });

  $(".viewmastersubjobfamily-modal-click").click(function (e) {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#viewmastersubjobfamily-modal")
        .modal("show")
        .find("#mastersubjobfamilyview")
        .empty()
        .append(html);
    });
  });
  $(".updatemastersubjobfamily-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#updatemastersubjobfamily-modal")
        .modal("show")
        .find("#updatemastersubjobfamily")
        .empty()
        .append(html);
    });
  });
  $(".createmastersubjobfamily-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#createmastersubjobfamily-modal")
        .modal("show")
        .find("#createmastersubjobfamily")
        .empty()
        .append(html);
    });
  });

  $(".viewcms-modal-click").click(function (e) {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#viewcms-modal").modal("show").find("#cmsview").empty().append(html);
    });
  });
  $(".updatecms-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#updatecms-modal")
        .modal("show")
        .find("#updatecms")
        .empty()
        .append(html);
    });
  });
  $(".createcms-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#createcms-modal")
        .modal("show")
        .find("#createcms")
        .empty()
        .append(html);
    });
  });

  $(".viewmasterassesment-modal-click").click(function (e) {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#viewmasterassesment-modal")
        .modal("show")
        .find("#masterassesmentview")
        .empty()
        .append(html);
    });
  });
  $(".updatemasterassesment-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#updatemasterassesment-modal")
        .modal("show")
        .find("#updatemasterassesment")
        .empty()
        .append(html);
    });
  });
  $(".createmasterassesment-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#createmasterassesment-modal")
        .modal("show")
        .find("#createmasterassesment")
        .empty()
        .append(html);
    });
  });

  $(".viewcms-modal-click").click(function (e) {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#viewcms-modal").modal("show").find("#cmsview").empty().append(html);
    });
  });
  $(".updatecms-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#updatecms-modal")
        .modal("show")
        .find("#updatecms")
        .empty()
        .append(html);
    });
  });
  $(".createcms-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#createcms-modal")
        .modal("show")
        .find("#createcms")
        .empty()
        .append(html);
    });
  });

  $(".viewmasteroffice-modal-click").click(function (e) {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#viewmasteroffice-modal")
        .modal("show")
        .find("#masterofficeview")
        .empty()
        .append(html);
    });
  });
  $(".updatemasteroffice-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#updatemasteroffice-modal")
        .modal("show")
        .find("#updatemasteroffice")
        .empty()
        .append(html);
    });
  });
  $(".createmasteroffice-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#createmasteroffice-modal")
        .modal("show")
        .find("#createmasteroffice")
        .empty()
        .append(html);
    });
  });
  $(".viewmappingregionarea-modal-click").click(function (e) {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#viewmappingregionarea-modal")
        .modal("show")
        .find("#mappingregionareaview")
        .empty()
        .append(html);
    });
  });
  $(".updatemappingregionarea-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#updatemappingregionarea-modal")
        .modal("show")
        .find("#updatemappingregionarea")
        .empty()
        .append(html);
    });
  });
  $(".createmappingregionarea-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#createmappingregionarea-modal")
        .modal("show")
        .find("#createmappingregionarea")
        .empty()
        .append(html);
    });
  });

  $(".viewmappingjob-modal-click").click(function (e) {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#viewmappingjob-modal")
        .modal("show")
        .find("#mappingjobview")
        .empty()
        .append(html);
    });
  });
  $(".updatemappingjob-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#updatemappingjob-modal")
        .modal("show")
        .find("#updatemappingjob")
        .empty()
        .append(html);
    });
  });
  $(".createmappingjob-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#createmappingjob-modal")
        .modal("show")
        .find("#createmappingjob")
        .empty()
        .append(html);
    });
  });
  $(".viewmappingindustry-modal-click").click(function (e) {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#viewmappingindustry-modal")
        .modal("show")
        .find("#mappingindustryview")
        .empty()
        .append(html);
    });
  });
  $(".updatemappingindustry-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#updatemappingindustry-modal")
        .modal("show")
        .find("#updatemappingindustry")
        .empty()
        .append(html);
    });
  });
  $(".createmappingindustry-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#createmappingindustry-modal")
        .modal("show")
        .find("#createmappingindustry")
        .empty()
        .append(html);
    });
  });
  $(".viewmasterregion-modal-click").click(function (e) {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#viewmasterregion-modal")
        .modal("show")
        .find("#masterregionview")
        .empty()
        .append(html);
    });
  });
  $(".updatemasterregion-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#updatemasterregion-modal")
        .modal("show")
        .find("#updatemasterregion")
        .empty()
        .append(html);
    });
  });
  $(".createmasterregion-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#createmasterregion-modal")
        .modal("show")
        .find("#createmasterregion")
        .empty()
        .append(html);
    });
  });
  $(".viewmasterareaish-modal-click").click(function (e) {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#viewmasterareaish-modal")
        .modal("show")
        .find("#masterareaishview")
        .empty()
        .append(html);
    });
  });
  $(".updatemasterareaish-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#updatemasterareaish-modal")
        .modal("show")
        .find("#updatemasterareaish")
        .empty()
        .append(html);
    });
  });
  $(".createmasterareaish-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#createmasterareaish-modal")
        .modal("show")
        .find("#createmasterareaish")
        .empty()
        .append(html);
    });
  });
  $(".createmasterroom-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#createmasterroom-modal")
        .modal("show")
        .find("#createmasterroom")
        .empty()
        .append(html);
    });
  });
  $(".viewmasterroom-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#viewmasterroom-modal")
        .modal("show")
        .find("#masterroomview")
        .empty()
        .append(html);
    });
  });
  $(".updatemasterroom-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#updatemasterroom-modal")
        .modal("show")
        .find("#updatemasterroom")
        .empty()
        .append(html);
    });
  });
  $(".createmasterpic-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#createmasterpic-modal")
        .modal("show")
        .find("#createmasterpic")
        .empty()
        .append(html);
    });
  });
  $(".viewmasterpic-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#viewmasterpic-modal")
        .modal("show")
        .find("#masterpicview")
        .empty()
        .append(html);
    });
  });
  $(".updatemasterpic-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#updatemasterpic-modal")
        .modal("show")
        .find("#updatemasterpic")
        .empty()
        .append(html);
    });
  });
  $(".reccan-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#reccan-modal").modal("show").find("#reccanview").empty().append(html);
    });
  });
  $(".confirm-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });
    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#confirm-modal")
        .modal("show")
        .find("#confirminterview")
        .empty()
        .append(html);
    });
  });
  $(".intproc-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#intproc-modal").modal("show").find("#intproc").empty().append(html);
    });
  });

  $(".intupload-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });
    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#intupload-modal")
        .modal("show")
        .find("#intupload")
        .empty()
        .append(html);
    });
  });

  $(".confirmpskotest-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#confirmpskotest-modal")
        .modal("show")
        .find("#confirmpskotest")
        .empty()
        .append(html);
    });
  });
  $(".psikotestproc-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#psikotestproc-modal")
        .modal("show")
        .find("#psikotestproc")
        .empty()
        .append(html);
    });
  });
  $(".psikotestupload-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#psikotestupload-modal")
        .modal("show")
        .find("#psikotestupload")
        .empty()
        .append(html);
    });
  });
  $(".confirmuint-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#confirmuint-modal")
        .modal("show")
        .find("#confirmuint")
        .empty()
        .append(html);
    });
  });
  $(".uintproc-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#uintproc-modal").modal("show").find("#uintproc").empty().append(html);
    });
  });
  $(".tproc-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#tproc-modal").modal("show").find("#tproc").empty().append(html);
    });
  });
  $(".createhiring-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#hiring-modal").modal("show").find("#hiring").empty().append(html);
    });
  });
  $(".approvehiring-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#hiringapprove-modal")
        .modal("show")
        .find("#hiringapprove")
        .empty()
        .append(html);
    });
  });
  $(".changejo-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#changejo-modal")
        .modal("show")
        .find("#changejoview")
        .empty()
        .append(html);
    });
  });
  $(".updatenpwp-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#crformupdate-modal")
        .modal("show")
        .find("#crformupdate")
        .empty()
        .append(html);
    });
  });
  $(".updatebankacc-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#crformupdatebank-modal")
        .modal("show")
        .find("#crformupdatebank")
        .empty()
        .append(html);
    });
  });

  $(".updatedescriptionjo-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });
    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#updatedescjo-modal")
        .modal("show")
        .find("#updatedescjo")
        .empty()
        .append(html);
    });
  });

  $(".viewcrdata-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#crdata-modal")
        .modal("show")
        .find("#crdatatview")
        .empty()
        .append(html);
    });
  });
  $(".viewcresign-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#viewcresign-modal")
        .modal("show")
        .find("#viewcresign-view")
        .empty()
        .append(html);
    });
  });
  $(".viewccanceljoin-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#viewccanceljoin-modal")
        .modal("show")
        .find("#viewccanceljoin-view")
        .empty()
        .append(html);
    });
  });
  $(".viewchiring-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#viewchiring-modal")
        .modal("show")
        .find("#viewchiring-view")
        .empty()
        .append(html);
    });
  });

  // begin request hold joborder
  $(".view-hold-job-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });
    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#view-hold-job-modal").modal("show").find("#view-hold-job-view").empty().append(html);
    });
  });
  $(".approve-hold-job-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });
    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#approve-hold-job-modal")
        .modal("show")
        .find("#approve-hold-job-view")
        .empty()
        .append(html);
    });
  });
  
  // begin request stop joborder
  $(".viewcrjo-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#crjo-modal").modal("show").find("#crjoview").empty().append(html);
    });
  });
  $(".approvecrjo-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#approvecrjo-modal")
        .modal("show")
        .find("#approvecrjoview")
        .empty()
        .append(html);
    });
  });
  $(".approvecr-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#approvecrdata-modal")
        .modal("show")
        .find("#approvecrdatatview")
        .empty()
        .append(html);
    });
  });

  $(".approvecrresign-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#approvecrresign-modal")
        .modal("show")
        .find("#approvecrresign-view")
        .empty()
        .append(html);
    });
  });
  $(".approvecrcanceljoin-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#approvecrcanceljoin-modal")
        .modal("show")
        .find("#approvecrcanceljoin-view")
        .empty()
        .append(html);
    });
  });
  $(".confirmcrcanceljoin-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#confirmcrcanceljoin-modal")
        .modal("show")
        .find("#confirmcrcanceljoin-view")
        .empty()
        .append(html);
    });
  });
  $(".approvecrhiring-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#approvecrhiring-modal")
        .modal("show")
        .find("#approvecrhiring-view")
        .empty()
        .append(html);
    });
  });
  $(".confirmcrhiring-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#confirmcrhiring-modal")
        .modal("show")
        .find("#confirmcrhiring-view")
        .empty()
        .append(html);
    });
  });
  $("#loginButton").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#login-modal").modal("show").find("#loginview").empty().append(html);
    });
  });
  $("#signupButton").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#signup-modal").modal("show").find("#signupview").empty().append(html);
    });
  });
  $("#signinButton").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#login-modal").modal("show").find("#loginview").empty().append(html);
    });
  });
  $(".whitelist-modal-click").click(function () {
    var loading = new Loading({
      direction: "hor",
      discription: "Loading...",
      defaultApply: true,
    });

    event.preventDefault();
    this.blur();
    $.get($(this).attr("value"), function (html) {
      loading.out();
      $("#whitelist-modal")
        .modal("show")
        .find("#whitelist")
        .empty()
        .append(html);
    });
  });
});
