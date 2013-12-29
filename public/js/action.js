$(document).ready(function(){
    $('#send').click(function(){
      
      $('#send_content').val($('#content_msg').val());
      $('#content_msg').val('');

      $('#msg_type').val('text');
  
      var data = {
          Host:$('#url').val(),
          Port:$('#port').val(),
          FromUserName:$('#fromeuser').val(),
          ToUserName:$('#touser').val(),
          MsgType:$('#msg_type').val(),
          Event:$('#event').val(),
          Content:$('#send_content').val()
      }
      send_message_to(data,$('#send_content').val());
      

    });

    function add_news_html(type,articals,count){
      var artical_html = '<div class="new-info">';
      if(count ==1){
          artical_html = artical_html+'<div class="news top"><label class="top-title">'+articals.item.Title+'</label><div class="discription">'+articals.item.Description+'</div><a class="url" href="'+articals.item.Url+'">查看全文</a></div>';
      }else{
          
          for(var i=0; i<articals.item.length; i++)
          {
              artical_html =artical_html +'<div class="news"><a href="'+articals.item[i].Url+'"><div class="news-item"><label class="title">'+articals.item[i].Title+'</label></div></a></div>';

          }
          
      }
      artical_html = artical_html +"</div>"
      $('#chart_log').append(artical_html) 
      
    }

    function send_message_to(data,msg){
           add_html('my',msg);
       $.ajax({  
                  type: "POST",  
                  url: "wxdg.php",  
                  cache: false,  
                  data: data,  
                  success: function(info){
                       info = eval('('+info+')');
                       
                       if(info.MsgType == 'text'){
                          add_html('you',info.Content);
                       }else if(info.MsgType=='news'){
                          add_news_html('you',info.Articles,parseInt(info.ArticleCount));
                       }
                      
                  }
              }); 
    }

    function add_html(type,content){
   
      html =' <div class="chart-item "><div class="msg-box"><div class="'+type+'">'+content+'</div></div></div>';      
    $('#chart_log').append(html) 
      
    }

    $('#add_contect').click(function(){
      $('#content_msg').val('');
      $('#event').val('subscribe');

      $('#msg_type').val('event');
  
      var data = {
          Host:$('#url').val(),
          Port:$('#port').val(),
          FromUserName:$('#fromeuser').val(),
          ToUserName:$('#touser').val(),
          MsgType:$('#msg_type').val(),
          Event:$('#event').val(),
          Content:$('#send_content').val()
      }
      send_message_to(data,'发送关注信息');
    });
  });

   