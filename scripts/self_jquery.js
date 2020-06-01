$(document).ready(function(){
            $('.active').click(function(){
                $('#nav_display1,#nav_display2,#search1+').toggleClass("left_nav_display");
            });

            $('.display_form,.floating_button,.nav_create_cause,.my_cause_button').click(function(){
                $('.class01').show();
               
            });

            

            $('.cross').click(function(){
                $('.class01,.upvote_modal').hide();
            });

            $('.upvote_button').click(function(){
                $('.upvote_modal').toggle();
                console.log('hi');
            })

            $('.cross_search').click(function(){
                $('.search').hide();
                $('.resp_search').hide();
                $('.search_icon').show();
            });

            $('.search_icon').click(function(){
                $('.search').show();
                $('.search_icon').hide();
            });

            $('.resp_cross_search').click(function(){                
                $('.resp_search').hide();
                
            });

            $('.resp_icon_search').click(function(){
                $('.resp_search').toggle();
                
            });

            $('.notification_icon').click(function(){
                $('.notification_display').toggle();
                
            });

            $('.res_notification_icon').click(function(){
                $('.res_notification_display').toggle();
                
            });

        });