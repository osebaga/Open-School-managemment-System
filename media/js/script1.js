/**
 * Created by miltone on 5/15/17.
 */


function disable_edit() {
    $('input, select, textarea').each(
        function(index){
            var input = $(this);
            input.prop('disabled', true);
            input.css({"background-color":"#fff"});
        }
    );

   /* $('.select2-selection').each(
        function(index){
            var input = $(this);
            input.css({"background-color":"#fff"});
        }
    );*/

}