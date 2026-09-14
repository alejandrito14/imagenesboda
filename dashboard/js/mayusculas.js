 $(document).ready( function () {
      $("input[type=text],textarea").blur( function () {
       $input=$(this);
       setTimeout(function () {
        $input.val($input.val().toUpperCase());
       },50);
      });
     });
  