appId = '180840938692447';
$(document).ready(function(){
    
    FB.init({
        appId: appId, // App ID
        status     : true, // check login status
        cookie     : true, // enable cookies to allow the server to access the session
        xfbml      : true  // parse XFBML
    });
    
    getLoggedin();

});

function getLoggedin(){
    FB.getLoginStatus(function(response) {
        
        if(response.authResponse==null){//not logged in
           
            FB.login(function(response) {
                if (response.authResponse) {
                    uid = response.authResponse.userID;
                    accessToken = response.authResponse.accessToken;
                    
                    FB.api('/me', function(response) {
                        $('#login_status').html('<img src="http://graph.facebook.com/'+response.id+'/picture" /> <br /> Welcome '+response.name);
                        $('#container').fadeIn('slow');
                    });
                    
                } else {
                   
                }
            }, {
                scope: 'publish_stream,offline_access,user_likes,email'
            });
            
        }else{ //loggedin and connected
            
            uid = response.authResponse.userID;
            accessToken = response.authResponse.accessToken;
                    
            FB.api('/me', function(response) {
                $('#login_status').html('<img src="http://graph.facebook.com/'+response.id+'/picture" /> <br /> Welcome '+response.name);
                $('#container').fadeIn('slow');
            });
        }
    });
}

function viewPopularBooks(){
    var urls = '';
    for(var i in books){
        urls += '"http://www.imeddic.com/bookstall/?book='+books[i].id+'",';
    }
    urls = urls.substr(0,urls.length-1);
    FB.api(
    {
        method: 'fql.query',
        query: 'SELECT share_count, like_count, comment_count, total_count, url FROM link_stat WHERE url IN ('+urls+') ORDER BY total_count DESC ;'
    },
    function(response) {
        var contents = '';
        for(var i in response){
            var bid = response[i].url.substr(response[i].url.indexOf('=')+1, response[i].url.length);
            contents += '<li>\
                        <a href="?book='+books[bid].id+'" >\
                        <img src="images/'+books[bid].image+'" />\
                        </a><br /><strong>'+books[bid].name+'</strong><br />\
                        <span class="author">'+books[bid].author+'</span><br />\
                        '+books[bid].description+'<br />\
                        Liked '+response[i].total_count+' times\
                        <div class="share" onclick="shareToMyFeed(\''+books[bid].id+'\')">Share</div>\
                        </li>';
        }
        $('#popular').html(contents);
    }
    );

}

function shareToMyFeed(id){
    var data = {
        method: 'feed',
        accessToken: accessToken,
        message: 'View the Book at My Bookstall',
        link: 'http://apps.facebook.com/'+appId+'/?book='+id,
        picture:'http://www.imeddic.com/bookstall/images/'+books[id].thumb,
        name:books[id].name,
        caption:books[id].author,
        description:books[id].description,
        to:uid,
        from:uid,
        actions:[
            {
                name: 'View the Book',
                link: 'http://apps.facebook.com/'+appId+'/?book='+id
            }
        ]
    };
    FB.api("/me/feed","post", data, function(response){
        console.log(response);
    });

}