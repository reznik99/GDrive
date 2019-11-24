$(document).ready(function(){

  function make_input_look_fancy(){
    $(this).addClass("filled");
  }

  function toggle_divs(){
    let target = $(this).parent().parent().parent();
    $(".hidden").removeClass("hidden");
    target.addClass("hidden");
  }

  $(document).on("focus click", ".input_field", make_input_look_fancy);
  $(document).on("click", ".toggle_divs", toggle_divs);
});
