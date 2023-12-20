        
        <script>
            $(document).ready(function(){
                $("#logout").on('click', function(){
                    confirm("Do you wish to logout?") ? window.location.href = "{{ route('user.logout') }}" : '';
                })
            })
        </script>
     <script>
    //   requesting_notification();
            function requesting_notification()
            {
                $.ajax({
                    type: 'get',
                    url: "{{ route('requestingitems.notification') }}",
                    dataType: 'json',
                    success:function(data)
                    {
                        if(data > 0)
                        {
                            $("#notif").show();
                            $("#notif").text(data);
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
            // setInterval(() => {
            //     requesting_notification();
            // }, 1000);
       </script>
    </body>
</html>
