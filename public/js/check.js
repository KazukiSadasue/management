$(function()
{
    $('#start').click(function(){
        $.ajax(
            {
                type:"GET",
                data: {"work_time":Math.floor( $.now() / 1000 )},
                url:"start",
                success: function(type)
                {
                    if (type == '1') {
                        alert('すでに出勤済みです');
                    }
                    if (type == '2') {
                        alert('出勤しました');
                        location.reload();
                    }
                    if (type == '3') {
                        alert('まだ退勤していません。');
                    }
                },
                error: function(XMLHttpRequest,textStatus,errorThrown)
                {
                    alert('エラーです');
                }
            });
        return false;
    });
    
    $('#finish').click(function(){
        $.ajax(
            {
                type:"GET",
                data: {"work_time":Math.floor( $.now() / 1000 )},
                url:"finish",
                success: function(type)
                {
                    if (type == '1') {
                        alert('すでに退勤済みです')
                    }
                    if (type == '2') {
                        alert('退勤しました');
                        location.reload();                        
                    }
                    if (type == '3') {
                        alert('まだ出勤していません');                        
                    }
                },
                error: function(XMLHttpRequest,textStatus,errorThrown)
                {
                    alert('エラーです');
                }
            });
        return false;
    });
});