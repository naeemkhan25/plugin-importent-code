;(function ($) {
    $(document).ready(function () {
        $(".action-button").on('click', function () {
            let task = $(this).data('task');
            let params = { "action": "display_result", "nonce": optionData.nonce, "task": task };
            $.post(optionData.ajax_url, params, function (data) {
                $("#plugin-demo-result").html("<pre>" + data + "</pre>").show();
            });
        });
    });
})(jQuery);