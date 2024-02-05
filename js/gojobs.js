var xhr = null;

var gojobs = {
    registerEvents: function() {
    var self = this;

        if($('.chagerequestresign-index').length > 0){

            var userId = [];

            // console.log(userId)

            // get data selected from checkbox

          if ($("input:checkbox[name='selection_all']")) {
            $("input:checkbox[name='selection_all']").change((e) => {
                let opts = $("input:checkbox[name='selection[]']:checked")
                  .map((i, el) => el.value)
                  .get();
                // console.log(opts);
                userId = opts;
              });
          }


          if ($("input:checkbox[name='selection[]']")) {
            $("input:checkbox[name='selection[]']").change((e) => {
              let opts = $("input:checkbox[name='selection[]']:checked")
                .map((i, el) => el.value)
                .get();
              // console.log("each value :", opts);
              userId = opts;
            });
          }
            // var keys = $("#grid").yiiGridView("getSelectedRows");

            // console.log(keys);

            // get data selected from checkbox
            // $("input:checkbox[name='checked']").change(e => {
            //   let opts = $("input:checkbox[name='selection[]']:checked").map((i, el) => el.value).get();
            //   console.log(opts);
            //   userId = opts;
            // });

            $("#massApprove").click(function () {
              // get url from data-load-url from button
              var loadUrl = $(this).data("load-url");

              if (userId.length > 0) {
                // build query string to url
                var arrayAsString = "?" + "id[]=" + userId.join("&" + "id[]=");
                loadUrl = loadUrl + arrayAsString;
              }

              // show modal
              $("#approvebulkcrresign-modal").modal("show");

              // remote url to div on modal
              $("#approvebulkcrresign-view").load(loadUrl);
            });

        }

    },

    initialize: function() {
        var self = this;

        self.registerEvents();
    }
}

$(document).ready(function() {
    gojobs.initialize();
});