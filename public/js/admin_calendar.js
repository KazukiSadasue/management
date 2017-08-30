$(function() {
    $.ajax({
        type: "GET",
        url: "/admin/calendar/calendarAjax",
        data:
        {
            "year": $('#year').val(),
            "month": $('#month').val(),
        },
        success: function(users)
        {
            $('#user > option').remove();
            $('#user').append($('<option>').val("").text('ユーザー選択'));
            users.forEach(function(val, i) {
                $('#user').append($('<option>').val(val['user_id']).text(val['name']));
            });
        },
        error: function(XMLHttpRequest,textStatus,errorThrown)
        {
            alert('エラーです！');
        }
    });

    $('#send').click(function() {
        var id = $('#user').val();
        if ( id == "" ) {
            window.location.href = '/admin/calendar';
        }
        else {
            var year = $('#year').val();
            var month = $('#month').val();
            window.location.href = '/admin/calendar/' + id + '/' + year + '/' + month;
        }
    });

    $('#year').change(function(){
        $.ajax({
            type: "GET",
            url: "/admin/calendar/calendarAjax",
            data:
            {
                "year": $('#year').val(),
                "month": $('#month').val(),
            },
            success: function(users)
            {
                $('#user > option').remove();
                $('#user').append($('<option>').val("").text('ユーザー選択'));
                users.forEach(function(val, i) {
                    $('#user').append($('<option>').val(val['user_id']).text(val['name']));
                });
            },
            error: function(XMLHttpRequest,textStatus,errorThrown)
            {
                alert('エラーです！');
            }
        });
    });
    
    $('#month').change(function(){
        $.ajax({
            type: "GET",
            url: "/admin/calendar/calendarAjax",
            data:
            {
                "year": $('#year').val(),
                "month": $('#month').val(),
            },
            success: function(users)
            {
                $('#user > option').remove();
                $('#user').append($('<option>').val("").text('ユーザー選択'));
                users.forEach(function(val, i) {
                    $('#user').append($('<option>').val(val['user_id']).text(val['name']));
                });
            },
            error: function(XMLHttpRequest,textStatus,errorThrown)
            {
                alert('エラーです！');
            }
        });
    });
});
