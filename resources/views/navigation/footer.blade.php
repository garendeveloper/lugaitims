        
        <script>
            $(document).ready(function(){
                $("#logout").on('click', function(){
                    confirm("Do you wish to logout?") ? window.location.href = "{{ route('user.logout') }}" : '';
                })
            })
            $(document).ready(function() {
            $(".notification-drop .item").on('click',function() {
                $(this).find('ul').toggle();
            });
            });
        </script>
     <script>
      requesting_notification();
            function requesting_notification()
            {
                $.ajax({
                    type: 'get',
                    url: "{{ route('requestingitems.notification') }}",
                    dataType: 'json',
                    success:function(data)
                    {
                        if(data.lowstock > 0)
                        {
                            $("#lowstock").show();
                            $("#lowstock").text(data.lowstock)
                            var html = "<li style = 'center'><b>LIST OF LOW STOCKS</b></li>";
                            for(var i = 0; i<data.lowstock; i++)
                            {
                                html += "<li>"+data.lowstocks[i].item+" = "+ data.lowstocks[i].stock+"</li>";
                            }
                            html += "<li><a class = 'btn btn-primary btn-sm btn-flat' href = '{{ route('items.index') }}'>View All</a></li>";
                            $("#notificationlist").html(html);
                        }
                        else
                        {
                            $("#lowstock").hide();
                            $("#lowstock").html("");
                        }
                        if(data.notif > 0)
                        {
                            $("#notif").show();
                            $("#notif").text(data.notif);
                        }
                        else
                        {
                            $("#notif").hide();
                            $("#notif").html("");
                        }
                    },
                    error: function()
                    {
                        alert("System cannot process request.")
                    }
                })
            }   
            setInterval(() => {
                requesting_notification();
            }, 1000);
       </script>
    </body>
</html>
