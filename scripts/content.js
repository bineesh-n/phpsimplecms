


            $('document').ready(function(){
               
                $('.fbi').hover(function(){
                    $('.fbi').stop().animate({width:'45px',height:'45px'},{queue:false,duration:20})
                })
                $('.twi').hover(function(){
                    $('.twi').stop().animate({width:'45px',height:'45px'},{queue:false,duration:20})
                })
                $('.fbi').mouseout(function(){
                    $('.fbi').stop().animate({width:'40px',height:'40px'},{queue:false,duration:20})
                })
                $('.twi').mouseout(function(){
                    $('.twi').stop().animate({width:'40px',height:'40px'},{queue:false,duration:20})
                })
                $('#head').mouseenter(function(){
                    d1 = $('#4').css('display')
                    d2 = $('#5').css('display')
                    d3 = $('#6').css('display')
                    if(d1 == 'block' ) {
                        $('#4').css('display','none')
                    }
                    if(d2 == 'block' ) {
                        $('#5').css('display','none')
                    }
                    if(d3 == 'block' ) {
                        $('#6').css('display','none')
                    }
                })
                $('#1').mouseenter(function(){
                    $('#4').fadeIn();
                    $('#4').css('display','block')
                })
                $('#2').mouseenter(function(){
                    $('#5').fadeIn();
                    $('#5').css('display','block')
                })
                $('#3').mouseenter(function(){
                    $('#6').fadeIn();
                    $('#6').css('display','block')
                })
                $('#4').mouseleave(function(){
                    $('#4').fadeOut();
                    
                })
                $('#5').mouseleave(function(){
                    $('#5').fadeOut();
                    
                })
                $('#6').mouseleave(function(){
                    $('#6').fadeOut();
                    
                })
            });
            
            function goHome() {
                if(window.location.toString()!='http://localhost/nss/'){
                    window.location = 'http://localhost/nss/'
                }
            }
            function validate(name) {
                switch(name) {
                    case 'login':
                                var un = document.forms[name].un.value;
                                var pwd = document.forms[name].pwd.value;
                                if( un ==="" && pwd === ""){
                                    displayPopup("Please enter password and username");
                                    return false;
                                }
                                else if( un === "") {
                                    displayPopup("Please enter username..!");
                                    return false;
                                }
                                else if(pwd === "") {
                                    displayPopup("Please enter password..!");
                                    return false;
                                }
                                break;
                    case 'act':
                                var nm = document.forms[name]['name'].value;
                                var desc = document.forms[name].desc.value;
                                if( nm ==="" && desc === ""){
                                    displayPopup("Please enter name and description");
                                    return false;
                                }
                                else if( nm === "") {
                                    displayPopup("Please enter name..!");
                                    return false;
                                }
                                else if(desc === "") {
                                    displayPopup("Please enter description..!");
                                    return false;
                                }
                                break;
                    case 'gal':
                                var item = document.forms[name].item.value;
                                
                                if( item === "") {
                                    displayPopup("Please enter item name..!");
                                    return false;
                                }
                                break;
                   case 'cont':
                                var nm = document.forms[name]['name'].value;
                                var no = document.forms[name].no.value;
                                if( nm ==="" && no === ""){
                                    displayPopup("Please enter name and number");
                                    return false;
                                }
                                else if( nm === "") {
                                    displayPopup("Please enter name..!");
                                    return false;
                                }
                                else if(no === "") {
                                    displayPopup("Please enter contact number..!");
                                    return false;
                                }
                                break;
                    case 'art':
                                var fPath = document.forms[name].photo.value;
                                var extnFile = fPath.substring(fPath.lastIndexOf('.')+1).toLowerCase();
                                if(extnFile !== 'png' &&extnFile !== 'jpg'&&extnFile !== 'gif' && fPath !== "") {
                                    displayPopup("Please upload a png, jpg or gif file");
                                    return false;
                                }
                                var title = document.forms[name].title.value;
                                if(title === "") {
                                    displayPopup("Please enter title..!");
                                    return false;
                                }
                                break;
                    case 'pic':
                                var title = document.forms[name].title.value;
                                if( title === "") {
                                    displayPopup("Please enter title..!");
                                    return false;
                                }
                                var fPath = document.forms[name].photo.value;
                                var extnFile = fPath.substring(fPath.lastIndexOf('.')+1).toLowerCase();
                                if(extnFile !== 'png' &&extnFile !== 'jpg'&&extnFile !== 'gif') {
                                    displayPopup("Please upload a png, jpg or gif file");
                                    return false;
                                }
                                break;
                    case 'una':
                                var un = document.forms[name].un.value;
                                if(un === "") {
                                    displayPopup("Please enter the new username..!")
                                    return false;
                                }
                                break;
                    case 'ema':
                                var email = document.forms[name].email.value;
                                var mailformat=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                                if(!email.match(mailformat)) {
                                    displayPopup("Please enter a valid email id..!")
                                    return false;
                                }
                                break;
                   case 'pwd':
                                var pwd = document.forms[name].pwd.value;
                                var pwdVerify = document.forms[name]['pwd-verify'].value;
                                if(pwd !== pwdVerify) {
                                    displayPopup("Passwords does not match..!")
                                    return false;
                                }
                                if(pwd === "" || pwd.length < 6) {
                                    displayPopup("Expects minimum length of 6 characters")
                                    return false;
                                }
                }
            }
            
            function closePopup() {
                $('#warn').css('display','none');
                $('#black').fadeOut();
            }
            
            function displayPopup(msg) {
                $('#black').fadeIn()
                $('#warn').css('display','block')
                document.getElementById('msg').innerHTML=msg;
            }