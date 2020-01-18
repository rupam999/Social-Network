$(document).ready(function(){
    $(".dropdown").hover(            
        function() {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).slideDown("400");
            $(this).toggleClass('open');        
        },
        function() {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).slideUp("400");
            $(this).toggleClass('open');       
        }
    );
});

$('#myModal').appendTo("body");
$('#exampleModal').appendTo("body");
$('#birthday').appendTo("body");


$(document).ready(function() {
    $('.nav-toggle').click(function(){
        //get collapse content selector
        var collapse_content_selector = $(this).attr('href');                   
                    
        //make the collapse content to be shown or hide
        var toggle_switch = $(this);
        $(collapse_content_selector).toggle(function(){
            if($(this).css('display')=='none'){
                toggle_switch.html('Friends and Peoples');//change the button label to be 'Friends and Peoples'
            }else{
                toggle_switch.html('Friends and Peoples');//change the button label to be 'Friends and Peoples'
            }   
        });
     });             
});



$(document).ready(function(){

    $('.chat_head').click(function(){
        $('.chat_body').slideToggle('slow');
    });
    $('.msg_head').click(function(){
        $('.msg_wrap').slideToggle('slow');
    });
    
    $('.close').click(function(){
        $('.msg_box').hide();
    });
    
    $('.user').click(function(){
        $('.msg_wrap').show();
        $('.msg_box').show();
    });
    
    // to send data to databse
    $('textarea').keypress(
    function(e){
        if (e.keyCode == 13) {
            e.preventDefault();
            $(document).ready(function(){
                // $("#save").click(function(){
                    $.ajax({
                        url:"insert.php",
                        type:"post",
                        data:$("#sendMsgFrm").serialize(), 
                        success:function(d){
                            $("#sendMsgFrm")[0].reset();
                            // alert(d);
                        }
                    });
                // });
                
            });
        }
    });

 $(document).ready(function(){
    $('#mainChat').load('load.php');
    refresh();
 });

 function refresh(){
    setTimeout(function(){
        $('#mainChat').load('load.php');
        refresh();
    },1000);
 }


   
});

