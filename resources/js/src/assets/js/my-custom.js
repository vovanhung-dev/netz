(function($) {

        $(document).ready(function() {
            $(".custom-dropdown__select").on("change", function() {
                var val = $(this).val();
                var clz = $(this).data("area");
                $("." + clz + " .lcol").addClass("hide");
                $("." + clz + " ." + val).removeClass("hide");
            });
        });

})(jQuery);