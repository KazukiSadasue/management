$(function()
{
    $('#start').click(function(){
        $.ajax(
            {
                type:"GET",
                data: {"work_time":Math.floor( $.now() / 1000 )},
                url:"start",
                success: function(bool)
                {
                    if (bool == 'true')
                    {
                        alert('すでに出勤済みです');
                    }
                    else
                    {
                        alert('出勤しました');
                        location.reload();
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
                url:"finish",
                success: function(bool)
                {
                    if (bool == 'true')
                    {
                        alert('すでに退勤済みです')
                    }
                    else
                    {
                        alert('退勤しました');
                        location.reload();                        
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