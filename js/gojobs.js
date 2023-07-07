var xhr = null;

var gojobs = {
    registerEvents: function() {
        var self = this;

        if($('.chagerequestresign-index').length > 0){

            var userId = [];

            console.log(userId)

            // get data selected from checkbox
            $("input:checkbox[name='selection_all']").change(e => {
              let opts = $("input:checkbox[name='selection[]']:checked").map((i, el) => el.value).get();
              console.log(opts);
              userId = opts;
            });

            // get data selected from checkbox
            $("input:checkbox[name='selection']").change(e => {
              let opts = $("input:checkbox[name='selection[]']:checked").map((i, el) => el.value).get();
              console.log(opts);
              userId = opts;
            });


            $('#massApprove').click(function(){

                // get url from data-load-url from button
                var loadUrl = $(this).data('load-url');

                if(userId.length > 0){
                    // build query string to url
                    var arrayAsString = '?' + 'id[]=' + userId.join('&' + 'id[]=');
                    loadUrl = loadUrl + arrayAsString;
                }

                // show modal
                $('#approvebulkcrresign-modal').modal('show');
                
                // remote url to div on modal
                $('#approvebulkcrresign-view').load(loadUrl);


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